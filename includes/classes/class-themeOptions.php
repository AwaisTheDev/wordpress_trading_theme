<?php

/**
 * Theme options
 *
 * @package lyra
 */

namespace LYRA_THEME\Includes;

use LYRA_THEME\Includes\traits\singleton;

class ThemeOptions
{
    use singleton;

    protected function __construct()
    {
        $this->setup_hooks();
    }

    public function setup_hooks()
    {
        add_action('admin_menu', array($this, 'ct_site_settings_menu_page'));
        add_action('admin_init', array($this, 'ct_admin_settings_page_options'));
    }
    /**
     * Register a custom menu page.
     */
    public function ct_site_settings_menu_page()
    {
        add_menu_page(
            __('M&C Trading', 'lyra'),
            __('M&C Trading', 'lyra'),
            'manage_options',
            'mc_options_page',
            array($this, 'mc_admin_page_contents_calback'),
            'dashicons-schedule',
            3
        );

    }

    public function mc_admin_page_contents_calback()
    {
        ob_start();?>

<div class="wrap">
    <?php echo settings_errors(); ?>
    <h1><?php echo get_admin_page_title(); ?></h1>
    <form method="post" action="options.php">
        <?php //br
        settings_fields('mc_page_links_settings_group');

        do_settings_sections('mc_options_page');
        submit_button('Save Settings');

        ?>

    </form>
</div>
<?php //br
        $output = ob_get_clean();
        echo $output;

    }

    public function ct_admin_settings_page_options()
    {

        //add_settings_section( id, title, callback, page )
        add_settings_section(
            'ct_default_page_links',
            'Page Links',
            '',
            'mc_options_page'
        );

        //register_setting( option_group, option_name, sanitize_callback );
        register_setting(
            'mc_page_links_settings_group',
            'login_page_link',
            array()
        );
        register_setting(
            'mc_page_links_settings_group',
            'register_page_link',
            array()
        );
        register_setting(
            'mc_page_links_settings_group',
            'dashboard_page_link',
            array()
        );

        //add_settings_field( $id:string, $title:string, $callback:callable, $page:string, $section:string, $args:array )
        add_settings_field(
            'mc_login_page_link',
            'Login Page',
            array($this, 'mc_login_page_link_callack'),
            'mc_options_page',
            'ct_default_page_links',
            array()
        );

        //add_settings_field( $id:string, $title:string, $callback:callable, $page:string, $section:string, $args:array )
        add_settings_field(
            'mc_register_page_link',
            'Register Page',
            array($this, 'mc_register_page_link_callack'),
            'mc_options_page',
            'ct_default_page_links',
            array()
        );
        //add_settings_field( $id:string, $title:string, $callback:callable, $page:string, $section:string, $args:array )
        add_settings_field(
            'mc_dashboard_page_link',
            'Dashbaord',
            array($this, 'mc_dashboard_page_link_callack'),
            'mc_options_page',
            'ct_default_page_links',
            array()
        );

        add_settings_field(
            'custom_feild',
            'Dashbaord',
            array($this, 'mc_dashboard_page_link_callack'),
            'mc_options_page',
            'ct_default_page_links',
            array()
        );

    }

    public function ct_page_links_callback()
    {
        //echo "Page Links Options";
    }

    public function mc_login_page_link_callack()
    {

        $login_page = get_option('login_page_link');
        //echo $login_page;
        ?>

<select name='login_page_link'>
    <option value='0'><?php _e('--Select a Page--', 'textdomain');?></option>
    <?php $pages = get_pages();?>
    <?php foreach ($pages as $page) {?>
    <option value='<?php echo $page->ID; ?>' <?php selected($login_page, $page->ID);?>>
        <?php echo $page->post_title; ?></option>
    <?php }
        ;?>
</select>

<?php

    }
    public function mc_register_page_link_callack()
    {

        $login_page = get_option('register_page_link');
        //echo $login_page;
        ?>

<select name='register_page_link'>
    <option value='0'><?php _e('--Select a Page--', 'textdomain');?></option>
    <?php $pages = get_pages();?>
    <?php foreach ($pages as $page) {?>
    <option value='<?php echo $page->ID; ?>' <?php selected($login_page, $page->ID);?>>
        <?php echo $page->post_title; ?></option>
    <?php }
        ;?>
</select>

<?php

    }

    public function mc_dashboard_page_link_callack()
    {

        $login_page = get_option('dashboard_page_link');
        //echo $login_page;
        ?>

<select name='dashboard_page_link'>
    <option value='0'><?php _e('--Select a Page--', 'textdomain');?></option>
    <?php $pages = get_pages();?>
    <?php foreach ($pages as $page) {?>
    <option value='<?php echo $page->ID; ?>' <?php selected($login_page, $page->ID);?>>
        <?php echo $page->post_title; ?></option>
    <?php }
        ;?>
</select>

<?php

    }

}