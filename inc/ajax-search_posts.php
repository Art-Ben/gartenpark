<?php
if( !function_exists('ajax_search_posts') ) {
    add_action( 'wp_ajax_customseacrh', 'ajax_search_posts' );
	add_action( 'wp_ajax_nopriv_customseacrh', 'ajax_search_posts' );

    function ajax_search_posts() {
        $response = array();
        $output = '';

        if( $_POST ) {
            $argsSeacrh = array(
                's' => $_POST['query'],
                'posts_per_page' => -1,
                'post_type' => 'post'
            );

            $querySearch = new WP_Query( $argsSeacrh );

            if( $querySearch->have_posts() ) {
                ob_start();
                while( $querySearch->have_posts() ) {
                    $querySearch->the_post();
                    get_template_part('template-parts/content', 'myLoopPost');
                    $output.= ob_get_contents();
                }
                ob_clean();


                $response['response'] = 'SUCCESS';
                $response['output'] = $output;
            } else {
                $response['response'] = 'ERROR';
                $response['error'] = 'Empty loop, or another problem with loop in inc/ajax-search_posts.php';
            }

            echo json_encode($response);
            exit();
        }
    }
}