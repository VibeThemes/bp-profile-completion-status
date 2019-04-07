<?php
/*
Plugin Name: Vibe Custom Types
Plugin URI: http://www.vibethemes.com/
Description: This plugin creates Custom Post Types and Custom Meta boxes for WPLMS theme.
Version: 3.9.1.1
Author: Mr.Vibe
License: GPLv2
Author URI: http://www.vibethemes.com/
Text Domain: bppcs
Domain Path: /languages/
*/
if ( !defined( 'ABSPATH' ) ) exit;

class bppcs{

	var $settings;
	var $temp;

	public static $instance;
	public static function init(){

        if ( is_null( self::$instance ) )
            self::$instance = new bppcs();
        return self::$instance;
    }

	private function __construct(){
		
	}
}

bppcs::init();