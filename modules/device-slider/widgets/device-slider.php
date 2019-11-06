<?php
namespace WidgetPack\Modules\DeviceSlider\Widgets;

use widget_pack_helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Device_Slider extends Widget_Base {


	public function get_name() {
		return 'avt-device-slider';
	}

	public function get_title() {
		return AWP . esc_html__( 'Device Slider', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-device-slider';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'device', 'slider', 'desktop', 'laptop', 'mobile' ];
	}

	public function get_style_depends() {
		return [ 'wipa-device-slider' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/GACXtqun5Og';
	}

	protected function _register_controls() {
		$this->register_query_section_controls();
	}

	private function register_query_section_controls() {

		$this->start_controls_section(
			'section_content_sliders',
			[
				'label' => esc_html__( 'Sliders', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'device_type',
			[
				'label'   => esc_html__( 'Select Device', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desktop',
				'options' => [
					'desktop'    => esc_html__('Desktop', 'avator-widget-pack') ,
					'safari'     => esc_html__('Safari', 'avator-widget-pack') ,
					'chrome'     => esc_html__('Chrome', 'avator-widget-pack') ,
					'chrome-dark'     => esc_html__('Chrome Dark', 'avator-widget-pack') ,
					'firefox'     => esc_html__('Firefox', 'avator-widget-pack') ,
					'edge'     	=> esc_html__('Edge', 'avator-widget-pack') ,
					'edge-dark'     	=> esc_html__('Edge Dark', 'avator-widget-pack') ,
					'macbookpro' => esc_html__('Macbook Pro', 'avator-widget-pack') ,
					'macbookair' => esc_html__('Macbook Air', 'avator-widget-pack') ,
					'tablet'     => esc_html__('Tablet', 'avator-widget-pack') ,
					'mobile'     	=> esc_html__('Mobile', 'avator-widget-pack') ,
					'mobile-dark'     	=> esc_html__('Mobile Dark', 'avator-widget-pack') ,
					'galaxy'     => esc_html__('Galaxy S9', 'avator-widget-pack') ,
					'iphonex'    => esc_html__('IPhone X', 'avator-widget-pack') ,
				],
			]
		);


		$this->add_control(
			'slides',
			[
				'label' => esc_html__( 'Slider Items', 'avator-widget-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'title' => esc_html__( 'Slide Item 1', 'avator-widget-pack' ),
					],
					[
						'title' => esc_html__( 'Slide Item 2', 'avator-widget-pack' ),
					],
					[
						'title' => esc_html__( 'Slide Item 3', 'avator-widget-pack' ),
					],
					[
						'title' => esc_html__( 'Slide Item 4', 'avator-widget-pack' ),
					],
				],
				'fields' => [
					
					[
						'name'        => 'title',
						'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => esc_html__( 'Slide Title' , 'avator-widget-pack' ),
						'label_block' => true,
						'dynamic'     => [ 'active' => true ],
					],
					
					[
						'name'          => 'title_link',
						'label'         => esc_html__( 'Title Link', 'avator-widget-pack' ),
						'type'          => Controls_Manager::URL,
						'default'       => ['url' => ''],
						'show_external' => false,
						'dynamic'       => [ 'active' => true ],
						'condition'     => [
							'title!' => ''
						]
					],
					[
						'name'    => 'background',
						'label'   => esc_html__( 'Background', 'avator-widget-pack' ),
						'type'    => Controls_Manager::CHOOSE,
						'default' => 'color',
						'options' => [
							'color' => [
								'title' => esc_html__( 'Color', 'avator-widget-pack' ),
								'icon'  => 'fas fa-paint-brush',
							],
							'image' => [
								'title' => esc_html__( 'Image', 'avator-widget-pack' ),
								'icon'  => 'fas fa-image',
							],
							'video' => [
								'title' => esc_html__( 'Video', 'avator-widget-pack' ),
								'icon'  => 'fas fa-play-circle',
							],
							'youtube' => [
								'title' => esc_html__( 'Youtube', 'avator-widget-pack' ),
								'icon'  => 'fab fa-youtube',
							],
						],
					],
					[
						'name'      => 'color',
						'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#14ABF4',
						'condition' => [
							'background' => 'color'
						],
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
						],
					],
					[
						'name'      => 'image',
						'label'     => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'      => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'condition' => [
							'background' => 'image'
						],
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'      => 'video_link',
						'label'     => esc_html__( 'Video Link', 'avator-widget-pack' ),
						'type'      => Controls_Manager::TEXT,
						'condition' => [
							'background' => 'video'
						],
						'default' => '//clips.vorwaerts-gmbh.de/big_buck_bunny.mp4',
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'      => 'youtube_link',
						'label'     => esc_html__( 'Youtube Link', 'avator-widget-pack' ),
						'type'      => Controls_Manager::TEXT,
						'condition' => [
							'background' => 'youtube'
						],
						'default' => 'https://youtu.be/YE7VzlLtp-4',
						'dynamic'     => [ 'active' => true ],
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_responsive_control(
			'slider_size',
			[
				'label' => esc_html__( 'Slider Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 180,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'prefix_class' => 'avt-device-slider-align-',
				'condition' => [
					'slider_size!' => [ '' ],
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Show Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'arrows'           => esc_html__( 'Arrows', 'avator-widget-pack' ),
					'dots'             => esc_html__( 'Dots', 'avator-widget-pack' ),
					'arrows_dots'      => esc_html__( 'Arrows and Dots', 'avator-widget-pack' ),
					'none'             => esc_html__( 'None', 'avator-widget-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Title Layout', 'avator-widget-pack' ),
				'condition' => [
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'content_position',
			[
				'label'   => esc_html__( 'Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => widget_pack_position(),
			]
		);


		$this->add_responsive_control(
			'content_align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Slider', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay',
			[
				'label'   => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'       => esc_html__( 'None', 'avator-widget-pack' ),
					'background' => esc_html__( 'Background', 'avator-widget-pack' ),
					'blend'      => esc_html__( 'Blend', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'overlay' => ['background', 'blend']
				],
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container .avt-overlay-default' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'blend_type',
			[
				'label'     => esc_html__( 'Blend Type', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'multiply',
				'options'   => widget_pack_blend_options(),
				'condition' => [
					'overlay' => 'blend',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container .avt-slideshow-items .avt-device-slider-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container .avt-slideshow-items .avt-device-slider-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-device-slider-container .avt-slideshow-items .avt-device-slider-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-device-slider-container .avt-slideshow-items .avt-device-slider-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-device-slider-container .avt-slideshow-items .avt-device-slider-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => esc_html__( 'Navigation', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation!' => 'none',
				],
			]
		);

		$this->add_control(
			'heading_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation' => [ 'arrows', 'arrows_dots', 'arrows_thumbnavs' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Arrows Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container .avt-slidenav' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'arrows_dots', 'arrows_thumbnavs' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__( 'Arrows Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container .avt-slidenav:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'arrows_dots', 'arrows_thumbnavs' ],
				],
			]
		);

		$this->add_control(
			'heading_dots',
			[
				'label'     => esc_html__( 'Dots', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation' => [ 'dots', 'arrows_dots' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => esc_html__( 'Dots Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container .avt-dotnav li a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'arrows_dots' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => esc_html__( 'Active Dot Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container .avt-dotnav li.avt-active a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'arrows_dots' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => esc_html__( 'Dots Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-device-slider-container .avt-dotnav a' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'arrows_dots' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => esc_html__( 'Autoplay Interval', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 7000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'              => esc_html__( 'Animation Speed', 'avator-widget-pack' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 500,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'slider_animations',
			[
				'label'     => esc_html__( 'Slider Animations', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'default'   => 'slide',
				'options'   => [
					'slide' => esc_html__( 'Slide', 'avator-widget-pack' ),
					'fade'  => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale' => esc_html__( 'Scale', 'avator-widget-pack' ),
					'push'  => esc_html__( 'Push', 'avator-widget-pack' ),
					'pull'  => esc_html__( 'Pull', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'kenburns_animation',
			[
				'label'     => esc_html__( 'Kenburns Animation', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'kenburns_reverse',
			[
				'label'     => esc_html__( 'Kenburn Reverse', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'kenburns_animation' => 'yes'
				]
			]
		);

		$this->end_controls_section();

	}
	
	protected function render_header() {
		$settings        = $this->get_settings_for_display();
		$device_type     = $settings['device_type'];
		$ratio           = '1280:720';
		
		if ('desktop' === $device_type) {
			$ratio = '1280:720';
		} elseif ('safari' === $device_type) {
			$ratio = '1400:727';
		} elseif ('chrome' === $device_type) {
			$ratio = '1400:788';
		} elseif ('chrome-dark' === $device_type) {
			$ratio = '1400:788';
		} elseif ('firefox' === $device_type) {
			$ratio = '1280:651';
		} elseif ('edge' === $device_type) {
			$ratio = '1280:651';
		} elseif ('edge-dark' === $device_type) {
			$ratio = '1280:651';
		} elseif ('macbookpro' === $device_type) {
			$ratio = '1280:815';
		} elseif ('macbookair' === $device_type) {
			$ratio = '1280:810';
		} elseif ('tablet' === $device_type) {
			$ratio = '768:1024';
		} elseif ('galaxy' === $device_type) {
			$ratio = '634:1280';
		} elseif ('iphonex' === $device_type) {
			$ratio = '600:1280';
		} elseif ('mobile' === $device_type) {
			$ratio = '600:1152';
		} elseif ('mobile-dark' === $device_type) {
			$ratio = '600:1152';
		}


		$slider_settings['avt-slideshow'] = wp_json_encode(array_filter([
			"animation"         => $settings["slider_animations"],
			"ratio"             => $ratio,
			"autoplay"          => ("yes" === $settings["autoplay"]) ? true : false,
			"autoplay-interval" => $settings["autoplay_interval"],
			"pause-on-hover"    => ("yes" === $settings["pause_on_hover"]) ? true : false,
	    ]));


		?>
		<div class="avt-device-slider-container">
			<div class="avt-device-slider avt-device-slider-<?php echo esc_attr($device_type); ?>">
				<div <?php echo widget_pack_helper::attrs($slider_settings); ?>>
					<div class="avt-position-relative avt-visible-toggle">
						<ul class="avt-slideshow-items">
		<?php
	}

	protected function render_footer() {
		$settings    = $this->get_settings_for_display();
		$device_type = $settings['device_type'];
			?>
				</ul>
						<?php if ('arrows' == $settings['navigation'] or 'arrows_dots' == $settings['navigation']) : ?>
							<a class="avt-position-center-left avt-position-small avt-hidden-hover" href="#" avt-slidenav-previous avt-slideshow-item="previous"></a>
				    		<a class="avt-position-center-right avt-position-small avt-hidden-hover" href="#" avt-slidenav-next avt-slideshow-item="next"></a>
						<?php endif; ?>


						<?php if ('dots' == $settings['navigation'] or 'arrows_dots' == $settings['navigation']) : ?>
							<div class="avt-dotnav-wrapper">
								<ul class="avt-dotnav avt-flex-center">

								    <?php		
									$avt_counter    = 0;
									$slideshow_dots = $this->get_settings('slides');
									      
									foreach ( $slideshow_dots as $dot ) :
										
										echo '<li class="avt-slideshow-dotnav avt-active" avt-slideshow-item="'.$avt_counter.'"><a href="#"></a></li>';
										$avt_counter++;

									endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="avt-device-slider-device">
					<img src="<?php echo AWP_ASSETS_URL; ?>images/devices/<?php echo esc_attr( $device_type ); ?>.svg" alt="Device Slider">
				</div>
			</div>
		</div>
		<?php
	}

	protected function rendar_item_image($image, $alt = '') {
		$image_src = wp_get_attachment_image_src( $image['image']['id'], 'full' );

		if ($image_src) :
			echo '<img src="'.esc_url($image_src[0]).'" alt=" ' . esc_html($alt) . '" avt-cover>';
		endif;

	}

	protected function rendar_item_video($link) {
		$video_src = $link['video_link'];

		?>
		<video autoplay loop muted playsinline avt-cover>
			<source src="<?php echo  $video_src; ?>" type="video/mp4">
		</video>
		<?php
	}

	protected function rendar_item_youtube($link) {

		$id = (preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link['youtube_link'], $match ) ) ? $match[1] : false;
		 $url = '//www.youtube.com/embed/' . $id . '?autoplay=1&mute=1&amp;controls=0&amp;showinfo=0&amp;rel=0&amp;loop=1&amp;modestbranding=1&amp;wmode=transparent&amp;playsinline=1&playlist=' . $id;

		?>
		<iframe src="<?php echo  esc_url( $url); ?>" allowfullscreen avt-cover></iframe>
		<?php
	}

	protected function rendar_item_content($content) {
		$settings = $this->get_settings_for_display();

		?>
        <div class="avt-slideshow-content-wrapper avt-position-z-index avt-position-<?php echo esc_attr($settings['content_position']); ?> avt-position-large avt-text-<?php echo esc_attr($settings['content_align']); ?>">

			<?php if ($content['title'] && ( 'yes' == $settings['show_title'] )) : ?>
				<div>
					<h2 class="avt-device-slider-title avt-display-inline-block" avt-slideshow-parallax="x:300, -300">
						<?php if ( '' !== $content['title_link']['url'] ) : ?>
							<a href="<?php echo esc_url( $content['title_link']['url'] ); ?>">
						<?php endif; ?>
							<?php echo wp_kses_post($content['title']); ?>
						<?php if ( '' !== $content['title_link']['url'] ) : ?>
							</a>
						<?php endif; ?>
					</h2>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}

	public function render() {
		$settings         = $this->get_settings_for_display();
		$kenburns_reverse = $settings['kenburns_reverse'] ? ' avt-animation-reverse' : '';

		$this->render_header();

			foreach ( $settings['slides'] as $slide ) : ?>
					    
			        <li class="avt-slideshow-item elementor-repeater-item-<?php echo esc_attr($slide['_id']); ?>">
				        <?php if( 'yes' == $settings['kenburns_animation'] ) : ?>
							<div class="avt-position-cover avt-animation-kenburns<?php echo esc_attr( $kenburns_reverse ); ?> avt-transform-origin-center-left">
						<?php endif; ?>

				            <?php if (( $slide['background'] == 'image' ) && $slide['image']) : ?>
					            <?php $this->rendar_item_image($slide, $slide['title']); ?>
					        <?php elseif (( $slide['background'] == 'video' ) && $slide['video_link']) : ?>
					            <?php $this->rendar_item_video($slide); ?>
					        <?php elseif (( $slide['background'] == 'youtube' ) && $slide['youtube_link']) : ?>
					            <?php $this->rendar_item_youtube($slide); ?>
					        <?php endif; ?>

				        <?php if( 'yes' == $settings['kenburns_animation'] ) : ?>
				            </div>
				        <?php endif; ?>

				        <?php if( 'none' !== $settings['overlay'] ) :
				        	$blend_type = ( 'blend' == $settings['overlay']) ? ' avt-blend-'.$settings['blend_type'] : ''; ?>
				            <div class="avt-overlay-default avt-position-cover<?php echo esc_attr($blend_type); ?>"></div>
				        <?php endif; ?>

			            <?php $this->rendar_item_content($slide); ?>
			        </li>

				<?php endforeach;

		$this->render_footer();
	}
}
