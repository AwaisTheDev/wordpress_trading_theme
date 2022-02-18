<?php
function mc_daily_profit()
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
    $email = $user_info->user_email;

    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $table_prefix = $wpdb->prefix;

    // echo $table_prefix;

    //Read Investor Data
    $query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
    $investordata = $wpdb->get_row($query, ARRAY_A, 0);

    $invested_amount = $investordata['amount_invested'];

    $profit_amount = ($invested_amount * 0.2) / 30;

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
                        <h2 class="h5 mb-4">Daily Profit</h2>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Amount In Wallet</h2>
                                        <h3 class="h2 mb-1">Rs. <?php echo check_if_zero($investordata['current_balance']); ?></h3>
                                        <div class="small mb-3">The amount you have in you wallet and you can withdraw.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Amount Invested</h2>
                                        <h3 class="h2 mb-1">Rs. <?php echo check_if_zero($investordata['amount_invested']); ?></h3>
                                        <div class="small mb-3">The amount you have invested.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Daily Profit</h2>
                                        <h3 class="h2 mb-1">Rs. <?php echo $profit_amount; ?></h3>
                                        <div class="small mb-3">Maximum daily profit you can get.</div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h2 class="h5">Get Daily Profit</h2>
                                        <form action="" method="POST">
                                            <input hidden id="get-dailt-profit-value" name="get-dailt-profit-value"type="text hidden" value="<?php echo $profit_amount; ?>">
                                            <button type="submit" id="get-daily-profit" class="btn btn-primary d-flex text-center w-100 mb-3 mt-3">Get Profit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <script type="text/javascript">
                                        jQuery(document).ready(function($) {
                                           $("#get-daily-profit").on('click',function(e){
                                                    e.preventDefault();

                                                    var profitValue = $("#get-dailt-profit-value").val();

                                                    //console.log(profitValue);

                                                    $.ajax({
                                                        url: "<?php echo LYRA_ROOT_DIR_URI ?>/shortcodes/includes/getProfit.php",
                                                        type: "POST",
                                                        data: {profit_amount:profitValue},
                                                        success: function(result){
                                                            console.log("result= " +result);

                                                            var state;
                                                            var resultString;
                                                            if( result == 1){
                                                                state = 'success';
                                                                resultString ='You have successfully recieved profit for today';
                                                            }else if(result == 0){
                                                                state = 'error';
                                                                resultString ='There is some error please try again later';
                                                            }else if(result == 3){
                                                                //console.log('error');
                                                                state = 'error';
                                                                resultString ="You have already recieved profit for today. Please try again tomorrow :)";
                                                            }

                                                            notificationFunction(resultString, state );


                                                        }
                                                     })
                                                });


                                            })



                                        </script>

            </div>
            <?php
return $html;
    $output = ob_get_clean();

    return $output;
}

add_shortcode('daily_profit', 'mc_daily_profit');