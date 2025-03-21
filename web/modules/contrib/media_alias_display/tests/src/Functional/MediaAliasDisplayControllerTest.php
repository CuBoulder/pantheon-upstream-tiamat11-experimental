<?php

declare(strict_types=1);

namespace Drupal\Tests\media_alias_display\Functional;

use Drupal\Core\File\FileExists;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Tests\TestFileCreationTrait;
use Drupal\Tests\media\Functional\MediaFunctionalTestBase;
use Drupal\Tests\system\Functional\Cache\AssertPageCacheContextsAndTagsTrait;
use Drupal\field\Entity\FieldConfig;
use Drupal\file\Entity\File;
use Drupal\file\FileInterface;
use Drupal\media\Entity\Media;
use Drupal\media\MediaTypeInterface;
use Drupal\user\Entity\Role;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group media_alias_display
 */
class MediaAliasDisplayControllerTest extends MediaFunctionalTestBase {

  use TestFileCreationTrait;
  use AssertPageCacheContextsAndTagsTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'media_alias_display', 'path',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Store file.
   *
   * @var \Drupal\file\FileInterface|null
   */
  protected ?FileInterface $file;

  /**
   * Store Media Type.
   *
   * @var \Drupal\media\MediaTypeInterface
   */
  protected MediaTypeInterface $mediaType;

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function setUp(): void {
    parent::setUp();

    // Turn on media modules standalone url setting.
    \Drupal::configFactory()
      ->getEditable('media.settings')
      ->set('standalone_url', TRUE)
      ->save(TRUE);
    $this->container->get('router.builder')->rebuild();

    $media_type = $this->createMediaType('image', [
      'id' => 'image',
      'new_revision' => FALSE,
    ]);
    $media_type->setFieldMap(['name' => 'name']);
    $media_type->save();
    $this->mediaType = $media_type;

    $this->drupalLogin($this->createUser([
      'administer site configuration',
      'access media overview',
      'administer media',
      'view media',
    ]));
  }

  /**
   * Create an image media entity.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createMedia($include_file = TRUE, $path_alias = NULL, $index = 0, $private_file = FALSE) {
    $media_type_id = $this->mediaType->id();
    /** @var \Drupal\field\FieldConfigInterface $field */
    $field = FieldConfig::load("media.$media_type_id.field_media_image");
    $settings = $field->getSettings();
    $settings['alt_field'] = TRUE;
    $settings['alt_field_required'] = FALSE;
    $field->set('settings', $settings);
    $field->save();

    $media = Media::create([
      'name' => 'Custom name',
      'bundle' => $media_type_id,
      'status' => TRUE,
      'path' => $path_alias,
    ]);

    $this->file = NULL;

