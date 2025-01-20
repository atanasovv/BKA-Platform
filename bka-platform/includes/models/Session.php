<?php

class Session {
    public $id;
    public $start_datetime;
    public $status;
    public $coach_id;
    public $client_id;

    public function __construct($id, $start_datetime, $status, $coach_id, $client_id) {
        $this->id = $id;
        $this->start_datetime = $start_datetime;
        $this->status = $status;
        $this->coach_id = $coach_id;
        $this->client_id = $client_id;
    }
}
?>