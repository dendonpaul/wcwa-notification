<div class="wrap">
    <!-- <h1>My Plugin Settings</h1> -->
    <form method="post" action="options.php">
        <?php
        // Output security fields for the registered setting
        settings_fields('wc_noti_settings_group');
        // Output setting sections and their fields
        do_settings_sections('wc_noti_settings_group');
        // Output save settings button
        submit_button();
        ?>
    </form>
</div>