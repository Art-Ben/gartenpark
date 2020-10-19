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
class Elementor_inlinelinks_Widget extends Widget_Base {

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
		return 'Elementor Inline links';
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
		return __( 'Elementor Inline links', 'gartenpark' );
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
		return 'fas fa-link';
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
            'sect_tit',
            [
				'label' => __( 'Titel für Section', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Titel für Section', 'gartenpark' )
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'lnk_title',
			[
                'label' => __( 'Titel zum Nachschlagen', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Titel zum Nachschlagen', 'gartenpark' ),
			]
        );

        $repeater->add_control(
            'lnk_color',
            [
                'label' => __( 'Silbenfarbe', 'gartenpark' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
			]
        );
        
        $repeater->add_control(
			'lnk_active',
			[
				'label' => __( 'Element is active ?', 'gartenpark' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Ja', 'your-plugin' ),
				'label_off' => __( 'Nein', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $repeater->add_control(
			'lnk_url',
			[
                'label' => __( 'Url-Links', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Url-Links', 'gartenpark' ),
			]
        );

        $this->add_control(
            'lnk_repeater',
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
        <div class="basicInlineLinks">
            <div class="basicInlineLinks__title">
                '. $settings['sect_tit'] .'
            </div>
            <div class="basicInlineLinks__items">
                <div class="basicInlineLinks__inner">
        ';
                foreach( $settings['lnk_repeater'] as $item ) {
					if( 'yes' === $item['lnk_active'] ) {
						$activeClass = 'active';
					} else {
						$activeClass = '';
					}
                    echo '<a href="'. $item['lnk_url'] . '" class="link '. $activeClass .'"><span class="square" style="background-color:'. $item['lnk_color'] .'"></span>'. $item['lnk_title'] .'</a>';
                };
        echo '  
                </div>
            </div>
        </div>';
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new  Elementor_inlinelinks_Widget() );