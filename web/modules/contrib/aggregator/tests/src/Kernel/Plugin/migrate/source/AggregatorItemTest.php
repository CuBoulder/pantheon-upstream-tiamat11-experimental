<?php

namespace Drupal\Tests\aggregator\Kernel\Plugin\migrate\source;

use Drupal\Tests\migrate\Kernel\MigrateSqlSourceTestBase;

/**
 * Tests aggregator item source plugin.
 *
 * @covers \Drupal\aggregator\Plugin\migrate\source\AggregatorItem
 * @group aggregator
 */
class AggregatorItemTest extends MigrateSqlSourceTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['aggregator', 'migrate_drupal'];

  /**
   * {@inheritdoc}
   */
  public static function providerSource() {
    // cspell:ignore larowlan
    $tests = [];

    $tests[0]['source_data']['aggregator_item'] = [
      [
        'iid' => 1,
        'fid' => 1,
        'title' => 'This (three) weeks in Drupal Core - January 10th 2014',
        'link' => 'https://groups.drupal.org/node/395218',
        'author' => 'larowlan',
        'description' => "<h2 id='new'>What's new with Drupal 8?</h2>",
        'timestamp' => 1389297196,
        'guid' => '395218 at https://groups.drupal.org',
      ],
    ];
    // The expected results are identical to the source data.
    $tests[0]['expected_data'] = $tests[0]['source_data']['aggregator_item'];

    return $tests;
  }

}
