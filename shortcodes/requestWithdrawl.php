<?php

add_shortcode('request_withdrawl', 'ct_request_withdrawl');

function ct_request_withdrawl()
{
    ob_start();
    ?>


   <!-- Deposit Forms -->
          <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body shadow-sm mb-4">
                    <h2 class="h5 mb-2">Request Withdrawl</h2>
                    <form action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div clss="input-group">
                                    <label for="mc_withdrawl_amount">Enter the amount you want to with draw $</label>
                                    <input class="form-control"  name="mc_withdrawl_amount" id="mc_withdrawl_amount" type="number" placeholder="e.g 10" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div clss="input-group">
                                    <label for="mc_withdrawl_method">Withdrawl Method</label>
                                    <select class="form-select" name="mc_withdrawl_method" id="mc_withdrawl_method">
                                        <option value="Binance" selected>Binance</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div clss="input-group">
                                    <label for="wd_binance_id">Enter Binance ID</label>
                                    <input class="form-control"  name="wd_binance_id" id="wd_binance_id" type="tel" placeholder="e.g 12345" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div clss="input-group">
                                    <label for="wd_name_on_binance">Enter your name on Binance profile</label>
                                    <input class="form-control"  name="wd_name_on_binance" id="wd_name_on_binance" type="text" placeholder="e.g Muhammad Awais" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="">
                                <button class="btn btn-dark mt-3 mc_withdrawl_submit" id="mc_withdrawl_submit"  name="mc_withdrawl_submit" type="submit">
                                                    Request Now
                                <span role="status" aria-hidden="true"></span>
                            </button>
                            <div class="result-message mt-2"></div>
                            </div>

                        </div>
                    </form>
                </div>


<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#mc_withdrawl_submit").on('click', function(e) {
        e.preventDefault();

        $("#mc_withdrawl_submit span").addClass("spinner-border spinner-border-sm");
        $("#mc_withdrawl_submit").attr('disabled', 'disabled');


        var mc_withdrawl_amount = $("#mc_withdrawl_amount").val();
        var mc_withdrawl_method = $("#mc_withdrawl_method").val();
        var wd_binance_id = $("#wd_binance_id").val();
        var wd_name_on_binance = $("#wd_name_on_binance").val();


        if(mc_withdrawl_amount== '' || mc_withdrawl_method==null || wd_binance_id==null || wd_name_on_binance==null){
                $('.result-message').html('Please enter all required feilds');
                $('.result-message').addClass('alert alert-secondary');
                $("#mc_withdrawl_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mc_withdrawl_submit").removeAttr('disabled', 'disabled');
        }

        //console.log(profitValue);

        var formData = {
            mc_withdrawl_amount: mc_withdrawl_amount,
            mc_withdrawl_method: mc_withdrawl_method,
            wd_binance_id: wd_binance_id,
            wd_name_on_binance:wd_name_on_binance
        }
        console.log(formData);
        $.ajax({
            url: "<?php echo LYRA_ROOT_DIR_URI ?>/shortcodes/includes/widthdrawProcessing.php",
            type: "POST",
            data: formData,
            success: function(result) {
                console.log("result=" + result);
                $('.result-message').html(result);
                $('.result-message').addClass('alert alert-secondary');
                $("#mc_withdrawl_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mc_withdrawl_submit").removeAttr('disabled', 'disabled');

            },
            error: function(){
                $('.result-message').addClass('alert alert-danger');
                $('.result-message').html('There is some error. Please Try again later');
                $("#mc_withdrawl_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mc_withdrawl_submit").removeAttr('disabled', 'disabled');
            }
        })
    });
})
</script>


<?php
$output = ob_get_clean();
    return $output;

}
