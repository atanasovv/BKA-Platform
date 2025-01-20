<?php

class RegisterController {
    private $coach_repo;
    private $client_repo;
    public function __construct() {
        add_shortcode('registration_form', [$this, 'render_registration_form']);
        add_action('init', [$this, 'handle_form_submission']);
        $this->coach_repo = new CoachRepository();
        $this->client_repo = new ClientRepository();
    }

    public function render_registration_form() {
        ob_start();
        include 'views/register-form.php';
        return ob_get_clean();
    }

    public function handle_form_submission() {
        if (isset($_POST['register_coach'])) {
            if (!isset($_POST['register_coach_nonce']) || !wp_verify_nonce($_POST['register_coach_nonce'], 'register_coach_action')) {
                // Invalid nonce
                wp_die(__('Security check failed', 'bka-platform'));
            }
            $this->register_coach();
        } elseif (isset($_POST['register_client'])) {
            if (!isset($_POST['register_client_nonce']) || !wp_verify_nonce($_POST['register_client_nonce'], 'register_client_action')) {
                // Invalid nonce
                wp_die(__('Security check failed', 'bka-platform'));
            }
            $this->register_client();
        }
    }

    private function register_coach() {

        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $coach = $this->coach_repo->from_post_data($_POST);  
        if (is_wp_error($coach)) {            // Handle error
            wp_send_json_error(['message' => 'Error creating user'], 400);
            return;
        }         
        
        if (!empty($_FILES['coach_profile_image'])) {         
            $upload = wp_handle_upload($_FILES['coach_profile_image'], ['test_form' => false]);
            if (!isset($upload['error']) && isset($upload['url'])) {
                $coach->profile_image_url = $upload['url'];
            }
        }

             
        
        $this->coach_repo->insert($coach);
    }

    private function register_client() {
        $username = sanitize_user($_POST['client_username']);
        $email = sanitize_email($_POST['client_email']);
        $password = $_POST['client_password'];

        $user_id = wp_create_user($username, $password, $email);
        if (is_wp_error($user_id)) {
            // Handle error
            return;
        }

        $client_repo = new ClientRepository();
        $new_client = new Client(null, $user_id, current_time('mysql'), '', 'active', current_time('mysql'));
        $client_repo->insert($new_client);
    }
}

new RegisterController();
?>