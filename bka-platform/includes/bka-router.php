<?php

class BkaRouter{

    public function __construct() {
        add_action('init', [$this, 'handle_form_submission']);     
    }

        public function handle_form_submission() {
            if (isset($_POST['bka_register'])) {
                if (!isset($_POST['register_nonce']) || !wp_verify_nonce($_POST['register_nonce'], 'register_action')) {
                    //Invalid nonce
                    wp_die(__('Security check failed', 'bka-platform'));
                }
                $register_controller = new RegisterController();
                $register_controller->bka_register();
            }
            if (isset($_POST['update_user'])) {
                if (!isset($_POST['edit_user_nonce']) || !wp_verify_nonce($_POST['edit_user_nonce'], 'edit_user_action')) {
                    // Invalid nonce
                    wp_die(__('Security check failed', 'bka-platform'));
                }
                $coach_controller = new CoachController();
                $coach_controller->update_coach();
            }

            
    }
}
new BkaRouter();
?>