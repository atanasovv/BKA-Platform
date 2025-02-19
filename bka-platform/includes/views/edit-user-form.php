<?php
// TODO: change id to be current user id


$currentId = 3; 
$bka_user = $bka_user_repo->find_by_id($currentId);

if ($bka_user) {
    ?>


<div class="edit-user-form">
    <form id="edit-user-form" method="POST" enctype="multipart/form-data">
        <?php wp_nonce_field('edit_user_action', 'edit_user_nonce'); ?>
        <input type="hidden" name="user_id" value="<?php echo esc_attr($bka_user->ID); ?>">
        <input type="hidden" name="protection_tocken" value="<?php echo esc_attr($bka_user->get_protection_tocken()); ?>">
        <div class="profile-section">
            <div class="profile-image">
            <img src="<?php echo esc_url($bka_user->profile_image_url); ?>" alt='Profile Image'>
                <label for="profile_image"> <?php _e('Profile Image','bka-platform'); ?>:</label>  
                <input type="file" id="profile_image" name="profile_image" accept="image/*">          
            </div>            
            <label for="email"> <?php _e('Email','bka-platform'); ?>:</label>
            <input type="email" id="email" name="email" value="<?php echo esc_attr($bka_user->email); ?>" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />
        </div>

        <div class="language-tabs">
            <ul class="tabs">
                <?php foreach ($bka_user->get_bka_user_details() as $details): 
                    $lang_code = esc_attr($details->lang_code);
                    $native_name = esc_attr($details->lang_code);
                    ?>
                 <li class="tab-link" data-tab="tab-<?php echo $native_name; ?>" ><?php echo $native_name; ?></li>
                <?php endforeach; ?>
               
            </ul>
            
       
           <?php foreach ($bka_user->get_bka_user_details() as $details): 
                $lang_code = esc_attr($details->lang_code);
                $native_name = esc_attr($details->lang_code);
                
            ?>

                <div id="tab-<?php echo esc_attr($native_name); ?>" class="tab-content">
                    <input type="hidden" name="lang_code[]" value="<?php echo esc_attr($lang_code); ?>">
                    <input type="hidden" name="protection_tocken_<?php echo esc_attr($lang_code); ?>" value="<?php echo esc_attr($details->get_protection_tocken()); ?>">
                    <input type="hidden" name="bka_user_details_id_<?php echo esc_attr($lang_code); ?>" value="<?php echo esc_attr($details->ID); ?>">                    


                    <label for="first_name_<?php echo esc_attr($lang_code); ?>"> <?php _e('First Name','bka-platform'); ?>:</label>
                    <input type="text" id="first_name_<?php echo esc_attr($lang_code); ?>" name="first_name_<?php echo esc_attr($lang_code); ?>" value="<?php echo esc_attr($details->first_name); ?>" required>
                    
                    <label for="last_name_<?php echo esc_attr($lang_code); ?>"> <?php _e('Last Name','bka-platform'); ?>:</label>
                    <input type="text" id="last_name_<?php echo esc_attr($lang_code); ?>" name="last_name_<?php echo esc_attr($lang_code);?>" value="<?php echo esc_attr($details->last_name); ?>" required>
                    
                    <label for="short_description_<?php echo esc_attr($lang_code); ?>"> <?php _e('Short Description','bka-platform'); ?>:</label>
                    <textarea id="short_description_<?php echo esc_attr($lang_code); ?>" name="short_description_<?php echo esc_attr($lang_code);?>"><?php echo esc_textarea($details->short_description); ?></textarea>
                    
                    <label for="about_<?php echo esc_attr($lang_code); ?>"> <?php _e('About','bka-platform'); ?>:</label>
                    <textarea id="about_<?php echo esc_attr($lang_code); ?>" name="about_<?php echo esc_attr($lang_code);?>"><?php echo esc_textarea($details->about); ?></textarea>
                </div>
            <?php endforeach; ?>
        </div>

        <input type="submit" name="update_user" value="<?php _e('Update', 'bka-platform'); ?>">
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.tab-link');
    var contents = document.querySelectorAll('.tab-content');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('current'); });
            contents.forEach(function(c) { c.classList.remove('current'); });

            tab.classList.add('current');
            document.getElementById(tab.getAttribute('data-tab')).classList.add('current');
        });
    });

    // Set the first tab as active by default
    if (tabs.length > 0) {
        tabs[0].classList.add('current');
        contents[0].classList.add('current');
    }
});
</script>

<?php
} else {
    echo '<p>' . __('User not found.', 'bka-platform') . '</p>';
}
?>