<?php

declare(strict_types=1);

namespace Drupal\Tests\media_alias_display\Functional;

use Drupal\Tests\media\Functional\MediaFunctionalTestBase;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group media_alias_display
 */
class MediaAliasDisplayFormTest extends MediaFunctionalTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'media_alias_display',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function setUp(): void {
    parent::setUp();

    $this->drupalLogin($this->createUser([
      'administer site configuration',
    ]));
  }

  /**
   * Tests the settings form for media alias display.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testSettingsFormPage(): void {
    $assert_session = $this->assertSession();
    $page = $this->getSession()->getPage();

    $this->drupalGet('admin/config/media/media_alias_display');
    $this->assertSession()->statusCodeEquals(200);

    // Kill switch will always appear in the form.
    $assert_session->pageTextContains('Kill Switch');

    // Create a media bundle, so it will be the only option on the form.
    $media_bundle = $this->createMediaType('image');

    $this->drupalGet('admin/config/media/media_alias_display');
    $assert_session->pageTextContains($media_bundle->label());

    $page->checkField('Kill Switch');
    $page->checkField($media_bundle->label());
    $page->pressButton('Save configuration');

    $this->drupalGet('admin/config/media/media_alias_display');
    $assert_session->checkboxChecked('Kill Switch');
    $assert_session->checkboxChecked($media_bundle->label());
  }

}
