<?php
function mc_user_dashboard()
{

    $html = "";
    if (!is_user_logged_in()) {
        $html .= 'You can not access this page';
        return $html;
    }

    $current_user = wp_get_current_user();

    $user_Id = $current_user->ID;
    $user_info = get_userdata($user_Id);

    $username = $user_info->user_login;
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;

    $full_name = $first_name . " " . $last_name;

    $email = $user_info->user_email;

    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $table_prefix = $wpdb->prefix;

    // echo $table_prefix;

    //Read Investor Data
    $query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
    $investordata = $wpdb->get_row($query, ARRAY_A, 0);

    $invested_amount = $investordata['amount_invested'];

    $daily_profit_percentage = get_option('investor_daily_profit');

    $profit_amount = ($invested_amount * ($daily_profit_percentage)/100) ;

    $profit_amount = number_format((float) $profit_amount, 2, '.', '');

    ob_start();?>

    <?php
// echo "<pre>";
    //     print_r($investordata);
    //     echo "</pre>";

    function check_if_zero($arg1)
    {
        if ($arg1 == null || $arg1 == 0) {
            return 0;
        } else {
            return $arg1;
        }
    }
    ?>

    <?php //echo get_template_part('template-parts/dashboard/top-banner'); ?>

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card card-body shadow-sm mb-4">
                        <h2 class="h5 mb-4">Dashboard</h2>
                        <p >Welcome!<b> <?php echo $full_name; ?><b></p>
                        <p>This is your dashboard where you can get overview of your profile.</p>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Amount Invested</h2>
                                        <h3 class="h2 mb-1">USD <?php echo check_if_zero($investordata['amount_invested']); ?></h3>
                                        <div class="small mb-3">The amount you have invested.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Amount In Wallet</h2>
                                        <h3 class="h2 mb-1">USD <?php echo check_if_zero($investordata['current_balance']); ?></h3>
                                        <div class="small mb-3">The amount you have in you wallet and you can withdraw.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Daily Profit</h2>
                                        <h3 class="h2 mb-1">USD <?php echo $profit_amount; ?></h3>
                                        <div class="small mb-3">Maximum daily profit you can get.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Refferal Earnings</h2>
                                        <h3 class="h2 mb-1">USD <?php echo check_if_zero($investordata['amount_earned_from_refferal']); ?></h3>
                                        <div class="small mb-3">Amount you have earned from refferals</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Total Profit</h2>
                                        <h3 class="h2 mb-1">USD <?php echo check_if_zero($investordata['total_profit']); ?></h3>
                                        <div class="small mb-3">Total profit amount from the date you started your account</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Total Deposits</h2>
                                        <h3 class="h2 mb-1">USD <?php echo check_if_zero($investordata['total_deposits']); ?></h3>
                                        <div class="small mb-3">The amount you have deposited from the date you satrted your account.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Total Withdrawls</h2>
                                        <h3 class="h2 mb-1">USD <?php echo check_if_zero($investordata['total_withdrawls']); ?></h3>
                                        <div class="small mb-3">The amount you have withdrawn from the date you satrted your account.</div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <?php
return $html;
    $output = ob_get_clean();

    return $output;
}

add_shortcode('user_dashboard', 'mc_user_dashboard');