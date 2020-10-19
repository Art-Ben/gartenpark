<?php
namespace Elementor;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor BreadCrumbs Widget.
 *
 * Elementor widget that create page breadcrumbs.
 *
 * @since 1.0.0
 */
class Elementor_Breadcrumbs_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Breadcrumbs widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Elementor Breadcrumbs';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Breadcrumbs widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Elementor Breadcrumbs', 'gartenpark' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Breadcrumbs widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fas fa-directions';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Bredcrumbs widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Register Breadcrumbs widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'gartenpark' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'separator',
			[
				'label' => _x( 'Trennbild wählen', 'choose separtor', 'gartenpark' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render Breadcrumbs widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

        global $post;

        $homepageText = '';

        if( ICL_LANGUAGE_CODE == 'en' ) {
            $homepageText = 'Homepage';
        } elseif( ICL_LANGUAGE_CODE == 'de' ) {
            $homepageText = 'Startseite';
        }

		$settings = $this->get_settings_for_display();

		$pageNum = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    
        $separator = ' <div class="separatorCont"><span class="separator-image" ></span></div> ';        
    
        $outputLine = '
            <div class="myBreadCrumbsList">
                <ul class="myBreadCrumbsList__items" itemscope itemtype="http://schema.org/BreadcrumbList">
        ';

        if( is_front_page() ){
            $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item">';

            if( $pageNum > 1 ) {
                $outputLine.= '
                <a itemprop="item" href="' . site_url() . '">
                    <span itemprop="name" class="homePageElem">'.$homepageText.'</span>
                </a>' . $separator . $pageNum . '- seite
                <meta itemprop="position" content="'. $pageNum .'" />';
            } else {
                $outputLine.= '
                    <span itemprop="name" class="homePageElem">'.$homepageText. '</span>
                    <meta itemprop="position" content="1" />
                ';
            }

            $outputLine.= '</li>';
    
        } else {

            $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item">';

                $outputLine.= '
                <a href="' . site_url() . '">
                    <span itemprop="name" class="homePageElem">'. $homepageText .'</span>
                </a>' . $separator;
    
            $outputLine.= '</li>';

            if( is_single() ){
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item">';

                $outputLine.= the_category(', ').$separator.get_the_title();

                $outputLine.= '</li>';
    
            } elseif ( is_page() ){
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item page-crumb">';
    
                $outputLine.= '<span itemprop="name">'.get_the_title().'</span>';

                $outputLine.= '</li>';
    
            } elseif ( is_category() ) {
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item cat-crumb">';
    
                $outputLine.= '<span itemprop="name">'.single_cat_title('', 0).'</span>';

                $outputLine.= '</li>';
    
            } elseif( is_tag() ) {
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item tag-crumb">';

                $outputLine.= '<span itemprop="name">'.single_tag_title('', 0).'</span>';

                $outputLine.= '</li>';
    
            } elseif ( is_day() ) {
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item day-crumb">';
    
                $outputLine.= '<a itemprop="item" href="' . get_year_link(get_the_time('Y')) . '"><span itemprop="name">' . get_the_time('Y') . '</span></a>' . $separator;
                $outputLine.= '<a itemprop="item" href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '"><span itemprop="name">' . get_the_time('F') . '</span></a>' . $separator;
                $outputLine.= get_the_time('d');

                $outputLine.= '</li>';
    
            } elseif ( is_month() ) {
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item month-crumb">';
    
                $outputLine.= '<a itemprop="item" href="' . get_year_link(get_the_time('Y')) . '"><span itemprop="name">' . get_the_time('Y') . '</span></a>' . $separator;
                $outputLine.= get_the_time('F');

                $outputLine.= '</li>';
    
            } elseif ( is_year() ) {
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item year-crumb">';
    
                $outputLine.= '<span itemprop="name">'. get_the_time('Y'). '</span>';

                $outputLine.= '</li>';
    
            } elseif ( is_author() ) {
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item author-crumb">';
                
                global $author;
                $userdata = get_userdata($author);
                $outputLine.= '<span itemprop="name">Veröffentlicht ' . $userdata->display_name. '</span>';
    
                $outputLine.= '</li>';

            } elseif ( is_404() ) {
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item 404-crumb">';
    
                $outputLine.= '<span itemprop="name">'._x('Fehler 404', 'breadcrumbs404', 'gartenpark').'</span>';
    
                $outputLine.= '</li>';
            } elseif ( $pageNum > 1 ) {
                $outputLine.= '<li itemprop="itemListElement" itemscope
            itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item page-pagination-crumb">';

                $outputLine.= ' (' . $pageNum . '- seite)';

                $outputLine.= '</li>';
            } elseif ( $post->post_parent ) {
    
                $parent_id  = $post->post_parent;
                $breadcrumbs = array(); 
            
                while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    $breadcrumbs[] = '<li itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem" class="myBreadCrumbsList__items--item parent-page-crumb"><a itemprop="item" href="' . get_permalink( $page->ID ) . '"><span itemprop="name">' . get_the_title( $page->ID ) . '</span></a>';
                    $parent_id = $page->post_parent;
                }
            
                $outputLine.= join( $separator, array_reverse( $breadcrumbs ) ) . $separator;
            
            }
        }
    
        echo $outputLine;
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new  Elementor_Breadcrumbs_Widget() );