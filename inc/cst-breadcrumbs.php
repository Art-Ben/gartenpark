<?php
/**
 * Custom breadcrumbs for anything
 */
if( !function_exists('the_breadcrumbs') ) {
    function the_breadcrumb(){

        $pageNum = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    
        $separator = ' <img src="'. get_template_directory_uri() .'/dist/images/icon-breadcrumbs-separator.svg" alt="Abscheider für Brotkrumen"> ';        
       
       
        global $post;
    
        $outputLine = '';

        if( is_front_page() ){
    
            if( $pageNum > 1 ) {
                $outputLine.= '<a href="' . site_url() . '">'._x('Srtaseite','homepage','gartenpark').'</a>' . $separator . $pageNum . '- seite';
            } else {
                $outputLine.= _x('Srtaseite','homepage','gartenpark');
            }
    
        } else {

            $outputLine.= '<a href="' . site_url() . '">'. _x('Srtaseite','homepage','gartenpark') .'</a>' . $separator;
    
    
            if( is_single() ){
    
                $outputLine.= the_category(', ').$separator.get_the_title();
    
            } elseif ( is_page() ){
    
                $outputLine.= get_the_title();
    
            } elseif ( is_category() ) {
    
                $outputLine.= single_cat_title();
    
            } elseif( is_tag() ) {
    
                $outputLine.= single_tag_title();
    
            } elseif ( is_day() ) {
    
                $outputLine.= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
                $outputLine.= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $separator;
                $outputLine.= get_the_time('d');
    
            } elseif ( is_month() ) {
    
                $outputLine.= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
                $outputLine.= get_the_time('F');
    
            } elseif ( is_year() ) {
    
                $outputLine.= get_the_time('Y');
    
            } elseif ( is_author() ) {
    
                global $author;
                $userdata = get_userdata($author);
                $outputLine.= 'Veröffentlicht ' . $userdata->display_name;
    
            } elseif ( is_404() ) {
    
                $outputLine.= _x('Fehler 404', 'breadcrumbs404', 'gartenpark');
    
            }
    
            if ( $pageNum > 1 ) {
                $outputLine.= ' (' . $pageNum . '- seite)';
            }
            
            if ( $post->post_parent ) {
    
                $parent_id  = $post->post_parent;
                $breadcrumbs = array(); 
            
                while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    $breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
                    $parent_id = $page->post_parent;
                }
            
                $outputLine.= join( $separator, array_reverse( $breadcrumbs ) ) . $separator;
            
            }

            if ( $post->post_parent ) {
    
                $parent_id  = $post->post_parent; 
                $breadcrumbs = array(); 
            
                while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    $breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
                    $parent_id = $page->post_parent;
                }
            
                $outputLine.= join( $separator, array_reverse( $breadcrumbs ) ) . $separator;
            
            }

            $current_cat = get_queried_object();
            
            if( $current_cat->parent ) {
                $outputLine.= get_category_parents( $current_cat->parent, true, $separator ) . $separator;
            }

            $post_categories = get_the_category();
    
            
            if( !empty( $post_categories[0]->cat_ID ) ) {
                $outputLine.= get_category_parents( $post_categories[0]->cat_ID, true, $separator ) . $separator;
            }
            $outputLine.= get_the_title();

            if( is_tax( $taxonomy_name ) ) {
                $outputLine.= single_term_title('', 0);
            }

            if( is_tax( $taxonomy_name ) ) {
                $current_term = get_queried_object();
                
                if( $current_term->parent ) {
                    $outputLine.= get_term_parents_list( $current_term->parent, $taxonomy_name, array( 'separator' => $separator ) ) . $separator;
                }
                $outputLine.= single_term_title('', 0);
            }

            if( is_singular( $post_type_name ) ) {
                $outputLine.= get_the_title();
            }

            if( is_singular( $post_type_name ) ) {
                $post_terms = get_the_terms( get_the_ID(), $taxonomy_name );
            
                if( !empty( $post_terms[0]->term_id ) ) {
                    $outputLine.= get_term_parents_list( $post_terms->term_id, $taxonomy_name, array( 'separator' => $separator ) ) . $separator;
                }
                $outputLine.= get_the_title();
            }
        }
    
        echo $outputLine;
    }
}