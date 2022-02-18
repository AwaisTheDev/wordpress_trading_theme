<?php

define('WP_USE_THEMES', true);

require_once dirname(__FILE__, 6) . "/wp-load.php";

/**
 * Get Current Balance
 */
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
$table_prefix = $wpdb->prefix;
$user_Id = get_current_user_id();
$query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
$investordata = $wpdb->get_row($query, ARRAY_A, 0);
$user_current_balance = $investordata['current_balance'];

$mc_withdrawl_amount = $_POST['mc_withdrawl_amount'];
$mc_withdrawl_method = $_POST['mc_withdrawl_method'];
$wd_binance_id = $_POST['wd_binance_id'];
$wd_name_on_binance = $_POST['wd_name_on_binance'];

//echo $mc_withdrawl_method;
// echo "Currnt Balance: $user_current_balance<br>";
// echo "Requested: $mc_withdrawl_amount<br>";

if ($user_current_balance == null || $user_current_balance == "") {
    echo "You have insufficient balance";
    exit;
}

if ($mc_withdrawl_amount > $user_current_balance) {
    echo "You can withdraw a maximum of $user_current_balance amount";
    exit;
}

$args = array(
    'post_type' => 'withdrawsrequest',
    'post_status' => 'pending',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'wd_withdrawl_status',
            'value' => 'Requested',
            'compare' => 'LIKE',
        ),
        array(
            'key' => 'wd_investor_id',
            'value' => $user_Id,
            'compare' => 'LIKE',
        ),
    ),
);
$withdrawl_requests = get_posts($args);
// echo "<pre>";
// print_r($withdrawl_requests);
// echo "</pre>";

$number_of_requests = count($withdrawl_requests);

if ($number_of_requests >= 1) {
    echo "You have a pending withdrawl request. Please wait the payment to be processed. Thank you.";
    exit;
}

/**
 * Create withdrawl request
 */
$create_withdrawl = array(
    'post_title' => 'Withdrawl Request',
    'post_status' => 'pending',
    'post_type' => 'withdrawsrequest',
);

$pid = wp_insert_post($create_withdrawl);

$current_user = wp_get_current_user();
/**
 * @example Safe usage:
 * $current_user = wp_get_current_user();
 * if ( ! $current_user->exists() ) {
 *     return;
 * }
 */

$fname = get_user_meta($user_Id, 'first_name', true);
$lname = get_user_meta($user_Id, 'last_name', true);

$name = "$fname $lname";

//echo $fname;

add_post_meta($pid, 'wd_investor_id', $user_Id, true);
add_post_meta($pid, 'wd_investor_name', $name, true);
add_post_meta($pid, 'wd_amount_requested', $mc_withdrawl_amount, true);
add_post_meta($pid, 'wd_withdrawl_method', $mc_withdrawl_method, true);
add_post_meta($pid, 'wd_binance_id', $wd_binance_id, true);
add_post_meta($pid, 'wd_name_on_binance', $wd_name_on_binance, true);
add_post_meta($pid, 'wd_withdraw_description', 'Your request is pending.', true);
add_post_meta($pid, 'wd_withdrawl_status', 'Requested', true);

echo "Payment Request sent. Your payment will be sent to your account within 2 business days.";
exit;
