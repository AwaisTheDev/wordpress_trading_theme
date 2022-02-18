<?php

add_action("after_switch_theme", "mac_investor_create_table");

function mac_investor_create_table()
{
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->prefix . "investor"; //get the database table prefix to create my new table

    $sql = "CREATE TABLE $table_name (
      wp_user_id int(10) unsigned,
      investor_id int(10) PRIMARY KEY,
      gender varchar(20),
      phone_number varchar(50),
      current_balance float(3),
      amount_invested float(3),
      total_amount_earned float(3),
      last_profit_date varchar(10),
      amount_earned_from_refferal float(3),
      total_withdrawls float(3),
      total_profit float(3),
      total_deposits float(3),

    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    dbDelta($sql);

    $table_name2 = $wpdb->prefix . "transctions";
    $sql1 = "CREATE TABLE $table_name2 (
      investor_id int(10) unsigned,
      transction_id int(20)  AUTO_INCREMENT PRIMARY KEY,
      source int(50),
      transction_amount int(50),
      transction_type  varchar(20)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    dbDelta($sql1);

}
