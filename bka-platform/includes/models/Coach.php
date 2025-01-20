<?php

class Coach {
    public $id;
    public $user;
    public $first_name;
    public $last_name;
    public $number_of_sessions;
    public $short_description;
    public $about;
    public $profile_image_url;

    public function __construct($id, 
                                $user_id,
                                $first_name,
                                $last_name,
                                $number_of_sessions, 
                                $short_description, 
                                $about, 
                                $profile_image_url) {
        $this->id = $id;
        $this->user = new WP_User($user_id);
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->number_of_sessions = $number_of_sessions;
        $this->short_description = $short_description;
        $this->about = $about;
        $this->profile_image_url = $profile_image_url;
    }
    public function set_role($role) {
        $this->user->set_role($role);
    }

    public function get_role() {
        return $this->user->roles;
    }
}
?>