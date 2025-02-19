<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

include_once plugin_dir_path(__FILE__) . 'includes/bka-database-manager.php';

// Delete the database tables
$db_manager = new DatabaseManager();
$db_manager->delete_database();