    if ($include_file) {
      /** @var \Drupal\Core\File\FileSystemInterface $file_system */
      $file_system = \Drupal::service('file_system');
      $original_uri = $this->getTestFiles('image')[$index]->uri;
      // Use a separate media_alias_display directory and file for this.
      // This should allow us to manipulate the files without any side effects.
      $destination_dir = ($private_file ? 'private://' : 'public://') . 'media_alias_display/';
      $file_system->prepareDirectory($destination_dir, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS);
      $destination_uri = $destination_dir . '/' . pathinfo($original_uri, PATHINFO_BASENAME);
      $uri = $file_system->copy($original_uri, $destination_uri, FileExists::Replace);
      $file = File::create([
        // Add a custom file name that might be different to the real internal
        // file.
        'filename' => 'custom-file-name-' . $file_system->basename($uri),
        'uri' => $uri,
      ]);
      $file->save();
      $this->file = $file;

      $media->set('field_media_image', [
        [
          'target_id' => $file->id(),
          'alt' => 'default alt',
          'title' => 'default title',
        ],
      ]);
    }
    $media->save();
    return $media;
  }

  /**
   * Test the DisplayController and all the checks there.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Behat\Mink\Exception\ExpectationException
   *
   * @dataProvider providerDisplayController
   */
  public function testDisplayController($current_alias, bool $private_file): void {
    $assert_session = $this->assertSession();

    $media = $this->createMedia(TRUE, $current_alias, 0, $private_file);
    $media_file = $this->file;
    if ($current_alias) {
      $path_alias = ltrim($current_alias, '/');
    }
    else {
      $path_alias = 'media/' . $media->id();
    }
    // Verifies kill switch isn't enabled + verifies it's not an allowed bundle.
    $this->drupalGet('media/' . $media->id());
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', $media_file->getMimeType());

    // Test a revision.
    $vid = $media->id();
    $media->setName($this->randomMachineName());
    $media->setNewRevision();
    $media->save();
    $this->drupalGet('media/' . $media->id() . '/revisions/' . $vid . '/view');
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', $media_file->getMimeType());

    // Test when the kill switch is enabled.
    \Drupal::configFactory()
      ->getEditable('media_alias_display.settings')
      ->set('kill_switch', TRUE)
      ->save(TRUE);

    $this->drupalGet('media/' . $media->id());
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', 'text/html');

    // Test when no bundle is selected, should default to all.
    // Turn off kill switch.
    \Drupal::configFactory()
      ->getEditable('media_alias_display.settings')
      ->set('kill_switch', FALSE)
      ->save(TRUE);

    $this->drupalGet('media/' . $media->id());
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', $media_file->getMimeType());

    // Test when a single bundle is selected.
    \Drupal::configFactory()
      ->getEditable('media_alias_display.settings')
      ->set('kill_switch', FALSE)
      ->set('media_bundles', [$this->mediaType->id() => $this->mediaType->id()])
      ->save(TRUE);

    $this->drupalGet('media/' . $media->id());
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', $media_file->getMimeType());

    // Test when edit-media is placed in the URL.
    // Should redirect to media edit page. User should have permission.
    $this->drupalGet('media/' . $media->id(), [
      'query' => ['edit-media' => ''],
      'absolute' => TRUE,
    ]);
    $assert_session->addressEquals('media/' . $media->id() . '/edit');

    // Test when user doesn't have permission.
    $current_roles = $this->loggedInUser->getRoles(TRUE);
    $id = end($current_roles);
    $role = Role::load($id);
    user_role_revoke_permissions($role->id(), ['administer media']);
    $this->drupalGet('media/' . $media->id(), [
      'query' => ['edit-media' => 1],
      'absolute' => TRUE,
    ]);
    // User won't be redirected because they don't have permission.
    $assert_session->addressEquals($path_alias);

    // Grant "edit any bundle media" permission that should allow a user to
    // access the edit page.
    $this->grantPermissions($role, ['edit any ' . $this->mediaType->id() . ' media']);
    $this->drupalGet('media/' . $media->id(), [
      'query' => ['edit-media' => 1],
      'absolute' => TRUE,
    ]);
    $assert_session->addressEquals('media/' . $media->id() . '/edit');

    user_role_revoke_permissions($role->id(), ['edit any ' . $this->mediaType->id() . ' media']);
    // Grant "edit own bundle media" permission that should allow a user to
    // access the edit page.
    $this->grantPermissions($role, ['edit own ' . $this->mediaType->id() . ' media']);
    $this->drupalGet('media/' . $media->id(), [
      'query' => ['edit-media' => 1],
      'absolute' => TRUE,
    ]);
    $assert_session->addressEquals('media/' . $media->id() . '/edit');

    // Test content dispositions.
    $this->drupalGet('media/' . $media->id());
    // The content disposition header should not exist by default.
    $assert_session->responseHeaderDoesNotExist('Content-Disposition');

    $this->drupalGet('media/' . $media->id(), ['query' => ['download' => '']]);
    $assert_session->responseHeaderContains('Content-Disposition', ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    $assert_session->responseHeaderContains('Content-Disposition', $media_file->getFilename());

    $this->drupalGet('media/' . $media->id(), ['query' => ['dl' => '1']]);
    $assert_session->responseHeaderContains('Content-Disposition', ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    $assert_session->responseHeaderContains('Content-Disposition', $media_file->getFilename());

    // Test when there is no file attached to an allowed bundle.
    $media_no_file_alias = $current_alias ? "$current_alias-no-file" : NULL;
    $media_no_file = $this->createMedia(FALSE, $media_no_file_alias, 1, $private_file);
    $this->drupalGet('media/' . $media_no_file->id());
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', 'text/html');
    // Test disposition behavior without files.
    $this->drupalGet('media/' . $media_no_file->id(), ['query' => ['download' => '']]);
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', 'text/html');
    $assert_session->responseHeaderDoesNotExist('Content-Disposition');

    // Test when file doesn't exist on server by deleting it.
    // Create a new media object.
    $media_with_deleted_file_alias = $current_alias ? "$current_alias-deleted-file" : NULL;
    $media_with_deleted_file = $this->createMedia(TRUE, $media_with_deleted_file_alias, 2, $private_file);
    $media_with_deleted_file_file = $this->file;
    $this->assertFileExists($media_with_deleted_file_file->getFileUri());
    // Test disposition behavior before files were deleted.
    $this->drupalGet('media/' . $media_with_deleted_file->id(), ['query' => ['download' => '']]);
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Disposition', ResponseHeaderBag::DISPOSITION_ATTACHMENT);

    $file_uri = $media_with_deleted_file_file->getFileUri();
    unlink($file_uri);
    $this->assertFileDoesNotExist($media_with_deleted_file_file->getFileUri());
    $this->drupalGet('media/' . $media_with_deleted_file->id());
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', 'text/html');
    // Test disposition behavior after file was deleted.
    $this->drupalGet('media/' . $media_with_deleted_file->id(), ['query' => ['download' => '']]);
    $assert_session->statusCodeEquals(200);
    $assert_session->responseHeaderContains('Content-Type', 'text/html');
    $assert_session->responseHeaderDoesNotExist('Content-Disposition');
  }

  /**
   * Data provider for testDisplayController().
   */
  public static function providerDisplayController(): array {
    return [
      'media with custom alias' => ['/custom-media-alias', FALSE],
      'media without alias' => [NULL, FALSE],
      'private media with custom alias' => ['/custom-media-alias', TRUE],
      'private media without alias' => [NULL, TRUE],
    ];
  }

}
