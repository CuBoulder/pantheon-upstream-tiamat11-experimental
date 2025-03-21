<?php

declare (strict_types=1);

namespace Drupal\layout_builder_iframe_modal\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Theme hook implementations for Layout Builder Iframe Modal.
 */
class ThemeHooks {

  /**
   * Implements hook_theme().
   */
  #[Hook('theme')]
  public function theme(): array {
    return [
      'lbim_iframe' => [
        'variables' => [
          'iframe_attributes' => NULL,
        ],
      ],
      'lbim_redirect' => [
        'variables' => [],
      ],
    ];
  }

}
