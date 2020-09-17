<?php
namespace Elementor;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor downloadEleme Widget.
 *
 * Elementor widget that create page breadcrumbs.
 *
 * @since 1.0.0
 */
class Elementor_downloadElem_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve downloadElem widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Elementor Downoalds elements';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve downloadElem widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Elementor Download groups elements', 'gartenpark' );
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
		return 'fas fa-download';
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
	 * Register downloadElem widget controls.
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

		$this->end_controls_section();

	}

	/**
	 * Render downloadElem widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();
        function filesize_formatted($size)
        {
            $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;
            return number_format($size / pow(1024, $power), 1, '.', ',') . ' ' . $units[$power];
        }

        if( $_GET ) {
            $orderPrimary = strtolower($_GET['primary'] ?? '');
        }

        if( have_rows('downloads_fields') ) {
            echo '<div class="customDownloadGroup__cont">';
            $counter = 0;
            while( have_rows('downloads_fields') ) {
                the_row();
                $group_title = get_sub_field('group_title');
                $group_color = get_sub_field('group_color');

                $group_id  = strtolower(get_sub_field('group_name'));
                $group_order = '';
                $counter++;

                if( $group_id == $orderPrimary ) {
                    $group_order = 'primary';
                } else {
                    $group_order = 'secondary';
                }
                echo '
                        <style>
                            #colorGroup'. $counter .' .customDownloadGroup__line {
                                background: '. $group_color .';
                            }

                            #colorGroup'. $counter .' .customDownloadGroup__inner .customDownloadGroup__title:after{
                                background-color: '. $group_color .';
                            }
                        </style>
                        <div class="customDownloadGroup '. $group_order .'" id="colorGroup'. $counter .'">
                            <div class="customDownloadGroup__line"></div>
                            <div class="customDownloadGroup__inner">
                                <div class="customDownloadGroup__title">'. $group_title .'</div>
                ';
				
				${"zip_".$group_id} = new \ZipArchive;
				if ( ${"zip_".$group_id}->open( get_template_directory().'/zip_'. $group_title .'.zip', \ZipArchive::CREATE|\ZipArchive::OVERWRITE) === TRUE ) {
					while( have_rows('group_files') ) {
						the_row();
						$file = get_sub_field('file');
						$file_name = $file['filename'];
						${"zip_".$group_id}->addFile(\get_attached_file($file['id']), $file_name);
					}
					${"zip_".$group_id}->close();
				}

                if( have_rows('group_files') ) {
                    while( have_rows('group_files') ) {
						the_row();

						$file = get_sub_field('file');
                		$file_name = get_sub_field('use_file_name') ? get_sub_field('file_name') : $file['title'];
						echo '
                            <div class="customDownloadGroup__item">
                                <span class="file-date">'. date('d.m.y', strtotime($file['date'])) .'</span>
                                <div class="info">
                                    <div class="info_left">
                                        <span class="file-name">'. $file_name .'</span>
                                    </div>
                                    <div class="info_right">
                                        <span class="file-size">'. filesize_formatted( intval($file['filesize']) ) .'</span>
										<a href="'. $file['url'] .'" class="file-view"></a>
										<a href="'. $file['url'] .'" class="file-download" download="'. $file['title'] .'"></a>
                                        <div class="file-share">
                                            <span class="file-share__toggler"></span>
                                            <div class="file-share__dropdown">
                                                
                                            </div>
                                        </div>
									</div>
                                </div>
                            </div>
						';
                    }
                }

				
				echo '
					<div class="donwloadLine">
						<a href="'. get_template_directory_uri().'/zip_'. $group_title .'.zip' .'" download="'. $group_title .'" class="linkUpload">
				';
					switch( constant("ICL_LANGUAGE_CODE") )	{
						case 'de': 
							echo 'Alles herunterladen';
						break;

						case 'uk':
							echo 'Download all files';
						break;
					}
				echo '</a>
					</div>
				';

                echo '
                            </div>
                        </div>
                ';
            }
            echo '</div>';
        }
        

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Elementor_downloadElem_Widget() );