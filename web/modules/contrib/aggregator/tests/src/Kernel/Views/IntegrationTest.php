<?php

namespace Drupal\Tests\aggregator\Kernel\Views;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Link;
use Drupal\Core\Render\RenderContext;
use Drupal\Core\Url;
use Drupal\filter\Entity\FilterFormat;
use Drupal\Tests\views\Kernel\ViewsKernelTestBase;
use Drupal\views\Tests\ViewTestData;
use Drupal\views\Views;

/**
 * Tests basic integration of views data from the aggregator module.
 *
 * @group aggregator
 */
class IntegrationTest extends ViewsKernelTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  protected static $modules = [
    'aggregator',
    'aggregator_test_views',
    'system',
    'field',
    'filter',
    'options',
    'user',
  ];

  /**
   * Views used by this test.
   *
   * @var array
   */
  public static $testViews = ['test_aggregator_items'];

  /**
   * The entity storage for aggregator items.
   *
   * @var \Drupal\aggregator\ItemStorage
   */
  protected $itemStorage;

  /**
   * The entity storage for aggregator feeds.
   *
   * @var \Drupal\aggregator\FeedStorage
   */
  protected $feedStorage;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  protected function setUp($import_test_views = TRUE): void {
    parent::setUp();

    $this->installConfig(['filter', 'aggregator']);
    $this->installEntitySchema('aggregator_item');
    $this->installEntitySchema('aggregator_feed');

    ViewTestData::createTestViews(static::class, ['aggregator_test_views']);

    $this->itemStorage = $this->container->get('entity_type.manager')->getStorage('aggregator_item');
    $this->feedStorage = $this->container->get('entity_type.manager')->getStorage('aggregator_feed');
    $this->renderer = $this->container->get('renderer');
  }

  /**
   * Tests basic aggregator_item view.
   */
  public function testAggregatorItemView() {
    $feed = $this->feedStorage->create([
      'title' => $this->randomMachineName(),
      'url' => 'https://www.drupal.org/',
      'refresh' => 900,
      'checked' => 123543535,
      'description' => $this->randomMachineName(),
    ]);
    $feed->save();

    $items = [];
    $expected = [];
    for ($i = 0; $i < 10; $i++) {
      $values = [];
      $values['fid'] = $feed->id();
      $values['timestamp'] = mt_rand($this->container->get('datetime.time')->getRequestTime() - 10, $this->container->get('datetime.time')->getRequestTime() + 10);
      $values['title'] = $this->randomMachineName();
      $values['description'] = $this->randomMachineName();
      // Add an image to ensure that the sanitizing can be tested below.
      $values['author'] = $this->randomMachineName() . '<img src="http://example.com/example.png" \>"';
      $values['link'] = 'https://www.drupal.org/node/' . mt_rand(1000, 10000);
      $values['guid'] = $this->randomString();

      $aggregator_item = $this->itemStorage->create($values);
      $aggregator_item->save();
      $items[$aggregator_item->id()] = $aggregator_item;

      $values['iid'] = $aggregator_item->id();
      $expected[] = $values;
    }

    $view = Views::getView('test_aggregator_items');
    $this->executeView($view);

    $column_map = [
      'iid' => 'iid',
      'title' => 'title',
      'aggregator_item_timestamp' => 'timestamp',
      'description' => 'description',
      'aggregator_item_author' => 'author',
    ];
    $this->assertIdenticalResultset($view, $expected, $column_map);

    /** @var \Drupal\filter\FilterFormatInterface $format */
    $format = FilterFormat::load('aggregator_html');
    $config = $format->filters('filter_html')->getConfiguration();
    $html_tags = preg_split('/\s+|<|>/', $config['settings']['allowed_html'], -1, PREG_SPLIT_NO_EMPTY);

    // Ensure that the rendering of the linked title works as expected.
    foreach ($view->result as $row) {
      $iid = $view->field['iid']->getValue($row);
      $expected_link = Link::fromTextAndUrl($items[$iid]->getTitle(), Url::fromUri($items[$iid]->getLink(), ['absolute' => TRUE]))->toString();
      $output = $this->renderer->executeInRenderContext(new RenderContext(), function () use ($view, $row) {
        return $view->field['title']->advancedRender($row);
      });
      $this->assertEquals($expected_link->getGeneratedLink(), (string) $output, 'Ensure the right link is generated');

      $expected_author = Xss::filter($items[$iid]->getAuthor(), $html_tags);
      $output = $this->renderer->executeInRenderContext(new RenderContext(), function () use ($view, $row) {
        return $view->field['author']->advancedRender($row);
      });
      $this->assertEquals($expected_author, (string) $output, 'Ensure the author got filtered');

      $expected_description = Xss::filter($items[$iid]->getDescription(), $html_tags);
      $output = $this->renderer->executeInRenderContext(new RenderContext(), function () use ($view, $row) {
        return $view->field['description']->advancedRender($row);
      });
      $this->assertEquals($expected_description, (string) $output, 'Ensure the author got filtered');
    }
  }

}
