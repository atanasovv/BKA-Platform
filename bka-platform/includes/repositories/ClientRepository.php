<?php


class ClientRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('bka_clients');
    }

    protected function to_array($client) {
        return [
            'user_id' => $client->user_id,
            'creation_date' => $client->creation_date,
            'activation_code' => $client->activation_code,
            'status' => $client->status,
            'registration_date' => $client->registration_date,
        ];
    }

    protected function to_object($row) {
        return new Client(
            $row->id,
            $row->user_id,
            $row->creation_date,
            $row->activation_code,
            $row->status,
            $row->registration_date
        );
    }
}
?>