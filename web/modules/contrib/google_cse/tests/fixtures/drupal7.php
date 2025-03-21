<?php
// phpcs:ignoreFile
/**
 * @file
 * A database agnostic dump for testing purposes.
 *
 * This file was generated by the Drupal 9.2.9 db-tools.php script.
 */

use Drupal\Core\Database\Database;

$connection = Database::getConnection();

$connection->schema()->createTable('system', array(
  'fields' => array(
    'filename' => array(
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '255',
      'default' => '',
    ),
    'name' => array(
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '255',
      'default' => '',
    ),
    'type' => array(
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '12',
      'default' => '',
    ),
    'owner' => array(
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '255',
      'default' => '',
    ),
    'status' => array(
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'default' => '0',
    ),
    'bootstrap' => array(
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'default' => '0',
    ),
    'schema_version' => array(
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'small',
      'default' => '-1',
    ),
    'weight' => array(
      'type' => 'int',
      'not null' => TRUE,
      'size' => 'normal',
      'default' => '0',
    ),
    'info' => array(
      'type' => 'blob',
      'not null' => FALSE,
      'size' => 'normal',
    ),
  ),
  'primary key' => array(
    'filename',
  ),
  'indexes' => array(
    'system_list' => array(
      'status',
      'bootstrap',
      'type',
      'weight',
      'name',
    ),
    'type_name' => array(
      'type',
      'name',
    ),
  ),
  'mysql_character_set' => 'utf8mb3',
));

$connection->insert('system')
->fields(array(
  'filename',
  'name',
  'type',
  'owner',
  'status',
  'bootstrap',
  'schema_version',
  'weight',
  'info',
))
->values(array(
  'filename' => 'modules/search/search.module',
  'name' => 'search',
  'type' => 'module',
  'owner' => '',
  'status' => '1',
  'bootstrap' => '0',
  'schema_version' => '7000',
  'weight' => '0',
  'info' => 'a:14:{s:4:"name";s:6:"Search";s:11:"description";s:36:"Enables site-wide keyword searching.";s:7:"package";s:4:"Core";s:7:"version";s:4:"7.84";s:4:"core";s:3:"7.x";s:5:"files";a:2:{i:0;s:19:"search.extender.inc";i:1;s:11:"search.test";}s:9:"configure";s:28:"admin/config/search/settings";s:11:"stylesheets";a:1:{s:3:"all";a:1:{s:10:"search.css";s:25:"modules/search/search.css";}}s:7:"project";s:6:"drupal";s:9:"datestamp";s:10:"1639410569";s:5:"mtime";i:1639410569;s:12:"dependencies";a:0:{}s:3:"php";s:5:"5.2.4";s:9:"bootstrap";i:0;}',
))
->values(array(
  'filename' => 'sites/all/modules/contrib/google_cse/google_cse.module',
  'name' => 'google_cse',
  'type' => 'module',
  'owner' => '',
  'status' => '1',
  'bootstrap' => '0',
  'schema_version' => '7201',
  'weight' => '0',
  'info' => 'a:14:{s:4:"name";s:10:"Google CSE";s:11:"description";s:68:"Use Google Custom Search to search your site and/or any other sites.";s:4:"core";s:3:"7.x";s:12:"dependencies";a:1:{i:0;s:6:"search";}s:5:"files";a:5:{i:0;s:18:"google_cse.install";i:1;s:17:"google_cse.module";i:2;s:20:"google_cse.admin.inc";i:3;s:20:"google_cse.theme.inc";i:4;s:21:"tests/google_cse.test";}s:7:"scripts";a:1:{s:13:"google_cse.js";s:50:"sites/all/modules/contrib/google_cse/google_cse.js";}s:11:"stylesheets";a:1:{s:3:"all";a:1:{s:14:"google_cse.css";s:51:"sites/all/modules/contrib/google_cse/google_cse.css";}}s:7:"version";s:14:"7.x-3.0-alpha1";s:7:"project";s:10:"google_cse";s:9:"datestamp";s:10:"1493228052";s:5:"mtime";i:1493228052;s:7:"package";s:5:"Other";s:3:"php";s:5:"5.2.4";s:9:"bootstrap";i:0;}',
))
->values(array(
  'filename' => 'modules/system/system.module',
  'name' => 'system',
  'type' => 'module',
  'owner' => '',
  'status' => '1',
  'bootstrap' => '0',
  'schema_version' => '7084',
  'weight' => '0',
  'info' => 'a:14:{s:4:"name";s:6:"System";s:11:"description";s:54:"Handles general site configuration for administrators.";s:7:"package";s:4:"Core";s:7:"version";s:4:"7.84";s:4:"core";s:3:"7.x";s:5:"files";a:6:{i:0;s:19:"system.archiver.inc";i:1;s:15:"system.mail.inc";i:2;s:16:"system.queue.inc";i:3;s:14:"system.tar.inc";i:4;s:18:"system.updater.inc";i:5;s:11:"system.test";}s:8:"required";b:1;s:9:"configure";s:19:"admin/config/system";s:7:"project";s:6:"drupal";s:9:"datestamp";s:10:"1639410569";s:5:"mtime";i:1639410569;s:12:"dependencies";a:0:{}s:3:"php";s:5:"5.2.4";s:9:"bootstrap";i:0;}',
))
->execute();

$connection->schema()->createTable('variable', array(
  'fields' => array(
    'name' => array(
      'type' => 'varchar',
      'not null' => TRUE,
      'length' => '128',
      'default' => '',
    ),
    'value' => array(
      'type' => 'blob',
      'not null' => TRUE,
      'size' => 'big',
    ),
  ),
  'primary key' => array(
    'name',
  ),
  'mysql_character_set' => 'utf8mb3',
));

$connection->insert('variable')
->fields(array(
  'name',
  'value',
))
->values(array(
  'name' => 'google_cse_cof_google',
  'value' => 's:7:"FORID:1";',
))
->values(array(
  'name' => 'google_cse_cof_here',
  'value' => 's:8:"FORID:10";',
))
->values(array(
  'name' => 'google_cse_custom_css',
  'value' => 's:15:"some stylesheet";',
))
->values(array(
  'name' => 'google_cse_custom_results_display',
  'value' => 's:10:"two-column";',
))
->values(array(
  'name' => 'google_cse_cx',
  'value' => 's:15:"abcgooglecustom";',
))
->values(array(
  'name' => 'google_cse_results_display',
  'value' => 's:4:"here";',
))
->values(array(
  'name' => 'google_cse_results_display_images',
  'value' => 'i:1;',
))
->values(array(
  'name' => 'google_cse_results_prefix',
  'value' => 's:11:"some prefix";',
))
->values(array(
  'name' => 'google_cse_results_searchbox_width',
  'value' => 's:2:"47";',
))
->values(array(
  'name' => 'google_cse_results_suffix',
  'value' => 's:11:"some suffix";',
))
->values(array(
  'name' => 'google_cse_results_tab',
  'value' => 's:14:"somecustomname";',
))
->values(array(
  'name' => 'google_cse_results_searchbox_width',
  'value' => 's:3:"608";',
))
->values(array(
  'name' => 'search_active_modules',
  'value' => 'a:3:{s:10:"google_cse";s:10:"google_cse";s:4:"node";s:4:"node";s:4:"user";s:4:"user";}',
))
->values(array(
  'name' => 'search_default_module',
  'value' => 's:10:"google_cse";',
))
->execute();
