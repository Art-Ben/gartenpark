<?php
/**
 * Acf option additional page
 */
if( function_exists('acf_add_options_page') ) {
	$option_page = acf_add_options_page(array(
		'page_title' 	=> 'Erweiterte Website-Einstellungen',
		'menu_title' 	=> 'Erweiterte Einstellungen',
		'menu_slug' 	=> 'options',
		'capability' 	=> 'edit_posts',
		'redirect' 	=> false,
        'post_id' => 'options',
        'update_button'		=> __('Обновить настрйоки', 'acf'),
        'updated_message'		=> __('Настройки обновлены', 'acf')
	));
}