<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BkaUserDetailsRepository extends BaseRepository {
    public function __construct($table_name = null) {
        $table = $table_name ? $table_name : BKA_USER_DETAILS_TABLE;
        parent::__construct($table);            

    }

    public function get_details_by_user_id($user_id) {
        $sql = $this->wpdb->prepare("SELECT * FROM $this->table WHERE user_id = %d", $user_id);
        $row = $this->wpdb->get_results($sql);        
        return array_map(array($this, 'to_object'), $row);
    }

    protected function to_array($bka_user_details) {
        if ($bka_user_details->ID !== 0) {
            $data['ID'] = $bka_user_details->ID;
        }
        return [            
            'user_id' => $bka_user_details->user_id,
            'lang_code' => $bka_user_details->lang_code,
            'first_name' => $bka_user_details->first_name,
            'last_name' => $bka_user_details->last_name,
            'short_description' => $bka_user_details->short_description,
            'about' => $bka_user_details->about,
        ];
    }
    
    protected function to_object($row) {
        return new BkaUserDetails(
            $row->ID,
            $row->user_id,
            $row->lang_code,
            $row->first_name,
            $row->last_name,
            $row->short_description ?? '',
            $row->about ?? ''
        );
    }
}