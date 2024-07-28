<?php

class WC_WA_Noti_Register_Settings
{
    //Register Fields.
    function __construct()
    {
        add_action('admin_menu', array($this, 'wc_whatsapp_notification_settings'));
        add_action('admin_init', array($this, 'wc_register_fields'));
    }

    //Add Menu to admin sidebar
    public function wc_whatsapp_notification_settings()
    {
        add_menu_page('WooCommerce WhatsApp Notification', 'WC Notification', 'manage_options', 'wc-noti-settings', array($this, 'showSettingsPage'));
        // add_submenu_page('wc-notification', 'WC Notification Settings', 'WC Settings', 'manage_options', 'wc-noti-settings', array($this, 'showSettingsPage'));
    }

    //Show contents in Dashboardpage
    public function showDashboardPage()
    {
        echo "Please go to the WC Settings page below to configure the WhatsApp API Key and WhatsApp Number ID to send the WhatsApp Notifications.";
    }

    //Show content in WC Settings page
    public function showSettingsPage()
    {
        require_once(WC_WA_NOTI_PATH . '/admin/views/wcwa-show-forms.php');
    }

    //Register Fields for the Settings
    public function wc_register_fields()
    {
        //Register settings
        register_setting('wc_noti_settings_group', 'wc_noti_api_key');
        register_setting('wc_noti_settings_group', 'wc_noti_whatsapp_id');
        register_setting('wc_noti_settings_group', 'wc_noti_admin_phone');
        register_setting('wc_noti_settings_group', 'wc_noti_admin_enable');
        register_setting('wc_noti_settings_group', 'wc_noti_customer_noti_enable');
        register_setting('wc_noti_settings_group', 'wc_noti_debug_enable');

        //Add section
        add_settings_section('wc_noti_section1', 'WC Notification Settings', null, 'wc_noti_settings_group');

        //Add Fields
        add_settings_field('wc_noti_api_key', 'WhatsApp API Key', array($this, 'wc_noti_api_key_field_callback'), 'wc_noti_settings_group', 'wc_noti_section1');
        add_settings_field('wc_noti_whatsapp_id', 'WhatsApp Number ID', array($this, 'wc_noti_whatsapp_id_field_callback'), 'wc_noti_settings_group', 'wc_noti_section1');
        add_settings_field('wc_noti_admin_enable', 'Enable Admin Order Notification?', array($this, 'wc_noti_admin_notification_enable_callback'), 'wc_noti_settings_group', 'wc_noti_section1');
        add_settings_field('wc_noti_admin_phone', 'Admin WhatsApp Number', array($this, 'wc_noti_admin_phone_field_callback'), 'wc_noti_settings_group', 'wc_noti_section1');
        add_settings_field('wc_noti_customer_noti_enable', 'Enable Customer Notification?', array($this, 'wc_noti_customer_noti_enable_field_callback'), 'wc_noti_settings_group', 'wc_noti_section1');
        add_settings_field('wc_noti_debug_enable', 'Enable Debug?', array($this, 'wc_noti_debug_enable_field_callback'), 'wc_noti_settings_group', 'wc_noti_section1');
    }

    //register input field for API Key
    public function wc_noti_api_key_field_callback()
    {
        $wc_api_key = get_option('wc_noti_api_key');
?>
        <input type="text" id="wc_noti_api_key" name="wc_noti_api_key" value="<?php echo isset($wc_api_key) ? $wc_api_key : '' ?>" />
    <?php
    }

    //Register input field for Number ID
    public function wc_noti_whatsapp_id_field_callback()
    {
        $wc_number_id = get_option('wc_noti_whatsapp_id');

    ?>
        <input type="text" name="wc_noti_whatsapp_id" id="wc_noti_whatsapp_id" value="<?php echo isset($wc_number_id) ? $wc_number_id : '' ?>" />
    <?php
    }

    //Register input field for admin email
    public function wc_noti_admin_phone_field_callback()
    {
        $wc_admin_phone = get_option('wc_noti_admin_phone');
    ?>
        <input type="number" name="wc_noti_admin_phone" id="wc_noti_admin_phone" value="<?php echo isset($wc_admin_phone) ? $wc_admin_phone : '' ?>" />
    <?php
    }

    //Enable admin notification
    public function wc_noti_admin_notification_enable_callback()
    {
        $wc_noti_admin_enable = get_option('wc_noti_admin_enable');
    ?>
        <input type="checkbox" name="wc_noti_admin_enable" id="wc_noti_admin_enable" <?php echo ($wc_noti_admin_enable == 'on') ? 'checked' : '' ?> />
    <?php
    }

    //Enable customer notification
    public function wc_noti_customer_noti_enable_field_callback()
    {
        $wc_noti_customer_enable = get_option('wc_noti_customer_noti_enable');
    ?>
        <input type="checkbox" name="wc_noti_customer_noti_enable" id="wc_noti_customer_noti_enable" <?php echo $wc_noti_customer_enable == 'on' ? 'checked' : '' ?> />
    <?php
    }

    //Enable debug mode
    public function wc_noti_debug_enable_field_callback()
    {
        $wc_noti_debug_enable = get_option('wc_noti_debug_enable');
    ?>
        <input type="checkbox" name="wc_noti_debug_enable" id="wc_noti_debug_enable" <?php echo $wc_noti_debug_enable == 'on' ? 'checked' : '' ?> />
<?php
    }
} ?>