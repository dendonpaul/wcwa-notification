<?php

/**
 * Plugin Name: WooCommerce WhatsApp Notifications
 * Description: Sends WhatsApp notifications to admin on new WooCommerce orders.
 * Version: 1.0
 * Author: Denny Paul
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WC_WA_Notification')) {
    class WC_WA_Notification
    {
        function __construct()
        {
            $this->define_constants();

            //register admin menu and form fields
            require(WC_WA_NOTI_PATH . '/admin/settings/class.wcwa-noti-register-settings.php');

            //WhatsApp Configuration
            require(WC_WA_NOTI_PATH . '/frontend/settings/class.wcwa-whatsapp-settings.php');

            //Start Instances
            $wcwa_noti_register_settings = new WC_WA_Noti_Register_Settings();
            $wcwa_whatsapp_settings = new WC_WA_Whatsapp_Settings();
        }

        //Constants
        public function define_constants()
        {
            define('WC_WA_NOTI_PATH', plugin_dir_path(__FILE__));
            define('WC_WA_NOTI_URL', plugin_dir_url(__FILE__));
            define('WC_WA_NOTI_VERSIO', '1.0.0');
        }

        //Activation
        public static function activate()
        {
            //Flush rewrite rules
            update_option('rewrite_rules', '');
        }

        //Deactivation
        public static function deactivate()
        {
            flush_rewrite_rules();
        }

        //Uninstall
        public static function uninstall()
        {
            //remove data when uninstalling, if required.
        }
    }
}

if (class_exists('WC_WA_Notification')) {
    register_activation_hook(__FILE__, array('WC_WA_Notification', 'activate'));
    register_deactivation_hook(__FILE__, array('WC_WA_Notification', 'deactivate'));
    register_uninstall_hook(__FILE__, array('WC_WA_Notification', 'uninstall'));

    $wcnoti = new WC_WA_Notification();
}
