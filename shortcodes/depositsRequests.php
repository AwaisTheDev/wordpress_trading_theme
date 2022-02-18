<?php

add_shortcode('deposit_requests', 'ct_deposit_requests_sent');

function ct_deposit_requests_sent()
{
    ob_start();

    $user_Id = get_current_user_id();

    ?>
<?php
$args = array(
        'post_type' => 'depositrequest',
        'post_status' => array('publish', 'pending', 'private'),
        'meta_query' => array(
            array(
                'key' => 'depr_investor_id',
                'value' => $user_Id,
                'compare' => 'LIKE',
            ),
        ),
    );
    $deposit_requests = new WP_Query($args);

    ?>
   <!-- Deposit Forms -->
          <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body shadow-sm mb-4">
                    <h2 class="h5 mb-2">My Deposit Requests</h2>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Request Date</th>
                                    <th class="border-0">Amount Requested</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Description</th>
                                </tr>
                            </thead>
                            <tbody>


                            <?php $deposit_status = get_post_meta(get_the_id(), 'depr_Deposit_status', true);
                            
                            ?>
                            <?php while ($deposit_requests->have_posts()) {$deposit_requests->the_post()?>
                                <tr>
                                    <td class="border-0 fw-bold"><?php echo get_the_ID() ?></td>
                                    <td class="border-0 fw-bold"><?php echo get_the_date() ?></td>
                                    <td class="border-0 fw-bold">USD. <?php echo get_post_meta(get_the_id(), 'depr_amount_requested', true) ?></td>
                                    <td class="border-0 fw-bold"><?php echo get_post_meta(get_the_id(), 'depr_Deposit_status', true) ?></td>
                                    <td class="border-0 fw-bold"><?php echo get_post_meta(get_the_id(), 'depr_request_description', true) ?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>

                </div>



<?php
$output = ob_get_clean();
    return $output;

}
