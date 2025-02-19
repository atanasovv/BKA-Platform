<?php


class CoachController {
    private $bka_user_repo;
    private $bka_user_details_repo;

    public function __construct() {
        $this->bka_user_repo = new BkaUserRepository();
        $this->bka_user_details_repo = new BkaUserDetailsRepository();
    }

    public function display_coaches_shortcode($atts) {
        ob_start();
        $this->render_coaches_list();
        return ob_get_clean();
    }

    public static function render_coach_edit_form() {
        $bka_user_repo = new BkaUserRepository();
        $bka_user_details_repo = new BkaUserDetailsRepository();         
        ob_start();
        include BKA_PLATFORM_PLUGIN_PATH . 'includes/views/edit-user-form.php';
        return ob_get_clean();
    }

    public function render_coaches_list() {
        ob_start();
        $coaches = $this->bca_user_repo->find_all();
        include BKA_PLATFORM_PLUGIN_PATH . 'includes/views/coaches-list.php';
        return ob_get_clean();
    }

    public function render_coach_profile($coach_id) {
        ob_start();
        $coach = $this->bca_user_repo->find_by_id($coach_id);
        include BKA_PLATFORM_PLUGIN_PATH . 'includes/views/coach-profile.php';
        return ob_get_clean();
    }

    public function render_coach_profile_edit($coach_id) {
        ob_start();
        $coach = $this->bca_user_repo->find_by_id($coach_id);
        include BKA_PLATFORM_PLUGIN_PATH . 'includes/views/edit-coach-form.php';
        return ob_get_clean();
    }

    public function update_coach() {
        if (!isset($_POST['edit_user_nonce']) || !wp_verify_nonce($_POST['edit_user_nonce'], 'edit_user_nonce')) {
            // wp_die(__('update_user: Invalid nonce', 'bka-platform'));
            //TODO: Enable form nonce validation
        }
        $user_id = get_current_user_id();
        $protection_tocken = sanitize_text_field($_POST['protection_tocken']);
        $id = sanitize_text_field($_POST['user_id']);   
        $email = sanitize_email($_POST['email']);

        $current_bka_user = $this->bka_user_repo->find_by_id($id);

        if($protection_tocken != $current_bka_user->get_protection_tocken()){
            wp_die(__('update_user: Invalid protection tocken', 'bka-platform'));
        }       

        $bka_user = new BkaUser($user_id, $user_id, '', $email, '', '');
        if ($bka_user){
            $bka_user->ID = $current_bka_user->ID;
            $bka_user->user_id = $current_bka_user->user_id;
            $bka_user->email = $email;
        }
        # TODO: Unify parsing of the Post data
        if ($_FILES['profile_image']['size'] > 0) {            
            $bka_user->profile_image_url = BkaUtils::upload_and_optimize_image($_FILES['profile_image']);
        }

        foreach ($_POST['lang_code'] as $lang_code) {
            $details_id = sanitize_text_field($_POST["bka_user_details_id_$lang_code"]);
            $protection_tocken = sanitize_text_field($_POST["protection_tocken_$lang_code"]);
            $first_name = sanitize_text_field($_POST["first_name_$lang_code"]);
            $last_name = sanitize_text_field($_POST["last_name_$lang_code"]);
            $short_description = sanitize_textarea_field($_POST["short_description_$lang_code"]);
            $about = sanitize_textarea_field($_POST["about_$lang_code"]);

            # Get user Details
            $current_details = $this->bka_user_details_repo->find($details_id);

            if($protection_tocken != $current_details->get_protection_tocken()){
                wp_die(__('update_user: Invalid protection tocken', 'bka-platform'));
            }

            if ($current_details) {
                $current_details->first_name = $first_name;
                $current_details->last_name = $last_name;
                $current_details->short_description = $short_description;
                $current_details->about = $about;
            }
            $this->bka_user_details_repo->update($current_details->ID, $current_details);
        }   

        $this->bka_user_repo->update_bka_user($current_bka_user->ID, $bka_user);


        wp_redirect($_SERVER['HTTP_REFERER']);
        exit;
     }
}

?>