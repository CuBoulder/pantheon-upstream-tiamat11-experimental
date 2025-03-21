<?php

namespace Drupal\Tests\menu_firstchild\Functional;

use Drupal\Core\Url;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\system\Entity\Menu;
use Drupal\system\MenuStorage;
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\menu_ui\Traits\MenuUiTrait;

/**
 * Test Menu Links.
 *
 * @group menu_firstchild
 */
class MenuFirstchildTest extends BrowserTestBase {

  use MenuUiTrait;
  use StringTranslationTrait;

  /**
   * The modules to load to run the test.
   *
   * @var array
   */
  protected static $modules = [
    'node',
    'field',
    'text',
    'options',
    'block',
    'contextual',
    'menu_link_content',
    'menu_ui',
    'path',
    'menu_firstchild',
  ];

  /**
   * Nodes created during setup.
   *
   * @var array
   */
  protected $nodes = [];

  /**
   * Default theme.
   *
   * @var string
   */
  protected $defaultTheme = 'claro';

  /**
   * A user with administration rights.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * An authenticated user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $authenticatedUser;

  /**
   * A test menu.
   *
   * @var \Drupal\system\Entity\Menu
   */
  protected $menu;

  /**
   * {@inheritdoc}
   */
  protected function setUp() : void {
    parent::setUp();

    $this->adminUser = $this->drupalCreateUser([
      'access administration pages',
      'administer blocks',
      'administer menu',
    ]);
    $this->authenticatedUser = $this->drupalCreateUser([]);

    $this->drupalCreateContentType([
      'type' => 'page',
      'name' => 'Basic page',
      'display_submitted' => FALSE,
    ]);

    // Create a few Nodes.
    $this->nodes[] = $this->drupalCreateNode([
      'type' => 'page',
      'status' => TRUE,
      'title' => 'Item 1',
    ]);

    $this->nodes[] = $this->drupalCreateNode([
      'type' => 'page',
      'status' => TRUE,
      'title' => 'Item 1',
    ]);
  }

