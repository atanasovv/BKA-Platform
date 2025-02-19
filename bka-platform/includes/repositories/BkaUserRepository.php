<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


class BkaUserRepository extends BaseRepository {
    private $detailsRepo = null;
    

    public function __construct($table_name = null) {
        $table = $table_name ? $table_name : BKA_USERS_TABLE;
        parent::__construct('bka_users');
        $this->detailsRepo = new BkaUserDetailsRepository();
        
    }

    protected function to_array($bka_user) {
        if ($bka_user->ID !== 0) {
            $data['ID'] = $bka_user->ID;
        }
        $data = [
            'user_id' => $bka_user->user_id,
            'profile_image_url' => $bka_user->profile_image_url,
            'role' => $bka_user->role,
            'email' => $bka_user->email,
        ];

        

        return $data;
    }

    protected function to_object($row) {
        return new BkaUser(
            $row->ID,
            $row->user_id,
            $row->profile_image_url,
            $row->email,
            null,
            $row->role
        );
    }

    public function from_post_data($post_data) {        

        if (!empty($_FILES['profile_image'])) {
            $profile_image_url = upload_and_optimize_image($_FILES['profile_image']);
        }
        
        $role = isset($post_data['role']) ? sanitize_text_field($post_data['role']) : '';
        if (empty($post_data['email'])) {
            return new WP_Error('missing_email', __('Email is required.', 'text-domain'));
        }
        if (empty($post_data['password'])) {
            return new WP_Error('missing_password', __('Password is required.', 'text-domain'));
        }
        $email = sanitize_email($post_data['email']);
        if (email_exists($email)) {
            return new WP_Error('email_exists', __('This email is already registered.', 'text-domain'));
        }
        $password = isset($post_data['password']) ? sanitize_text_field($post_data['password']) : '';

        $user_id = $this->create_wp_user($email, $password, $role);

        if (is_wp_error($user_id)) {
            return new WP_Error('Error creating user: ' . $user_id->get_error_message());
        }       

        $bka_user = new BkaUser(
            0,
            $user_id,                        
            $profile_image_url,
            $email,
            $password,
            $role
        );

        
        
        $first_name = isset($post_data["first_name"]) ? sanitize_text_field($post_data["first_name"]) : '';
        $last_name = isset($post_data["last_name"]) ? sanitize_text_field($post_data["last_name"]) : '';
        $number_of_sessions = isset($post_data["number_of_sessions"]) ? intval($post_data["number_of_sessions"]) : 0;
        $short_description = isset($post_data["short_description"]) ? sanitize_textarea_field($post_data["short_description"]) : '';
        $about = isset($post_data["about"]) ? sanitize_textarea_field($post_data["about"]) : '';
        $profile_image_url = isset($post_data["profile_image_url"]) ? esc_url_raw($post_data["profile_image_url"]) : '';
   
        $bka_user->ID = $this->insert($bka_user);
        if (is_wp_error($bka_user->ID)) {
            WP_Error(['message' => 'Error creating user'], 400);
        }

        $details = new BkaUserDetails(
            0,
            $bka_user->ID, 
            DEFAULT_LANG_CODE,
            $first_name,
            $last_name,
            $short_description,
            $about
        );
        
        $details->ID = $this->detailsRepo->insert($details);

        $bka_user->add_bka_user_details($details);

        return $bka_user;
    }

    private function create_wp_user($email, $password, $role){
        $userdata = [
            'user_login' => $email,
            'user_pass'  => $password,
            'user_email' => $email,
            'role'       => $role,
        ];

        if (email_exists($email)) {
            return new WP_Error('email_exists', __('Error: User with this email already exists.', 'text-domain'));
        }

        $user_id = wp_insert_user($userdata);

        if (is_wp_error($user_id)) {
            return new WP_Error('Error creating user: ' . $user_id->get_error_message());            
        }

        return $user_id;
    }

    public function to_object_users_and_details($row){
        $bka_user = $this->to_object($row);
        $details = $this->detailsRepo->to_object($row);
        $bka_user->add_bka_user_details($details);
        return $bka_user;
    }



    public function find_all() {
        global $DEFAULT_LANG_CODE;
        $results = $this->wpdb->get_results("
                SELECT 
                    *
                FROM 
                    wp_bka_users AS u
                LEFT JOIN 
                    wp_bka_user_details AS ud 
                ON 
                    u.`ID` = ud.user_id
                where u.`role` = 'coach' 
                and 
                ud.`lang_code` = '$this->lang_code'");
                $result = array_map([$this, 'to_object_users_and_details'], $results);
                return $result;
    }

    public function find_by_id($user_id) {
        $results = $this->find($user_id);
        $result =  $this->to_object($results);  
        $details = $this->detailsRepo->get_details_by_user_id($result->ID);
        foreach ($details as $detail) {
            $result->add_bka_user_details($detail);
        }
                    
        return $result;
    }    

    public function update_bka_user($ID, $bka_user) {
        $this->update($ID, $bka_user);
        
    }    
}
?>