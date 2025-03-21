<?php

declare(strict_types = 1);

namespace Drupal\ucb_bootstrap_layouts\Plugin\Layout;

use Drupal\ucb_bootstrap_layouts\UCBLayout;

/**
 * Provides a plugin class for two column layouts.
 */
final class TwoColumnLayout extends LayoutBase {

  /**
   * {@inheritdoc}
   */
  protected function getColumnWidths(): array {
    return [
      UCBLayout::ROW_WIDTH_34_66 => $this->t('34% / 66%'),
      UCBLayout::ROW_WIDTH_50_50 => $this->t('50% / 50%'),
      UCBLayout::ROW_WIDTH_66_34 => $this->t('66% / 34%'),
    ];
  } 

  /**
   * {@inheritdoc}
   */
  protected function getDefaultColumnWidth(): string {
    return UCBLayout::ROW_WIDTH_50_50;
  }

}
