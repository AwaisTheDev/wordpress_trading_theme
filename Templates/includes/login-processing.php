
<?php

define('WP_USE_THEMES', true);

require_once dirname(__FILE__, 6) . "/wp-load.php";
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
$table_prefix = $wpdb->prefix;

$username = $_POST['mac_username'];
$password = $_POST['mac_password'];
$remenber_user = $_POST['mac_remember_user'];

$login_data = array();
$login_data['user_login'] = $username;
$login_data['user_password'] = $password;
$login_data['remember'] = $remenber_user;

$user_verify = wp_signon($login_data, false);

// echo "<pre>";
// print_r($user_verify->errors);
// echo "</pre>";

if (is_wp_error($user_verify)) {
    echo "<b>Error! </b>";

}

if (property_exists($user_verify, 'errors')) {
    if (array_key_exists('invalid_username', $user_verify->errors)) {
        echo 'Invalid Username';
        exit;
    } elseif (array_key_exists('incorrect_password', $user_verify->errors)) {
        echo 'Your Password is incorrect.';
        exit;

    }
}

$dashbard_link = get_page_link(get_option('dashboard_page_link'));

if (is_wp_error($user_verify)) {
    //echo "Invalid login details";

} else {
    if (is_user_logged_in()) {

        echo 'Welcome, registered user!';
        echo "<script>window.location = '$dashbard_link';</script>";
    } else {
        echo 'Welcome, visitor!';
        echo "<script>window.location = '$dashbard_link';</script>";

    }
}
