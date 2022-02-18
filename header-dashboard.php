<?php

/**
 * @package lyra
 */
?>

<!DOCTYPE html>
<html lang="<?php language_attributes(); ?> ">

<!-- header Code for theme -->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php wp_head(); ?>
</head>


<!-- Body Start Here  -->
<body <?php body_class( )  ?>>

<?php 
    if(function_exists('wp_body_open')){
        wp_body_open( );
    }
 ?>

