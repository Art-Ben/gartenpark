<?php
function gartenpark_scripts() {
	wp_enqueue_style( 'gartenpark-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'gartenpark-style', 'rtl', 'replace' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// styles 
	wp_enqueue_style('main-css', get_template_directory_uri().'/dist/style.min.css', array(), null, '');

	// scripts
	wp_register_script('main-js', get_template_directory_uri().'/dist/main.min.js', array(), null, true);
	
	wp_localize_script( 'main-js', 'ajax_object', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
	) ); 

	wp_enqueue_script('main-js');
}
add_action( 'wp_enqueue_scripts', 'gartenpark_scripts' );