<?php
/*
 ** Template Name: Dashboard
 */

//get_header();

$link = get_page_link(get_option('login_page_link'));

if (!is_user_logged_in()) {
    wp_redirect($link . '/?refferer=dashboard');
    exit;
}

$user = wp_get_current_user();
if (!in_array('investor', (array) $user->roles)) {
    wp_redirect(site_url());
    exit;
}

get_header('dashboard');

echo get_template_part('template-parts/dashboard/sidebar');

$logged_in_user_meta = get_user_meta($user->ID);

//print_r($logged_in_user_meta);

if ($logged_in_user_meta['account_activated'][0] == "0") {
    echo "<div class='card p-5'>You must acivate your account before continuing.</div>";
} else {
    the_content();
}

echo get_template_part('template-parts/dashboard/footer');
?>

</body>
</html>
