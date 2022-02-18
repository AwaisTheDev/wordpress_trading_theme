<?php

define('WP_USE_THEMES', true);

require_once dirname(__FILE__, 6) . "/wp-load.php";

/**
 * Get Current Balance
 */
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/upgrade.php';

$user_Id = get_current_user_id();

$mc_deposit_amount = $_POST['mc_deposit_amount'];

/**
 * Create withdrawl request
 */

$fname = get_user_meta($user_Id, 'first_name', true);
$lname = get_user_meta($user_Id, 'last_name', true);

$name = "$fname $lname";

$create_deposit = array(
    'post_title' => 'Deposit Request by '. $name,
    'post_status' => 'pending',
    'post_type' => 'depositrequest',
);

$pid = wp_insert_post($create_deposit);

//echo $fname;

add_post_meta($pid, 'depr_investor_id', $user_Id, true);
add_post_meta($pid, 'depr_amount_requested', $mc_deposit_amount, true);
add_post_meta($pid, 'depr_Deposit_status', "Pending", true);
add_post_meta($pid, 'depr_request_description', "Your request is pending.", true);


// For Featured Image
if( !function_exists('wp_generate_attachment_metadata')){
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
}

$attach_id =null;
if($_FILES) {
    foreach( $_FILES as $file => $array ) {
        if($_FILES[$file]['error'] !== UPLOAD_ERR_OK){
            return "upload error : " . $_FILES[$file]['error'];
        }
        $attach_id = media_handle_upload( $file, $pid );
    }
    //echo "here";
}
if($attach_id > 0) {
    update_post_meta( $pid,'_thumbnail_id', $attach_id );

    //echo "image added";
}

echo "Deposit Request sent. Your deposit will be added to your account within 2 business days.";
exit;
