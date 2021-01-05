<?php

// Enqueue css files
function lyra_enqueue_css(){
    wp_register_style( 'lyra_stylesheet', get_template_directory_uri().'/assets/css/style.css' , [] , filemtime(get_template_directory().'/assets/css/style.css') ,'all' );
    wp_register_style( 'lyra_bootstrap_css', get_template_directory_uri().'/assets/library/bootstrap/css/bootstrap.min.css' , [] , 5.0 ,'all' );


    wp_enqueue_style( 'lyra_stylesheet');
    wp_enqueue_style( 'lyra_bootstrap_css');
}

add_action( 'wp_enqueue_scripts', 'lyra_enqueue_css' );


// Enqueue Javascript Files
function lyra_enqueue_javascript(){
    wp_register_script( 'lyra_javascript', get_template_directory_uri().'/assets/js/main.js' , [] , filemtime(get_template_directory().'/assets/js/main.js') ,true);
    wp_register_script( 'lyra_bootstrap_js', get_template_directory_uri().'/assets/library/bootstrap/js/bootstrap.min.js' , ['jquery'] , 5.0 ,true);
    
    wp_enqueue_script('lyra_javascript');
    wp_enqueue_script('lyra_bootstrap_js');
}

add_action( 'wp_enqueue_scripts', 'lyra_enqueue_javascript' );
