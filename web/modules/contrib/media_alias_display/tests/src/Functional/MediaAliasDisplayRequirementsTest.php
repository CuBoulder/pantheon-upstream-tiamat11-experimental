<?php

declare(strict_types=1);

namespace Drupal\Tests\media_alias_display\Functional;

use Drupal\Tests\media\Functional\MediaFunctionalTestBase;

/**
 * Test the requirements check in media_alias_display requirements hook.
 *
 * @group media_alias_display
 */
class MediaAliasDisplayRequirementsTest extends MediaFunctionalTestBase {

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
      'access site reports',
    ]));
  }

  /**
   * Tests the requirements hook in media_alias_display.install.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testRequirements(): void {
    $assert_session = $this->assertSession();

    $this->drupalGet('admin/reports/status');
    $assert_session->statusCodeEquals(200);
    $assert_session->pageTextContains('Media Alias Display Settings');
    $assert_session->pageTextContains('Media setting "Standalone URL" needs to be checked for the module to work. Go to media settings.');

    \Drupal::configFactory()
      ->getEditable('media.settings')
      ->set('standalone_url', TRUE)
      ->save(TRUE);
    $this->resetAll();
    $this->drupalGet('admin/reports/status');
    $assert_session->statusCodeEquals(200);

    $assert_session->pageTextNotContains('Media setting "Standalone URL" needs to be checked for the module to work. Go to media settings.');
  }

}
