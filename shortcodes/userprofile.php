<?php
function lyra_user_profile()
{

    $html = "";
    if (!is_user_logged_in()) {
        $login_link = get_page_link(get_option('login_page_link'));
        $html .= 'You can not access this page! <br>Please <a href="' . $login_link . '">login</a> to continue.';
        return $html;
    }

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
    $investor_birthday = $user_info->investor_birthday;
    $gender = $user_info->user_gender;

    $street_address = $user_info->user_address_street;
    $city = $user_info->user_address_city;
    $state = $user_info->user_address_state;
    $zip = $user_info->user_address_zip;

    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $table_prefix = $wpdb->prefix;

    ob_start();?>
    <?php //echo get_template_part('template-parts/dashboard/top-banner'); ?>

            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="card card-body shadow-sm mb-4">
                        <h2 class="h5 mb-4">General information</h2>
                        <div class="alert alert-warning d-none profile-save-response" role="alert"></div>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="mc_user_first_name">First Name</label>
                                        <input class="form-control" id="mc_user_first_name" value="<?php echo $first_name ?>" type="text" placeholder="Enter your first name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="mc_user_last_name">Last Name</label>
                                        <input class="form-control" id="mc_user_last_name" value="<?php echo $last_name ?>" type="text" placeholder="Also your last name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-3">
                                    <label for="mc_user_birthday">Birthday</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                        <input data-datepicker="" class="form-control" id="mc_user_birthday" type="text" placeholder="dd/mm/yyyy" value="<?php echo $investor_birthday; ?>">
                                     </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gender">Gender</label>
                                    <select class="form-select mb-0" id="mc_user_gender" name="mc_user_gender" aria-label="Gender select example">
                                        <option value="Select" >--Select--</option>
                                        <option value="Male" <?php selected($gender, 'Male')?>>Male</option>
                                        <option value="Female" <?php selected($gender, 'Female')?>>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" id="mc_user_email" value="<?php echo $email ?>"  type="email" placeholder="name@company.com" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <?php $phone_number = get_user_meta($user_Id, 'investor_phone_number', true)?>
                                        <input class="form-control" id="mc_user_phone_number" type="number" value="<?php echo $phone_number ?>" placeholder="+12-345 678 910" required>
                                    </div>
                                </div>
                            </div>
                            <h2 class="h5 my-4">Location</h2>
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="mc_street_address">Street Address</label>
                                        <input class="form-control" value="<?php echo $street_address; ?>" id="mc_street_address" type="text" placeholder="Enter your home address" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <div class="form-group">
                                        <label for="mc_city">City</label>
                                        <input class="form-control" value="<?php echo $city; ?>" id="mc_city" name="mc_city" type="text" placeholder="City" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="mc_state">State</label>
                                        <input class="form-control" id="mc_state" value="<?php echo $state; ?>" type="text" name="state" placeholder="State" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="mc_zip">ZIP</label>
                                        <input class="form-control" value="<?php echo $zip; ?>" id="mc_zip" type="text" placeholder="ZIP" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" id="mc_save_user_information" class="btn btn-dark">Save Information<span></span></button>
                            </div>
                        </form>
                    </div>
                </div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#mc_save_user_information").on('click',function(e){
                e.preventDefault();

                $("#mc_save_user_information span").addClass("spinner-border spinner-border-sm");
                $("#mc_save_user_information").attr('disabled','disabled');


                var mc_user_first_name = $("#mc_user_first_name").val();
                var mc_user_last_name = $("#mc_user_last_name").val();
                var mc_user_birthday = $("#mc_user_birthday").val();
                var mc_user_email = $("#mc_user_email").val();
                var mc_user_phone_number = $("#mc_user_phone_number").val();
                var mc_user_gender = $("#mc_user_gender option:selected").val();

                /**
                 * Address Informatin
                 */
                var mc_street_address = $("#mc_street_address").val();
                var mc_city = $("#mc_city").val();
                var mc_state = $("#mc_state").val();
                var mc_zip = $("#mc_zip").val();

                //console.log(profitValue);

                var formData ={
                    mc_user_first_name:mc_user_first_name,
                    mc_user_last_name:mc_user_last_name,
                    mc_user_birthday:mc_user_birthday,
                    mc_user_email:mc_user_email,
                    mc_user_phone_number:mc_user_phone_number,
                    mc_user_gender:mc_user_gender,
                    mc_street_address:mc_street_address,
                    mc_city:mc_city,
                    mc_state:mc_state,
                    mc_zip:mc_zip,
                }

                $.ajax({
                    url: "<?php echo LYRA_ROOT_DIR_URI ?>/shortcodes/includes/userProfileProcessing.php",
                    type: "POST",
                    data: formData,
                    success: function(result){
                        console.log("result= " + result);
                        $("#mc_save_user_information span").removeClass("spinner-border spinner-border-sm");
                        $("#mc_save_user_information").removeAttr('disabled','disabled');

                        $(".profile-save-response").html(result);
                        $(".profile-save-response").removeClass('d-none');

                        //location . reload();

                    }
                    })
            });
        })
    </script>

                <div class="col-12 col-xl-4">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm text-center p-0">
                                <div class="profile-cover rounded-top" data-background="../assets/img/profile-cover.jpg"></div>
                                <div class="card-body pb-5">
                                    <img src="<?php echo esc_url(get_avatar_url($user_Id)) ?>" class="user-avatar large-avatar rounded-circle mx-auto mt-n7 mb-4" alt="Neil Portrait">
                                    <?php $investor_name = $first_name . $last_name;?>
                                    <h4 class="h3"><?php echo ($investor_name == null) ? "No Name" : $first_name . " " . $last_name; ?></h4>
                                    <h5>Your account ID = <?php echo $user_Id; ?></h5>
                                    <a class="btn btn-sm btn-dark me-2" href="#"><span class="fas fa-user-plus me-1"></span> Logout</a>
                                </div>
                             </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-body shadow-sm mb-4">
                                <h2 class="h5 mb-4">Change profile photo</h2>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <!-- Avatar -->
                                        <div class="user-avatar xl-avatar">
                                            <img class="rounded" src="<?php echo esc_url(get_avatar_url($user_Id)) ?>" alt="change avatar">
                                        </div>
                                    </div>
                                    <div class="file-field">
                                        <div class="d-flex justify-content-xl-center ms-xl-3">
                                           <div class="d-flex">
                                              <span class="icon icon-md"><span class="fas fa-paperclip me-3"></span></span> <input type="file">
                                              <div class="d-md-block text-left">
                                                 <div class="fw-normal text-dark mb-1">Choose Image</div>
                                                 <div class="text-gray small">JPG, GIF or PNG. Max size of 800K</div>
                                              </div>
                                           </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

 <?php

    $output = ob_get_clean();

    return $output;
}

add_shortcode('user_profile', 'lyra_user_profile');