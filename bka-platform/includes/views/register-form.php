<div class="registration-tabs">
    
    <div class="tab-header">
        <div class="tabs">
            <div class="tab-link current" data-tab="tab-1"> <?php _e('Register coach', 'bka-platform');?> </div>
            <div class="tab-link" data-tab="tab-2"><?php _e('Register client', 'bka-platform');?></div>
        </div>
    </div>
    <div id="tab-1" class="tab-content current">
        <form id="coach-registration-form" method="POST" enctype="multipart/form-data">
            <?php wp_nonce_field('register_coach_action', 'register_coach_nonce'); ?>
            <input type="hidden" name="coach_role" value="coach">

            <label for="coach_first_name"> <?php _e('First Name','bka-platform'); ?>:</label> 
            <input type="text" id="coach_first_name" name="coach_first_name" required >

            <label for="coach_last_name"> <?php _e('Last Name','bka-platform'); ?>:</label>            
            <input type="text" id="coach_last_name" name="coach_last_name" required>

            <label for="coach_email"> <?php _e('Email','bka-platform'); ?>:</label>
            <input type="email" id="coach_email" name="coach_email" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />

            <label for="coach_password"> <?php _e('Password','bka-platform'); ?>:</label>
            <input type="password" id="coach_password" name="coach_password" required>

            <label for="coach_confirm_password"> <?php _e('Confirm Password','bka-platform'); ?>:</label>
            <span id="coach_password_error" class="password-error"></span>
            <input type="password" id="coach_confirm_password" name="coach_confirm_password" required >

            <label for="coach_profile_image"> <?php _e('Profile Image','bka-platform'); ?>:</label>
            <input type="file" id="coach_profile_image" name="coach_profile_image">

            <label for="coach_short_description"> <?php _e('Short Description','bka-platform');?> :</label>
            <textarea id="coach_short_description" name="coach_short_description"></textarea>

            <label for="coach_about"> <?php _e('About','bka-platform'); ?>:</label>
            <textarea id="coach_about" name="coach_about"></textarea>

            <input type="submit" name="register_coach" value="Register">`
        </form>
    </div>
    <div id="tab-2" class="tab-content">
        <form id="client-registration-form" method="post">
            <input type="hidden" name="user_role" value="client">
            <label for="client_first_name"> <?php _e('First Name','bka-platform'); ?>:</label>
            <input type="text" id="client_first_name" name="client_first_name" required>
            <label for="client_last_name"> <?php _e('Last Name','bka-platform'); ?>:</label>
            <input type="text" id="client_last_name" name="client_last_name" required>
            <label for="client_email"> <?php _e('Email','bka-platform'); ?>:</label>
            <input type="email" id="client_email" name="client_email" required>
            <label for="client_password"> <?php _e('Password','bka-platform'); ?>:</label>
            <input type="password" id="client_password" name="client_password" required>
            <label for="client_confirm_password"> <?php _e('Confirm Password','bka-platform'); ?>:</label>
            <span id="client_password_error" class="password-error"></span>
            <input type="password" id="client_confirm_password" name="client_confirm_password" required>
            <input type="submit" name="register_client" value="Register">
        </form>
    </div>
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

    function validatePassword(formId, passwordId, confirmPasswordId) {
        var form = document.getElementById(formId);
        form.addEventListener('submit', function(event) {
            var password = document.getElementById(passwordId).value;
            var confirmPassword = document.getElementById(confirmPasswordId).value;
            if (password !== confirmPassword) {
                event.preventDefault();
                alert('<?php _e('Passwords do not match', 'bka-platform'); ?>');
            }
        });
    }

    function validatePasswordOnExit(passwordId, confirmPasswordId, errorId) {
        var confirmPasswordField = document.getElementById(confirmPasswordId);
        var errorField = document.getElementById(errorId);
        confirmPasswordField.addEventListener('blur', function() {
            var password = document.getElementById(passwordId).value;
            var confirmPassword = confirmPasswordField.value;
            if (password !== confirmPassword) {
                errorField.textContent = '<?php _e('Passwords do not match', 'bka-platform'); ?>';
                confirmPasswordField.style.border = '1px solid red';
            } else {
                errorField.textContent = '';
                confirmPasswordField.style.border = '';
            }
        });
    }

    validatePassword('coach-registration-form', 'coach_password', 'coach_confirm_password');
    validatePassword('client-registration-form', 'client_password', 'client_confirm_password');
    validatePasswordOnExit('coach_password', 'coach_confirm_password', 'coach_password_error');
    validatePasswordOnExit('client_password', 'client_confirm_password', 'client_password_error');
});
</script>