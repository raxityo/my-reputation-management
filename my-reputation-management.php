<?php
/*
Plugin Name: My Reputation Management
Plugin URI: http://thetechtime.com/
Description: A reputation management Plugin
Version: 1.0
Author: Rakshit Majithiya (rakshit@thetechtime.com)
Author URI: http://thetechtime.com/
*/

define( CONTEXT_ID ,"business");
include_once'Metabox.class.php';

add_action( 'init', 'create_post_type_business' );
function create_post_type_business() {
	register_post_type( CONTEXT_ID,
		array(
			'labels' => array(
				'name' => __( 'Businesses' ),
				'singular_name' => __( 'Business' ),
				'add_new' => __( 'Add New Business' ),
				'add_new_item' => __( 'Add New Business' ),
				'edit_item' => __( 'Edit This Business' ),
				'new_item' => __( 'Add New Business' ),
				'view_item' => __( 'View This Business' ),
				'search_items' => __( 'Search Businesses' ),
				'not_found' => __( 'No Businesses found' ),
				'not_found_in_trash' => __( 'No Businesses found in trash' )
				),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 
				'slug' => 'business',
				'with_front' => FALSE
				),
			'supports' => array(
				'title',
				'thumbnail')
			)
		);
}

$businessinfo = new MetaTextBox("Enter info about this business: " , "businessinfo");
$businessinfo->init();
add_filter( 'template_include', 'insert_my_template' );

function insert_my_template( $template )
{
    if ( CONTEXT_ID === get_post_type() )
        return dirname( __FILE__ ) . '/single-business.php';

    return $template;
}
?>