<?php  

class BkaUtils{

    public static function optimize_image($file_path) {
        $editor = wp_get_image_editor($file_path);
        if (is_wp_error($editor)) {
            return $file_path; // Return original if there's an error
        }
        // Resize the image to a maximum width and height
        $editor->resize(300, 300, true);

        // Save the optimized image
        $editor->save($file_path);

        if (file_exists($file_path)) {
            return $file_path;
        } else {
            return new WP_Error('image_save_error', 'Failed to save image');
        }        
    }

    public static function upload_and_optimize_image($file) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        $upload = wp_handle_upload($file, ['test_form' => false]);
        if (!isset($upload['error']) && isset($upload['url'])) {
            $image = BkaUtils::optimize_image(isset($upload['file']));
            if (is_wp_error($image)) {
                WP_Error(['message' => 'Error optimizing image'], 400);
                return;
            }
            return $upload['url'];
        } else {
            return new WP_Error('image_upload_error', 'Failed to upload image');
        }
    }
}