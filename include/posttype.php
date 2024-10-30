<?php
add_action( 'init', 'mbgmnew_gallery_post' );
function mbgmnew_gallery_post() {
	$labels = array(
		'name'               => _x( 'MB Gallery', 'post type general name', 'mbgm' ),
		'singular_name'      => _x( 'MB Gallery', 'post type singular name', 'mbgm' ),
		'menu_name'          => _x( 'MB Gallery', 'admin menu', 'mbgm' ),
		'name_admin_bar'     => _x( 'MB Gallery', 'add new on admin bar', 'mbgm' ),
		'add_new'            => _x( 'Add New', 'MB Gallery', 'mbgm' ),
		'add_new_item'       => __( 'Add New MBG', 'mbgm' ),
		'new_item'           => __( 'New MBG', 'mbgm' ),
		'edit_item'          => __( 'Edit MBG', 'mbgm' ),
		'view_item'          => __( 'View MBG', 'mbgm' ),
		'all_items'          => __( 'Gallery', 'mbgm' ),
		'search_items'       => __( 'Search MBG', 'mbgm' ),
		'parent_item_colon'  => __( 'Parent MBG:', 'mbgm' ),
		'not_found'          => __( 'No MBG found.', 'mbgm' ),
		'not_found_in_trash' => __( 'No MBG found in Trash.', 'mbgm' )
	);
	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'mbgm' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => false,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'mb_gallery' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'           => 'dashicons-schedule',
		'supports'           => array( 'title', 'editor', 'thumbnail', )
	);
	register_post_type( 'mb_gallery', $args );
}
//mbg slider
add_action( 'init', 'mbgmnew_Slider_post' );
function mbgmnew_Slider_post() {
	$labels = array(
		'name'               => _x( 'Sliders', 'post type general name', 'mbgm' ),
		'singular_name'      => _x( 'Slider', 'post type singular name', 'mbgm' ),
		'menu_name'          => _x( 'Slider', 'admin menu', 'mbgm' ),
		'name_admin_bar'     => _x( 'Slider', 'add new on admin bar', 'mbgm' ),
		'add_new'            => _x( 'Add New', 'Slider', 'mbgm' ),
		'add_new_item'       => __( 'Add New Slider', 'mbgm' ),
		'new_item'           => __( 'New Slider', 'mbgm' ),
		'edit_item'          => __( 'Edit Slider', 'mbgm' ),
		'view_item'          => __( 'View Slider', 'mbgm' ),
		'all_items'          => __( 'All Sliders', 'mbgm' ),
		'search_items'       => __( 'Search Slider', 'mbgm' ),
		'parent_item_colon'  => __( 'Parent Slider:', 'mbgm' ),
		'not_found'          => __( 'No Slider found.', 'mbgm' ),
		'not_found_in_trash' => __( 'No Slider found in Trash.', 'mbgm' )
	);
	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'mbgm' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => false,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'mb_slider' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'           => 'dashicons-schedule',
		'supports'           => array( 'title', 'editor', 'thumbnail', )
	);
	register_post_type( 'mb_slider', $args );
}
?>