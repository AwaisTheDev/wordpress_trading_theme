<?php
/*
 ** Template Name: Activate Account
 */

if (!isset($_GET['activation']) || !isset($_GET['user_id'])) {
    wp_redirect(site_url());
}
$user_id = $_GET['user_id'];
$act_code = $_GET['activation'];

$activated_account_code = 1122;

$activation_status = get_user_meta($user_id, 'account_activated', true);

$login_link = get_page_link(get_option('login_page_link'));

get_header();

if ($activation_status == 1) {
    echo '<h2>Your Account is already activated</h2>';
    echo "<p>Please <a href='$login_link'>Login</a> to continue </p> ";
    exit;
}

//echo $activation_status;

$code = get_user_meta($user_id, 'activation_code', true);

if ($code == $act_code) {
    echo '<h2><i style="color:green;" class="fa fa-check"></i> Your Account is successfully verified <h2>';
    echo "<p>Please <a href='$login_link'>Login</a> to continue </p> ";

    update_user_meta($user_id, 'account_activated', 1);
    update_user_meta($user_id, 'activation_code', '');

} else {
    echo "<h2>There is some error. Please try again later.</h2>";
}

get_footer();
