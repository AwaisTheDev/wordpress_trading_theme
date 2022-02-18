<?php

define('WP_USE_THEMES', true);

require_once dirname(__FILE__, 6) . "/wp-load.php";
$current_user = wp_get_current_user();
$user_Id = $current_user->ID;

/**
 * Submmitted Data
 */
$profit_amount = $_POST['profit_amount'];

/**
 * Database connection
 */
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
$table_prefix = $wpdb->prefix;

/**
 * Get Previous Value
 */

$query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
$investordata = $wpdb->get_row($query, ARRAY_A, 0);
$current_wallet_balance = $investordata['current_balance'];
$newValue = $profit_amount + $current_wallet_balance;

$date = getdate();
$currentDate = (string) $date['mday'];

$newProfitDate = $currentDate;

if (isset($investordata['last_profit_date'])) {
    if ($currentDate == $investordata['last_profit_date']) {
        echo 3;
        return;
    }
}

$wpdb->query("START TRANSACTION");

$result = $wpdb->update(
    //Table name
    "{$wpdb->prefix}investor",

    //values
    array(
        'current_balance' => $newValue,
        'last_profit_date' => $newProfitDate,
    ),

    //where
    array('investor_id' => $user_Id)
);

/**
 * Update total profit
 */

$query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
$investordata = $wpdb->get_row($query, ARRAY_A, 0);

$current_total_profit = $investordata['total_profit'];

$newValue = $profit_amount + $current_total_profit;

$profitResult = $wpdb->update(
    //Table name
    "{$wpdb->prefix}investor",

    //values
    array(
        'total_profit' => $newValue,
    ),

    //where
    array('investor_id' => $user_Id)
);

/**
 * Update refferal bonus
 */
$refferal_user_id = get_user_meta($user_Id, 'invsetor_reffered_by', true);

if ($refferal_user_id != null) {
    $refferal_bonus = $profit_amount * .02;

    $refferal_user_query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$refferal_user_id}";
    $refferal_user_data = $wpdb->get_row($refferal_user_query, ARRAY_A, 0);

    $refferal_user_data['wp_user_id'];

    $current_refferal_wallet_balance = $refferal_user_data['amount_earned_from_refferal'];
    $newRefferalValue = $refferal_bonus + $current_refferal_wallet_balance;
    $resultRefferal = $wpdb->update(
        //Table name
        "{$wpdb->prefix}investor",

        //values
        array(
            'amount_earned_from_refferal' => $newRefferalValue,
        ),

        //where
        array('investor_id' => $refferal_user_id)
    );

}

/**
 * Update Profit
 */

if ($error) {
    // Error occured, don't save any changes
    $wpdb->query("ROLLBACK");
    echo 0;

} else {
    // All ok, save the changes
    $wpdb->query("COMMIT");
    echo 1;

}