  /**
   * Test Basic Functionality.
   */
  public function testBasicFunc() {
    $session = $this->assertSession();

    // Goto First node created.
    $first_url = Url::fromRoute('entity.node.canonical', ['node' => $this->nodes[0]->id()])->toString();
    $node_f_url = "/node/" . $this->nodes[0]->id();
    $this->drupalGet($node_f_url);
    $session->statusCodeEquals(200);

    // Goto Second node created.
    $second_url = Url::fromRoute('entity.node.canonical', ['node' => $this->nodes[1]->id()])->toString();
    $node_s_url = "/node/" . $this->nodes[1]->id();
    $this->drupalGet($node_s_url);
    $session->statusCodeEquals(200);

    // Login Admin User.
    $this->drupalLogin($this->adminUser);

    $this->drupalPlaceBlock('local_actions_block', [
      'label' => 'Primary admin actions',
      'region' => 'content',
      'theme' => 'claro',
    ]);

    $this->drupalGet("admin/structure/block/list/claro");

    // Add Menu Items.
    $this->menu = $this->addCustomMenu();
    $menu_name = $this->menu->id();

    // Test the 'Add link' local action.
    $this->drupalGet(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    // Build Parent Link.
    $this->clickLink($this->t('Add link'));

    $this->submitForm([
      'link[0][uri]' => 'route:<none>',
      'title[0][value]' => "MFC Parent",
      'menu_firstchild_enabled' => TRUE,
      'expanded' => TRUE,
      'description[0][value]' => "MFC Parent",
      'weight[0][value]' => 10,
    ], $this->t('Save'));
    $this->assertSession()->addressEquals(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $menu_links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['title' => "MFC Parent"]);
    $parent_menu_link = reset($menu_links);

    $this->assertInstanceOf(MenuLinkContent::class, $parent_menu_link);
    $this->assertMenuLink(['menu_name' => $menu_name, 'children' => []], $parent_menu_link->getPluginId());

    // Build First Child link.
    $this->clickLink($this->t('Add link'));

    $this->submitForm([
      'link[0][uri]' => '/node/' . $this->nodes[0]->id(),
      'title[0][value]' => "First Child",
      'description[0][value]' => "First Child",
      'menu_parent' => $menu_name . ':' . $parent_menu_link->getPluginId(),
      'weight[0][value]' => 0,
    ], $this->t('Save'));
    $this->assertSession()->addressEquals(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $menu_links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['title' => "First Child"]);
    $c1_menu_link = reset($menu_links);

    $this->assertInstanceOf(MenuLinkContent::class, $c1_menu_link);
    $this->assertMenuLink(['menu_name' => $menu_name, 'parent' => $parent_menu_link->getPluginId()], $c1_menu_link->getPluginId());

    // Build Second Child link.
    $this->clickLink($this->t('Add link'));

    $this->submitForm([
      'link[0][uri]' => '/node/' . $this->nodes[1]->id(),
      'title[0][value]' => "Second Child",
      'description[0][value]' => "Second Child",
      'menu_parent' => $menu_name . ':' . $parent_menu_link->getPluginId(),
      'weight[0][value]' => 10,
    ], $this->t('Save'));
    $this->assertSession()->addressEquals(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $menu_links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['title' => "Second Child"]);
    $c2_menu_link = reset($menu_links);

    $this->assertInstanceOf(MenuLinkContent::class, $c2_menu_link);
    $this->assertMenuLink(['menu_name' => $menu_name, 'parent' => $parent_menu_link->getPluginId()], $c2_menu_link->getPluginId());

    // Go to Homepage.
    $this->drupalGet('<front>');

    // Check for Parent links.
    $this->assertSession()->linkExists($this->t('MFC Parent'));
    $links = $this->xpath('//a[contains(@href, :href)][@title = :label]', [
      ':href' => $first_url,
      ':label' => "MFC Parent",
    ]);
    $this->assertTrue(!empty($links), "MFC Parent Link Does not exist: " . $first_url . " :: " . count($links));

    // Check for Child 1 links /w hierarchy.
    $this->assertSession()->linkExists($this->t('First Child'));
    $links = $this->xpath('//a[contains(@href, :href1)][@title = :label1]/following-sibling::ul[contains(@class, "menu")]/*/a[contains(@href, :href2)][@title = :label2]', [
      ':href1' => $first_url,
      ':label1' => "MFC Parent",
      ':href2' => $first_url,
      ':label2' => "First Child",
    ]);
    $this->assertTrue(!empty($links), "First Child Link Does not exist");

    // Check for Child 2 links /w hierarchy.
    $this->assertSession()->linkExists($this->t('Second Child'));
    $links = $this->xpath('//a[contains(@href, :href1)][@title = :label1]/following-sibling::ul[contains(@class, "menu")]/*/a[contains(@href, :href2)][@title = :label2]', [
      ':href1' => $first_url,
      ':label1' => "MFC Parent",
      ':href2' => $second_url,
      ':label2' => "Second Child",
    ]);
    $this->assertTrue(!empty($links), "Second Child Link Does not exist");

    // Install test module, and clear cache.
    \Drupal::service('module_installer')->install(['menu_firstchild_test']);
    \Drupal::service('cache.menu')->invalidateAll();

    // Refresh Homepage.
    $this->drupalGet('<front>');

    $links = $this->xpath('//a[contains(@class, :class)][@title = :label]', [
      ':class' => "custom-class-to-test-for",
      ':label' => "MFC Parent",
    ]);
  }

  /**
   * Creates a custom menu.
   *
   * Borrowed from Drupal\Tests\menu_ui\Traits\MenuUiTrait.
   *
   * @return \Drupal\system\Entity\Menu
   *   The custom menu that has been created.
   */
  public function addCustomMenu() {
    // Try adding a menu using a menu_name that is too long.
    $this->drupalGet('admin/structure/menu/add');
    $menu_name = strtolower($this->randomMachineName(MenuStorage::MAX_ID_LENGTH + 1));
    $label = $this->randomMachineName(16);
    $edit = [
      'id' => $menu_name,
      'description' => '',
      'label' => $label,
    ];
    $this->submitForm($edit, $this->t('Save'));

    // Verify that using a menu_name that is too long results in a validation
    // message.
    $this->assertSession()->responseContains($this->t('@name cannot be longer than %max characters but is currently %length characters long.', [
      '@name' => $this->t('Menu name'),
      '%max' => MenuStorage::MAX_ID_LENGTH,
      '%length' => mb_strlen($menu_name),
    ]));

    // Change the menu_name so it no longer exceeds the maximum length.
    $menu_name = strtolower($this->randomMachineName(MenuStorage::MAX_ID_LENGTH));
    $edit['id'] = $menu_name;
    $this->submitForm($edit, $this->t('Save'));

    // Verify that no validation error is given for menu_name length.
    $this->assertSession()->responseNotContains($this->t('@name cannot be longer than %max characters but is currently %length characters long.', [
      '@name' => $this->t('Menu name'),
      '%max' => MenuStorage::MAX_ID_LENGTH,
      '%length' => mb_strlen($menu_name),
    ]));
    // Verify that the confirmation message is displayed.
    $this->assertSession()->responseContains($this->t('Menu %label has been added.', ['%label' => $label]));
    $this->drupalGet('admin/structure/menu');
    $this->assertSession()->pageTextContains($label);

    // Confirm that the custom menu block is available.
    $this->drupalGet('admin/structure/block/list/' . $this->config('system.theme')->get('default'));
    $this->clickLink('Place block');
    $this->assertSession()->pageTextContains($label);

    // Enable the block.
    $block = $this->drupalPlaceBlock('system_menu_block:' . $menu_name, [
      'label' => 'Primary admin actions',
      'region' => 'content',
      'theme' => 'claro',
    ]);
    return Menu::load($menu_name);
  }

  /**
   * Test Stacking Functionality.
   */
  public function testStackingFunc() {
    $session = $this->assertSession();

    // Goto First node created.
    $first_url = Url::fromRoute('entity.node.canonical', ['node' => $this->nodes[0]->id()])->toString();
    $node_f_url = "/node/" . $this->nodes[0]->id();
    $this->drupalGet($node_f_url);
    $session->statusCodeEquals(200);

    // Goto Second node created.
    $second_url = Url::fromRoute('entity.node.canonical', ['node' => $this->nodes[1]->id()])->toString();
    $node_s_url = "/node/" . $this->nodes[1]->id();
    $this->drupalGet($node_s_url);
    $session->statusCodeEquals(200);

    // Login Admin User.
    $this->drupalLogin($this->adminUser);

    $this->drupalPlaceBlock('local_actions_block', [
      'label' => 'Primary admin actions',
      'region' => 'content',
      'theme' => 'claro',
    ]);

    $this->drupalGet("admin/structure/block/list/claro");

    // Add Menu Items.
    $this->menu = $this->addCustomMenu();
    $menu_name = $this->menu->id();

    // Test the 'Add link' local action.
    $this->drupalGet(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    // Build Grand Parent Link.
    $this->clickLink($this->t('Add link'));

    $this->submitForm([
      'link[0][uri]' => 'route:<none>',
      'title[0][value]' => "MFC Grand Parent",
      'menu_firstchild_enabled' => TRUE,
      'expanded' => TRUE,
      'description[0][value]' => "MFC Parent",
      'weight[0][value]' => 10,
    ], $this->t('Save'));
    $this->assertSession()->addressEquals(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $menu_links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['title' => "MFC Grand Parent"]);
    $grand_parent_menu_link = reset($menu_links);

    $this->assertInstanceOf(MenuLinkContent::class, $grand_parent_menu_link);
    $this->assertMenuLink(['menu_name' => $menu_name, 'children' => []], $grand_parent_menu_link->getPluginId());

    // Build Parent Link.
    $this->clickLink($this->t('Add link'));

    $this->submitForm([
      'link[0][uri]' => 'route:<none>',
      'title[0][value]' => "MFC Parent",
      'menu_firstchild_enabled' => TRUE,
      'expanded' => TRUE,
      'description[0][value]' => "MFC Parent",
      'menu_parent' => $menu_name . ':' . $grand_parent_menu_link->getPluginId(),
      'weight[0][value]' => 10,
    ], $this->t('Save'));
    $this->assertSession()->addressEquals(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $menu_links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['title' => "MFC Parent"]);
    $parent_menu_link = reset($menu_links);

    $this->assertInstanceOf(MenuLinkContent::class, $parent_menu_link);
    $this->assertMenuLink(['menu_name' => $menu_name, 'children' => []], $parent_menu_link->getPluginId());

    // Build First Child link.
    $this->clickLink($this->t('Add link'));

    $this->submitForm([
      'link[0][uri]' => 'route:<none>',
      'title[0][value]' => "MFC First Child",
      'menu_firstchild_enabled' => TRUE,
      'expanded' => TRUE,
      'description[0][value]' => "MFC First Child",
      'menu_parent' => $menu_name . ':' . $parent_menu_link->getPluginId(),
      'weight[0][value]' => 0,
    ], $this->t('Save'));
    $this->assertSession()->addressEquals(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $menu_links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['title' => "MFC First Child"]);
    $c1_menu_link = reset($menu_links);

    $this->assertInstanceOf(MenuLinkContent::class, $c1_menu_link);
    $this->assertMenuLink(['menu_name' => $menu_name, 'parent' => $parent_menu_link->getPluginId()], $c1_menu_link->getPluginId());

    // Build Second Child link.
    $this->clickLink($this->t('Add link'));

    $this->submitForm([
      'link[0][uri]' => '/node/' . $this->nodes[1]->id(),
      'title[0][value]' => "MFC Second Child",
      'description[0][value]' => "MFC Second Child",
      'menu_parent' => $menu_name . ':' . $parent_menu_link->getPluginId(),
      'weight[0][value]' => 10,
    ], $this->t('Save'));
    $this->assertSession()->addressEquals(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $menu_links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['title' => "MFC Second Child"]);
    $c2_menu_link = reset($menu_links);

    $this->assertInstanceOf(MenuLinkContent::class, $c2_menu_link);
    $this->assertMenuLink(['menu_name' => $menu_name, 'parent' => $parent_menu_link->getPluginId()], $c2_menu_link->getPluginId());





    // Build First Grand Child link.
    $this->clickLink($this->t('Add link'));

    $this->submitForm([
      'link[0][uri]' => '/node/' . $this->nodes[0]->id(),
      'title[0][value]' => "MFC First Grand Child",
      'description[0][value]' => "MFC First Grand Child",
      'menu_parent' => $menu_name . ':' . $c1_menu_link->getPluginId(),
      'weight[0][value]' => 0,
    ], $this->t('Save'));
    $this->assertSession()->addressEquals(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $menu_links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['title' => "MFC First Grand Child"]);
    $gc1_menu_link = reset($menu_links);

    $this->assertInstanceOf(MenuLinkContent::class, $gc1_menu_link);
    $this->assertMenuLink(['menu_name' => $menu_name, 'parent' => $c1_menu_link->getPluginId()], $gc1_menu_link->getPluginId());










    // Go to Homepage.
    $this->drupalGet('<front>');

    // Check for Parent links.
    $this->assertSession()->linkExists($this->t('MFC Parent'));
    $links = $this->xpath('//a[contains(@href, :href)][@title = :label]', [
      ':href' => $first_url,
      ':label' => "MFC Parent",
    ]);
    $this->assertTrue(!empty($links), "MFC Parent Link Does not exist: " . $first_url . " :: " . count($links));

    // Check for Child 1 links /w hierarchy.
    $this->assertSession()->linkExists($this->t('First Child'));
    $links = $this->xpath('//a[contains(@href, :href1)][@title = :label1]/following-sibling::ul[contains(@class, "menu")]/*/a[contains(@href, :href2)][@title = :label2]', [
      ':href1' => $first_url,
      ':label1' => "MFC Parent",
      ':href2' => $first_url,
      ':label2' => "MFC First Child",
    ]);
    $this->assertTrue(!empty($links), "First Child Link Does not exist");

    // Check for Child 2 links /w hierarchy.
    $this->assertSession()->linkExists($this->t('Second Child'));
    $links = $this->xpath('//a[contains(@href, :href1)][@title = :label1]/following-sibling::ul[contains(@class, "menu")]/*/a[contains(@href, :href2)][@title = :label2]', [
      ':href1' => $first_url,
      ':label1' => "MFC Parent",
      ':href2' => $second_url,
      ':label2' => "MFC Second Child",
    ]);
    $this->assertTrue(!empty($links), "Second Child Link Does not exist");

    // Install test module, and clear cache.
    \Drupal::service('module_installer')->install(['menu_firstchild_test']);
    \Drupal::service('cache.menu')->invalidateAll();

    // Refresh Homepage.
    $this->drupalGet('<front>');

    $links = $this->xpath('//a[contains(@class, :class)][@title = :label]', [
      ':class' => "custom-class-to-test-for",
      ':label' => "MFC Parent",
    ]);
  }

}
