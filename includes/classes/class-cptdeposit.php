<?php

/**
 * Enqueue Assets
 *
 * @package lyra
 */

namespace LYRA_THEME\Includes;

use LYRA_THEME\Includes\traits\singleton;

class CPTDeposit
{
    use singleton;

    protected function __construct()
    {

        $this->setup_hooks();

    }

    public function setup_hooks()
    {

        add_action('init', array($this, 'create_depositrequest_cpt'), 0);
        add_action('load-post.php', array($this, 'aa_Deposits_meta_setup'));
        add_action('load-post-new.php', array($this, 'aa_Deposits_meta_setup'));

    }
    // Register Custom Post Type deposit Request
    public function create_depositrequest_cpt()
    {

        $labels = array(
            'name' => _x('Deposit Requests', 'Post Type General Name', 'lyra'),
            'singular_name' => _x('Deposit Request', 'Post Type Singular Name', 'lyra'),
            'menu_name' => _x('Deposit Requests', 'Admin Menu text', 'lyra'),
            'name_admin_bar' => _x('Deposit Request', 'Add New on Toolbar', 'lyra'),
            'archives' => __('Deposit Request Archives', 'lyra'),
            'attributes' => __('Deposit Request Attributes', 'lyra'),
            'parent_item_colon' => __('Parent Deposit Request:', 'lyra'),
            'all_items' => __('All Deposit Requests', 'lyra'),
            'add_new_item' => __('Add New Deposit Request', 'lyra'),
            'add_new' => __('Add New', 'lyra'),
            'new_item' => __('New Deposit Request', 'lyra'),
            'edit_item' => __('Edit Deposit Request', 'lyra'),
            'update_item' => __('Update Deposit Request', 'lyra'),
            'view_item' => __('View Deposit Request', 'lyra'),
            'view_items' => __('View Deposit Requests', 'lyra'),
            'search_items' => __('Search Deposit Request', 'lyra'),
            'not_found' => __('Not found', 'lyra'),
            'not_found_in_trash' => __('Not found in Trash', 'lyra'),
            'featured_image' => __('Featured Image', 'lyra'),
            'set_featured_image' => __('Set featured image', 'lyra'),
            'remove_featured_image' => __('Remove featured image', 'lyra'),
            'use_featured_image' => __('Use as featured image', 'lyra'),
            'insert_into_item' => __('Insert into Deposit Request', 'lyra'),
            'uploaded_to_this_item' => __('Uploaded to this Deposit Request', 'lyra'),
            'items_list' => __('Deposit Requests list', 'lyra'),
            'items_list_navigation' => __('Deposit Requests list navigation', 'lyra'),
            'filter_items_list' => __('Filter Deposit Requests list', 'lyra'),
        );

        $args = array(
            'label' => __('Deposit Request', 'lyra'),
            'description' => __('', 'lyra'),
            'labels' => $labels,
            'menu_icon' => 'dashicons-external',
            'supports' => array('title', 'revisions', 'thumbnail'),
            'taxonomies' => array(),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => false,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'show_in_rest' => true,
            'publicly_queryable' => true,
            'capability_type' => 'post',
        );
        register_post_type('depositrequest', $args);
    }

    public function aa_Deposits_meta_setup()
    {

        add_action('add_meta_boxes', array($this, 'aa_add_Deposits_meta_boxes'));
        add_action('save_post', array($this, 'aa_save_project_information_meta'), 10, 2);

    }

    public function aa_add_Deposits_meta_boxes()
    {
        add_meta_box('Deposit_related_information', 'Related Information', array($this, 'aa_related_information_metabox'), 'depositrequest', 'normal', "default");
    }

