<?php

/**
 * Plugin Name: Elementor Special slider
 * Description: Cutom posts styled for elementor
 * Plugin URI: http://artwebsolutions.site
 * Version: 1.0.0
 * Author: ArtBen777
 * Author URI: http://artwebsolutions.site
 * Text Domain: elementor-custom-breadcrumbs
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class ElementorSpecialNavRegister{

   private static $instance = null;

   public static function get_instance() {
      if ( ! self::$instance )
         self::$instance = new self;
      return self::$instance;
   }

   public function init(){
      add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_specnav_widget' ) );
   }

   public function register_specnav_widget() {

      if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){

         $widget_file = 'inc/elementor-widgets/widgets/elementor-widget_specnav_class.php';
         $template_file = locate_template($widget_file);
         if ( !$template_file || !is_readable( $template_file ) ) {
            $template_file = plugin_dir_path(__FILE__).'elementor-widget_specnav_class.php';
         }
         if ( $template_file && is_readable( $template_file ) ) {
            require_once $template_file;
         }
      }
   }
}

ElementorSpecialNavRegister::get_instance()->init();