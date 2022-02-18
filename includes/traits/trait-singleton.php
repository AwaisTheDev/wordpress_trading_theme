<?php

namespace LYRA_THEME\Includes\traits;

trait singleton{

    public function __construct(){

    }

    public function __clone(){

    }

    final public static function get_Instance(){
        
        static $instance = [];

        $called_class = get_called_class();

        if(!isset($instance[$called_class])){
            $instance[$called_class]= new $called_class();

            do_action( 'lyra_theme_singleton_trait_init%s', $called_class );
        }
        return $instance[$called_class];
    }
}