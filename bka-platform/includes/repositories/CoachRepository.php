<?php
class CoachRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('bka_coaches');
    }

    protected function to_array($coach) {
        return [
            'id' => $coach->id,
            'user_id' => $coach->user->ID,
            'first_name' => $coach->first_name,
            'last_name' => $coach->last_name,            
            'number_of_sessions' => $coach->number_of_sessions,
            'short_description' => $coach->short_description,
            'about' => $coach->about,
            'profile_image_url' => $coach->profile_image_url,
        ];
    }

    protected function to_object($row) {
        return new Coach(
            $row->ID,
            $row->user_id,
            $row->first_name,
            $row->last_name,
            $row->number_of_sessions,
            $row->short_description,
            $row->about,
            $row->profile_image_url
        );
    }

    public function from_post_data($post_data) {
        
        $first_name = isset($post_data['coach_first_name']) ? sanitize_text_field($post_data['coach_first_name']) : '';
        $last_name = isset($post_data['coach_last_name']) ? sanitize_text_field($post_data['coach_last_name']) : '';
        $number_of_sessions = 0;
        $short_description = isset($post_data['coach_short_description']) ? sanitize_textarea_field($post_data['coach_short_description']) : '';
        $about = isset($post_data['coach_about']) ? sanitize_textarea_field($post_data['coach_about']) : '';
        $profile_image_url = isset($post_data['coach_profile_image']) ? esc_url_raw($post_data['coach_profile_image']) : '';
        $email = isset($post_data['coach_email']) ? sanitize_email($post_data['coach_email']) : '';
        if (empty($email)) {
            return new WP_Error('empty_email', 'Email is required');
        }
        $role = isset($post_data['coach_role']) ? sanitize_text_field($post_data['coach_role']) : 'coach';
        $password = isset($post_data['coach_password']) ? sanitize_text_field($post_data['coach_password']) : '';
        $user_id = wp_create_user($email, $password, $email);
        if (is_wp_error($user_id)) {
            return $user_id;
        }
        else {
            $user = new WP_User($user_id);
            $user->set_role($role);
        }

        $coach = new Coach(
            null,
            $user_id,
            $first_name,
            $last_name,
            $number_of_sessions,
            $short_description,
            $about,
            $profile_image_url
        );

        if (! $coach instanceof Coach) {
            log_error('Invalid coach');
            return new WP_Error('invalid_coach', 'Invalid coach');
            wp_delete_user($user_id);
        }

        return $coach;
    }

    public function find_all() {
        $results = $this->wpdb->get_results("SELECT * FROM {$this->table}");
        return array_map([$this, 'to_object'], $results);
    }
}
?>