    public function aa_related_information_metabox($post)
    {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $table_prefix = $wpdb->prefix;
        $user_Id = esc_attr(get_post_meta($post->ID, 'depr_investor_id', true));
        $query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
        $investordata = $wpdb->get_row($query, ARRAY_A, 0);
        $output_val = $investordata['current_balance'];
        $amount_invested = $investordata['amount_invested'];

        if ($investordata == null) {
            $output_val = "Invalid Investor ID";
        } else {
            echo "<b style='font-size:16px; color:red;'>Current balance: $output_val</b><br>";
            echo "<b style='font-size:16px; color:red;'>Amount Invested: $amount_invested</b><br>";

        }

        ?>

        <?php wp_nonce_field(basename(__FILE__), 'aa_Deposit_class_nonce');?>
        <p>
            <label for="depr_investor_id"><?php _e("Investor Id", 'lyra');?></label>
            <br />
            <input class="widefat" type="number" name="depr_investor_id" id="depr_investor_id" value="<?php echo esc_attr(get_post_meta($post->ID, 'depr_investor_id', true)); ?>"   />
        </p>

        <b>Deposit Request Information</b>
        <p>
            <label for="depr_amount_requested"><?php _e("Deposit Amount", 'lyra');?></label>
            <br />
            <input class="widefat" type="number" name="depr_amount_requested" id="depr_amount_requested" value="<?php echo esc_attr(get_post_meta($post->ID, 'depr_amount_requested', true)); ?>"    />
        </p>

        <b>Deposit Processing</b>
        <p>
        <?php $meta_element_class = get_post_meta($post->ID, 'depr_Deposit_status', true);
        ?>
            <label for="depr_Deposit_status"><?php _e("Deposit Status", 'lyra');?></label>

            <?php //echo "Status =" .$meta_element_class; ?>
            <br />
            <select name="depr_Deposit_status" id="depr_Deposit_status">
                    <option value="Pending" <?php selected($meta_element_class, 'Pending');?>>Pending</option>
                    <option value="Declined" <?php selected($meta_element_class, 'Declined');?>>Declined</option>
                    <option value="Deposited" <?php selected($meta_element_class, 'Deposited');?>>Deposited</option>
            </select>
        </p>

        <?php $Deposit_status = get_post_meta($post->ID, 'depr_Deposit_status', true);?>


        <p>
            <label for="depr_request_processed_by"><?php _e("Processed By", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="depr_request_processed_by" id="depr_request_processed_by" value="<?php echo esc_attr(get_post_meta($post->ID, 'depr_request_processed_by', true)); ?>" />
        </p>
        <p>
            <label for="depr_request_result"><?php _e("Result", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="depr_request_result" id="depr_request_result" value="<?php echo esc_attr(get_post_meta($post->ID, 'depr_request_result', true)); ?>"  readonly/>
        </p>

        <p>
            <label for="depr_request_description"><?php _e("Description", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="depr_request_description" id="depr_request_description" value="<?php echo esc_attr(get_post_meta($post->ID, 'depr_request_description', true)); ?>"  />
        </p>
        <?php

    }

    /* Save the meta box’s post metadata. */
    public function aa_save_project_information_meta($post_id, $post)
    {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['aa_Deposit_class_nonce']) || !wp_verify_nonce($_POST['aa_Deposit_class_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        /* Get the post type object. */
        $post_type = get_post_type_object($post->post_type);

        /* Check if the current user has permission to edit the post. */
        if (!current_user_can($post_type->cap->edit_post, $post_id)) {
            return $post_id;
        }


        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $table_prefix = $wpdb->prefix;

        $user_Id = $_POST['depr_investor_id'];

        $query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
        $investordata = $wpdb->get_row($query, ARRAY_A, 0);

        $user_current_balance = $investordata['amount_invested'];

        $this->set_meta_values('depr_investor_id', $post_id);
        $this->set_meta_values('depr_request_description', $post_id);
        $this->set_meta_values('depr_request_processed_by', $post_id);
        $this->set_meta_values('depr_request_result', $post_id);
        $this->set_meta_values('depr_Deposit_status', $post_id);

        if ($investordata == null) {
            $this->save_meta_value_function('The investor ID you provided does\'nt exist', 'depr_request_result', $post_id);
        } else {
            $this->save_meta_value_function('The investor ID you provided exists', 'depr_request_result', $post_id);

            if ($_POST['depr_amount_requested'] == 0 || $_POST['depr_amount_requested'] == null) {
                return;
            }

            $current_deposit_status = $_POST['depr_Deposit_status'];
            $previous_deposit_status = get_post_meta($post_id, 'depr_Deposit_status', true);
            $newBalance = $user_current_balance + $_POST['depr_amount_requested'];

            if ($current_deposit_status == "Deposited" && $previous_deposit_status != "Deposited") {
                $result = $wpdb->update(
                    //Table name
                    "{$wpdb->prefix}investor",

                    //values
                    array(
                        'amount_invested' => $newBalance,
                    ),

                    //where
                    array('investor_id' => $user_Id)
                );

                if ($result == 1) {
                    $this->set_meta_values('depr_amount_requested', $post_id);
                    $this->set_meta_values('depr_Deposit_status', $post_id);

                    /**
                     * Update Total Deposit
                     */
                    $query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
                    $investordata = $wpdb->get_row($query, ARRAY_A, 0);

                    $current_total_deposit = $investordata['total_deposits'];

                    $newValue = $_POST['depr_amount_requested'] + $current_total_deposit;

                    $depositResult = $wpdb->update(
                        //Table name
                        "{$wpdb->prefix}investor",

                        //values
                        array(
                            'total_deposits' => $newValue,
                        ),

                        //where
                        array('investor_id' => $user_Id)
                    );

                }

            }

        }

    }

    public function set_meta_values($meta_key, $post_id)
    {
        $meta_key_value = (isset($_POST[$meta_key]) ? $_POST[$meta_key] : "0");
        echo $meta_key_value;
        $this->save_meta_value_function($meta_key_value, $meta_key, $post_id);

    }

    public function save_meta_value_function($new_meta_value, $meta_key, $post_id)
    {

        /* Get the meta value of the custom field key. */
        $meta_value = get_post_meta($post_id, $meta_key, true);

        /* If a new meta value was added and there was no previous value, add it. */
        if ($new_meta_value && '’' == $meta_value) {
            add_post_meta($post_id, $meta_key, $new_meta_value, true);
        }

        /* If the new meta value does not match the old value, update it. */
        elseif ($new_meta_value && $new_meta_value != $meta_value) {
            update_post_meta($post_id, $meta_key, $new_meta_value);
        }

        /* If there is no new meta value but an old value exists, delete it. */
        elseif ('' == $new_meta_value) {
            delete_post_meta($post_id, $meta_key, $meta_value);
        }

    }

}
