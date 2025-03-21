<?php

namespace Drupal\media_alias_display\Form;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implement config form for Media Alias Display.
 */
class MediaAliasDisplayForm extends ConfigFormBase {

  /**
   * Constructs a new MediaAliasDisplayForm.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configManager
   *   Configuration Interface.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Config\TypedConfigManagerInterface $typed_config_manager
   *   The typed config manager.
   */
  public function __construct(
    protected ConfigFactoryInterface $configManager,
    protected EntityTypeManagerInterface $entityTypeManager,
    protected TypedConfigManagerInterface $typed_config_manager,
  ) {
    parent::__construct($configManager, $typed_config_manager);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): static {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager'),
      $container->get('config.typed'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [
      'media_alias_display.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'media_alias_display_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('media_alias_display.settings');

    $bundles = [];
    try {
      $types = $this->entityTypeManager->getStorage('media_type')->loadMultiple();
      foreach ($types as $bundle) {
        $bundles[$bundle->id()] = $bundle->label();
      }
    }
    catch (InvalidPluginDefinitionException | PluginNotFoundException) {
      // @todo Put logger.
    }

    $form['container'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Media Bundles'),
    ];

    $form['container']['media_bundles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Bundles'),
      '#description' => $this->t('If none selected all will be used'),
      '#options' => $bundles,
      '#default_value' => !empty($config->get('media_bundles')) ? $config->get('media_bundles') : [],
    ];

    $form['kill_switch'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Kill Switch'),
      '#description' => $this->t('Disable media_alias_display completely.'),
      '#default_value' => $config->get('kill_switch'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    parent::submitForm($form, $form_state);

    $this->config('media_alias_display.settings')
      ->set('kill_switch', $form_state->getValue('kill_switch'))
      ->set('media_bundles', array_filter($form_state->getValue('media_bundles')))
      ->save();
  }

}
