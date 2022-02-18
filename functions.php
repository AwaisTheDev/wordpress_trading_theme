<?php

/**
 * @package lyra
 */

//Define root constant
if (!defined('LYRA_ROOT_DIR_PATH')) {
    define('LYRA_ROOT_DIR_PATH', untrailingslashit(get_template_directory()));
}

if (!defined('LYRA_ROOT_DIR_URI')) {
    define('LYRA_ROOT_DIR_URI', untrailingslashit(get_template_directory_uri()));
}

//include autoloader
require_once LYRA_ROOT_DIR_PATH . '/includes/helpers/autoloader.php';

//Load theme class
function lyra_load_theme_class()
{
    LYRA_THEME\Includes\LYRA_THEME::get_Instance();
}
lyra_load_theme_class();

// /**
//  * Php Mailer Start
//  */
// require_once LYRA_ROOT_DIR_PATH . '/php-mailer/PHPMailer.php';
// require_once LYRA_ROOT_DIR_PATH . '/php-mailer/SMTP.php';
// require_once LYRA_ROOT_DIR_PATH . '/php-mailer/OAuth.php';
// require_once LYRA_ROOT_DIR_PATH . '/php-mailer/Exception.php';
// /**
//  * Php Mailer ENd
//  */

//Include Shortcodes
require_once LYRA_ROOT_DIR_PATH . '/shortcodes/userprofile.php';
require_once LYRA_ROOT_DIR_PATH . '/shortcodes/userdashboard.php';
require_once LYRA_ROOT_DIR_PATH . '/shortcodes/deposit.php';
require_once LYRA_ROOT_DIR_PATH . '/shortcodes/dailyProfit.php';
require_once LYRA_ROOT_DIR_PATH . '/shortcodes/requestWithdrawl.php';
require_once LYRA_ROOT_DIR_PATH . '/shortcodes/withdrawlRequests.php';
require_once LYRA_ROOT_DIR_PATH . '/shortcodes/depositsRequests.php';

//Investor Database
require_once LYRA_ROOT_DIR_PATH . '/includes/custom_database.php';

add_shortcode('refferal_link', 'mc_investor_refferal_link');

function mc_investor_refferal_link()
{
    $current_user = wp_get_current_user();

    $refferal_link = site_url() . '/register/?' . $current_user->user_login;
    return $refferal_link;

}

do_shortcode('[refferal_link]');
