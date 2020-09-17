<?php
namespace Elementor;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor Special slider Widget.
 *
 * Elementor widget that create page breadcrumbs.
 *
 * @since 1.0.0
 */
class Elementor_specNav_Widget extends Widget_Base {

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
		return 'Elementor SpecialNavigation';
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
		return __( 'Elementor SpecialNavigation', 'gartenpark' );
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
		return 'fas fa-route';
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
            'items_title',
            [
				'label' => __( 'Text für Navigationselement', 'gartenpark' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Text eingeben', 'plugin-name' )
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_color',
            [
                'label' => __( 'Wählen Sie eine Farbe für den Artikel', 'gartenpark' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#153252',
			]
        );

        $repeater->add_control(
            'item_name',
            [
				'label' => __( 'Name des Elements', 'gartenpark' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Geben Sie den Namen des Elements ein.', 'plugin-name' )
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => __( 'Referenz für Element', 'gartenpark' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Geben Sie den Link ein', 'plugin-name' )
            ]
        );

        $repeater->add_control(
            'item_is_disabled',
            [
                'label' => __( 'Element aktiv ?', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Ja', 'gartenpark' ),
				'label_off' => __( 'Nein', 'gartenpark' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );

        $this->add_control(
            'items_repeater',
            [
                'label' => __( 'Elemente', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => _x('Folie','slide title','gartenpark')
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
        
        echo '
            <div class="specialNavigation">
                <div class="specialNavigation__title">
                    '. $settings['items_title'] .':
                </div>
                <div class="specialNavigation__items">
        ';

        foreach (  $settings['items_repeater'] as $item ) {

            if( $item['item_is_disabled'] !=='yes' ) {
                $disabled_class = 'disabled';
            }
            echo '
                <a href="'. $item['item_link'] .'" class="specialNavigation__link '. $disabled_class .'">
                    <div class="color_square" style="background-color:'. $item['item_color'] .'"></div>
                    <span class="item-name">'. $item['item_name'] .'</span>
                </a>
            ';
        }

        echo '
                </div>
            </div>
        ';
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new  Elementor_specNav_Widget() );