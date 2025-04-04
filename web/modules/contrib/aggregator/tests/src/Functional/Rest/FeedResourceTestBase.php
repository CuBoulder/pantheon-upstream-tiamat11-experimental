<?php

namespace Drupal\Tests\aggregator\Functional\Rest;

use Drupal\aggregator\Entity\Feed;
use Drupal\Tests\rest\Functional\EntityResource\EntityResourceTestBase;

/**
 * Defines a base class for feed resource tests.
 */
abstract class FeedResourceTestBase extends EntityResourceTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['aggregator'];

  /**
   * {@inheritdoc}
   */
  public static $entityTypeId = 'aggregator_feed';

  /**
   * {@inheritdoc}
   */
  protected static $patchProtectedFieldNames = [];

  /**
   * {@inheritdoc}
   */
  protected static $uniqueFieldNames = ['url'];

  /**
   * {@inheritdoc}
   */
  protected function setUpAuthorization($method) {
    switch ($method) {
      case 'GET':
        $this->grantPermissionsToTestedRole(['access news feeds']);
        break;

      case 'POST':
      case 'PATCH':
      case 'DELETE':
        $this->grantPermissionsToTestedRole(['administer news feeds']);
        break;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function createEntity() {
    $feed = Feed::create();
    $feed->set('fid', 1)
      ->set('uuid', 'abcdefg')
      ->setTitle('Feed')
      ->setUrl('http://example.com/rss.xml')
      ->setDescription('Feed Resource Test 1')
      ->setRefreshRate(900)
      ->setLastCheckedTime(123456789)
      ->setQueuedTime(123456789)
      ->setWebsiteUrl('http://example.com')
      ->setImage('http://example.com/feed_logo')
      ->setEtag('hijklmn')
      ->setLastModified(123456789)
      ->save();

    return $feed;
  }

  /**
   * {@inheritdoc}
   */
  protected function getExpectedNormalizedEntity() {
    return [
      'uuid' => [
        [
          'value' => 'abcdefg',
        ],
      ],
      'fid' => [
        [
          'value' => 1,
        ],
      ],
      'langcode' => [
        [
          'value' => 'en',
        ],
      ],
      'url' => [
        [
          'value' => 'http://example.com/rss.xml',
        ],
      ],
      'title' => [
        [
          'value' => 'Feed',
        ],
      ],
      'refresh' => [
        [
          'value' => 900,
        ],
      ],
      'checked' => [
        [
          'value' => (new \DateTime())->setTimestamp(123456789)->setTimezone(new \DateTimeZone('UTC'))->format(\DateTime::RFC3339),
          'format' => \DateTime::RFC3339,
        ],
      ],
      'queued' => [
        [
          'value' => (new \DateTime())->setTimestamp(123456789)->setTimezone(new \DateTimeZone('UTC'))->format(\DateTime::RFC3339),
          'format' => \DateTime::RFC3339,
        ],
      ],
      'link' => [
        [
          'value' => 'http://example.com',
        ],
      ],
      'description' => [
        [
          'value' => 'Feed Resource Test 1',
        ],
      ],
      'image' => [
        [
          'value' => 'http://example.com/feed_logo',
        ],
      ],
      'etag' => [
        [
          'value' => 'hijklmn',
        ],
      ],
      'modified' => [
        [
          'value' => (new \DateTime())->setTimestamp(123456789)->setTimezone(new \DateTimeZone('UTC'))->format(\DateTime::RFC3339),
          'format' => \DateTime::RFC3339,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getNormalizedPostEntity() {
    return [
      'title' => [
        [
          'value' => 'Feed Resource Post Test',
        ],
      ],
      'url' => [
        [
          'value' => 'http://example.com/feed',
        ],
      ],
      'refresh' => [
        [
          'value' => 900,
        ],
      ],
      'description' => [
        [
          'value' => 'Feed Resource Post Test Description',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getExpectedUnauthorizedAccessMessage($method) {
    switch ($method) {
      case 'GET':
        return "The 'access news feeds' permission is required.";

      case 'POST':
      case 'PATCH':
      case 'DELETE':
        return "The 'administer news feeds' permission is required.";

      default:
        return parent::getExpectedUnauthorizedAccessMessage($method);
    }
  }

}
