<?php

Class BkaUser  {
    public int $ID;
    public int $user_id;
    public string $profile_image_url;
    public string $email;
    public string $role;
    public int $number_of_sessions;
    private WP_User $wp_user;
    private array $bka_user_details = [];

    public function __construct($id, $user_id, $profile_image_url, $email, $password, $role){
        $this->ID = $id;
        $this->user_id = $user_id;
        $this->profile_image_url = $profile_image_url;
        $this->role = $role;
        $this->email = $email;
        $this->user_id = $user_id;
        $this->number_of_sessions = 0;     
    }     

    public function add_bka_user_details(BkaUserDetails $bka_user_details){
        $this->bka_user_details[$bka_user_details->lang_code] = $bka_user_details;
    }

    
    public function get_bka_user_details($lang_code = null){
        if ($lang_code == null){
            return $this->bka_user_details ?? null;
        }
        else{
            return $this->bka_user_details[$lang_code] ?? null;
        }  
    }

    public function get_protection_tocken(){
        return hash('sha256', $this->user_id . $this->email);
    }

}

class BkaUserDetails {
    public int $ID;
    public int $user_id;
    public string $lang_code;
    public string $first_name;
    public string $last_name;
    public string $short_description;
    public string $about;
   

    public function __construct($id, 
                        $user_id, 
                        $lang_code, 
                        $first_name, 
                        $last_name, 
                        $short_description=null, 
                        $about=null){
        $this->ID = $id;
        $this->user_id = $user_id;
        $this->lang_code = $lang_code;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->short_description = $short_description;
        $this->about = $about;
        }
    public function get_protection_tocken(){
            return hash('sha256', $this->user_id . $this->first_name . $this->last_name);
    }

   
}