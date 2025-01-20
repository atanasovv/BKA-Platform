<?php
class DatabaseManager {

    public static function create_database() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_prefix = $wpdb->prefix;
        $sql_files = [
            'create-clients-table.sql',
            'create-coaches-table.sql',
            'create-sessions-table.sql',
            'create-questions-table.sql',
            'create-question-translations-table.sql'
        ];

        foreach ($sql_files as $file) {
            $file_path = BKA_PLATFORM_PLUGIN_PATH . 'includes/databases/' . $file;
            if (file_exists($file_path)) {
                $sql = file_get_contents($file_path);
                $sql = str_replace('{charset_collate}', $charset_collate, $sql);
                $sql = str_replace('{table_prefix}', $table_prefix, $sql);
                $wpdb->query($sql);
            }
        }
    }

    public static function delete_database() {
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