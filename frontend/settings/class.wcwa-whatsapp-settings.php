<?php

class WC_WA_Whatsapp_Settings
{
    function __construct()
    {
        add_action('woocommerce_thankyou', array($this, 'send_whatsapp_notification_on_new_order'), 10, 1);
    }

    public function send_whatsapp_notification_on_new_order($order_id)
    {
        if (!$order_id) return;

        // Get an instance of the order object
        $order = wc_get_order($order_id);

        // Admin phone number
        $admin_phone_number = get_option('wc_noti_admin_phone');
        $user_billing_number = $order->billing_phone;

        // echo $user_billing_number;
        // echo $order->billing_first_name;
        $product_details = "";
        foreach ($order->get_items() as $item_id => $item) {
            $product_details .= $item->get_name() . 'X' . $item->get_quantity() . ' ,';
        }

        // Your WhatsApp Business API credentials
        $access_token = get_option('wc_noti_api_key');
        $whatsapp_number_id = get_option('wc_noti_whatsapp_id');
        $whatsapp_api_url = 'https://graph.facebook.com/v19.0/' . $whatsapp_number_id . '/messages';


        // Prepare the message
        $messageAdmin = 'New order received. Order ID: ' . $order_id;
        $messageUser = 'Hello ' . $order->billing_first_name . ', Your order for ' . $product_details . ' has been placed successfully.';

        // Send the WhatsApp notification to admin, if enabled in WP settings
        if (get_option('wc_noti_admin_enable') == 'on') {
            $this->send_whatsapp_message($admin_phone_number, $messageAdmin, $whatsapp_api_url, $access_token);
        }
        if (get_option('wc_noti_customer_noti_enable')) {
            $this->send_whatsapp_message($user_billing_number, $messageUser, $whatsapp_api_url, $access_token);
        }
    }

    public function send_whatsapp_message($to, $message, $whatsapp_api_url, $access_token)
    {
        $data = array(
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => array(
                'body' => $message
            ),
        );

        $post = json_encode($data);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token,
        );

        $ch = curl_init($whatsapp_api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('WhatsApp API error: ' . curl_error($ch));
        }
        curl_close($ch);
        if (get_option('wc_noti_debug_enable') == 'on') {
            echo $response;
        }

        return $response;
    }
}
