<?php
/**
 * @package lyra
 */

namespace LYRA_THEME\Includes;

use LYRA_THEME\Includes\traits\singleton;

class LYRA_THEME
{
    use singleton;

    protected function __construct()
    {
        $this->setup_hooks();
        Assets::get_instance();
        Menus::get_instance();
        ThemeOptions::get_instance();
        DailyProfitPage::get_instance();
        CPTWithdraw::get_instance();
        CPTDeposit::get_instance();

    }

    public function setup_hooks()
    {

        add_action('after_setup_theme', array($this, 'theme_setup'));

        add_action('init', array($this, 'ct_add_investor_role'));
        add_action('after_setup_theme', array($this, 'ct_remove_admin_bar'));
        add_action('init', array($this, 'ct_restrict_dashbard_access'));

    }

    public function ct_restrict_dashbard_access()
    {
        if (is_admin() && !defined('DOING_AJAX') && (current_user_can('subscriber') || current_user_can('contributor') || current_user_can('investor'))) {
            wp_redirect(home_url());
            exit;
        }
    }

    public function theme_setup()
    {
        add_theme_support('title-tag');

        $defaults = array(
            'height' => 100,
            'width' => 100,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-description'),
            'unlink-homepage-logo' => false,
        );
        add_theme_support('custom-logo', $defaults);

        add_theme_support('post-thumbnails');

        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support(
            'html5',
            [
                'comment-list',
                'comment-form',
                'search-form',
                'gallery',
                'caption',
                'script',
                'style',

            ]
        );

        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');

        global $content_width;

        if (!isset($content_width)) {
            $content_width = 1240;
        }
    }

    public function ct_add_investor_role()
    {

        $capabilities = array(
            'read' => true,
            'create_posts' => true,
            'edit_posts' => true,
            'publish_posts' => true,
        );
        add_role('investor', __('Investor'), $capabilities);
    }

    public function ct_remove_admin_bar()
    {
        if (current_user_can('investor')) {
            show_admin_bar(false);
        }
    }

}
