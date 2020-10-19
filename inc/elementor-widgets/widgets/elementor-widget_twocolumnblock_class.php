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
class Elementor_twocolumnblock_Widget extends Widget_Base {

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
		return 'Elementor TwoColumnBlock';
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
		return __( 'Elementor TwoColumnBlock', 'gartenpark' );
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
		return 'fas fa-columns';
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
            'items_left_column_text_title',
            [
				'label' => __( 'Titel für linke Spalte', 'gartenpark' ),
                'label_block' => true,
                'rows' => 8,
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Titel für linke Spalte', 'gartenpark' )
            ]
        );
        
        $this->add_control(
            'items_left_column_text',
            [
				'label' => __( 'Text für Navigationselement', 'gartenpark' ),
                'label_block' => true,
                'rows' => 8,
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Text für linke Spalte', 'gartenpark' )
            ]
        );

        $this->add_control(
            'items_right_column_text_title',
            [
				'label' => __( 'Titel für rechte Spalte', 'gartenpark' ),
                'label_block' => true,
                'rows' => 8,
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Text für rechte Spalte', 'gartenpark' )
            ]
        );

        $this->add_control(
            'items_right_column_text',
            [
				'label' => __( 'Text für Navigationselement', 'gartenpark' ),
                'label_block' => true,
                'rows' => 8,
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Text für rechte Spalte', 'gartenpark' )
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_image',
            [
                'label' => 'Bild für Schieberegler',
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
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
        <div class="basicTextTwoColumns">
			<div class="basicTextTwoColumns__top with-image">
				<div class="basicTextTwoColumns__top--inner">
					<div class="basicTextTwoColumns__column">
						<div class="tit">
							'. $settings['items_left_column_text_title'] . '
						</div>
						<div class="desc">
							'. $settings['items_left_column_text'] . '
						</div>
					</div>
					<div class="basicTextTwoColumns__column">
						<div class="tit">
							'. $settings['items_right_column_text_title'] . '
						</div>
						<div class="desc">
							'. $settings['items_right_column_text'] . '
						</div>
					</div>
				</div>
            </div>
            <div class="basicTextTwoColumns__bottom use-slider-for-twoColumnBLock">
    ';
                foreach( $settings['items_repeater'] as $image ) {
                    echo '<img src="'. $image['item_image']['url'] . '" alt="'. $image['item_image']['alt'] . '" class="thumb">';
                };
    echo '      
            </div>
        </div>';
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new  Elementor_twocolumnblock_Widget() );