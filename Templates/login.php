<?php
/*
 ** Template Name: Login
 */

if (is_user_logged_in()) {
    wp_redirect(get_page_link(get_option('dashboard_page_link')));
}

get_header();
?>

<main>

        <!-- Section -->
        <section class="d-flex align-items-center mb-lg-5">
            <div class="container">

                <p class="text-center"><a href="../dashboard/dashboard.html" class="text-gray-700"><i class="fas fa-angle-left me-2"></i> Back to homepage</a></p>
                <div class="row justify-content-center form-bg-image" data-background-lg="../../assets/img/illustrations/signin.svg">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Sign in to our platform</h1>
                            </div>
                            <?php if (isset($_GET['refferer'])) {?>
                                <div class="alert alert-info" role="alert">
                                    Please login to access dashboard
                                </div>
                            <?php }?>
                            <form action="<?php the_permalink()?>" method="POST"name="user_login" class="mt-4">
                                <!-- Form -->
                                <div class="result-message"></div>
                                <div class="form-group mb-4">
                                    <label for="email">Username or Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><span class="fas fa-envelope"></span></span>
                                        <input type="text" id="mac_username" name="mac_username" class="form-control" placeholder="example@company.com" id="email" autofocus required>
                                    </div>
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="password">Your Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2"><span class="fas fa-unlock-alt"></span></span>
                                            <input type="password" id="mac_password" name="mac_password" placeholder="Password" class="form-control" id="password" required>
                                        </div>
                                    </div>
                                    <!-- End of Form -->
                                    <div class="d-flex justify-content-between align-items-top mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" id="mac_remember_user" name="mac_remember_user" type="checkbox" id="remember">
                                            <label class="form-check-label mb-0" for="remember">
                                              Remember me
                                            </label>
                                        </div>
                                        <div><a href="#" class="small text-right">Lost password?</a></div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" id="mac_login_submit" name="mac_login_submit" class="btn btn-dark">Sign in
                                    <span></span>
                                    </button>
                                </div>
                            </form>


                            <div class="d-flex justify-content-center align-items-center mt-4">
                                <span class="fw-normal">
                                    Not registered?
                                    <a href="<?php echo get_page_link(get_option('register_page_link')) ?>" class="fw-bold">Register
                                here</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#mac_login_submit").on('click', function(e) {
        e.preventDefault();

        $("#mac_login_submit span").addClass("spinner-border spinner-border-sm");
        $("#mac_login_submit").attr('disabled', 'disabled');


        var mac_password = $("#mac_password").val();
        var mac_username = $("#mac_username").val();
        var mac_remember_user = $("#mac_remember_user").val();


        if(mac_password==null || mac_username==null){
                $('.result-message').html('Please enter all required feilds');
                $('.result-message').addClass('alert alert-secondary');
                $("#mac_login_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mac_login_submit").removeAttr('disabled', 'disabled');
        }

        //console.log(profitValue);

        var formData = {
            mac_password: mac_password,
            mac_username: mac_username,
            mac_remember_user: mac_remember_user
        }
        console.log(formData);
        $.ajax({
            url: "<?php echo LYRA_ROOT_DIR_URI ?>/templates/includes/login-processing.php",
            type: "POST",
            data: formData,
            success: function(result) {
                console.log("result=" + result);
                $('.result-message').html(result);
                $('.result-message').addClass('alert alert-secondary');
                $("#mac_login_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mac_login_submit").removeAttr('disabled', 'disabled');

            },
            error: function(){
                $('.result-message').addClass('alert alert-danger');
                $('.result-message').html('There is some error. Please Try again later');
                $("#mac_login_submit span").removeClass(
                    "spinner-border spinner-border-sm");
                $("#mac_login_submit").removeAttr('disabled', 'disabled');
            }
        })
    });
})
</script>


<?php get_footer()?>