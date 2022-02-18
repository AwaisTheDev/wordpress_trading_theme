<?php

define('WP_USE_THEMES', true);

require_once dirname(__FILE__, 5) . "/wp-load.php";
/**
 * Submmitted Data
 */
$profit_percentage = $_POST['profit_amount'];

/**
 * Database connection
 */
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
$table_prefix = $wpdb->prefix;

//$wpdb->beginTransaction();

/**
 * Get Previous Value
 */
$investors_query = "SELECT * FROM {$table_prefix}investor";

$investorsdata = $wpdb->get_results($investors_query, ARRAY_A, 0);
//var_dump($investordata);

foreach ($investorsdata as $investor) {
    if ($investor['amount_invested'] != null || $investor['amount_invested'] > 0) {

        //calculate profit

        $profit_percentage = (float) $profit_percentage;
        $invested_amount = $investor['amount_invested'];
        $profit_amount = ($invested_amount * ($profit_percentage / 100));

        $profit_amount = number_format((float) $profit_amount, 3, '.', '');

        $current_wallet_balance = $investor['current_balance'];
        $newValue = $profit_amount + $current_wallet_balance;

        //check if profit is not sent for today already
        $date = getdate();
        $currentDate = (string) $date['mday'];
        $newProfitDate = $currentDate;

        if (isset($investor['last_profit_date'])) {
            if ($currentDate == $investor['last_profit_date']) {
                //echo "Profit already sent for today. You can perform this action after 12PM";
                //die();
            }
        }

        

        //update total profit

        $current_total_profit = $investor['total_profit'];
        $newValue = $profit_amount + $current_total_profit;

        $profitResult = $wpdb->update(
            //Table name
            "{$wpdb->prefix}investor",

            //values
            array(
                'total_profit' => $newValue,
            ),

            //where
            array('investor_id' => $investor['investor_id'])
        );

        /**
         * Update refferal bonus
         */

        $refferal_bonus = null;
        $refferal_user_id = get_user_meta($investor['investor_id'], 'invsetor_reffered_by', true);

        if ($refferal_user_id != null) {
            $refferal_bonus = $profit_amount * .02;

            $refferal_user_query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$refferal_user_id}";
            $refferal_user_data = $wpdb->get_row($refferal_user_query, ARRAY_A, 0);

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

        if($refferal_bonus != null){
            $newValue = $newValue + $refferal_bonus;
        }

        
        //add wwallet balance wirh profit for today and refferal bonus 
        $result = $wpdb->update(
            //Table name
            "{$wpdb->prefix}investor",

            //values
            array(
                'current_balance' => $newValue,
                'last_profit_date' => $newProfitDate,
            ),

            //where
            array('investor_id' => $investor['investor_id'])
        );

        if($result){
            echo "Profit successfully sent";
        }
        else{
            echo "There is some error";
        }
    }
}

//$wpdb->commit();
die();