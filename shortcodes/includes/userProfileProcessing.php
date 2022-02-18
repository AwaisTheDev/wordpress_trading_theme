<?php

define('WP_USE_THEMES', true);

require_once dirname(__FILE__, 6) . "/wp-load.php";
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
$table_prefix = $wpdb->prefix;

$user_id = get_current_user_id();

$fname = $_POST['mc_user_first_name'];
$lname = $_POST['mc_user_last_name'];
$birthday = $_POST['mc_user_birthday'];
$email = $_POST['mc_user_email'];
$phoneNumber = $_POST['mc_user_phone_number'];
$gender = $_POST['mc_user_gender'];

/**
 * Address Information
 */
$street = $_POST['mc_street_address'];
$city = $_POST['mc_city'];
$state = $_POST['mc_state'];
$zip = $_POST['mc_zip'];

$errors = "";

if ($fname == null) {
    $errors .= "<li>First Name is required</li>";
}
if ($lname == null) {
    $errors .= "<li>Last Name is required</li>";
}
if ($email == null) {
    $errors .= "<li>Email is is required</li>";
}
if ($phoneNumber == null) {
    $errors .= "<li>Phone Number is is required</li>";
}

if ($errors != null) {
    echo $errors;
    exit;
}

save_user_meta_values('first_name', $fname, $user_id);
save_user_meta_values('last_name', $lname, $user_id);
save_user_meta_values('investor_phone_number', $phoneNumber, $user_id);
save_user_meta_values('user_gender', $gender, $user_id);

if ($birthday == null || $birthday != "") {
    save_user_meta_values('investor_birthday', $birthday, $user_id);
}

/**
 * Save Address Information
 */

save_user_meta_values('user_address_street', $street, $user_id);
save_user_meta_values('user_address_city', $city, $user_id);
save_user_meta_values('user_address_state', $state, $user_id);
save_user_meta_values('user_address_zip', $zip, $user_id);

function save_user_meta_values($key, $value, $user_id)
{
    if ($value == '' || $value == null) {
        delete_user_meta($user_id, $key);
        return;
    }
    $existing_fname = get_user_meta($user_id, $key, true);
    if ($existing_fname == null) {
        update_user_meta($user_id, $key, $value);
    } else if ($existing_fname == "") {
        update_user_meta($user_id, $key, $value);

    } else if ($existing_fname == $value) {

    } else {
        update_user_meta($user_id, $key, $value);
    }

}

$result .= "Profile Information Saved Successfully!";
echo $result;
