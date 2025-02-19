<?php

class ClientRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('bka_clients');
    }
 

    public function from_post_data($post_data){
        $first_name = isset($post_data['client_first_name']) ? sanitize_text_field($post_data['client_first_name']) : '';
        $last_name = isset($post_data['client_last_name']) ? sanitize_text_field($post_data['client_last_name']) : '';
        $email = isset($post_data['client_email']) ? sanitize_email($post_data['client_email']) : '';
        if (empty($email)) {
            return new WP_Error('empty_email', 'Email is required');
        }
        $password = isset($post_data['client_password']) ? sanitize_text_field($post_data['client_password']) : '';
        $user_id = wp_create_user($email, $password, $email);
        if (is_wp_error($user_id)) {
            return $user_id;
        }
        else {
            $user = new WP_User($user_id);
            $user->set_role('client');
        }

        $client = new Client(
            null,
            $user_id,
            $first_name,
            $last_name,
            $password,
            $email
        );

        return $client;
    }

    protected function to_array($client) {
        return [
            'client_id' => $client->client_id,
            'user_id' => $client->user_id,
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
            'email' => $client->email,
        ];
    }

    protected function to_object($row) {
        return new Client(
            $row->client_id,
            $row->user_id,
            $row->first_name,
            $row->last_name,
            null,
            $row->email
        );
    }
}
?>