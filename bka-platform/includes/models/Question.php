<?php

class Question {
    public $id;
    public $wp_user_id;
    public $type;

    public function __construct($id, $wp_user_id, $type) {
        $this->id = $id;
        $this->wp_user_id = $wp_user_id;
        $this->type = $type;
    }
}
?>