<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// GoCart Theme
$config['theme'] = 'default';

// SSL support
$config['ssl_support'] = false;

// Business information
$config['company_name'] = 'iDesign';
$config['address1']     = 'Boac, Marinduque';
$config['address2']     = '';
$config['country']      = 'PH'; // use proper country codes only
$config['city']         = 'Boac';
$config['state']        = '';
$config['zip']          = '1605';
$config['email']        = 'admin@idesign.ph';

// Store currency
$config['currency']                     = 'PHP';  // USD, EUR, etc
$config['currency_symbol']              = 'PHP '; // &#8369;
$config['currency_symbol_side']         = 'left'; // anything that is not "left" is automatically right
$config['currency_decimal']             = '.';
$config['currency_thousands_separator'] = ',';

// Shipping config units
$config['weight_unit']    = 'LB'; // LB, KG, etc
$config['dimension_unit'] = 'IN'; // FT, CM, etc

// site logo path (for packing slip)
$config['site_logo'] = '/assets/img/logo.png';

//change the name of the admin controller folder 
$config['admin_folder'] = 'admin';

//file upload size limit
$config['size_limit'] = intval(ini_get('upload_max_filesize')) * 1024;

//are new registrations automatically approved (true/false)
$config['new_customer_status'] = true;

//do we require customers to log in 
$config['require_login'] = true;

//default order status
$config['order_status'] = 'Pending';

// default Status for non-shippable orders (downloads)
$config['nonship_status'] = 'Pending';

$config['delivery_statuses'] = array(
    'Pending'    => 'Pending',
    'Processing' => 'Processing',
    'On Hold'    => 'On Hold',
    'Cancelled'  => 'Cancelled'
);

$config['payment_statuses'] = array(
    'Pending'    => 'Pending',
    'Paid'       => 'Paid',
    'Cancelled'  => 'Cancelled'
);

// enable inventory control ?
$config['inventory_enabled'] = true;

// allow customers to purchase inventory flagged as out of stock?
$config['allow_os_purchase'] = true;

//do we tax according to shipping or billing address (acceptable strings are 'ship' or 'bill')
$config['tax_address'] = 'ship';

//do we tax the cost of shipping?
$config['tax_shipping'] = true;

//Delivery Config
$config['delivery_amount'] = '0';
$config['allow_delivery_charge'] = false;

//product quantity for B2B Customers
$config['b2b_min_qty'] = '10';
$config['b2b_max_qty'] = '50';
$config['max_qty'] = '50';

//Coupon Config 
$config['coupon_minimum_transaction'] = '300';
$config['coupon_reg_prefix'] = 'REG';
$config['coupon_reg_amount'] = '50';
$config['code_max_number'] = '-6';

//UBIZ API Credentials
$config['api_key'] = 'd38a00c8907e2311689246876fef0ef4';
$config['api_secret'] = '1f236935f7b9849cef7a30ba1566833a';
$config['merchant_code'] = '88DBPH';
$config['checkouts_url'] = 'http://api.dev.ubiz.unionbank.com.ph/v1/checkouts.json'; //for PROD environment use https://secured.ubiz.unionbank.com.ph

//Enabled Payment Method
$config['allow_credit_card'] = false;
$config['allow_bank_deposit'] = false;
$config['allow_ubiz'] = false;
$config['allow_otc_nonbank'] = true;

//enable reward point via category or per final total purchase
$config['reward_points_per_totalprice'] = true;
$config['reward_points_rpoints'] = 1;
$config['reward_points_rprice'] = 500;