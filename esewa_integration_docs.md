# eSewa Payment Gateway Integration

## Overview
This documentation explains how the eSewa payment gateway has been integrated into the NepalBazar ecommerce website.

## Files Added/Modified

1. **includes/esewa_config.php**
   - Contains all eSewa API credentials and configuration
   - Defines URLs for test and production environments
   - Stores success and failure URLs

2. **users_area/payment.php**
   - Updated to include eSewa payment option
   - Implements the eSewa payment form

3. **users_area/checkout.php**
   - Enhanced with eSewa payment option
   - Displays order summary and shipping information
   - Calculates total amount for payment

4. **users_area/esewa_payment_success.php**
   - Handles successful payment callbacks from eSewa
   - Verifies transaction with eSewa API
   - Completes order processing and clears cart

5. **users_area/esewa_payment_failure.php**
   - Handles failed payment attempts
   - Redirects user back to cart with appropriate message

## Database Changes

A script (`update_orders_table.php`) was created to add the following fields to the `user_orders` table:

- `payment_mode` - Stores the payment method used (e.g., "eSewa", "COD")
- `payment_reference` - Stores the payment reference ID from eSewa

## Integration Steps

### Step 1: Configuration
The eSewa configuration file stores all necessary credentials:
- Merchant ID: EPAYTEST (for test environment)
- Secret Key: 8gBm/:&EnhH.1/q
- URLs for test environment

### Step 2: Checkout Process
1. User reviews cart items and proceeds to checkout
2. Checkout page displays order summary and payment options
3. User selects eSewa as the payment method

### Step 3: Payment Process
1. When the user clicks "Pay with eSewa", they are redirected to the eSewa payment page
2. The following parameters are passed to eSewa:
   - Total amount (`tAmt`)
   - Product amount (`amt`)
   - Tax amount (`txAmt`) - Currently set to 0
   - Service charge (`psc`) - Currently set to 0
   - Delivery charge (`pdc`) - Currently set to 0
   - Merchant ID (`scd`)
   - Product/Order ID (`pid`)
   - Success and failure URLs

### Step 4: Payment Callback
1. After payment processing, eSewa redirects to either:
   - Success URL with parameters: `pid`, `amt`, `refId`
   - Failure URL with error details
   
2. Success handler:
   - Verifies the transaction with eSewa API
   - Updates order status
   - Stores payment reference
   - Clears the cart
   - Redirects to confirmation page

3. Failure handler:
   - Logs failure details (optional)
   - Redirects back to cart page

## Testing

Test credentials provided by eSewa:
- eSewa ID: 9806800001/2/3/4/5
- Password: Nepal@123
- MPIN: 1122 (for mobile application)
- Merchant ID: EPAYTEST
- Token: 123456

## Production Deployment

For production deployment:
1. Replace test credentials with production credentials in `esewa_config.php`
2. Update the eSewa URLs to production URLs
3. Thoroughly test the payment flow in production environment

## Troubleshooting

Common issues:
1. Payment verification failures: Check that the merchant ID matches between your configuration and eSewa account
2. Callback errors: Ensure your success and failure URLs are accessible and properly handle the parameters
3. Transaction not being recorded: Check database connection and ensure tables have correct fields

## Security Considerations

1. All sensitive credentials are stored in a separate configuration file
2. Payment verification is implemented to prevent fraud
3. HTTPS should be used in production
4. No sensitive payment data is stored in the database 