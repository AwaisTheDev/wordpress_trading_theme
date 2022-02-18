<?php

define('WP_USE_THEMES', true);
require_once dirname(__FILE__, 6) . "/wp-load.php";
$current_user = wp_get_current_user();
$user_Id = $current_user->ID;

//db connection
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
$table_prefix = $wpdb->prefix;

$query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
$investordata = $wpdb->get_row($query, ARRAY_A, 0);

$amount_invested = $investordata['amount_invested'];

$data = array();
$data['jazz_cash_no'] = $_POST['mc_jazzcash_number'];
$data['cnic_digits'] = $_POST['mc_cnic_digits'];
$data['price'] = $_POST['mc_deposit_amount'];

$data['paymentMethod'] = $_POST['paymentMethod'];
$data['ccNo'] = $_POST['mc_credit_card_number'];
$data['expMonth'] = $_POST['mc_card_expiry_month'];
$data['expYear'] = $_POST['mc_card_expiry_year'];
$data['cvv'] = $_POST['mc_card_cvv'];

require_once LYRA_ROOT_DIR_PATH . '/includes/classes/JazzcashApi.php';

$jc_api = new JazzcashApi();
$response = $jc_api->createCharge($data);

//return $response;
$code = $response['pp_ResponseCode'];

echo "<pre>";
print_r($data);
echo "</pre>";

$success_codes = [
    "000",
    "121",
];

$error_codes = [
    '101',
    '105',
    '110',
    '111',
    '112',
    '115',
    '118',
];

//Add New amount to previous amount in the database
$new_total = $amount_invested + $response['pp_Amount'] / 100;

//Update Database
if (in_array($code, $success_codes)) {
    $result = $wpdb->update(
        //Table name
        "{$wpdb->prefix}investor",

        //values
        array(
            'amount_invested' => $new_total,
        ),

        //where
        array('investor_id' => $user_Id)
    );

    //Update Transctions
    $wpdb->insert(
        "{$wpdb->prefix}transctions",
        array(
            'investor_id' => $user_Id,
            'source' => $response['pp_MobileNumber'],
            'transction_amount' => $response['pp_Amount'] / 100,
            'transction_type' => 'Deposit',
        )
    );
}

// echo "<pre>";
// print_r($response);
// echo "</pre>";

 echo "Success!!";
