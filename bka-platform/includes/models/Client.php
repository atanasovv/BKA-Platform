<?php

class Client {
    public $id;
    public $user_id;
    public $creation_date;
    public $activation_code;
    public $status;
    public $registration_date;

    public function __construct($id, $user_id, $creation_date, $activation_code, $status, $registration_date) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->creation_date = $creation_date;
        $this->activation_code = $activation_code;
        $this->status = $status;
        $this->registration_date = $registration_date;
    }
}
?>