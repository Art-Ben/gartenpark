<?php
namespace Elementor;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor Special table Widget.
 *
 * Elementor widget for spec table.
 *
 * @since 1.0.0
 */
class Elementor_specTable_Widget extends Widget_Base {

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
		return 'Elementor SpecialTable';
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
		return __( 'Elementor SpecialTable', 'gartenpark' );
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
		return 'fas fa-table';
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
			'select_color',
			[
                'label' => __( 'Wählen Sie ein Farbschema', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'white'  => __( 'Weiß', 'gartenpark' ),
					'black' => __( 'Schwarz', 'gartenpark' ),
				],
				'default' => 'white'
			]
		);
        

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_column_first',
            [
                'label' => __( 'Text für die erste Spalte', 'gartenpark' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Text eingeben', 'gartenpark' ),
			]
        );

        $repeater->add_control(
            'item_column_second',
            [
                'label' => __( 'Text für die zweite Spalte', 'gartenpark' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Text eingeben', 'gartenpark' ),
			]
        );

        $repeater->add_control(
            'item_column_theerd',
            [
                'label' => __( 'Text für die dritte Spalte', 'gartenpark' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Text eingeben', 'gartenpark' ),
			]
        );

        $this->add_control(
            'items_repeater',
            [
                'label' => __( 'Elemente', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => _x('neues Element','gartenpark')
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
            <div class="specialTable">
                <div class="specialTable__columns '. $settings['select_color'] .'">
        ';

        foreach (  $settings['items_repeater'] as $item ) {
            echo '
                <div class="column">
                    <div class="subColumn">
                        '. $item['item_column_first'] .'
                    </div>

                    <div class="subColumn">
                        '. $item['item_column_second'] .'
                    </div>

                    <div class="subColumn">
                        '. $item['item_column_theerd'] .'        
                    </div>
                </div>
            ';
        }

        echo '
                </div>
            </div>
        ';
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new  Elementor_specTable_Widget() );