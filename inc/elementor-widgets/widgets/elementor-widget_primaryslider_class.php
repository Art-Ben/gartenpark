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
class Elementor_primarySlider_Widget extends Widget_Base {

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
		return 'Elementor SpecialSlider';
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
		return __( 'Elementor SpecialSlider', 'gartenpark' );
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
		return 'fas fa-photo-video';
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
        
        $repeater = new \Elementor\Repeater();

        $this->add_control(
			'page_logo',
			[
				'label' => _x( 'Logo für Seite', 'choose page logo', 'gartenpark' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
        );

        $repeater->add_control(
            'slide_is_video',
            [
                'label' => __( 'Ein Bild oder Video verwenden ?', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Bild', 'gartenpark' ),
				'label_off' => __( 'Video', 'gartenpark' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $repeater->add_control(
            'slide_poster',
            [
				'label' => _x( 'Video poster', 'gartenpark' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'slide_is_video',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                    ],
                ]
            ]
        );

        $repeater->add_control(
            'slide_video_upload',
            [
                'label' => _x( 'Feld für Dateidownload', 'video file', 'gartenpark' ),
				'label_block' => true,
				'type' => 'file-select',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'slide_is_video',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                    ],
                ]
            ]
        );

        $repeater->add_control(
            'slide_banner',
            [
                'label' => _x( 'Bild', 'page banner', 'gartenpark' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'slide_is_video',
                            'operator' => '!==',
                            'value' => 'yes'
                        ],
                    ],
                ]
            ]
        );

        $this->add_control(
            'page_slider',
            [
                'label' => __( 'Folien', 'plugin-domain' ),
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
        $home_url = is_front_page() ? 'javascript:void(0);' : get_home_url();
        $video_config_arr = array(
            'alwaysShowControls' => false,
            'features' => []
        );
        $video_config = json_encode($video_config_arr);

        if( have_rows('social_links', 'options') ) {
            $social_links_str = '';
            while( have_rows('social_links', 'options') ) {
                the_row();
                $social_links_str.= '<a target="_blank" href="'. get_sub_field('social_link') .'" class="social-link"><img src="'. get_sub_field('social_icon') .'"></a>';
            }
        }
        echo '
        <section class="page__intro">
            <div class="page__intro--logo">';
            if( !is_front_page() ) {
                echo '
                <a href="'. $home_url .'" class="page__intro--logo_link">
                    <img src="'. $settings['page_logo']['url'] .'" alt="Gartenpark Korneuburg">
                </a>';
            } else {
                echo '
                <span class="page__intro--logo_link">
                    <img src="'. $settings['page_logo']['url'] .'" alt="Gartenpark Korneuburg">
                </span>';
            }
        echo '
            </div>
            
            <div class="page__intro--aside">
                <div class="line"></div>
                <div class="page__intro-socials">
                    '. $social_links_str .'
                </div>
            </div>
            <div class="page__intro--centr">
        ';
        if( count($settings['page_slider']) > 1 ) {
            echo'
                <div class="page__intro--slider">
                ';

                foreach( $settings['page_slider'] as $slide ) {
                    echo '
                        <div class="page__intro--slider_slide">
                    ';
                        if( $slide['slide_is_video'] === 'yes' ) {
                            echo '
                                <video height="100%" width="100%" class="page__intro_poster my-player mejs__player" poster="'. $slide['slide_poster']['url'] .'" data-mejsoptions='. $video_config .'>
                                    <source src="'. $slide['slide_video_upload'] .'" type="video/mp4">
                                </video>
                            ';
                        } else {
                            echo '
                                <div class="page__intro_banner" style="background-image:url('. $slide['slide_banner']['url'] .')"></div>
                            ';
                        }
                    echo '
                        </div>
                    ';
                }
            echo '</div>';
        } else {
            echo '
                <div class="page__intro--item">
            ';
            foreach( $settings['page_slider'] as $slide ) {
                if( $slide['slide_is_video'] === 'yes' ) {
                    echo '
                        <video height="100%" width="100%" class="page__intro_poster my-player mejs__player" poster="'. $slide['slide_poster']['url'] .'" data-mejsoptions='. $video_config .'>
                            <source src="'. $slide['slide_video_upload'] .'" type="video/mp4">
                        </video>
                    ';
                } else {
                    echo '<div class="page__intro_banner" style="background-image:url('. $slide['slide_banner']['url'] .')"></div>';
                }
            }
                            
            echo '
                </div>
            ';
        }
        echo '</div>';
            if( count($settings['page_slider']) > 1 ) {
                echo '
                    <div class="page__intro--slider_nav">
                        <button class="arrow prev"></button>
                        <button class="arrow next"></button>
                    </div>
                ';
            }
        echo '
            </section>
        ';
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new  Elementor_primarySlider_Widget() );