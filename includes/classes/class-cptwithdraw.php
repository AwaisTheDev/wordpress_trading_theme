<?php

/**
 * Enqueue Assets
 *
 * @package lyra
 */

namespace LYRA_THEME\Includes;

use LYRA_THEME\Includes\traits\singleton;

class CPTWithdraw
{
    use singleton;

    protected function __construct()
    {

        $this->setup_hooks();

    }

    public function setup_hooks()
    {

        add_action('init', array($this, 'create_withdrawsrequest_cpt'), 0);
        add_action('load-post.php', array($this, 'aa_withdrawls_meta_setup'));
        add_action('load-post-new.php', array($this, 'aa_withdrawls_meta_setup'));

    }
    // Register Custom Post Type Withdraws Request
    public function create_withdrawsrequest_cpt()
    {

        $labels = array(
            'name' => _x('Withdrawl Requests', 'Post Type General Name', 'lyra'),
            'singular_name' => _x('Withdrawl Request', 'Post Type Singular Name', 'lyra'),
            'menu_name' => _x('Withdrawl Requests', 'Admin Menu text', 'lyra'),
            'name_admin_bar' => _x('Withdrawl Request', 'Add New on Toolbar', 'lyra'),
            'archives' => __('Withdrawl Request Archives', 'lyra'),
            'attributes' => __('Withdrawl Request Attributes', 'lyra'),
            'parent_item_colon' => __('Parent Withdrawl Request:', 'lyra'),
            'all_items' => __('All Withdrawl Requests', 'lyra'),
            'add_new_item' => __('Add New Withdrawl Request', 'lyra'),
            'add_new' => __('Add New', 'lyra'),
            'new_item' => __('New Withdrawl Request', 'lyra'),
            'edit_item' => __('Edit Withdrawl Request', 'lyra'),
            'update_item' => __('Update Withdrawl Request', 'lyra'),
            'view_item' => __('View Withdrawl Request', 'lyra'),
            'view_items' => __('View Withdrawl Requests', 'lyra'),
            'search_items' => __('Search Withdrawl Request', 'lyra'),
            'not_found' => __('Not found', 'lyra'),
            'not_found_in_trash' => __('Not found in Trash', 'lyra'),
            'featured_image' => __('Featured Image', 'lyra'),
            'set_featured_image' => __('Set featured image', 'lyra'),
            'remove_featured_image' => __('Remove featured image', 'lyra'),
            'use_featured_image' => __('Use as featured image', 'lyra'),
            'insert_into_item' => __('Insert into Withdrawl Request', 'lyra'),
            'uploaded_to_this_item' => __('Uploaded to this Withdrawl Request', 'lyra'),
            'items_list' => __('Withdrawl Requests list', 'lyra'),
            'items_list_navigation' => __('Withdrawl Requests list navigation', 'lyra'),
            'filter_items_list' => __('Filter Withdrawl Requests list', 'lyra'),
        );

        $args = array(
            'label' => __('Withdrawl Request', 'lyra'),
            'description' => __('', 'lyra'),
            'labels' => $labels,
            'menu_icon' => 'dashicons-external',
            'supports' => array('title', 'revisions'),
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
        register_post_type('withdrawsrequest', $args);
    }

    public function aa_withdrawls_meta_setup()
    {

        add_action('add_meta_boxes', array($this, 'aa_add_withdrawls_meta_boxes'));
        add_action('save_post', array($this, 'aa_save_project_information_meta'), 10, 2);

    }

    public function aa_add_withdrawls_meta_boxes()
    {
        add_meta_box('withdrawl_related_information', 'Related Information', array($this, 'aa_related_information_metabox'), 'withdrawsrequest', 'normal', "default");
    }

    public function aa_related_information_metabox($post)
    {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $table_prefix = $wpdb->prefix;
        $user_Id = esc_attr(get_post_meta($post->ID, 'wd_investor_id', true));
        $query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
        $investordata = $wpdb->get_row($query, ARRAY_A, 0);
        $user_current_balance = $investordata['current_balance'];

        echo "<b style='font-size:16px; color:red;'>Current balance: $user_current_balance</b>";

        ?>

        <?php wp_nonce_field(basename(__FILE__), 'aa_withdrawl_class_nonce');?>
        <p>
            <label for="wd_investor_id"><?php _e("Investor Id", 'lyra');?></label>
            <br />
            <input class="widefat" type="number" name="wd_investor_id" id="wd_investor_id" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_investor_id', true)); ?>" readonly  />
        </p>
        <p>
            <label for="wd_investor_name"><?php _e("Investor Name", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="wd_investor_name" id="wd_investor_name" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_investor_name', true)); ?>"  readonly  />
        </p>

        <b>Withdrawl Request Information</b>
        <p>
            <label for="wd_amount_requested"><?php _e("Amount Requested for wiithdrawl", 'lyra');?></label>
            <br />
            <input class="widefat" type="number" name="wd_amount_requested" id="wd_amount_requested" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_amount_requested', true)); ?>"  readonly  />
        </p>

        <p>
        <?php $meta_element_class = get_post_meta($post->ID, 'wd_withdrawl_method', true);
        ?>
            <label for="wd_withdrawl_method"><?php _e("Withdrawl Method", 'lyra');?></label>
            <br />
            <select name="wd_withdrawl_method" id="wd_withdrawl_method" readonly >
                    <option value="Binance" <?php selected($meta_element_class, 'Binance');?>>Binance</option>
            </select>
        </p>

        <p>
            <label for="wd_binance_id"><?php _e("Binance ID", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="wd_binance_id" id="wd_binance_id" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_binance_id', true)); ?>" readonly   />
        </p>
        <p>
            <label for="wd_name_on_binance"><?php _e("Name on Binance account", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="wd_name_on_binance" id="wd_name_on_binance" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_name_on_binance', true)); ?>"  readonly  />
        </p>

        <b>Withdrawl Processing</b>
        <p>
        <?php $meta_element_class = get_post_meta($post->ID, 'wd_withdrawl_status', true);
        ?>
            <label for="wd_withdrawl_status"><?php _e("Withdrawl Status", 'lyra');?></label>
            <br />
            <select name="wd_withdrawl_status" id="wd_withdrawl_status">
                    <option value="Requested" <?php selected($meta_element_class, 'Requested');?>>Requested</option>
                    <option value="In Review" <?php selected($meta_element_class, 'In Review');?>>In Review</option>
                    <option value="Some Error" <?php selected($meta_element_class, 'Some Error');?>>Some Error</option>
                    <option value="Completed" <?php selected($meta_element_class, 'Completed');?>>Completed</option>
                    <option value="Declined" <?php selected($meta_element_class, 'Declined');?>>Declined</option>
            </select>
        </p>

        <?php $withdrawl_status = get_post_meta($post->ID, 'wd_withdrawl_status', true);?>


        <p>
            <label for="wd_withdraw_description"><?php _e("Description", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="wd_withdraw_description" id="wd_withdraw_description" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_withdraw_description', true)); ?>" <?php echo ($withdrawl_status == "Completed") ? 'readonly ' : ''; ?> />
        </p>

        <p>
            <label for="wd_transction_processed_by"><?php _e("Processed By", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="wd_transction_processed_by" id="wd_transction_processed_by" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_transction_processed_by', true)); ?>"  <?php echo ($withdrawl_status == "Completed") ? 'readonly ' : ''; ?> />
        </p>
        <p>

            <label for="wd_transction_amount"><?php _e("Amount Sent", 'lyra');?></label>
            <br />
            <input class="widefat" type="number" name="wd_transction_amount" id="wd_transction_amount" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_transction_amount', true)); ?>"  <?php echo ($withdrawl_status == "Completed") ? 'readonly ' : ''; ?>  />
        </p>
        <p>
            <label for="wd_transction_ID"><?php _e("Transction Id", 'lyra');?></label>
            <br />
            <input class="widefat" type="text" name="wd_transction_ID" id="wd_transction_ID" value="<?php echo esc_attr(get_post_meta($post->ID, 'wd_transction_ID', true)); ?>" <?php echo ($withdrawl_status == "Completed") ? 'readonly ' : ''; ?> />
        </p>

        <?php

    }

    /* Save the meta box’s post metadata. */
    public function aa_save_project_information_meta($post_id, $post)
    {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['aa_withdrawl_class_nonce']) || !wp_verify_nonce($_POST['aa_withdrawl_class_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        /* Get the post type object. */
        $post_type = get_post_type_object($post->post_type);

        /* Check if the current user has permission to edit the post. */
        if (!current_user_can($post_type->cap->edit_post, $post_id)) {
            return $post_id;
        }

        $this->set_meta_values('wd_investor_id', $post_id);
        $this->set_meta_values('wd_investor_name', $post_id);
        $this->set_meta_values('wd_amount_requested', $post_id);
        $this->set_meta_values('wd_withdrawl_method', $post_id);
        $this->set_meta_values('wd_binance_id', $post_id);
        $this->set_meta_values('wd_name_on_binance', $post_id);
        $this->set_meta_values('wd_withdraw_description', $post_id);
        $this->set_meta_values('wd_transction_processed_by', $post_id);
        $this->set_meta_values('wd_transction_amount', $post_id);
        $this->set_meta_values('wd_transction_ID', $post_id);

        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $table_prefix = $wpdb->prefix;
        $user_Id = esc_attr(get_post_meta($post_id, 'wd_investor_id', true));
        $query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
        $investordata = $wpdb->get_row($query, ARRAY_A, 0);
        $user_current_balance = $investordata['current_balance'];

        $newValue = $user_current_balance - $_POST['wd_amount_requested'];

        $previous_withdrawl_status = get_post_meta($post_id, 'wd_withdrawl_status', true);

        if (isset($_POST['wd_withdrawl_status'])) {

            $current_withdrawl_status = $_POST['wd_withdrawl_status'];
            if ($current_withdrawl_status == 'Completed' && $previous_withdrawl_status != 'Completed') {

                $result = $wpdb->update(
                    //Table name
                    "{$wpdb->prefix}investor",

                    //values
                    array(
                        'current_balance' => $newValue,
                    ),

                    //where
                    array('investor_id' => $user_Id)
                );

                if ($result == 1) {
                    /**
                     * Update Total withdrawls
                     */
                    $query = "SELECT * FROM {$table_prefix}investor WHERE investor_id = {$user_Id}";
                    $investordata = $wpdb->get_row($query, ARRAY_A, 0);

                    $current_total_withdrawls = $investordata['total_withdrawls'];

                    $newValue = $_POST['wd_amount_requested'] + $current_total_withdrawls;

                    $withdrawlResult = $wpdb->update(
                        //Table name
                        "{$wpdb->prefix}investor",

                        //values
                        array(
                            'total_withdrawls' => $newValue,
                        ),

                        //where
                        array('investor_id' => $user_Id)
                    );
                    if ($withdrawlResult == 1) {
                        $this->save_meta_value_function($current_withdrawl_status, 'wd_withdrawl_status', $post_id);

                    }

                }

            } elseif ($previous_withdrawl_status == 'Completed') {
               //do nothing
            }else{
                $this->save_meta_value_function($current_withdrawl_status, 'wd_withdrawl_status', $post_id);
            }
        }

    }

    public function set_meta_values($meta_key, $post_id)
    {
        $meta_key_value = (isset($_POST[$meta_key]) ? $_POST[$meta_key] : "");
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
