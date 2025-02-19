<?php
class DatabaseManager {

    public function __construct() {
    }

    public $table_prefix;
    public $charset_collate;

    public function create_database() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_prefix = $wpdb->prefix;
        $sql_files = ['create-bka-users-table-users.sql',
            'create-bka-user-details-table-bka-users.sql',
            'create-sessions-table-bka-users.sql',
            'create-questions-table-bka-users.sql',
            'create-question-translations-table-questions.sql'
        ];

        foreach ($sql_files as $file) {
            $file_path = BKA_PLATFORM_PLUGIN_PATH . 'includes/databases/' . $file;
            if (file_exists($file_path)) {
                $sql = file_get_contents($file_path);
                $sql = str_replace('{charset_collate}', $charset_collate, $sql);
                $sql = str_replace('{table_prefix}', $table_prefix, $sql);
                $sql = str_replace('{table_name}', $this->extract_table_name_from_file_name($file) , $sql);
                $sql = str_replace('{foreing_name}', $this->extract_foreing_name_from_file_name($file) , $sql);   
                $wpdb->query($sql);
            }
            else {
                error_log("File not found: $file_path");
            }
        }
    }

    public function extract_table_name_from_file_name($file_name) {
        $table_name = preg_replace('/^create-(.*?)-table-.*?\.sql$/', '$1', $file_name);
        $table_name = str_replace('-', '_', $table_name);
        return $table_name;
    }

    public function extract_foreing_name_from_file_name($file_name) {
        $table_name = preg_replace('/^create-(.*?)-table-(.*?)\.sql$/', '$2', $file_name);
        $table_name = str_replace('-', '_', $table_name);
        return $table_name;
    }

    public function delete_database() {
        global $wpdb;
        $sql_files = glob(__DIR__ . 'includes/databases/delete_*.sql');

        foreach ($sql_files as $file) {
            $table_name = $wpdb->prefix . basename($file, '.sql');
            $sql = "DROP TABLE IF EXISTS $table_name;";
            $wpdb->query($sql);
        }
    }   
    
}
?>