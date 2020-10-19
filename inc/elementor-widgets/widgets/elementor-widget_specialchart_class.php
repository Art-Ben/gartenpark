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
class Elementor_specialchart_Widget extends Widget_Base {

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
		return 'Elementor Special chart';
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
		return __( 'Elementor Special chart', 'gartenpark' );
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
		return 'fas fa-chart-pie';
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
            'chart_id',
            [
				'label' => __( 'Identifikator für das Diagramm', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Identifikator für das Diagramm', 'gartenpark' )
            ]
        );

        $this->add_control(
            'chart_title',
            [
				'label' => __( 'Titel', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Titel', 'gartenpark' )
            ]
        );
        
        $this->add_control(
            'chart_inside_title',
            [
				'label' => __( 'Text für Grafiken', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Text für Grafiken', 'gartenpark' )
            ]
        );

        $this->add_control(
            'chart_inside_subtitle',
            [
				'label' => __( 'Untertitel für Grafik', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Untertitel für Grafik', 'gartenpark' )
            ]
        );
        
        $this->add_control(
            'chart_background',
            [
                'label' => __( 'Hintergrundfarbe der Rückseite für Grafiken', 'gartenpark' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
			]
        );

        $this->add_control(
            'chart_line_color',
            [
                'label' => __( 'Farbe der grafischen Elemente', 'gartenpark' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
			]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'chart_data_percent',
            [
                'label' => __( 'Wert für Graph', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Wert für Graph', 'gartenpark' )
			]
        );

        $repeater->add_control(
            'chart_data_label',
            [
                'label' => __( 'Unterschrift für Wert', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Unterschrift für Wert', 'gartenpark' )
			]
        );

        $this->add_control(
            'chart_options',
            [
                'label' => __( 'Diagramm-Daten', 'gartenpark' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'prevent_empty' => true,
				'title_field' => __('Datensatz','gartenpark')
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

        $chartId = $settings['chart_id'];
        $chartTitle = $settings['chart_title'];
        $chartInsideTitle = $settings['chart_inside_title'];
        $chartInsideSubTitle = $settings['chart_inside_subtitle'];
        $chartColor = $settings['chart_line_color'];
        $chartBg = $settings['chart_background'];
        
        $dataSets = array();

        foreach( $settings['chart_options'] as $singleData ) {
            $dataSets[ $singleData['chart_data_percent'] ] = $singleData['chart_data_label'];
        }

        echo '
            <div class="mySpecialChart">
                <div class="mySpecialChart__title">'. $chartTitle .'</div>
                <div class="mySpecialChart__inner">
                    <div class="mySpecialChart__instence"  id="mySpecialChart-'. $chartId .'"></div>
                    <div class="mySpecialChart__inside">
                        <span class="tit">'. $chartInsideTitle .'</span>
                        <span class="subtit">'. $chartInsideSubTitle .'</span>
                    </div>
                </div>
            </div>

            <script>
            
            window.onload = function () {
                CanvasJS.addColorSet("myColor",
                    [
                        "'. $chartColor .'"
                    ]
                );

                var chart = new CanvasJS.Chart("mySpecialChart-'. $chartId .'", {
                    title: false,
                    subtitles: false,
                    backgroundColor: "'. $chartBg .'",
                    animationEnabled: true,
                    colorSet: "myColor",
                    legend: false,
                    data: [{
                        type: "doughnut",
                        indexLabelFontSize: 12,
                        indexLabelFontColor: "'. $chartColor .'",
                        indexLabelFontFamily: "Semplicita Pro",
                        indexLabel: "{y}% — {label}",
                        indexLabelWrap: true, 
                        startAngle: -90,
                        toolTipContent: null,
                        dataPoints: [';
                            foreach( $dataSets as $key=>$setItem ) {
                                echo '{ y:'. $key .', label: "'. $setItem .'" },';
                            }
            echo '
                        ]
                    }]
                });
                chart.render();
            }
            </script>
        ';
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new  Elementor_specialchart_Widget() );