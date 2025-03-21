<?php

namespace Drupal\menu_firstchild;

use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Url;

/**
 * Class MenuItemParser.
 *
 * @package Drupal\menu_firstchild
 */
class MenuItemParser {

  /**
   * Parses a menu item and modifies it if menu_firstchild is enabled.
   *
   * @param array $item
   *   Menu item array.
   * @param string $menu_name
   *   Menu machine name.
   *
   * @return array
   *   Menu item array.
   */
  public function parse(array $item, $menu_name) {

    // If menu_firstchild is enabled on the menu item, continue parsing it.
    if ($this->enabled($item)) {
      $tree = $this->childTree($item, $menu_name);

      // Preserve Title.
      $original_attributes = $item['url']->getOption('attributes');
      $original_title = isset($original_attributes['title']) ? $original_attributes['title'] : FALSE;

      // Children found, get url of first one.
      if (count($tree)) {
        // Grab first real url.
        // $first_child = reset($tree);
        $first_child = $this->getFirstChildRecursivly($tree);
        $url = $first_child->link->getUrlObject();
      }
      else {
        $first_child = NULL;
        $url = Url::fromRoute('<none>');
      }

      // Create a new URL so we don't copy attributes etc.
      if ($url->isRouted()) {
        $item['url'] = Url::fromRoute($url->getRouteName(), $url->getRouteParameters());
      }
      else {
        $item['url'] = Url::fromUri($url->getUri());
      }

      // Add a class on the menu item so it can be themed accordingly.
      $item['attributes']->addClass('menu-firstchild');

      // Add title user entered from Menu Link form.
      if ($original_title) {
        $new_attrs = $item['url']->getOption('attributes');
        $new_attrs['title'] = $original_title;
        $item['url']->setOption("attributes", $new_attrs);
      }

      \Drupal::moduleHandler()->alter('menu_firstchild_item', $item, $first_child);
    }

    // Parse all children if any are found.
    if (!empty($item['below'])) {
      foreach ($item['below'] as &$below) {
        $below = $this->parse($below, $menu_name);
      }
    }

    return $item;
  }

  /**
   * Returns the URL of the first child of given menu item.
   *
   * This does take into account menu_firstchild.
   *
   * @param array $item
   *   Menu item array.
   * @param string $menu_name
   *   Menu machine name.
   *
   * @return \Drupal\Core\Url
   *   URL to use in the link.
   */
  protected function firstChildUrl(array $item, $menu_name) {
    // Get tree.
    $tree = $this->childTree($item, $menu_name);

    // Children found, get url of first one.
    if (count($tree)) {
      $first_child = reset($tree);
      $url = $first_child->link->getUrlObject();
    }
    else {
      $url = Url::fromRoute('<none>');
    }

    return $url;
  }

  /**
   * Returns the URL of the first child of given menu item.
   *
   * This does take into account menu_firstchild.
   *
   * @param array $item
   *   Menu item array.
   * @param string $menu_name
   *   Menu machine name.
   *
   * @return array
   *   Menu tree below current item.
   */
  protected function childTree(array $item, $menu_name) {
    // Init menu tree.
    $menu_tree = \Drupal::menuTree();

    // Get parameters of given link.
    $id = $item['original_link']->getPluginId();
    $parameters = new MenuTreeParameters();
    $parameters->setRoot($id)->excludeRoot()->setMaxDepth(9)->onlyEnabledLinks();

    // Load the tree based on this set of parameters.
    $tree = $menu_tree->load($menu_name, $parameters);

    // Transform the tree.
    $manipulators = [
      // Only show links that are accessible for the current user.
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      // Use the default sorting of menu links.
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];

    // Get tree.
    $tree = $menu_tree->transform($tree, $manipulators);

    return $tree;
  }

  /**
   * Returns whether menu_firstchild is enabled on a menu item.
   *
   * @param array $item
   *   Menu item array.
   *
   * @return bool
   *   Returns TRUE if menu_firstchild is enabled on the menu item.
   */
  protected function enabled(array $item) {
    $options = ($item['url'] instanceof Url) ? $item['url']->getOption('menu_firstchild') : [];
    return !empty($options['enabled']);
  }

  /**
   * Find the correct first child element.
   *
   * This allows for stacking elements.
   *
   * @param array $tree
   *   Menu Tree.
   *
   * @return array
   *    Menu item.
   */
  protected function getFirstChildRecursivly(array $tree) {
    $element = reset($tree);

    $url_obj = $element->link->getUrlObject();
    $url_options = $url_obj->getOption('menu_firstchild');

    if (isset($url_options['enabled']) && $url_options['enabled'] && !empty($element->subtree)) {
      return $this->getFirstChildRecursivly($element->subtree);
    }

    return $element;
  }

}
