<?php

class ShortcodeRegistrar {
    public function __construct() {
        add_action('init', [$this, 'register_shortcodes']);
    }

    public function register_shortcodes() {
        add_shortcode('registration_form', [$this, 'render_registration_form']);
    }

    public function render_registration_form() {
        ob_start();
        include BKA_PLATFORM_PLUGIN_PATH . 'includes/views/register-form.php';
        return ob_get_clean();
    }
}
?>