<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


abstract class BaseRepository {
    protected $table;
    protected $wpdb;
    protected $lang_code;
    

    public function __construct($table) {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix . $table;
        $this->lang_code = get_locale();
    }

    public function get_table_name() {
        return $this->table;
    }

    public function insert($data) {
        $this->wpdb->insert($this->table, $this->to_array($data));
        return $this->wpdb->insert_id;
    }

    public function update($id, $data) {
        return $this->wpdb->update($this->table, $this->to_array($data), ['ID' => $id]);
    }

    public function delete($id) {
        return $this->wpdb->delete($this->table, ['ID' => $id]);
    }

    public function find($id) {
        $result = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->table} WHERE ID = %d", $id));
        return $this->to_object($result);
    }

    public function find_all() {
        $results = $this->wpdb->get_results("SELECT * FROM {$this->table}");
        return array_map([$this, 'to_object'], $results);
    }

    protected abstract function to_array($object);
    protected abstract function to_object($row);
}
?>