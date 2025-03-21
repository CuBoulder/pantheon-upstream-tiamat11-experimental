<?php

/**
 * @file
 * Hooks related to the Menu Firstchild module.
 */

/**
 * Alter the menu item created by Firstchild.
 *
 * @param array $menu_item
 *   Item to be altered.
 * @param array|null $child
 *   Child menu item, themain item was created from.
 */
function hook_menu_firstchild_item_alter(array &$menu_item, $child) {
  $menu_item['attributes']->addClass('custom-class');
}
