<?php
define('WP_USE_THEMES', true);

require_once dirname(__FILE__, 6) . "/wp-load.php";
global $wpdb;
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
$table_prefix = $wpdb->prefix;

global $reg_errors;
$reg_errors = new WP_Error;
$username = $_POST['ct_username'];
$useremail = $_POST['ct_useremail'];
$password = $_POST['ct_password'];
$first_name = $_POST['ct_first_name'];
$last_name = $_POST['ct_last_name'];
$ct_userphone = $_POST['ct_userphone'];
$confirm_password = $_POST['confirm_password'];
$ct_reffered_by = $_POST['ct_reffered_by'];

if ($password != $confirm_password) {
    echo "<li>Passwords do not match</li>";
    exit;
}
if (empty($username) || empty($useremail) || empty($password)) {
    $reg_errors->add('field', 'Required form field is missing');
}
if (6 > strlen($username)) {
    $reg_errors->add('username_length', 'Username too short. At least 6 characters is required');
}
if (username_exists($username)) {
    $reg_errors->add('user_name', 'The username you entered already exists!');
}
if (!validate_username($username)) {
    $reg_errors->add('username_invalid', 'The username you entered is not valid!');
}
if (!is_email($useremail)) {
    $reg_errors->add('email_invalid', 'Email id is not valid!');
}

if (email_exists($useremail)) {
    $reg_errors->add('email', 'Email Already exist!');
}
if (5 > strlen($password)) {
    $reg_errors->add('password', 'Password length must be greater than 5!');
}

if (is_wp_error($reg_errors)) {
    foreach ($reg_errors->get_error_messages() as $error) {
        $signUpError = '<p style="color:#FF0000; text-aling:left;"><strong>ERROR</strong>: ' . $error . '<br /></p>';
    }
}

if (isset($signUpError)) {echo '<div>' . $signUpError . '</div>';}

if (0 == count($reg_errors->get_error_messages())) {
// sanitize user form input
    global $username, $useremail;
    $username = sanitize_user($_POST['ct_username']);
    $useremail = sanitize_email($_POST['ct_useremail']);
    $password = esc_attr($_POST['ct_password']);

    /**
     * Insert User Data
     */
    $userdata = array(
        'user_login' => $username,
        'user_email' => $useremail,
        'user_pass' => $password,
    );
    $user = wp_insert_user($userdata);

    $u = new WP_User($user);
    // Replace the current role with 'investor' role
    $u->set_role('investor');

    if ($user) {

        /**
         * Update Investors Table
         */
        $wpdb->insert(
            "{$wpdb->prefix}investor",
            array(
                'wp_user_id' => $u->ID,
                'investor_id' => $u->ID,
            )
        );

        /**
         * Update Phone Number
         */

        update_user_meta($u->ID, 'first_name', $first_name);
        update_user_meta($u->ID, 'last_name', $last_name);
        update_user_meta($u->ID, 'nickname', $first_name);
        add_user_meta($u->ID, 'investor_phone_number', $ct_userphone, true);

        if ($ct_reffered_by != null) {

            $reffred_by_user = get_user_by('login', $ct_reffered_by);

            if ($reffred_by_user->ID != null) {

                //check if refferal user has investor role.
                $refferal_user_meta = get_userdata($reffred_by_user->ID);

                $refferal_user_role = $refferal_user_meta->roles;
                if (in_array("investor", $refferal_user_role)) {
                    //Update current user data
                    add_user_meta($u->ID, 'invsetor_reffered_by', $reffred_by_user->ID, true);
                    //print('Refferal Stored.');
                    //Update refferal aser data
                    add_user_meta($reffred_by_user->ID, 'my_refferals', $u->ID, true);

                } else {
                    echo "Refferal user is not investor";
                    add_user_meta($u->ID, 'invsetor_reffered_by', 0, true);

                }

            } else {
                add_user_meta($u->ID, 'invsetor_reffered_by', 0, true);
                print('Refferal user does not exist.');
            }

        } else {
            //print('Refferal user not entered.');
        }

        echo "<li>Account Registered Successfully</li>";

        /**
         * Activation Code Generation
         */
        $code = md5(time());
        //$string = array('id' => $u, 'code' => $code);
        update_user_meta($u->ID, 'account_activated', 0);
        update_user_meta($u->ID, 'activation_code', $code);
        // create the url
        $url = get_site_url() . '/activate-account/?user_id=' . $u->ID . '&activation=' . $code;

        /**
         * Php Mailer Start
         */
        require_once LYRA_ROOT_DIR_PATH . '/php-mailer/PHPMailer.php';
        require_once LYRA_ROOT_DIR_PATH . '/php-mailer/SMTP.php';
        require_once LYRA_ROOT_DIR_PATH . '/php-mailer/OAuth.php';
        require_once LYRA_ROOT_DIR_PATH . '/php-mailer/Exception.php';
        /**
         * Php Mailer ENd
         */

        $register_acc_mail = new PHPMailer\PHPMailer\PHPMailer();

        //Set PHPMailer to use SMTP.
        $register_acc_mail->isSMTP();
        $register_acc_mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $email_content = "
        Thank you for registring your account.<br><br>
        Your Username is: $username<br>
        Your Password is: $password<br>
        <b>Please verify your email before continuing</b><br>
        <brYou can verify your email by clicking the link below.<br> $url";

        $register_acc_mail->Host = "smtp.gmail.com";
        $register_acc_mail->SMTPAuth = true;
        //`$register_acc_mail->SMTPDebug = 2;
        $register_acc_mail->Username = "testit0699@gmail.com";
        $register_acc_mail->Password = 'test_email_pa$$word';
        $register_acc_mail->SMTPSecure = "tls";
        $register_acc_mail->Port = 587;

        $register_acc_mail->From = get_option('admin_email');
        $register_acc_mail->FromName = "M&C Trading";

        $register_acc_mail->addAddress($useremail, $first_name);
        $register_acc_mail->isHTML(true);
        $register_acc_mail->Subject = "Activate Your Account";
        $register_acc_mail->Body = $email_content;

        try {
            if ($register_acc_mail->send()) {
                echo "<li>Activation Code Sent. Please Check your email.</li>";
            }
        } catch (Exception $e) {
            echo "Mailer Error: " . $register_acc_mail->ErrorInfo;
        }

    } else {
        echo "We are having issues handeling your request! Please try agian later.";

    }

}
