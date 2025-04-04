<?php

namespace Drupal\Tests\aggregator\Functional\migrate_drupal_ui\d6;

use Drupal\Tests\aggregator\Functional\migrate_drupal_ui\MigrateUpgradeExecuteTestBase;
use Drupal\Tests\migrate_drupal_ui\Functional\MigrateUpgradeTestBase;

/**
 * Tests Drupal 6 upgrade using the migrate UI.
 *
 * @group aggregator
 */
class UpgradeTest extends MigrateUpgradeExecuteTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'aggregator',
    'migrate_drupal_ui',
  ];

  /**
   * {@inheritdoc}
   *
   * @phpstan-ignore-next-line
   */
  protected function setUp(): void {
    MigrateUpgradeTestBase::setUp();
    $this->loadFixture($this->getModulePath('aggregator') . '/tests/fixtures/drupal6.php');
  }

  /**
   * {@inheritdoc}
   */
  protected function getSourceBasePath() {
    return __DIR__ . '/files';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEntityCounts() {
    return [
      'aggregator_feed' => 1,
      'aggregator_item' => 1,
      'block' => 37,
      'entity_view_display' => 58,
      'entity_view_mode' => 14,
      'view' => 16,
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getEntityCountsIncremental() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  protected function getAvailablePaths() {
    return [
      'Aggregator',
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getMissingPaths() {
    return [];
  }

}
