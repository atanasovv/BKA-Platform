<?php

class BkaRegisterPages {
    private $pages_config = [
        [
            'post_title' => 'Login',
            'post_name' => 'login',
            'post_content' => '[login_form]',
            'post_type' => 'page',
            'post_status' => 'publish',
        ],
        [
            'post_title' => 'Register',
            'post_name' => 'register',
            'post_content' => '[registration_form]',
            'post_type' => 'page',
            'post_status' => 'publish',
        ],
    ];

    public function register() {
        foreach ($this->pages_config as $page) {
            // Dynamically add post_author
            $page['post_author'] = get_current_user_id();
            $this->createPage($page);
        }
    }

    public function remove() {
        foreach ($this->pages_config as $page) {
            $existing_page = get_page_by_path($page['post_name']);
            if ($existing_page) {
                wp_delete_post($existing_page->ID, true);
            }
        }
    }

    private function createPage($page) {
        $existing_page = get_page_by_path($page['post_name']); // Match key name
        if (!$existing_page) {
            wp_insert_post($page);
        }
    }
}
