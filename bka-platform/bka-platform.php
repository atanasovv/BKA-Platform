<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link    http://example.com
 * @since   0.0.1-beta
 * @package Bka_Platform
 *
 * @wordpress-plugin
 * Plugin Name:       BKA Platform
 * Plugin URI:        http://github.com/bka-media/bka-platform
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Vladislav Atanasov
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bka-platform
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

define('BKA_PLATFORM_VERSION', '1.0.0');
define('DEFAULT_LANG_CODE', function_exists('pll_current_language') ? pll_current_language() : get_locale());

if (! class_exists('BkaPlatform')) {

    class BkaPlatform
    {

        public function __construct()
        {
            define('BKA_PLATFORM_PLUGIN_PATH', plugin_dir_path(__FILE__));
            include_once plugin_dir_path(__FILE__) . '/vendor/autoload.php';
        }

        public function initialize()
        {
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/bka-utilities.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/bka-option-page.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/bka-platform-i18n.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/bka-database-manager.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/bks-global-variables.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/bka-router.php';

            # Repositories
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/repositories/BaseRepository.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/repositories/ClientRepository.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/repositories/CoachRepository.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/repositories/SessionRepository.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/repositories/BkaUserRepository.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/repositories/QuestionRepository.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/repositories/QuestionTranslationRepository.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/repositories/BkaUserDetailsRepository.php';

            # Models
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/models/BkaUser.php';    
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/models/Session.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/models/Question.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/models/QuestionTranslation.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/controllers/RegisterController.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/ShortcodeRegistrar.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/bka-register-pages.php';
            include_once BKA_PLATFORM_PLUGIN_PATH . '/includes/controllers/CoachController.php';

            
 
            register_activation_hook(__FILE__, array($this, 'activate'));
            register_deactivation_hook(__FILE__, array($this, 'deactivate'));
            
        }

        public function activate()
        {
            $db_manager = new DatabaseManager();
            $db_manager->create_database();
            $register_pages = new BkaRegisterPages();
            $register_pages->register();
        }
        public function deactivate()
        {
            $register_pages = new BkaRegisterPages();
            $register_pages->remove();
        }

        public function set_local()
        {
            $plugin_i18n = new Bka_Platform_i18n();
            $plugin_i18n->load_plugin_textdomain();
        }
    }

    $bkaPlatform = new BkaPlatform();
    $bkaPlatform->initialize();
    $bkaPlatform->set_local();

    $shortcodeRegistrar = new ShortcodeRegistrar();
    $shortcodeRegistrar->register_shortcodes();

 

    add_action('wp_enqueue_scripts', function () {
        wp_enqueue_style('bka-platform-style', plugins_url('/includes/assets/css/bka-style.css', __FILE__), array(), BKA_PLATFORM_VERSION);
        wp_enqueue_script('bka-platform-script', plugins_url('/includes/assets/js/bka.js', __FILE__), array('jquery'), BKA_PLATFORM_VERSION, true);
    });

}
