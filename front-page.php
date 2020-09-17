<?php
/**
 * Template for displaying front page
 */
get_header();
echo '<div class="basicPage">';
while( have_posts() ) {
    the_post();
    the_content();
}
if( get_field('use_buttonlink')) {
    echo '<a href="'. get_field('buttonlink_url') .'" style="background-color:'. get_field('buttonlink_color') .'" class="buttonlinkspecial"></a>';
}
echo '</div>';
get_footer();