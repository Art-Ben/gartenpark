<?php
/**
 * Function for init cpt for application
 */

add_action( 'init', 'register_application_post_type' );
function register_application_post_type(){
	register_post_type( 'application', [
		'label'  => 'Vaccin',
		'labels' => [
			'name'               => 'Bewerbung über Kontaktformular', 
			'singular_name'      => 'Bewerbung über Kontaktformular', 
			'add_new'            => 'Neue Anwendung hinzufügen',
			'add_new_item'       => 'Neue Anwendung hinzufügen',
			'edit_item'          => 'Bewerbung bearbeiten',
			'new_item'           => 'Neue Anwendung',
			'view_item'          => 'Anwendung ansehen',
			'search_items'       => 'Suche Anwendung',
			'not_found'          => 'Anwendung nicht gefunden',
			'not_found_in_trash' => 'Anwendung nicht im Papierkorb gefunden',
			'parent_item_colon'  => '',
			'menu_name'          => 'Bewerbungen',
		],
		'description'         => '',
		'public'              => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'menu_position'       => 4,
		'menu_icon'           => get_template_directory_uri().'/dist/images/icon-mail-white.svg',
        'capability_type'     => 'post',
        'capabilities'        => array(
          'create_posts' => 'do_not_allow'
        ),
        'map_meta_cap'        => true,
		'hierarchical'        => false,
		'supports'            => ['title'],
		'has_archive'         => false,
		'rewrite'             => false,
		'query_var'           => false
	] );
}