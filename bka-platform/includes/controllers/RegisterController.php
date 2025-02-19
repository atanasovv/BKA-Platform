<?php

class RegisterController {
    private $bka_user_repo;
    private $bka_user_details_repo;
    private $client_repo;
    public function __construct() {

 
        $this->bka_user_repo = new BkaUserRepository();
        $this->client_repo = new ClientRepository();
        $this->bka_user_details_repo = new BkaUserDetailsRepository();
    }

    public static function render_registration_form() {
        ob_start();
        include BKA_PLATFORM_PLUGIN_PATH . 'includes/views/register-form.php';
        return ob_get_clean();
    }

    private function bka_register() {

        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        $bka_user = $this->bka_user_repo->from_post_data($_POST);

        if (is_wp_error($bka_user)) {
            $error_message = $bka_user->get_error_message();
            add_filter('registration_errors', function($errors) use ($error_message) {
                $errors->add('bka_registration_error', $error_message);
                return $errors;
            });
            return;
        }

    }

}
new RegisterController();
?>