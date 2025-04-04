<?php

namespace Drupal\Tests\aggregator\Kernel\Migrate;

use Drupal\migrate_drupal\Tests\StubTestTrait;
use Drupal\Tests\migrate_drupal\Kernel\MigrateDrupalTestBase;

/**
 * Test stub creation for aggregator feeds and items.
 *
 * @group aggregator
 */
class MigrateAggregatorStubTest extends MigrateDrupalTestBase {

  use StubTestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['aggregator'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installEntitySchema('aggregator_feed');
    $this->installEntitySchema('aggregator_item');
  }

  /**
   * Tests creation of aggregator feed stubs.
   */
  public function testFeedStub() {
    $this->performStubTest('aggregator_feed');
  }

  /**
   * Tests creation of aggregator feed items.
   */
  public function testItemStub() {
    $this->performStubTest('aggregator_item');
  }

}
