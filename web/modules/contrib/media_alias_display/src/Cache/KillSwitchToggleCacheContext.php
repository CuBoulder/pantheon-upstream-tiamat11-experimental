<?php

namespace Drupal\media_alias_display\Cache;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines a cache context for toggling kill switch.
 *
 * Cache context ID: 'media_alias_display_kill_switch_toggle'.
 */
class KillSwitchToggleCacheContext implements CacheContextInterface {

  public function __construct(
    protected ConfigFactoryInterface $configFactory,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function getLabel(): string|TranslatableMarkup {
    return new TranslatableMarkup('Media Alias display killing context');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext(): string {
    $config = $this->configFactory->getEditable('media_alias_display.settings');
    if (!empty($config->get('kill_switch')) && $config->get('kill_switch') === TRUE) {
      return 'active';
    }
    return 'inactive';
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata(): CacheableMetadata {
    $cacheable_metadata = new CacheableMetadata();
    $cacheable_metadata->addCacheTags('config:media_alias_display.settings');
    return $cacheable_metadata;
  }

}
