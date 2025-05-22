<?php
include('./includes/connect.php');
include('./includes/esewa_config.php');
include('./includes/esewa_helper.php');

// Test parameters - using values from eSewa documentation examples
$amount = 100;
$tax_amount = 10;
$total_amount = 110;
$transaction_uuid = "241028"; // This should be unique for each transaction
$merchant_code = ESEWA_MERCHANT_ID;

// Generate signed fields list and values
$signed_field_names = "total_amount,transaction_uuid,product_code";
$values_to_sign = [$total_amount, $transaction_uuid, $merchant_code];

// Generate signature
$signature = generate_esewa_signature($values_to_sign, ESEWA_SECRET_KEY);

// Generate example sign string for documentation
$doc_sign_string = "total_amount,transaction_uuid,product_code";
$doc_example = $total_amount . "," . $transaction_uuid . "," . $merchant_code;
$doc_signature = generate_esewa_signature([$total_amount, $transaction_uuid, $merchant_code], ESEWA_SECRET_KEY);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eSewa Payment Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .card {
            margin-bottom: 20px;
        }
        pre {
            background: #f6f8fa;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">eSewa Payment Test</h1>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Test Parameters</h3>
            </div>
            <div class="card-body">
                <p><strong>Total Amount:</strong> <?php echo $total_amount; ?></p>
                <p><strong>Transaction UUID:</strong> <?php echo $transaction_uuid; ?></p>
                <p><strong>Merchant Code:</strong> <?php echo $merchant_code; ?></p>
                <p><strong>Signed Fields:</strong> <?php echo $signed_field_names; ?></p>
                <p><strong>Values to Sign:</strong> <?php echo implode(",", $values_to_sign); ?></p>
                <p><strong>Secret Key:</strong> <?php echo ESEWA_SECRET_KEY; ?></p>
                <p><strong>Generated Signature:</strong> <?php echo $signature; ?></p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title mb-0">Example From Documentation</h3>
            </div>
            <div class="card-body">
                <p><strong>String to sign:</strong> <?php echo $doc_example; ?></p>
                <p><strong>Generated Signature:</strong> <?php echo $doc_signature; ?></p>
                <p><strong>Expected Signature:</strong> i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0">Test Form</h3>
            </div>
            <div class="card-body">
                <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="tax_amount" value="<?php echo $tax_amount; ?>">
                    <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
                    <input type="hidden" name="transaction_uuid" value="<?php echo $transaction_uuid; ?>">
                    <input type="hidden" name="product_service_charge" value="0">
                    <input type="hidden" name="product_delivery_charge" value="0">
                    <input type="hidden" name="product_code" value="<?php echo $merchant_code; ?>">
                    <input type="hidden" name="success_url" value="<?php echo ESEWA_SUCCESS_URL; ?>">
                    <input type="hidden" name="failure_url" value="<?php echo ESEWA_FAILURE_URL; ?>">
                    <input type="hidden" name="signed_field_names" value="<?php echo $signed_field_names; ?>">
                    <input type="hidden" name="signature" value="<?php echo $signature; ?>">
                    
                    <button type="submit" class="btn btn-primary btn-lg">Test eSewa Payment</button>
                </form>
                
                <hr>
                
                <h5>Form HTML:</h5>
                <pre><?php echo htmlspecialchars('
<form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
    <input type="hidden" name="amount" value="' . $amount . '">
    <input type="hidden" name="tax_amount" value="' . $tax_amount . '">
    <input type="hidden" name="total_amount" value="' . $total_amount . '">
    <input type="hidden" name="transaction_uuid" value="' . $transaction_uuid . '">
    <input type="hidden" name="product_service_charge" value="0">
    <input type="hidden" name="product_delivery_charge" value="0">
    <input type="hidden" name="product_code" value="' . $merchant_code . '">
    <input type="hidden" name="success_url" value="' . ESEWA_SUCCESS_URL . '">
    <input type="hidden" name="failure_url" value="' . ESEWA_FAILURE_URL . '">
    <input type="hidden" name="signed_field_names" value="' . $signed_field_names . '">
    <input type="hidden" name="signature" value="' . $signature . '">
    
    <button type="submit" class="btn btn-primary">Pay with eSewa</button>
</form>
'); ?></pre>
            </div>
        </div>
    </div>
</body>
</html> 