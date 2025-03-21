<?php

namespace Drupal\media_alias_display\Controller;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\Controller\EntityRevisionViewController;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\file\FileInterface;
use Drupal\media\MediaInterface;
use Drupal\media\Plugin\media\Source\File as FileMediaSource;
use Drupal\media_alias_display\Response\CacheableBinaryFileResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Defines a controller to render a file with Media Alias being used.
 */
class DisplayController extends EntityRevisionViewController {

  /**
   * The controller constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entityRepository
   *   The entity repository.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   *   The date formatter.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $translation
   *   The string translation manager.
   * @param \Drupal\Core\Session\AccountInterface $currentUser
   *   Current user.
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger
   *   The media alias display logger.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Request stack.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configManager
   *   Configuration Interface.
   * @param \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface $streamWrapperManager
   *   The stream wrapper manager.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler.
   */
  public function __construct(
    EntityTypeManagerInterface $entityTypeManager,
    EntityRepositoryInterface $entityRepository,
    DateFormatterInterface $dateFormatter,
    TranslationInterface $translation,
    protected AccountInterface $currentUser,
    protected LoggerChannelInterface $logger,
    protected Request $request,
    protected ConfigFactoryInterface $configManager,
    protected StreamWrapperManagerInterface $streamWrapperManager,
    protected ModuleHandlerInterface $moduleHandler,
  ) {
    parent::__construct($entityTypeManager, $entityRepository, $dateFormatter, $translation);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): static {
    // @phpstan-ignore-next-line
    return new static(
      $container->get('entity_type.manager'),
      $container->get('entity.repository'),
      $container->get('date.formatter'),
      $container->get('string_translation'),
      $container->get('current_user'),
      $container->get('logger.factory')->get('media_alias_display'),
      $container->get('request_stack')->getCurrentRequest(),
      $container->get('config.factory'),
      $container->get('stream_wrapper_manager'),
      $container->get('module_handler')
    );
  }

  /**
   * Render the current revision.
   *
   * Difference between this and viewRevision is first object passed in.
   */
  public function view(EntityInterface $media, $view_mode = 'full', $langcode = NULL) {
    assert($media instanceof MediaInterface);
    return $this->check($media, $view_mode, $langcode);
  }

  /**
   * Using EntityRevisionViewController render the Media revision.
   */
  public function viewRevision(RevisionableInterface $_entity_revision, $view_mode = 'full', $langcode = NULL) {
    assert($_entity_revision instanceof MediaInterface);
    return $this->check($_entity_revision, $view_mode, $langcode);
  }

  /**
   * Bulk of the Media Alias Display module.
   */
  private function check($media, $view_mode = 'full', $langcode = NULL) {
    $config = $this->configManager->get('media_alias_display.settings');

    if (!empty($config->get('kill_switch')) && $config->get('kill_switch') === TRUE) {
      return $this->updateRenderCache(parent::__invoke($media, $view_mode), $config);
    }

    $media_bundle = $media->bundle();
    $allowed_bundles = $config->get('media_bundles');
    if (!empty($config->get('media_bundles'))) {
      $allow_all_bundles = TRUE;
      foreach ($config->get('media_bundles') as $allowed_bundle) {
        if (!empty($allowed_bundle)) {
          $allow_all_bundles = FALSE;
          break;
        }
      }

      if (!$allow_all_bundles && !isset($allowed_bundles[$media_bundle])) {
        return $this->updateRenderCache(parent::__invoke($media, $view_mode), $config);
      }
    }

    $edit_own = 'edit own ' . $media_bundle . ' media';
    $edit_any = 'edit any ' . $media_bundle . ' media';

    // Skip redirect and go straight to media object.
    if ($this->request->query->has('edit-media') &&
      (($this->currentUser->hasPermission($edit_own) || $this->currentUser->hasPermission($edit_any)) || $this->currentUser->hasPermission('administer media'))) {
      return new RedirectResponse($media->toUrl('edit-form')->toString());
    }

    if (
      $this->moduleHandler->moduleExists('media_alias_display_field_override') &&
      $media->hasField('field_override_mad_module')
    ) {
      $override_module = $media->get('field_override_mad_module')->value;
      if (isset($override_module) && $override_module) {
        return $this->updateRenderCache(parent::__invoke($media, $view_mode), $config);
      }
    }

    $source = $media->getSource();
    if (!($source instanceof FileMediaSource)) {
      // The module only supports file media sources at the moment. Could
      // potentially add support for redirect to oEmbed sources.
      $this->logger
        ->notice('Media item "@media_entity_id" does not have a file media source', [
          '@media_entity_id' => $media->id(),
        ]);
      return $this->updateRenderCache(parent::__invoke($media, $view_mode), $config);
    }

    $file = $media->get($source->getConfiguration()['source_field'])->entity;

    // If media has no file item.
    if (!$file) {
      $this->logger
        ->notice('Media item "@media_entity_id" does not have a file entity attached', [
          '@media_entity_id' => $media->id(),
        ]);
      return $this->updateRenderCache(parent::__invoke($media, $view_mode), $config);
    }

    assert($file instanceof FileInterface);
    $uri = $file->getFileUri();
    $scheme = $this->streamWrapperManager::getScheme($uri);

    // Or item does not exist on disk.
    if (!$this->streamWrapperManager->isValidScheme($scheme) || !is_file($uri)) {
      $this->logger
        ->notice('File attached to Media item "@media_entity_id" does not exist on disk', [
          '@media_entity_id' => $media->id(),
        ]);
      return $this->updateRenderCache(parent::__invoke($media, $view_mode), $config);
    }

    $response = new CacheableBinaryFileResponse($uri, Response::HTTP_OK, [], $scheme !== 'private');
    $response->addCacheableDependency($media);
    $response->addCacheableDependency($file);
    $response->addCacheableDependency($config);
    // Force a direct download if a "dl" or "download" query string is present.
    if ($this->request->query->has('dl') || $this->request->query->has('download')) {
      $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $file->getFilename());
    }
    $response->getCacheableMetadata()->addCacheContexts([
      'media_alias_display_kill_switch_toggle',
      'url.query_args:edit-media',
      'user.permissions',
      'url.query_args:dl',
      'url.query_args:download',
    ]);

    if (!$response->headers->has('Content-Type')) {
      $response->headers->set('Content-Type', $file->getMimeType() ?: 'application/octet-stream');
    }

    return $response;
  }

  /**
   * Add appropriate cache tags to the render array.
   */
  protected function updateRenderCache($response, ImmutableConfig $config): array {
    if (!is_array($response)) {
      return $response;
    }
    CacheableMetadata::createFromRenderArray($response)
      ->addCacheableDependency($config)
      ->addCacheContexts([
        'media_alias_display_kill_switch_toggle',
        'url.query_args:dl',
        'url.query_args:download',
      ])
      ->applyTo($response);

    return $response;
  }

}
