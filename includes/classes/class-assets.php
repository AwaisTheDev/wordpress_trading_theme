<?php

/**
 * Enqueue Assets
 *
 * @package lyra
 */

namespace LYRA_THEME\Includes;

use LYRA_THEME\Includes\traits\singleton;

class Assets
{
    use singleton;

    protected function __construct()
    {

        $this->setup_hooks(); 

    }

    public function setup_hooks()
    {

        add_action('wp_enqueue_scripts', array($this, 'lyra_enqueue_css'));
        add_action('wp_enqueue_scripts', array($this, 'lyra_enqueue_javascript'));

    }

    public function lyra_enqueue_css()
    {
        wp_register_style('lyra_stylesheet', LYRA_ROOT_DIR_URI . '/assets/css/style.css', [], filemtime(LYRA_ROOT_DIR_PATH . '/assets/css/style.css'), 'all');
        wp_register_style('lyra_bootstrap_css', LYRA_ROOT_DIR_URI . '/assets/library/bootstrap/css/bootstrap.min.css', [], 5.0, 'all');
        wp_register_style('volt_template_css', LYRA_ROOT_DIR_URI . '/assets/volt-template/css/volt.css', [], 1.0, 'all');
        wp_register_style('volt_font_awesome', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/@fortawesome/fontawesome-free/css/all.min.css', [], 1.0, 'all');
        wp_register_style('volt_sweetalert2', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/sweetalert2/dist/sweetalert2.min.css', [], 1.0, 'all');
        wp_register_style('volt_notyf', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/notyf/notyf.min.css', [], 1.0, 'all');

        wp_enqueue_style('lyra_stylesheet');
        //wp_enqueue_style( 'lyra_bootstrap_css');
        wp_enqueue_style('volt_template_css');
        wp_enqueue_style('volt_font_awesome');
        wp_enqueue_style('volt_sweetalert2');
        wp_enqueue_style('volt_notyf');
    }

    public function lyra_enqueue_javascript()
    {
        wp_enqueue_script("jquery");
        wp_register_script('lyra_javascript', LYRA_ROOT_DIR_URI . '/assets/js/main.js', [], filemtime(LYRA_ROOT_DIR_PATH . '/assets/js/main.js'), true);
        //wp_register_script( 'lyra_bootstrap_js', LYRA_ROOT_DIR_URI .'/assets/library/bootstrap/js/bootstrap.min.js' , ['jquery'] , 5.0 ,true);
        wp_enqueue_script('lyra_javascript');
        //wp_enqueue_script('lyra_bootstrap_js');

        wp_register_script('volt_template_js', LYRA_ROOT_DIR_URI . '/assets/volt-template/assets/js/volt.js', [], 1.0, false);
        wp_register_script('volt_popper_js', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/@popperjs/core/dist/umd/popper.min.js', [], 1.0, false);
        wp_register_script('volt_bootstrap_js', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/bootstrap/dist/js/bootstrap.min.js', [], 1.0, false);
        wp_register_script('volt_onscreen_js', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/onscreen/dist/on-screen.umd.min.js', [], 1.0, false);
        wp_register_script('volt_slider', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/nouislider/distribute/nouislider.min.js', [], 1.0, false);
        wp_register_script('volt_polyfill_js', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js', [], 1.0, false);
        wp_register_script('volt_datepicker_js', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/vanillajs-datepicker/dist/js/datepicker.min.js', [], 1.0, false);
        wp_register_script('volt_notfy_js', LYRA_ROOT_DIR_URI . '/assets/volt-template/vendor/notyf/notyf.min.js', [], 1.0, false);

        wp_enqueue_script('volt_template_js');
        wp_enqueue_script('volt_popper_js');
        wp_enqueue_script('volt_bootstrap_js');
        wp_enqueue_script('volt_onscreen_js');
        wp_enqueue_script('volt_slider');
        wp_enqueue_script('volt_polyfill_js');
        wp_enqueue_script('volt_datepicker_js');
        wp_enqueue_script('volt_notfy_js');
    }

}
