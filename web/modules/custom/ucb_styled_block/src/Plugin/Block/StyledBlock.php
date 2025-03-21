<?php

namespace Drupal\ucb_styled_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the styled block base class.
 *
 * This class can be extended by other blocks which need to be styled.
 */
abstract class StyledBlock extends BlockBase {

  /**
   * The styled block service defined in this module.
   *
   * @var \Drupal\ucb_styled_block\StyledBlockServiceInterface
   */
  protected $styledBlockService;

  /**
   * Gets the styled block service.
   *
   * @return \Drupal\ucb_styled_block\StyledBlockServiceInterface
   *   The styled block service.
   */
  public function getStyledBlockService() {
    if ($this->styledBlockService) {
      return $this->styledBlockService;
    }
    // Normally this would be set using dependency injection, but some
    // instances have been found of that not working correctly.
    // phpcs:ignore
    return $this->styledBlockService = \Drupal::service('ucb_styled_block.service');
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'block_styles' => $this->getStyledBlockService()->getDefaultStyleValues(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $stylesConfiguration = $this->getConfiguration()['block_styles'];
    $form['#type'] = 'details';
    $form['#title'] = $this->t('Content');
    $form['#group'] = 'tabs';
    $form['#open'] = TRUE;
    return [
      'tabs' => [
        '#type' => 'horizontal_tabs',
        'content' => $form,
        'block_styles' => [
          '#type' => 'details',
          '#title' => $this->t('Styles'),
          '#group' => 'tabs',
          'bs_block_icon' => [
            '#type' => 'details',
            '#title' => $this->t('Block Icon'),
            '#open' => FALSE,
            'bs_icon' => [
              '#type' => 'text_format',
              '#format' => 'icon_picker',
              '#allowed_formats' => ['icon_picker'],
              '#base_type' => 'textarea',
              '#title' => $this->t('Icon'),
              '#description' => $this->t('Use the Icons button in the WYSIWYG bar to select your icon. Only the icon will be used. Styling will be applied with the settings below.'),
              '#default_value' => $stylesConfiguration['icon'],
            ],
            'bs_icon_position' => [
              '#type' => 'select',
              '#title' => $this->t('Icon Position'),
              '#options' => [
                'bs_icon_position_default' => $this->t('Default'),
                'bs_icon_position_offset' => $this->t('Offset'),
                'bs_icon_position_top' => $this->t('Top'),
              ],
              '#description' => $this->t('Choose how the icon positions itself with the heading.'),
              '#default_value' => $stylesConfiguration['icon_position'],
            ],
            'bs_icon_color' => [
              '#type' => 'select',
              '#title' => $this->t('Icon Color'),
              '#options' => [
                'bs_icon_color_default' => $this->t('Default'),
                'bs_icon_color_gray' => $this->t('Gray'),
                'bs_icon_color_gold' => $this->t('Gold'),
                'bs_icon_color_blue' => $this->t('Blue'),
                'bs_icon_color_green' => $this->t('Green'),
                'bs_icon_color_orange' => $this->t('Orange'),
                'bs_icon_color_purple' => $this->t('Purple'),
                'bs_icon_color_red' => $this->t('Red'),
                'bs_icon_color_yellow' => $this->t('Yellow'),
              ],
              '#default_value' => $stylesConfiguration['icon_color'],
            ],
            'bs_icon_size' => [
              '#type' => 'select',
              '#title' => $this->t('Icon Size'),
              '#options' => [
                'bs_icon_size_default' => $this->t('Default'),
                'bs_icon_size_increase' => $this->t('Increase'),
              ],
              '#default_value' => $stylesConfiguration['icon_size'],
            ],
          ],
          'bs_block_heading' => [
            '#type' => 'details',
            '#title' => $this->t('Block Heading'),
            '#open' => FALSE,
            'bs_heading' => [
              '#type' => 'select',
              '#title' => $this->t('Heading'),
              '#options' => [
                'bs_heading_default' => $this->t('Default (H2)'),
                'bs_heading_h3' => $this->t('H3'),
                'bs_heading_h4' => $this->t('H4'),
                'bs_heading_h5' => $this->t('H5'),
                'bs_heading_h6' => $this->t('H6'),
                'bs_heading_strong' => $this->t('Strong'),
              ],
              '#description' => $this->t('This setting should be used to put your content in the proper hierarchy, not to change the font size of the title.'),
              '#default_value' => $stylesConfiguration['heading'],
            ],
            'bs_heading_alignment' => [
              '#type' => 'select',
              '#title' => $this->t('Heading Alignment'),
              '#options' => [
                'bs_heading_align_default' => $this->t('Default'),
                'bs_heading_align_centered' => $this->t('Centered'),
              ],
              '#default_value' => $stylesConfiguration['heading_alignment'],
            ],
            'bs_heading_style' => [
              '#type' => 'select',
              '#title' => $this->t('Heading Style'),
              '#options' => [
                'bs_heading_style_default' => $this->t('Default'),
                'bs_heading_style_default_hero' => $this->t('Hero'),
                'bs_heading_style_default_hero_bold' => $this->t('Hero Bold'),
                'bs_heading_style_default_supersize' => $this->t('Supersize'),
                'bs_heading_style_default_supersize_bold' => $this->t('Supersize Bold'),
              ],
              '#default_value' => $stylesConfiguration['heading_style'],
            ],
          ],
          'bs_block_style' => [
            '#type' => 'details',
            '#title' => $this->t('Block Style'),
            '#open' => FALSE,
            'bs_background_style' => [
              '#type' => 'select',
              '#title' => $this->t('Background Style'),
              '#options' => [
                'bs_background_style_none' => $this->t('None'),
                'bs_background_style_white' => $this->t('White'),
                'bs_background_style_gray' => $this->t('Light Gray'),
                'bs_background_style_dark_gray' => $this->t('Dark Gray'),
                'bs_background_style_tan' => $this->t('Tan'),
                'bs_background_style_light_blue' => $this->t('Light Blue'),
                'bs_background_style_medium_blue' => $this->t('Medium Blue'),
                'bs_background_style_dark_blue' => $this->t('Dark Blue'),
                'bs_background_style_light_green' => $this->t('Light Green'),
                'bs_background_style_brick' => $this->t('Brick'),
                'bs_background_style_outline' => $this->t('Outline'),
                'bs_background_style_underline' => $this->t('Underline'),
              ],
              '#default_value' => $stylesConfiguration['background_style'],
            ],
          ],
          'bs_block_typography' => [
            '#type' => 'details',
            '#title' => $this->t('Block Typography'),
            '#open' => FALSE,
            'bs_title_font_scale' => [
              '#type' => 'select',
              '#title' => $this->t('Title Font Scale'),
              '#options' => [
                'bs_title_font_scale_default' => $this->t('Default'),
                'bs_title_font_scale_increase' => $this->t('Increase'),
                'bs_title_font_scale_decrease' => $this->t('Decrease'),
              ],
              '#default_value' => $stylesConfiguration['title_font_scale'],
            ],
            'bs_content_font_scale' => [
              '#type' => 'select',
              '#title' => $this->t('Title Font Scale'),
              '#options' => [
                'bs_content_font_scale_default' => $this->t('Default'),
                'bs_content_font_scale_increase' => $this->t('Increase'),
                'bs_content_font_scale_decrease' => $this->t('Decrease'),
              ],
              '#default_value' => $stylesConfiguration['content_font_scale'],
            ],
          ],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $stylesForm = $form_state->getValues()['tabs']['block_styles'];
    $stylesConfiguration = &$this->configuration['block_styles'];
    $stylesConfiguration['icon'] = $stylesForm['bs_block_icon']['bs_icon']['value'] ?? $stylesConfiguration['icon'];
    $stylesConfiguration['icon_position'] = $stylesForm['bs_block_icon']['bs_icon_position'] ?? $stylesConfiguration['icon_position'];
    $stylesConfiguration['icon_color'] = $stylesForm['bs_block_icon']['bs_icon_color'] ?? $stylesConfiguration['icon_color'];
    $stylesConfiguration['icon_size'] = $stylesForm['bs_block_icon']['bs_icon_size'] ?? $stylesConfiguration['icon_size'];
    $stylesConfiguration['heading'] = $stylesForm['bs_block_heading']['bs_heading'] ?? $stylesConfiguration['heading'];
    $stylesConfiguration['heading_alignment'] = $stylesForm['bs_block_heading']['bs_heading_alignment'] ?? $stylesConfiguration['heading_alignment'];
    $stylesConfiguration['heading_style'] = $stylesForm['bs_block_heading']['bs_heading_style'] ?? $stylesConfiguration['heading_style'];
    $stylesConfiguration['background_style'] = $stylesForm['bs_block_style']['bs_background_style'] ?? $stylesConfiguration['background_style'];
    $stylesConfiguration['title_font_scale'] = $stylesForm['bs_block_typography']['bs_title_font_scale'] ?? $stylesConfiguration['title_font_scale'];
    $stylesConfiguration['content_font_scale'] = $stylesForm['bs_block_typography']['bs_content_font_scale'] ?? $stylesConfiguration['content_font_scale'];
    parent::blockSubmit($form, $form_state);
  }

}
