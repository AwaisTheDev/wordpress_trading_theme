<?php
/*
 ** Template Name: Register
 */

if (is_user_logged_in()) {
    wp_redirect(get_page_link(get_option('dashboard_page_link')));
}

get_header();

global $wpdb, $user_ID;
?>

<section class="d-flex align-items-center mb-lg-5">
    <div class="container">
        <p class="text-center"><a href="<?php echo site_url(); ?>" class="text-gray-700"><i
                    class="fas fa-angle-left me-2"></i> Back to homepage</a></p>
        <div class="row justify-content-center form-bg-image"
            style="background-image:url('<?php echo LYRA_ROOT_DIR_URI . '/assets/img/illustrations/signin.svg' ?>'">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="mb-4 mb-lg-0 bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-0 h3">Register Now</h1>
                    </div>
                    <form action="<?php the_permalink()?>" method="POST" name="user_registeration">
                    <div class="result-message">

                    </div>
                        <!-- Form -->
                        <div class="form-group mb-4">
                            <label for="email">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3"><span
                                        class="fas fa-envelope"></span></span>
                                <input type="text" class="form-control" id="ct_first_name" name="ct_first_name" placeholder="Enter your Name"
                                    required>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="email">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3"><span
                                        class="fas fa-envelope"></span></span>
                                <input type="text" class="form-control" id="ct_last_name" name="ct_last_name" placeholder="Enter your Name"
                                    required>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="email">Username</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3"><span
                                        class="fas fa-user"></span></span>
                                <input type="text" class="form-control" name="ct_username" id="ct_username"
                                    placeholder="Please Select a username" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="email">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3"><span
                                        class="fas fa-envelope"></span></span>
                                <input type="email" class="form-control" id="ct_useremail" name="ct_useremail" placeholder="Email Address"
                                    required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="email">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3"><span
                                        class="fas fa-phone"></span></span>
                                <input type="tel" class="form-control" id="ct_userphone" name="ct_userphone" placeholder="Phone Number"
                                    required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="email">Reffered By</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3"><span
                                        class="fas fa-link"></span></span>
                                <input type="text" class="form-control"  id="ct_reffered_by" name="ct_reffered_by" placeholder="Refferal by Username"
                                   value='<?php echo (isset($_GET['reffered_by'])) ? $_GET['reffered_by'] : '' ?>' <?php echo (isset($_GET['reffered_by'])) ? 'readonly' : '' ?>  required>
                            </div>
                        </div>

                        <!-- End of Form -->
                        <div class="form-group">
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="password">Your Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon4"><span
                                            class="fas fa-unlock-alt"></span></span>
                                    <input type="password" name="ct_password" placeholder="Password"
                                        class="form-control" id="ct_password" required>
                                </div>
                            </div>
                            <!-- End of Form -->
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="confirm_password">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon5"><span
                                            class="fas fa-unlock-alt"></span></span>
                                    <input type="password" name="confirm_password" placeholder="Confirm Password"
                                        class="form-control" id="confirm_password" required>
                                </div>
                            </div>
                            <!-- End of Form -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="terms">
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#">terms and conditions</a>
                                </label>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="ct_user_registeration" id="ct_user_registeration"
                                class="btn btn-dark">SignUp<span></span></button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            Already have an account?
                            <a href="<?php echo get_page_link(get_option('login_page_link')) ?>" class="fw-bold">Login
                                here</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#ct_user_registeration").on('click', function(e) {
        e.preventDefault();

        $("#ct_user_registeration span").addClass("spinner-border spinner-border-sm");
        $("#ct_user_registeration").attr('disabled', 'disabled');


        var ct_username = $("#ct_username").val();
        var ct_first_name = $("#ct_first_name").val();
        var ct_last_name = $("#ct_last_name").val();
        var ct_useremail = $("#ct_useremail").val();
        var ct_password = $("#ct_password").val();
        var ct_userphone = $("#ct_userphone").val();
        var confirm_password = $("#confirm_password").val();
        var ct_reffered_by = $("#ct_reffered_by").val();

        function showResult(message){
            $('.result-message').html(message);
            $('.result-message').addClass('alert alert-secondary');
            $("#ct_user_registeration span").removeClass(
                "spinner-border spinner-border-sm");
            $("#ct_user_registeration").removeAttr('disabled', 'disabled');
        }


        //console.log(profitValue);

        var formData = {
            ct_username: ct_username,
            ct_first_name: ct_first_name,
            ct_last_name: ct_last_name,
            ct_useremail: ct_useremail,
            ct_password: ct_password,
            ct_userphone: ct_userphone,
            ct_reffered_by: ct_reffered_by,
            confirm_password: confirm_password
        }

        for (const property in formData) {
              if(formData[property]== null || formData[property]== ""){
                  if(property == 'ct_reffered_by'){
                      console.log("Refferal User Empty");
                      break;
                  }
                showResult("Please enter all feilds");
                return;
              }
        }

        $.ajax({
            url: "<?php echo LYRA_ROOT_DIR_URI ?>/templates/includes/register-processing.php",
            type: "POST",
            data: formData,
            success: function(result) {
                console.log("result=" + result);
                showResult(result);
            },
            error: function(){
                showResult(result);
            }
        })
    });
})
</script>