<?php

namespace Drupal\ucb_styled_block;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Implements the styled block service interface.
 */
class StyledBlockService implements StyledBlockServiceInterface {

  /**
   * Contains the configuration parameters for this module.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $moduleConfiguration;

  /**
   * Constructs a StyledBlockService.
   *
   * @param \Drupal\Core\Config\ImmutableConfig $configFactory
   *   The config factory for getting configuration.
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->moduleConfiguration = $configFactory->get('ucb_styled_block.configuration');
  }

  /**
   * {@inheritdoc}
   */
  public function backgroundStyle($input) {
    return $this->styleConfigValue('background_style', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function titleFontScale($input) {
    return $this->styleConfigValue('title_font_scale', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function contentFontScale($input) {
    return $this->styleConfigValue('content_font_scale', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function icon($input) {
    if (preg_match('/<i class="([^"]+)/', $input, $matches)) {
      $output = '';
      foreach (preg_split('/\s+/', $matches[1]) as $className) {
        if (preg_match('/fa-([a-z]|[0-9]|-)+/', $className, $classMatches)) {
          $classFa = $classMatches[0];
          // Filters out any Font Awesome class that can't be an icon or style.
          if (!preg_match('/^fa-((2xs|xs|sm|lg|xl|2xl|([0-9]|10)x)|beat-fade|bounce|border|fade|flip-(horizontal|vertical|both)|fw|inverse|li|pull-(left|right)|rotate-(90|180|270|by)|shake|spin(-(pulse|reverse))?|sr-only(-focusable)?|stack(-(1|2)x)?|ul)$/', $classFa)) {
            $output .= $output ? ' ' . $classFa : $classFa;
          }
        }
      }
      return $output;
    }
    return $this->styleConfigValue('icon', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function iconColor($input) {
    return $this->styleConfigValue('icon_color', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function iconPosition($input) {
    return $this->styleConfigValue('icon_position', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function iconSize($input) {
    return $this->styleConfigValue('icon_size', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function heading($input) {
    return $this->styleConfigValue('heading', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function headingAlignment($input) {
    return $this->styleConfigValue('heading_alignment', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function headingStyle($input) {
    return $this->styleConfigValue('heading_style', $input);
  }

  /**
   * {@inheritdoc}
   */
  public function getStyleOutput($styleName, $input) {
    return $styleName == 'icon' ? $this->icon($input) : $this->styleConfigValue($styleName, $input);
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultStyleValues() {
    return $this->moduleConfiguration->get('block_style_defaults');
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultStyleOutputs() {
    $defaultStyleOutputs = [];
    $styles = $this->moduleConfiguration->get('block_styles');
    $styleDefaults = $this->moduleConfiguration->get('block_style_defaults');
    foreach ($styleDefaults as $styleName => $styleDefault) {
      $defaultStyleOutputs[$styleName] = $styleDefault ? $styles[$styleName][$styleDefault] : '';
    }
    return $defaultStyleOutputs;
  }

  /**
   * Accesses this module's configuration for the value of a block style.
   *
   * @param string $styleName
   *   The machine name of the block style.
   * @param string $input
   *   The user-input machine name of the block style's value.
   *
   * @return string
   *   The config value of this block style, or the default if the input isn't
   *   valid.
   */
  protected function styleConfigValue($styleName, $input) {
    $style = $this->moduleConfiguration->get('block_styles')[$styleName] ?? [];
    $styleDefault = $this->moduleConfiguration->get('block_style_defaults')[$styleName];
    return $style[$input] ?? ($styleDefault ? $style[$styleDefault] : '');
  }

}
