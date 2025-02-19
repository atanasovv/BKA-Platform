<?php


class SessionRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('bka_sessions');
    }

    protected function to_array($session) {
        return [
            'start_datetime' => $session->start_datetime,
            'status' => $session->status,
            'coach_id' => $session->coach_id,
            'client_id' => $session->client_id,
        ];
    }

    protected function to_object($row) {
        return new Session(
            $row->id,
            $row->start_datetime,
            $row->status,
            $row->coach_id,
            $row->client_id
        );
    }
}
?>