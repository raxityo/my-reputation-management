<?php
function register_client_post_type() {

   /**
    * Register a custom post type
    *
    * @see register_post_type for full list of options for register_post_type
    * @see add_post_type_support for full descriptions of 'supports' options
    * @see get_post_type_capabilities for full list of available fine grained capabilities that are supported
    */
    register_post_type( 'rm_client',
		array(
			'labels' => array(
				'name' => __( 'Clients' ),
				'singular_name' => __( 'Client' )
			),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'products'
		)
	));
}
add_action( 'init', 'register_client_post_type' );
?>