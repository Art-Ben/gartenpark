<?php
namespace Elementor;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor myPosts Widget.
 *
 * Elementor widget that create page breadcrumbs.
 *
 * @since 1.0.0
 */
class Elementor_myPosts_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve myPosts widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Elementor myPosts';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve myPosts widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Elementor myPosts', 'gartenpark' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve myPosts widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'far fa-newspaper';
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
	 * Register myPosts widget controls.
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
			'posts_per_page',
			[
				'label' => __( 'Wie viele Aktuelles gibt es zu zeigen', 'gartenpark' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label_block' => true,
                'placeholder' => __('Our value','gartenpark'),
                'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 2
			]
        );
        
        $this->add_control(
			'orderby',
			[
				'label' => __( 'Welche Art der Sortierung der Nachrichten', 'gartenpark' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
				'options' => [
                    'none' => 'ID',
                    'date' => 'Datu', 
					'author' => 'Autor',
                    'title' => 'Titel',
                    'name' => 'Name',
                    'rand' => 'Zufällig',
                    
				],
				'default' => 'none',
			]
        );
        
        $this->add_control(
			'order',
			[
				'label' => __( 'Welche Art der Sortierung der Nachrichten', 'gartenpark' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
				'options' => [
					'ASC'  => 'ASC',
					'DESC' => 'DESC'  
				],
				'default' => 'ASC'
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render myPosts widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();

        $basic_posts_args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['posts_per_page'],
            'ignore_sticky_posts' => true,
            'post_status' => 'publish',
            'orderby' => $settings['orderby'],
            'order' => $settings['order']
        );

        $basic_posts_query = new \WP_Query($basic_posts_args);
        echo '<div class="myPostsBlock">';
        if( $basic_posts_query->have_posts() ) {
            while( $basic_posts_query->have_posts() ) {
                $basic_posts_query->the_post();
                get_template_part('template-parts/content', 'myLoopPost');
            }
            wp_reset_postdata();
        } else {
            echo '<span class="noPostsFound">'._x('Keine Beiträge gefunden','no-posts','gartenpark').'</span>';
        }
        echo '</div>';
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new  Elementor_myPosts_Widget() );