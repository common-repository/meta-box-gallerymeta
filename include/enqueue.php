<?php
function mbgm_metabox_enqueue($hook) {
    if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
      wp_enqueue_script('mbgm-admin-js', plugin_dir_url( __DIR__ ). 'js/gallery-metabox.js', array('jquery'),'1.0.0',true);
      wp_enqueue_style('mbgm-admin-css', plugin_dir_url( __DIR__ ). 'css/gallery-metabox.css', array(), '1.0.0', 'all');      
    }
    wp_enqueue_style('mbgm-admin-new', plugin_dir_url( __DIR__ ). 'css/admin.css', array(), '1.0.0', 'all');
  }
  add_action('admin_enqueue_scripts', 'mbgm_metabox_enqueue');
//-------------------------- Optional - If Add Shortcode use any single page with design ------------- //
function mbgm_add_css_js(){    
    //front-end unityg
    wp_enqueue_style( 'unitycss', plugin_dir_url(__FILE__) . '../css/unite-gallery.css', array(), '1.0.0', 'all' );
    wp_enqueue_script('unityjs', plugin_dir_url(__FILE__) . '../js/unitegallery.min.js' , array('jquery'),'1.0.0',true);   
    if (is_singular('mb_gallery')) {
        //single
        wp_enqueue_script('unityjs2', plugin_dir_url(__FILE__) . '../js/ug-theme-tilesgrid.js' , array('jquery'),'1.0.0',true);
    }else{
        //blog
        wp_enqueue_script('ug-theme-slider', plugin_dir_url(__FILE__) . '../js/ug-theme-slider.js' , array('jquery'),'1.0.0',true);   
    }   
    //slider-1
    wp_enqueue_style('mbgm-boots5-css', plugin_dir_url(__DIR__) . '/slider/slider-1/bootstrap.min.css', array(), '1.0.0', 'all'); 
    wp_enqueue_script('mbgm-boots5-js', plugin_dir_url(__DIR__) . '/slider/slider-1/bootstrap.min.js', array('jquery'), '1.0.0', true); 
    //slider-3
    wp_enqueue_style('mbgm-slider-3-css', plugin_dir_url(__DIR__) . '/slider/slider-3/style.css', array(), '1.0.0', 'all'); 
    wp_enqueue_script('mbgm-slider-3-js', plugin_dir_url(__DIR__) . '/slider/slider-3/script.js', array('jquery'), '1.0.0', true); 
    //slider-4
    wp_enqueue_style('mbgm-slick-4-css', plugin_dir_url(__DIR__) . '/slider/slider-4/slick.css', array(), '1.0.0', 'all');  
    wp_enqueue_style('mbgm-slider-4-css', plugin_dir_url(__DIR__) . '/slider/slider-4/style.css', array(), '1.0.0', 'all'); 
    wp_enqueue_script('mbgm-slick-4-js', plugin_dir_url(__DIR__) . '/slider/slider-4/slick.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('mbgm-slider-4-js', plugin_dir_url(__DIR__) . '/slider/slider-4/script.js', array('jquery'), '1.0.0', true); 
    //slider-5
    wp_enqueue_style('mbgm-style5-css', plugin_dir_url(__DIR__) . '/slider/slider-5/style.css', array(), '1.0.0', 'all'); 
    wp_enqueue_script('mbgm-script5-js', plugin_dir_url(__DIR__) . '/slider/slider-5/script.js', array('jquery'), '1.0.0', true);     
}add_action('wp_enqueue_scripts','mbgm_add_css_js'); 
?>