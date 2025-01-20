<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

include_once plugin_dir_path(__FILE__) . 'includes/bka-database-manager.php';

// Delete the database tables
DatabaseManager::delete_database();