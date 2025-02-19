<div class="registration-tabs">
    
    <div class="tab-header">
        <div class="tabs">
            <div class="tab-link current" data-tab="coach"> <?php _e('Register coach', 'bka-platform');?> </div>
            <div class="tab-link" data-tab="client"><?php _e('Register client', 'bka-platform');?></div>
        </div>
    </div>
    <div id="tab-1" class="tab-content current">
        <form id="coach-registration-form" method="POST" enctype="multipart/form-data">
            <?php wp_nonce_field('register_action', 'register_nonce'); ?>

            <input type="hidden" id='role' name="role" value="coach">

            <label for="first_name"> <?php _e('First Name','bka-platform'); ?>:</label> 
            <input type="text" id="first_name" name="first_name" required >

            <label for="last_name"> <?php _e('Last Name','bka-platform'); ?>:</label>            
            <input type="text" id="last_name" name="last_name" required>

            <label for="email"> <?php _e('Email','bka-platform'); ?>:</label>
            <input type="email" id="email" name="email" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />

            <label for="coach_password"> <?php _e('Password','bka-platform'); ?>:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password"> <?php _e('Confirm Password','bka-platform'); ?>:</label>
            <span id="password_error" class="password-error"></span>
            <input type="password" id="confirm_password" name="confirm_password" required >

            <label for="profile_image"> <?php _e('Profile Image','bka-platform'); ?>:</label>
            <input type="file" id="profile_image" name="profile_image">            

            <input type="submit" name="bka_register" value="Register">`
        </form>
    </div>    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.tab-link');
    currentRole = '';
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {  
            tabs.forEach(function(t) { t.classList.remove('current'); });          
            
            currentRole = tab.getAttribute('data-tab');
            document.getElementById('role').value = currentRole; 
            tab.classList.add('current');
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

    validatePassword('registration-form', 'password', 'confirm_password');
    validatePasswordOnExit('password', 'confirm_password', 'coach_password_error');
});
</script>