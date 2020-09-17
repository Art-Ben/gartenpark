<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package gartenpark
 */

get_header();
	echo '<div class="basicPage">';
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile;

	if( get_field('use_buttonlink')) {
		echo '<a href="'. get_field('buttonlink_url') .'" style="background-color:'. get_field('buttonlink_color') .'" class="buttonlinkspecial"></a>';
	}

	echo '</div>';
get_footer();
