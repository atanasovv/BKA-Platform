<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if ($coach) {
    ?>
    <div class="coach-profile">
        <h2><?php echo esc_html($coach->get_bka_user_details('en')->first_name . ' ' . $coach->get_bka_user_details('en')->last_name); ?></h2>
        <img src="<?php echo esc_url($coach->profile_image_url); ?>" alt="<?php echo esc_attr($coach->get_bka_user_details('en')->first_name); ?>" class="profile-image">
        <p><strong><?php _e('Email:', 'bka-platform'); ?></strong> <?php echo esc_html($coach->email); ?></p>
        <p><strong><?php _e('Role:', 'bka-platform'); ?></strong> <?php echo esc_html($coach->role); ?></p>
        <p><strong><?php _e('Number of Sessions:', 'bka-platform'); ?></strong> <?php echo esc_html($coach->number_of_sessions); ?></p>
        <p><strong><?php _e('Short Description:', 'bka-platform'); ?></strong> <?php echo esc_html($coach->get_bka_user_details('en')->short_description); ?></p>
        <p><strong><?php _e('About:', 'bka-platform'); ?></strong> <?php echo esc_html($coach->get_bka_user_details('en')->about); ?></p>
    </div>
    <?php
} else {
    echo '<p>' . __('Coach not found.', 'bka-platform') . '</p>';
}
?>