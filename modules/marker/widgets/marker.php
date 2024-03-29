<?php
namespace WidgetPack\Modules\Marker\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Marker extends Widget_Base {

	public function get_name() {
		return 'avt-marker';
	}

	public function get_title() {
		return AWP . __( 'Marker', 'avator-widget-pack' );
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'marker', 'pointer' ];
	}

	public function get_icon() {
		return 'avt-wi-marker';
	}

	public function get_style_depends() {
		return [ 'wipa-marker' ];
	}

	public function get_script_depends() {
		return [ 'popper', 'tippyjs', 'wipa-marker' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/aH4QiD6v-lk';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_marker_image',
			[
				'label' => __( 'Marker Image', 'avator-widget-pack' ),
			]
		);


		$this->add_control(
			'image',
			[
				'label'   => __( 'Choose Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image', // Actually its `image_size`.
				'label'   => __( 'Image Size', 'avator-widget-pack' ),
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption',
			[
				'label'       => __( 'Caption', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => '',
				'placeholder' => __( 'Enter your caption about the image', 'avator-widget-pack' ),
				'title'       => __( 'Input image caption here', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link to', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'http://your-link.com', 'avator-widget-pack' ),
				'condition'   => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->end_controls_section();

		
		$this->start_controls_section(
			'section_content_sliders',
			[
				'label' => esc_html__( 'Markers', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'markers',
			[
				'label'   => esc_html__( 'Marker Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'marker_title'      => esc_html__( 'Marker #1', 'avator-widget-pack' ),
						'marker_x_position' => [
							'size' => 50,
							'unit' => '%',
						],
						'marker_y_position' => [
							'size' => 50,
							'unit' => '%',
						]
					],
					[
						'marker_title'      => esc_html__( 'Marker #2', 'avator-widget-pack' ),
						'marker_x_position' => [
							'size' => 30,
							'unit' => '%',
						],
						'marker_y_position' => [
							'size' => 30,
							'unit' => '%',
						]
					],
					[
						'marker_title'      => esc_html__( 'Marker #3', 'avator-widget-pack' ),
						'marker_x_position' => [
							'size' => 80,
							'unit' => '%',
						],
						'marker_y_position' => [
							'size' => 20,
							'unit' => '%',
						]
					],
				],
				'fields' => [
					[
						'name'        => 'marker_title',
						'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Marker Title' , 'avator-widget-pack' ),
						'label_block' => true,
					],
					[
						'name'    => 'marker_tooltip',
						'label'   => __( 'Tooltip', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SWITCHER,
						'default' => 'yes',
					],
					[
						'name'    => 'marker_tooltip_placement',						
						'label'   => esc_html__( 'Placement', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'top',
						'options' => [
							'top-start'    => esc_html__( 'Top Left', 'avator-widget-pack' ),
							'top'          => esc_html__( 'Top', 'avator-widget-pack' ),
							'top-end'      => esc_html__( 'Top Right', 'avator-widget-pack' ),
							'bottom-start' => esc_html__( 'Bottom Left', 'avator-widget-pack' ),
							'bottom'       => esc_html__( 'Bottom', 'avator-widget-pack' ),
							'bottom-end'   => esc_html__( 'Bottom Right', 'avator-widget-pack' ),
							'left'         => esc_html__( 'Left', 'avator-widget-pack' ),
							'right'        => esc_html__( 'Right', 'avator-widget-pack' ),
						],
						'render_type' => 'template',
						'condition'   => [
							'marker_tooltip' => 'yes',
						],
					],
					[
						'name'    => 'marker_x_position',
						'label'   => esc_html__( 'X Postion', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SLIDER,
						'default' => [
							'size' => 20,
							'unit' => '%',
						],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
					],
					[
						'name'    => 'marker_y_position',
						'label'   => esc_html__( 'Y Postion', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SLIDER,
						'default' => [
							'size' => 20,
							'unit' => '%',
						],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
					],
					
					[
						'name'    => 'marker_select_icon',
						'label'   => esc_html__( 'Select Icon', 'avator-widget-pack' ),
						'type'        => Controls_Manager::ICONS,
						'fa4compatibility' => 'icon',
					],

					[
						'name'    => 'link_to',
						'label'   => esc_html__( 'Link to', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SELECT,
						'default' => '',
						'options' => [
							''         => __( 'None', 'avator-widget-pack' ),
							'custom'   => __( 'Custom URL', 'avator-widget-pack' ),
							'lightbox' => __( 'Lightbox', 'avator-widget-pack' ),
						],
					],
					[
						'name'        => 'marker_link',
						'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::URL,
						'dynamic'     => [ 'active' => true ],
						'placeholder' => 'http://your-link.com',
						'default'     => [
							'url' => '#',
						],
						'condition' => [
							'link_to' => 'custom',
						],
					],
					[
						'name'    => 'image_link',
						'label'   => esc_html__( 'Choose Image', 'avator-widget-pack' ),
						'type'    => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'condition' => [
							'link_to' => 'lightbox',
						],
					],
				],
				'title_field' => '{{{ marker_title }}}',
			]
		);

		$this->add_control(
			'marker_animation',
			[
				'label'   => __( 'Pulse Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_tooltip_settings',
			[
				'label' => __( 'Tooltip Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'marker_tooltip_animation',
			[
				'label'   => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shift-toward',
				'options' => [
					'shift-away'   => esc_html__( 'Shift-Away', 'avator-widget-pack' ),
					'shift-toward' => esc_html__( 'Shift-Toward', 'avator-widget-pack' ),
					'fade'         => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale'        => esc_html__( 'Scale', 'avator-widget-pack' ),
					'perspective'  => esc_html__( 'Perspective', 'avator-widget-pack' ),
				],
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'marker_tooltip_x_offset',
			[
				'label'   => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'marker_tooltip_y_offset',
			[
				'label'   => esc_html__( 'Distance', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'marker_tooltip_arrow',
			[
				'label'        => esc_html__( 'Arrow', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'marker_tooltip_trigger',
			[
				'label'       => __( 'Trigger on Click', 'avator-widget-pack' ),
				'description' => __( 'Don\'t set yes when you set lightbox image with marker.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label'   => __( 'Size (%)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-marker-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'   => __( 'Opacity', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-marker-wrapper img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'label'     => __( 'Image Border', 'avator-widget-pack' ),
				'selector'  => '{{WRAPPER}} .avt-marker-wrapper img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-marker-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'image_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .avt-marker-wrapper img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => __( 'Caption', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'caption_align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .marker-caption-text' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .marker-caption-text' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .marker-caption-text',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_marker',
			[
				'label' => __( 'Marker', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'marker_background_color',
				'selector' => '{{WRAPPER}} .avt-marker-wrapper .avt-marker',
			]
		);

		$this->add_control(
			'marker_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-marker-wrapper .avt-marker' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'marker_size',
			[
				'label' => __( 'Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-marker-wrapper .avt-marker > svg' => 'width: calc({{SIZE}}{{UNIT}} - 12px); height: auto;',
					'{{WRAPPER}} .avt-marker-wrapper .avt-marker > i' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'marker_opacity',
			[
				'label'   => __( 'Opacity (%)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-marker-wrapper .avt-marker' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'marker_border',
				'label'     => __( 'Image Border', 'avator-widget-pack' ),
				'selector'  => '{{WRAPPER}} .avt-marker-wrapper .avt-marker',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'marker_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-marker-wrapper .avt-marker' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'marker_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-marker-wrapper .avt-marker' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .avt-marker-animated .avt-marker:before, {{WRAPPER}} .avt-marker-animated .avt-marker:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'marker_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .avt-marker-wrapper .avt-marker',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tooltip',
			[
				'label' => esc_html__( 'Tooltip', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'marker_tooltip_width',
			[
				'label'      => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em',
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'marker_tooltip_typography',
				'selector' => '{{WRAPPER}} .tippy-tooltip .tippy-content',
			]
		);

		$this->add_control(
			'marker_tooltip_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'marker_tooltip_text_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
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
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'marker_tooltip_background',
				'selector' => '{{WRAPPER}} .tippy-tooltip, {{WRAPPER}} .tippy-tooltip .tippy-backdrop',
			]
		);

		$this->add_control(
			'marker_tooltip_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'marker_tooltip_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'marker_tooltip_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .tippy-tooltip',
			]
		);

		$this->add_responsive_control(
			'marker_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'marker_tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .tippy-tooltip',
			]
		);

		$this->add_control(
			'tooltip_size',
			[
				'label'   => esc_html__( 'Tooltip Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''      => esc_html__( 'Default', 'avator-widget-pack' ),
					'large' => esc_html__( 'Large', 'avator-widget-pack' ),
					'small' => esc_html__( 'small', 'avator-widget-pack' ),
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-marker-' . $this->get_id();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$has_caption = ! empty( $settings['caption'] );

		$this->add_render_attribute( 'wrapper', 'class', 'avt-marker-wrapper avt-inline avt-dark' );
		$this->add_render_attribute( 'wrapper', 'id', esc_attr($id) );

		if ('yes' === $settings['marker_animation']) {
			$this->add_render_attribute( 'wrapper', 'class', 'avt-marker-animated' );
			$this->add_render_attribute( 'wrapper', 'avt-scrollspy', 'target: .avt-marker-wrapper > a.avt-marker-item; cls:avt-animation-scale-up; delay: 300;' );
		}

		$this->add_render_attribute( 'wrapper', 'avt-lightbox', 'toggle: .avt-marker-lightbox-item; animation: slide;' );

		if ( $has_caption ) : ?>
			<figure class="marker-caption">
		<?php endif; ?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>			
	        
			<?php

			echo Group_Control_Image_Size::get_attachment_image_html( $settings );
		    
		    foreach ($settings['markers'] as $marker) {

				$this->add_render_attribute('marker', 'class',  ['avt-marker-item avt-position-absolute avt-transform-center avt-marker avt-icon'], true);
				$this->add_render_attribute('marker', 'style', 'left:' . $marker['marker_x_position']['size'] . '%;', true);
				$this->add_render_attribute('marker', 'style', 'top:' . $marker['marker_y_position']['size'] . '%;');
				$this->add_render_attribute('marker', 'data-tippy-content', [$marker['marker_title']], true);

				if ($marker['link_to'] and $marker['marker_link']) {					
					if ( 'lightbox' === $marker['link_to'] ) {
						$this->add_render_attribute( 'marker', 'data-elementor-open-lightbox', 'no', true);
						$this->add_render_attribute( 'marker', 'data-caption', $marker['marker_title'], true);
						$this->add_render_attribute( 'marker', 'class', 'avt-marker-lightbox-item');
						$this->add_render_attribute( 'marker', 'href', $marker['image_link']['url'], true);
					} else {
						$this->add_render_attribute('marker', 'href', $marker['marker_link']['url'], true);
						if ( ! empty( $marker['marker_link']['is_external'] ) ) {
							$this->add_render_attribute('marker', 'target', ['_blank'], true);
						}					
						if ( ! empty( $marker['marker_link']['nofollow'] ) ) {
							$this->add_render_attribute('marker', 'rel', ['nofollow'], true);
						}
					}					
				} else {
					$this->add_render_attribute('marker', 'href', 'javascript:void(0);', true);
				}

				if ($marker['marker_title'] and $marker['marker_tooltip']) {
					// Tooltip settings
					$this->add_render_attribute( 'marker', 'class', 'avt-tippy-tooltip' );
					$this->add_render_attribute( 'marker', 'data-tippy', '', true );

					if ($marker['marker_tooltip_placement']) {
						$this->add_render_attribute( 'marker', 'data-tippy-placement', $marker['marker_tooltip_placement'], true );
					}

					if ($settings['marker_tooltip_animation']) {
						$this->add_render_attribute( 'marker', 'data-tippy-animation', $settings['marker_tooltip_animation'], true );
					}

					if ($settings['marker_tooltip_x_offset']['size'] or $settings['marker_tooltip_y_offset']['size']) {
						$this->add_render_attribute( 'marker', 'data-tippy-offset', $settings['marker_tooltip_x_offset']['size'] .','. $settings['marker_tooltip_y_offset']['size'], true );
					}

					if ('yes' == $settings['marker_tooltip_arrow']) {
						$this->add_render_attribute( 'marker', 'data-tippy-arrow', 'true', true );
					}

					if ('yes' == $settings['marker_tooltip_trigger']) {
						$this->add_render_attribute( 'marker', 'data-tippy-trigger', 'click', true );
					}

				}

				$migrated  = isset( $marker['__fa4_migrated']['marker_select_icon'] );
				$is_new    = empty( $marker['marker_icon'] ) && Icons_Manager::is_migration_allowed();
		    	
		    	?>		    	
				<a <?php echo $this->get_render_attribute_string('marker'); ?>>

					<?php if ( ($is_new or $migrated) and $marker['marker_select_icon']['value'] ) :
						Icons_Manager::render_icon( $marker['marker_select_icon'], [ 'aria-hidden' => 'true' ] );
					else : ?>
						<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="marker"><rect x="9" y="4" width="1" height="11"></rect><rect x="4" y="9" width="11" height="1"></rect></svg>
					<?php endif; ?>

				</a>
				<?php		    	
		    } ?>

		</div>

		<?php if ( $has_caption ) : ?>
			<figcaption class="marker-caption-text"><?php echo esc_html($settings['caption']); ?></figcaption>
		<?php endif; ?>

		<?php if ( $has_caption ) : ?>
			</figure>
		<?php endif; ?>

		<?php
	}

	protected function _content_template() {
		?>
		<# if ( '' !== settings.image.url ) {
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			if ( ! image_url ) {
				return;
			}

			var has_caption = ! settings.caption;

			view.addRenderAttribute( 'wrapper', 'class', [ 'avt-marker-wrapper', 'avt-inline', 'avt-dark' ] );

			if ('yes' === settings.marker_animation) {
				view.addRenderAttribute( 'wrapper', 'class', [ 'avt-marker-animated' ] );
			}

			var marker_wrapper = view.getRenderAttributeString( 'wrapper' ); #>

			<# if ( hasCaption ) { #>
				<figure class="marker-caption">
			<# } #>
			
			<div <# print(marker_wrapper); #>><#
				var imgClass = '',
					hasCaption = '' !== settings.caption;

					var iconHTML = {},
						migrated = {};

				#>				

				<img src="{{ image_url }}" class="{{ imgClass }}" />
			
				<# _.each( settings.markers, function( item, index ) { 
								
					view.addRenderAttribute( 'marker', 'class', [ 'avt-position-absolute', 'avt-transform-center', 'avt-marker', 'avt-icon' ], true );
					view.addRenderAttribute( 'marker', 'style', 'left:' + item.marker_x_position.size + '%;', true );
					view.addRenderAttribute( 'marker', 'style', 'top:' + item.marker_y_position.size + '%;' );
					view.addRenderAttribute( 'marker', 'title', [item.marker_title], true );

					if (item.link_to && item.marker_link) {					
						if ( 'lightbox' === item.link_to ) {
							view.addRenderAttribute( 'marker', 'data-elementor-open-lightbox', 'no');
							view.addRenderAttribute( 'marker', 'data-caption', item.marker_title);
							view.addRenderAttribute( 'marker', 'class', 'avt-marker-lightbox-item');
							view.addRenderAttribute('marker', 'href', item.image_link.url, true);
						} else {
							view.addRenderAttribute('marker', 'href', item.marker_link.url, true);
							if ( item.marker_link.is_external) {
								view.addRenderAttribute('marker', 'target', '_blank', true);
							}					
							if (item.marker_link.nofollow) {
								view.addRenderAttribute('marker', 'rel', 'nofollow', true);
							}
						}					
					}

					if (item.marker_title) {

						view.addRenderAttribute( 'marker', 'class', 'avt-tippy-tooltip' );
						view.addRenderAttribute( 'marker', 'data-tippy', '', true );
						if (item.marker_tooltip_placement ) {
							view.addRenderAttribute( 'marker', 'data-tippy-placement', item.marker_tooltip_placement, true );
						}

						if (settings.marker_tooltip_animation ) {
							view.addRenderAttribute( 'marker', 'data-tippy-animation', settings.marker_tooltip_animation, true );
						}
						if (settings.marker_tooltip_x_offset.size || settings.marker_tooltip_y_offset.size ) {
							view.addRenderAttribute( 'marker', 'data-tippy-offset', settings.marker_tooltip_x_offset.size + ',' + settings.marker_tooltip_y_offset.size, true );
						}

						if (settings.marker_tooltip_arrow ) {
							view.addRenderAttribute( 'marker', 'data-tippy-arrow', 'true', true );
						}
					}

					iconHTML[ index ] = elementor.helpers.renderIcon( view, item.marker_select_icon, { 'aria-hidden': true }, 'i' , 'object' );

					migrated[ index ] = elementor.helpers.isIconMigrated( item, 'marker_select_icon' );

					#>		 
					
					<a <# print( view.getRenderAttributeString( 'marker' ) ); #>>

						<# if ( iconHTML[ index ] && iconHTML[ index ].rendered && ( ! item.marker_icon || migrated[ index ] ) ) { #>
							{{{ iconHTML[ index ].value }}}
						<# } else { #>
							<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="marker"><rect x="9" y="4" width="1" height="11"></rect><rect x="4" y="9" width="11" height="1"></rect></svg>
						<# } #>
					</a>

				<# }); #>				 

				<# if ( hasCaption ) { #>
					<figcaption class="marker-caption-text">{{{ settings.caption }}}</figcaption><#
				} #>
			</div>

			<# if ( hasCaption ) { #>
				</figure>
			<# } #>

			<# } #>
		<?php
	}
}
