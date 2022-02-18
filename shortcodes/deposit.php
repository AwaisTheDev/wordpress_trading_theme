<?php
function lyra_deposit_page()
{

    // echo "<pre>";
    // print_r(wp_get_current_user()) ;
    // echo "</pre>";

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

    $query = $wpdb->prepare("SELECT * FROM %d WHERE wp_user_id = %d", $table_prefix, $user_Id);

    $user_custom_data = $wpdb->get_row($query, ARRAY_A, 3);

    //print_r($user_custom_data);

    //echo $user_custom_data->gender;
    ob_start();
    ?>


    <!-- Topcontent template -->
    <?php //echo get_template_part('template-parts/dashboard/top-banner'); ?>




<!-- Deposit Forms -->
          <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body shadow-sm mb-4">
                    <h2 class="h5 mb-2">Deposit Amount</h2>

                    <div class="result-message"></div>
                      <!-- End of Tab Nav -->
                      <!-- Tab Content -->
                      <div class="card border-0">
                          <div class="card-body p-0">
                              <div class="tab-content" id="tabcontent1">

                                    <div style="display:none;" class="deposit-result alert alert-dismissible fade show"  role="alert">
                                        <span class="alert-content"></span>
                                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <!-- Deposit using jazzcash -->
                                  <div class="tab-pane fade show active" id="tabs-text-1" role="tabpanel" aria-labelledby="tabs-text-1-tab">
                                      <form id="mc_deposit_form" action="<?php the_permalink()?>" method="POST">

                                          <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div>
                                                    <label for="mc_deposit_amount">Deposit Amount (in USD)</label>
                                                    <input class="form-control" name="mc_deposit_amount" id="mc_deposit_amount" type="number" placeholder="Enter the amount you want to deposit." required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div>
                                                    <label for="mc_deposit_screenshot">Upload screenshot</label>
                                                    <input class="form-control" name="mc_deposit_screenshot" id="mc_deposit_screenshot" type="file">
                                                </div>
                                            </div>
                                            <button type="submit" id="mc_deposit_submit" class="btn btn-dark">Send deposit request</button>
                                      </form>
                                    </div>

                                    <script type="text/javascript">
jQuery(document).ready(function($) {


    $("#mc_deposit_submit").on('click', function(e) {
        e.preventDefault();

        $("#mc_deposit_submit span").addClass("spinner-border spinner-border-sm");
        $("#mc_deposit_submit").attr('disabled', 'disabled');


        var mc_deposit_amount = $("#mc_deposit_amount").val();

        //check if input is empty

        if(mc_deposit_amount== ''){
                $('.result-message').html('Please enter all required feilds');
                $('.result-message').addClass('alert alert-secondary');
                $("#mc_deposit_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mc_deposit_submit").removeAttr('disabled', 'disabled');
                
                return;
        }

        // check if screenshot is uploaded

        if( document.getElementById("mc_deposit_screenshot").files.length === 0 ){
                $('.result-message').html('Plese upload a screenshot');
                $('.result-message').addClass('alert alert-danger');
                $("#mc_deposit_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mc_deposit_submit").removeAttr('disabled', 'disabled');
                
                return;
        }

        //console.log(profitValue);

        var formData = new FormData();
        formData.append('mc_deposit_amount', mc_deposit_amount);
        formData.append('file', document.getElementById('mc_deposit_screenshot').files[0]);

        console.log(formData);
        $.ajax({
            url: "<?php echo LYRA_ROOT_DIR_URI ?>/shortcodes/includes/depositProcessing.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log("result=" + result);
                $('.result-message').html(result);
                $('.result-message').removeClass('alert alert-secondary alert-danger');
                $('.result-message').addClass('alert alert-success');
                $("#mc_deposit_submit span").removeClass("spinner-border spinner-border-sm");
                $("#mc_deposit_submit").removeAttr('disabled', 'disabled');

            },
            error: function(){
                $('.result-message').addClass('alert alert-danger');
                $('.result-message').html('There is some error. Please Try again later');
                $("#mc_deposit_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mc_deposit_submit").removeAttr('disabled', 'disabled');
            }
        })
    });
})
</script>

                                    
                                  </div>
                              </div>
                          </div>
                      </div>
<!-- End of Tab Content -->

                </div>

            </div>

            </div>
    <?php
$output = ob_get_clean();
    return $output;
}

add_shortcode('user_deposit_page', 'lyra_deposit_page');