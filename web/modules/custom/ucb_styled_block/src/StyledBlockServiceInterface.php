<?php

namespace Drupal\ucb_styled_block;

/**
 * Defines a service with helper methods which can be called as a public API.
 */
interface StyledBlockServiceInterface {

  /**
   * Converts the input to a valid background style CSS class.
   *
   * @param string $input
   *   The user-input background style machine name.
   *
   * @return string
   *   The CSS class.
   */
  public function backgroundStyle($input);

  /**
   * Converts the input to a valid title font scale CSS class.
   *
   * @param string $input
   *   The user-input title font scale machine name.
   *
   * @return string
   *   The CSS class.
   */
  public function titleFontScale($input);

  /**
   * Converts the input to a valid content font scale CSS class.
   *
   * @param string $input
   *   The user-input content font scale machine name.
   *
   * @return string
   *   The CSS class.
   */
  public function contentFontScale($input);

  /**
   * Converts the input to a valid icon CSS class.
   *
   * @param string $input
   *   The user-input icon HTML.
   *
   * @return string
   *   The CSS class.
   */
  public function icon($input);

  /**
   * Converts the input to a valid icon color CSS class.
   *
   * @param string $input
   *   The user-input icon color machine name.
   *
   * @return string
   *   The CSS class.
   */
  public function iconColor($input);

  /**
   * Converts the input to a valid icon position CSS class.
   *
   * @param string $input
   *   The user-input icon position machine name.
   *
   * @return string
   *   The CSS class.
   */
  public function iconPosition($input);

  /**
   * Converts the input to a valid icon size CSS class.
   *
   * @param string $input
   *   The user-input icon size machine name.
   *
   * @return string
   *   The CSS class.
   */
  public function iconSize($input);

  /**
   * Converts the input to a valid heading HTML tag.
   *
   * @param string $input
   *   The user-input heading machine name.
   *
   * @return string
   *   The HTML tag.
   */
  public function heading($input);

  /**
   * Converts the input to a valid heading alignment CSS class.
   *
   * @param string $input
   *   The user-input heading alignment machine name.
   *
   * @return string
   *   The CSS class.
   */
  public function headingAlignment($input);

  /**
   * Converts the input to a valid heading style CSS class.
   *
   * @param string $input
   *   The user-input heading style machine name.
   *
   * @return string
   *   The CSS class.
   */
  public function headingStyle($input);

  /**
   * Gets a block style's output.
   *
   * @param string $styleName
   *   The machine name of the block style.
   * @param string $input
   *   The user-input machine name of the block style's value.
   *
   * @return string
   *   The output of this block style, or the default output if the input isn't
   *   valid.
   */
  public function getStyleOutput($styleName, $input);

  /**
   * Gets all the default block style values.
   *
   * @return array
   *   The default block style values.
   */
  public function getDefaultStyleValues();

  /**
   * Gets all the default block style outputs.
   *
   * @return array
   *   The default block style outputs.
   */
  public function getDefaultStyleOutputs();

}
