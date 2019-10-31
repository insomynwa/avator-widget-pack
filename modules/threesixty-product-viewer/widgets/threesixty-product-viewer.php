<?php
namespace WidgetPack\Modules\ThreesixtyProductViewer\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Threesixty_Product_Viewer extends Widget_Base {

	public function get_name() {
		return 'avt-threesixty-product-viewer';
	}

	public function get_title() {
		return AWP . __( '360&#176; Product Viewer', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-360-product-viewer';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'three', 'sixty', 'degree', 'product', 'viewer', 'news' ];
	}

	public function get_script_depends() {
		return [ 'spritespin', 'avt-uikit-icons' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'source_type',
			[
				'label'       => __( 'Source Type', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'local',
				'label_block' => true,
				'options'     => [
					'local' => __( 'Local Images', 'avator-widget-pack' ),
					'remote' => __( 'Remote Images', 'avator-widget-pack' ),
				],
			]
		);	

		$this->add_control(
			'images',
			[
				'label'   => __( 'Add Images', 'avator-widget-pack' ),
				'type'    => Controls_Manager::GALLERY,
				'dynamic' => [ 'active' => true ],
				'condition' => [
					'source_type' => 'local'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'exclude'   => [ 'custom' ],
				'default'   => 'full',
				'condition' => [
					'source_type' => 'local'
				],
			]
		);

		$this->add_control(
			'remote_images',
			[
				'type'          => Controls_Manager::URL,
				'label'         => __( 'Images Source', 'avator-widget-pack' ),
				'label_block'   => true,
				'description'   => __( 'You should named all files with same digit serial numeric number, e.g: image-01.jpg, image-35.jpg', 'avator-widget-pack' ),
				'show_external' => false,
				'placeholder'   => __( 'https://example.com/image-{frame}.jpg', 'avator-widget-pack' ),
				'dynamic'       => [ 'active' => true ],
				'condition'     => [
					'source_type' => 'remote',
				],
			]
		);

		$this->add_control(
			'digit_number',
			[
				'label'       => esc_html__( 'File Name Digit Number', 'avator-widget-pack' ),
				'description' => __( 'Please select digit number of your file name. Such as if 001.jpg then you have to select 3', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 2,
				'options'     => [
					1  => '1',
					2  => '2',
					3  => '3',
					4  => '4',
					5  => '5',
					6  => '6',
				],
				'condition'     => [
					'source_type' => 'remote',
				],
			]
		);

		$this->add_control(
			'start_frame',
			[
				'label' => __('Start Frame', 'elementor-bundle-addons'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'condition'     => [
					'source_type' => 'remote',
				],
			]
		);

		$this->add_control(
			'end_frame',
			[
				'label' => __('End Frame', 'elementor-bundle-addons'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 8,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 12,
				],
				'condition'     => [
					'source_type' => 'remote',
				],
			]
		);

		$this->add_control(
			'width',
			[
				'label' => __('Width', 'elementor-bundle-addons'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 1280,
						'step' => 10,
					],
				],
				'default' => [
					'size' => 480,
				],
			]
		);

		$this->add_control(
			'height',
			[
				'label' => __('Height', 'elementor-bundle-addons'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 327,
				],
			]
		);

		$this->add_control(
			'full_screen_button',
			[
				'label'     => __( 'Fullscreen Button', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tspv_fb_icon',
			[
				'label'   => __( 'Button Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'options' => [
					'expand' => [
						'title' => __( 'Expand', 'avator-widget-pack' ),
						'icon'  => 'fas fa-expand',
					],
					'plus' => [
						'title' => __( 'Plus', 'avator-widget-pack' ),
						'icon'  => 'fas fa-plus',
					],
					'search' => [
						'title' => __( 'Zoom', 'avator-widget-pack' ),
						'icon'  => 'fas fa-search',
					],
				],
				'default'   => 'search',
				'condition' => [
					'full_screen_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'tspv_fb_icon_position',
			[
				'label'     => __( 'Icon Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => widget_pack_position(),
				'default'   => 'bottom-left',
				'condition' => [
					'full_screen_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'tspv_fb_icon_on_hover',
			[
				'label'        => __( 'Icon On Hover', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-tspv-fb-icon-on-hover-',
				'condition'    => [
					'full_screen_button' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => __( 'Additional', 'avator-widget-pack' ),
			]
		);		

		$this->add_control(
			'animate',
			[
				'label'       => __( 'Animate', 'avator-widget-pack' ),
				'default'     => 'yes',
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Starts the animation automatically on load', 'avator-widget-pack' ),
			]
		);
		
		$this->add_control(
			'frame_time',
			[
				'label'       => __('Frame Time', 'elementor-bundle-addons'),
				'description' => __( 'Time in ms between updates. e.g. 40 is exactly 25 FPS', 'avator-widget-pack' ),
				'type'        => Controls_Manager::NUMBER,
				'condition' => [
					'animate' => 'yes'
				],
			]
		);		
		
		$this->add_control(
			'loop',
			[
				'label'   => __( 'Loop', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'animate' => 'yes'
				],
			]
		);

		$this->add_control(
			'stop_frame',
			[
				'label'       => __('Stop Frame', 'elementor-bundle-addons'),
				'description' => __( 'Stops the animation on that frame if `loop` is false', 'avator-widget-pack' ),
				'type'        => Controls_Manager::NUMBER,
				'condition' => [
					'loop!' => 'yes'
				]
			]
		);		
		
		$this->add_control(
			'reverse',
			[
				'label'       => __( 'Reverse', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Animation playback is reversed', 'avator-widget-pack' ),
				'condition' => [
					'animate' => 'yes'
				],
			]
		);
		
		$this->add_control(
			'retain_animate',
			[
				'label'       => __( 'Retain Animate', 'avator-widget-pack' ),
				'description' => __( 'Retains the animation after user iser interaction', 'avator-widget-pack' ),
				'default'     => 'yes',
				'type'        => Controls_Manager::SWITCHER,
				'separator'   => 'after',
				'condition' => [
					'animate' => 'yes'
				],
			]
		);		

		$this->add_control(
			'mouse_option',
			[
				'label'       => esc_html__( 'Mouse Option', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'drag',
				'options'     => [
					''      => esc_html__('None', 'avator-widget-pack'),
					'drag'  => esc_html__('Drag', 'avator-widget-pack'),
					'move'  => esc_html__('Move', 'avator-widget-pack'),
					'wheel' => esc_html__('Wheel', 'avator-widget-pack'),
				],
			]
		);	

		$this->add_control(
			'sense',
			[
				'label'       => __('Reverse', 'elementor-bundle-addons'),
				'description' => __( 'Sensitivity factor for user interaction', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition' => [
					'mouse_option' => ['drag', 'move'],
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'ease',
			[
				'label' => __( 'Easing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'blur',
			[
				'label' => __( 'Blur', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		// $this->add_control(
		// 	'sub_sampling',
		// 	[
		// 		'label'       => __( 'Detect Sub Sampling', 'avator-widget-pack' ),
		// 		'description' => __( 'Tries to detect whether the images are downsampled by the browser', 'avator-widget-pack' ),
		// 		'type'        => Controls_Manager::SWITCHER,
		// 	]
		// );

		// $this->add_control(
		// 	'frame',
		// 	[
		// 		'label'       => __('Frame', 'elementor-bundle-addons'),
		// 		'description' => __( 'Initial frame number', 'avator-widget-pack' ),
		// 		'type'        => Controls_Manager::NUMBER,
		// 		'default'     => 0,
		// 	]
		// );

		// $this->add_control(
		// 	'wrap',
		// 	[
		// 		'label'       => __( 'Wrap', 'avator-widget-pack' ),
		// 		'default'     => 'yes',
		// 		'type'        => Controls_Manager::SWITCHER,
		// 		'description' => __( 'Allows the user to drag the animation beyond the last frame and wrap over to the beginning', 'avator-widget-pack' ),
		// 	]
		// );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => esc_html__( 'Icon Style', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'full_screen_button' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 2,
						'max'  => 100,
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon svg' => 'height: {{SIZE}}px; width: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-icon',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_shadow',
				'selector' => '{{WRAPPER}} .avt-icon',
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon:hover'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$image_urls   = [];
		$tspv_plugins = [];

		if ( 'local' == $settings['source_type'] ) {
			foreach ( $settings['images'] as $index => $item ) : ?>
				<?php $image_urls[] = Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'thumbnail', $settings );	?>
			<?php endforeach;
		} elseif ( 'remote' == $settings['source_type'] ) {
			$image_urls = $settings['remote_images']['url'];
		}

		if ( ! empty( $image_urls ) ) {

			$tspv_plugins[] = '360';
			$tspv_plugins[] = 'progress';

			if ($settings['mouse_option']) {
				$tspv_plugins[] = $settings['mouse_option'];
			}
			if ($settings['ease']) {
				$tspv_plugins[] = 'ease';
			}
			if ($settings['blur']) {
				$tspv_plugins[] = 'blur';
			}

			$this->add_render_attribute(
				[
					'threesixty' => [
						'data-settings' => [
							wp_json_encode(array_filter([
								"source_type"   => $settings["source_type"],					
								"frame_limit"   => ("remote" == $settings["source_type"]) ? [$settings["start_frame"]["size"], $settings["end_frame"]["size"]] : false,
								"image_digits"  => ("remote" == $settings["source_type"]) ? $settings["digit_number"] : false,
								"source"        => $image_urls,
								"width"         => $settings["width"]["size"],
								"height"        => $settings["height"]["size"],
								"animate"       => $settings["animate"] ? true : false, 
								"frameTime"     => $settings["frame_time"], 
								"loop"          => $settings["loop"] ? true : false, 
								"retainAnimate" => $settings["retain_animate"] ? true : false, 
								"reverse"       => $settings["reverse"] ? true : false, 
								"sense"         => ($settings["sense"]) ? -1 : false, 
								"stopFrame"     => $settings["stop_frame"], 
								"responsive"    => true,
								"plugins"       => $tspv_plugins,
					        ]))
						]
					]
				]
			);

			$this->add_render_attribute( 'threesixty', 'class', 'avt-threesixty-product-viewer' );

			if ( $settings['full_screen_button'] ) {
				$this->add_render_attribute( 'tspv-fb', [
					'href'     => '#',
					'class'    => 'avt-tspv-fb avt-icon avt-position-small avt-position-' . $settings['tspv_fb_icon_position'],
					'avt-icon' =>'icon: ' . $settings['tspv_fb_icon'] . '; ratio: 1.6;',
				]);
			}

			?>
			<div <?php echo $this->get_render_attribute_string( 'threesixty' ); ?>>
			
				<div class="avt-tspv-container"></div>

				<?php if ($settings['full_screen_button']) : ?>
					<a <?php echo $this->get_render_attribute_string( 'tspv-fb' ); ?>></a>
				<?php endif; ?>

			</div>
			<?php
		} else {
			?>
			<div class="avt-alert-warning" avt-alert>
			    <a class="avt-alert-close" avt-close></a>
			    <p><?php printf(__( 'Please choose a set of images or set url.', 'avator-widget-pack' )); ?></p>
			</div>
			<?php
		}
	}
}
