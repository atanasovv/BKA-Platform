<?php 
$coaches = $this->bca_user_repo->find_all(); 
shuffle($coaches);
?>
       
<div class="coach-search">
    <input type="text" id="coach-search-input" placeholder="<?php _e('Search coaches...', 'bka-platform'); ?>">
</div>
<div class="coach-list">
    <?php foreach ($coaches as $coach): ?>
        <?php $details = $coach->get_bka_user_details(DEFAULT_LANG_CODE); ?>
        <div class="coach-item" itemscope itemtype="https://schema.org/Person">
            <div class="coach-image">
                <img src="<?php echo esc_url($coach->profile_image_url); ?>" alt="<?php echo esc_attr($details->first_name . ' ' . $details->last_name); ?>" itemprop="image">
            </div>
            <div class="coach-info">
                
                <h2 itemprop="name"><strong><?php echo esc_html($details->first_name . ' ' . $details->last_name); ?></strong></h2>
                <p itemprop="description"><em><?php echo esc_html($details->short_description); ?></em></p>
                <p><?php _e('Sessions count:', 'bka-platform'); ?> <span itemprop="numberOfSessions"><?php echo esc_html($coach->number_of_sessions); ?></span></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('coach-search-input');
        var coachItems = document.querySelectorAll('.coach-item');

        searchInput.addEventListener('input', function() {
            var filter = searchInput.value.toLowerCase();
            coachItems.forEach(function(item) {
                var name = item.querySelector('[itemprop="name"]').textContent.toLowerCase();
                var description = item.querySelector('[itemprop="description"]').textContent.toLowerCase();
                if (name.includes(filter) || description.includes(filter)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
