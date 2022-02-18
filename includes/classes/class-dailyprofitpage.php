<?php

/**
 * Daily Profit
 *
 * @package lyra
 */

namespace LYRA_THEME\Includes;

use LYRA_THEME\Includes\traits\singleton;

class DailyProfitPage
{
    use singleton;

    protected function __construct()
    {
        $this->setup_hooks();
    }

    public function setup_hooks()
    {
        add_action('admin_menu', array($this, 'ct_site_settings_menu_page_daily_profit'));
        add_action('admin_init', array($this, 'ct_admin_settings_investor_daily_profit_page_options'));
    }
    /**
     * Register a custom menu page.
     */
    public function ct_site_settings_menu_page_daily_profit()
    {
        add_submenu_page('mc_options_page', 'Send Profit', 'Send Profit', 'manage_options', 'investor_profit_page', array($this, 'mc_profit_subpage_callback'), 1);
    }

    public function mc_profit_subpage_callback()
    {
        ob_start();?>

        <div class="wrap">
            <?php echo settings_errors(); ?>
            <h1><?php echo get_admin_page_title(); ?></h1>
            <form method="post" action="options.php">
                <?php //br
                settings_fields('mc_investor_daily_profit_opt_group');

                do_settings_sections('investor_profit_page');
                submit_button('Save Settings');

                ?>

            </form>


            <p>First enter the profit value above and save it. Then click send profit to all investors to send profit.</p>
            <form action="<?php get_template_directory_uri() . "/includes/profit-processing.php"?>">
                <label style="margin-bottom:10px;" for="">Profit percentage</label><br>
                <input readonly style="margin:10px 0px; max-width:400px" id="daily-profit-value" type="number" min="1" max="100" value="<?php echo  $daily_profit = get_option('investor_daily_profit'); ?>"><br>
                <input id="send-profit-to-all" type="submit" class="button button-primary" value="Send profit to all investors">
            </form>

            <div class="notice">
                <p></p>
            </div>

            <style>.notice{display:none;}</style>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $("#send-profit-to-all").on('click',function(e){
                            e.preventDefault();

                            var profitValue = $("#daily-profit-value").val();
                            

                            if(confirm("This will add " + profitValue +"% profit to all investor's accounts")){
                                $.ajax({
                                url: "<?php echo LYRA_ROOT_DIR_URI ?>/includes/profit-processing.php",
                                type: "POST",
                                data: {profit_amount:profitValue},
                                success: function(result){

                                    $(".notice").css('display','block');
                                    $('.notice').addClass("notice-success");
                                    $('.notice p').html("Profit sent successfully");
                                    //console.log("result= " + result);
                                },
                                error: function(error){
                                    $(".notice").css('display','block');
                                    $('.notice').addClass("notice-danger");
                                    $('.notice p').html("Error");
                                }
                                })
                            }
                            
                        });


                    })
                </script>
        </div>
        <?php //br
        $output = ob_get_clean();
        echo $output;

    }

    public function ct_admin_settings_investor_daily_profit_page_options()
    {

        //add_settings_section( id, title, callback, page )
        add_settings_section(
            'ct_investor_daily_profit_section',
            'Investor Daily profit',
            '',
            'investor_profit_page'
        );

        //register_setting( option_group, option_name, sanitize_callback );
        register_setting(
            'mc_investor_daily_profit_opt_group',
            'investor_daily_profit',
            array()
        );

        //add_settings_field( $id:string, $title:string, $callback:callable, $page:string, $section:string, $args:array )
        add_settings_field(
            'mc_daily_profit_feild',
            'Daily Profit',
            array($this, 'mc_daily_profit_feild_callack'),
            'investor_profit_page',
            'ct_investor_daily_profit_section',
            array()
        );

    }


    public function mc_daily_profit_feild_callack()
    {

        $daily_profit = get_option('investor_daily_profit');
        //echo $login_page;
        ?>
        <input type="number" name="investor_daily_profit" value="<?php echo $daily_profit; ?>">


        <?php

    }
    
}