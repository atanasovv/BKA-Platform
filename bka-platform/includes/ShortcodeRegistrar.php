<?php

class ShortcodeRegistrar {
    public function __construct() {
        add_action('init', [$this, 'register_shortcodes']);  
    }

    public function register_shortcodes() {
        add_shortcode('registration_form', ['RegisterController', 'render_registration_form']);
        add_shortcode('edit_bka_user', ['CoachController', 'render_coach_edit_form']);
        add_shortcode('show_coaches', [$this, 'render_coaches_list']);     
 
    }

    public function render_registration_form() {
        ob_start();
        include BKA_PLATFORM_PLUGIN_PATH . 'includes/views/register-form.php';
        return ob_get_clean();
    }
    public function render_coaches_list() {
        $coach_controller = new CoachController();
        return $coach_controller->render_coaches_list();
    }

   
}
?>