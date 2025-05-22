<?php
require_once dirname(__FILE__) . '/khalti_config.php';

function get_khalti_payment_button($amount, $order_id, $product_name) {
    $amount_in_paisa = $amount * 100; // Khalti expects amount in paisa
    $button_id = 'khalti-payment-button-' . $order_id;
    
    return "
    <button id='" . $button_id . "' class='btn-payment btn-khalti'>Pay with Khalti</button>
    <script src='https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.22.0.0.0/khalti-checkout.iffe.js'></script>
    <script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function() {
            var config = {
                'publicKey': '" . KHALTI_PUBLIC_KEY . "',
                'productIdentity': '" . $order_id . "',
                'productName': '" . addslashes($product_name) . "',
                'productUrl': window.location.origin + '/Ecommerce%20Website/',
                'amount': " . $amount_in_paisa . ",
                'callbackUrl': '" . KHALTI_SUCCESS_URL . "',
                eventHandler: {
                    onSuccess: function (payload) {
                        console.log('Payment successful:', payload);
                        window.location.href = '" . KHALTI_SUCCESS_URL . "?token=' + payload.token + '&amount=' + payload.amount;
                    },
                    onError: function (error) {
                        console.log('Payment error:', error);
                        alert('Payment failed. Please try again.');
                    },
                    onClose: function () {
                        console.log('Khalti widget closed');
                    }
                }
            };
            
            var btn = document.getElementById('" . $button_id . "');
            if(btn) {
                var checkout = new KhaltiCheckout(config);
                btn.onclick = function () {
                    checkout.show({popUp: true});
                }
            } else {
                console.error('Khalti payment button not found:', '" . $button_id . "');
            }
        });
    </script>";
}

function verify_khalti_payment($token, $amount) {
    if (empty($token) || empty($amount)) {
        return array('error' => 'Missing token or amount');
    }

    $args = http_build_query(array(
        'token' => $token,
        'amount' => $amount
    ));

    $url = KHALTI_VERIFY_URL;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $headers = [
        'Authorization: Key ' . KHALTI_SECRET_KEY,
        'Content-Type: application/x-www-form-urlencoded'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);
    
    if ($curl_error) {
        return array('error' => 'CURL Error: ' . $curl_error);
    }
    
    $result = json_decode($response, true);
    
    if (KHALTI_DEBUG) {
        error_log('Khalti Response: ' . print_r($result, true));
    }
    
    return $result;
}
?> 