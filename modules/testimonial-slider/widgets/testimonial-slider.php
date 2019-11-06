<?php
namespace WidgetPack\Modules\TestimonialSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;

use WidgetPack\Modules\TestimonialSlider\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial_Slider extends Widget_Base {

	public function get_name() {
		return 'avt-testimonial-slider';
	}

	public function get_title() {
		return AWP . esc_html__( 'Testimonial Slider', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-testimonial-slider';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'slider' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font', 'wipa-testimonial-slider' ];
	}

	public function get_script_depends() {
		return [ 'avt-uikit-icons' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/pI-DLKNlTGg';
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Thumb( $this ) );
		$this->add_skin( new Skins\Skin_Single( $this ) );
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'thumb',
			[
				'label'     => esc_html__( 'Testimonial Image', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'company_name',
			[
				'label'   => esc_html__( 'Company Name/Address', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'text_limit',
			[
				'label'   => esc_html__( 'Text Limit', 'avator-widget-pack' ),
				'description' => 'Its just work for text , but not working excerpt.',
				'type'    => Controls_Manager::NUMBER,
				'default' => 80,
			]
		);

		$this->add_control(
			'rating',
			[
				'label'   => esc_html__( 'Rating', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);


		$this->add_control(
			'meta_position',
			[
				'label'   => __( 'Meta Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'before' => [
						'title' => __( 'Before', 'avator-widget-pack' ),
						'icon'  => 'fas fa-arrow-up',
					],
					'after' => [
						'title' => __( 'After', 'avator-widget-pack' ),
						'icon'  => 'fas fa-arrow-down',
					],
				],
				'default'   => 'after',
			]
		);


		$this->add_control(
			'alignment',
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
				'default'   => 'left',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'image_size',
			[
				'label'   => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-testimonial-thumb' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => 'avt-single',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => esc_html__( 'Query', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__( 'Show All', 'avator-widget-pack' ),
					'by_name' => esc_html__( 'Manual Selection', 'avator-widget-pack' ),
				],
				'label_block' => true,
			]
		);


		$post_categories = get_terms( 'testimonial_categories' );

		$post_options = [];
		foreach ( $post_categories as $category ) {
			$post_options[ $category->slug ] = $category->name;
		}

		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $post_options,
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'posts',
			[
				'label'   => esc_html__( 'Posts Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => esc_html__( 'Date', 'avator-widget-pack' ),
					'title'    => esc_html__( 'Title', 'avator-widget-pack' ),
					'category' => esc_html__( 'Category', 'avator-widget-pack' ),
					'rand'     => esc_html__( 'Random', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'avator-widget-pack' ),
					'ASC'  => esc_html__( 'Ascending', 'avator-widget-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settins',
			[
				'label' => esc_html__( 'Slider Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Auto Play', 'avator-widget-pack' ),
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
				'label'   => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__( 'Loop', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label'     => __( 'Navigation', 'avator-widget-pack' ),
				'condition' => [
					'_skin!' => 'avt-thumb',
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'avator-widget-pack' ),
					'arrows' => __( 'Arrows', 'avator-widget-pack' ),
					'dots'   => __( 'Dots', 'avator-widget-pack' ),
					'none'   => __( 'None', 'avator-widget-pack' ),
				],
				'prefix_class' => 'avt-navigation-type-',
				'render_type'  => 'template',				
			]
		);
		
		$this->add_control(
			'both_position',
			[
				'label'     => __( 'Arrows and Dots Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => widget_pack_navigation_position(),
				'condition' => [
					'navigation' => 'both',
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => __( 'Arrows Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => widget_pack_navigation_position(),
				'condition' => [
					'navigation' => 'arrows',
				],				
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'     => __( 'Dots Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => widget_pack_pagination_position(),
				'condition' => [
					'navigation' => 'dots',
				],				
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_thumb',
			[
				'label'     => __( 'Item Style', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				// 'condition' => [
				// 	'_skin!' => '',
				// ],
			]
		);

		$this->add_control(
			'heading_testimonial',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Testimonial', 'avator-widget-pack' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'testimonial_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-item-inner'                                     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-slider li.avt-slider-thumbnav .avt-slider-thumbnav-inner:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'testimonial_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-item-inner' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'testimonial_shadow',
				'label'    => esc_html__( 'Shadow', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-testimonial-slider .avt-slider-item-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'testimonial_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-testimonial-slider .avt-slider-item-inner',
			]
		);

		$this->add_control(
			'testimonial_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'testimonial_thumb',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Thumb', 'avator-widget-pack' ),
				'separator' => 'before',
				'condition' => [
					'_skin' => 'avt-thumb',
				],
			]
		);

		$this->add_responsive_control(
			'horizontal_spacing',
			[
				'label'   => esc_html__( 'Horizontal Space', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-thumbnav:not(:first-child)' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => 'avt-thumb',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_spacing',
			[
				'label'   => esc_html__( 'Vertical Space', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-thumbnav-inner' => 'padding-top: calc({{SIZE}}{{UNIT}} + 20px);',
				],
				'condition' => [
					'_skin' => 'avt-thumb',
				],
			]
		);

		$this->add_control(
			'hide_arrow_style',
			[
				'label'        => esc_html__( 'Hide Arrow Style', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-arrow-style-hide-',
				'condition' => [
					'_skin' => 'avt-thumb',
				],
			]
		);

		$this->add_control(
			'thumb_opacity',
			[
				'label' => __( 'Thumbnail Opacity', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.05,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.8,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-thumbnav-inner img' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'_skin' => 'avt-thumb',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'thumb_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-testimonial-slider .avt-slider-thumbnav-inner img',
			]
		);

		$this->add_control(
			'thumb_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-thumbnav-inner img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'active_thumb_opacity',
			[
				'label' => __( 'Active Opacity', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.05,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-active .avt-slider-thumbnav-inner img' => 'opacity: {{SIZE}};',
				],
				'separator' => 'before',
				'condition' => [
					'_skin' => 'avt-thumb',
				],
			]
		);

		$this->add_control(
			'active_thumb_border_color',
			[
				'label'     => __( 'Active Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-active .avt-slider-thumbnav-inner img' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'avt-thumb',
					'thumb_border_border!' => '',					
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_style',
			[
				'label' => esc_html__( 'Content Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quatation_heading',
			[
				'label'     => esc_html__( 'Quatation', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'quatation_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-text:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quatation_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-testimonial-text:after',
			]
		);

		$this->add_control(
			'text_heading',
			[
				'label'     => esc_html__( 'Text', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-testimonial-text',
			]
		);

		$this->add_responsive_control(
			'text_cite_space',
			[
				'label' => __( 'Meta Space', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider-item-inner > div:first-child' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
				'condition' => ['title' => 'yes'],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-meta .avt-testimonial-title' => 'color: {{VALUE}};',
				],
				'condition' => ['title' => 'yes'],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-testimonial-meta .avt-testimonial-title',
				'condition' => ['title' => 'yes'],
			]
		);

		$this->add_control(
			'address_heading',
			[
				'label'     => esc_html__( 'Name/Address', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'company_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'address_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-meta .avt-testimonial-address' => 'color: {{VALUE}};',
				],
				'condition' => [
					'company_name' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'address_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-testimonial-meta .avt-testimonial-address',
				'condition' => [
					'company_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_heading',
			[
				'label'     => esc_html__( 'Rating', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-rating .avt-rating-item' => 'color: {{VALUE}};',
				],
				'condition' => [
					'rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => esc_html__( 'Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-rating.avt-rating-1 .avt-rating-item:nth-child(1)'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-slider .avt-rating.avt-rating-2 .avt-rating-item:nth-child(-n+2)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-slider .avt-rating.avt-rating-3 .avt-rating-item:nth-child(-n+3)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-slider .avt-rating.avt-rating-4 .avt-rating-item:nth-child(-n+4)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-slider .avt-rating.avt-rating-5 .avt-rating-item:nth-child(-n+5)' => 'color: {{VALUE}};',
				],
				'condition' => [
					'rating' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'      => __( 'Navigation', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'avt-thumb',
						],
						[
							'name'     => 'navigation',
							'operator' => '!=',
							'value'    => 'none',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev svg,
					{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev,
					{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev:hover,
					{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev svg,
					{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Arrows Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev:hover svg,
					{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_space',
			[
				'label' => __( 'Space', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev,
					{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev,
					{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-dotnav a' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-dotnav a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Dots Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-slider-dotnav.avt-active a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_acx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nnx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nny_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cx_position',
			[
				'label'   => __( 'Arrows Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-testimonial-slider .avt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cy_position',
			[
				'label'   => __( 'Dots Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-slider .avt-dots-container' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	public function query_posts() {

		$settings = $this->get_settings();

		$args = array(
			'post_type'      => 'avator-testimonial',
			'posts_per_page' => $settings['posts'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish'
		);

		if ( 'by_name' === $settings['source'] and !empty($settings['post_categories']) ) {			  
			$args['tax_query'][] = array(
				'taxonomy' => 'testimonial_categories',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		}

		$this->_query = new \WP_Query( $args );
	}

	public function get_query() {
		return $this->_query;
	}

	public function render_header($skin, $id, $settings) {
		
		$this->add_render_attribute( 'testimonial-slider', 'id', 'avt-testimonial-slider-' . esc_attr($id) );
		$this->add_render_attribute( 'testimonial-slider', 'class', ['avt-testimonial-slider', 'avt-testimonial-slider-skin-' . esc_attr($skin)] );

		?>

		<div <?php echo $this->get_render_attribute_string( 'testimonial-slider' ); ?>>
		<?php

		$this->add_render_attribute(
			[
				'slider-settings' => [
					'class' => [
						( 'both' == $settings['navigation'] ) ? 'avt-arrows-dots-align-' . $settings['both_position'] : '',
						( 'arrows' == $settings['navigation'] or 'arrows-thumbnavs' == $settings['navigation'] ) ? 'avt-arrows-align-' . $settings['arrows_position'] : '',
						( 'dots' == $settings['navigation'] ) ? 'avt-dots-align-'. $settings['dots_position'] : '',
					],
					'avt-slider' => [
						wp_json_encode(array_filter([
							"autoplay"          => $settings["autoplay"],
							"autoplay-interval" => $settings["autoplay_interval"],
							"finite"            => $settings["loop"] ? false : true,
							"pause-on-hover"    => $settings["pause_on_hover"] ? true : false
						]))
					]
				]
			]
		);

		?>
		<div <?php echo ( $this->get_render_attribute_string( 'slider-settings' ) ); ?>>
			<ul class="avt-slider-items avt-child-width-1-1 avt-grid avt-grid-match" avt-grid>
		<?php
	}

	public function render_footer($settings) {

		?>
			</ul>
			<?php if ('both' == $settings['navigation']) : ?>
				<?php $this->render_both_navigation($settings); ?>

				<?php if ( 'center' === $settings['both_position'] ) : ?>
					<?php $this->render_dotnavs($settings); ?>
				<?php endif; ?>

			<?php elseif ('arrows' == $settings['navigation']) : ?>
				<?php $this->render_navigation($settings); ?>
			<?php elseif ('dots' == $settings['navigation']) : ?>
				<?php $this->render_dotnavs($settings); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php
	}

	public function render_navigation($settings) {

		if (('both' == $settings['navigation']) and ('center' == $settings['both_position'])) {
			$arrows_position = 'center';
		} else {
			$arrows_position = $settings['arrows_position'];
		}

		?>
		<div class="avt-position-z-index avt-visible@m avt-position-<?php echo esc_attr($arrows_position); ?>">
			<div class="avt-arrows-container avt-slidenav-container">
				<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9" avt-slider-item="previous"></a>
				<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9" avt-slider-item="next"></a>
			</div>
		</div>
		<?php
	}

	public function render_dotnavs($settings) {

		if (('both' == $settings['navigation']) and ('center' == $settings['both_position'])) {
			$dots_position = 'bottom-center';
		} else {
			$dots_position = $settings['dots_position'];
		}

		?>
		<div class="avt-position-z-index avt-visible@m avt-position-<?php echo esc_attr($dots_position); ?>">
			<div class="avt-dotnav-wrapper avt-dots-container">
				<ul class="avt-dotnav avt-flex-center">

				    <?php		
					$avt_counter = 0;

					$this->query_posts();

					$wp_query = $this->get_query();

					while ( $wp_query->have_posts() ) : $wp_query->the_post();
					      
						echo '<li class="avt-slider-dotnav avt-active" avt-slider-item="'.$avt_counter.'"><a href="#"></a></li>';
						$avt_counter++;

					endwhile;
					wp_reset_postdata(); ?>

				</ul>
			</div>
		</div>
		<?php
	}

	public function render_both_navigation($settings) {
		?>
		<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="avt-arrows-dots-container avt-slidenav-container ">
				
				<div class="avt-flex avt-flex-middle">
					<div>
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9" avt-slider-item="previous"></a>						
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="avt-dotnav-wrapper avt-dots-container">
							<ul class="avt-dotnav">
							    <?php		
								$avt_counter = 0;

								$this->query_posts();

								$wp_query = $this->get_query();

								while ( $wp_query->have_posts() ) : $wp_query->the_post();								      
									echo '<li class="avt-slider-dotnav avt-active" avt-slider-item="'.$avt_counter.'"><a href="#"></a></li>';
									$avt_counter++;
								endwhile;
								wp_reset_postdata();
								
								?>
							</ul>
						</div>
					<?php endif; ?>
					
					<div>
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9" avt-slider-item="next"></a>						
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	public function render_image() {
		$settings = $this->get_settings();
		
		if( 'yes' != $settings['thumb'] ) {
			return;
		}

		$testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );		

		if ( ! $testimonial_thumb ) {
			$testimonial_thumb = AWP_ASSETS_URL.'images/member.svg';
		} else {
			$testimonial_thumb = $testimonial_thumb[0];
		}

		?>
		<div>
    		<div class="avt-testimonial-thumb">
				<img src="<?php echo esc_url( $testimonial_thumb ); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
			</div>
		</div>
		<?php
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'text_limit' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		do_shortcode(the_excerpt());		

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_meta($element_key) {
		$settings = $this->get_settings_for_display();
    	
    	$this->add_render_attribute( $element_key, 'class', ['avt-rating', 'avt-grid', 'avt-grid-collapse'] );
    	$this->add_render_attribute( $element_key, 'class', 'avt-rating-' . get_post_meta(get_the_ID(), 'avator_tm_rating', true) );
    	
    	if ( !$settings['thumb'] ) {
    		$this->add_render_attribute( $element_key, 'class', 'avt-flex-' . $settings['alignment'] );
    	}
    	  

        if ( $settings['title']  or $settings['company_name'] or $settings['rating']) : ?>
		    <div class="avt-testimonial-meta">
                <?php if ($settings['title']) : ?>
                    <div class="avt-testimonial-title"><?php echo get_the_title(); ?></div>
                <?php endif ?>

                <?php if ( $settings['company_name']) : ?>
                	<?php $separator = (( $settings['title'] ) and ( $settings['company_name'] )) ? ', ' : ''?>
                    <span class="avt-testimonial-address"><?php echo esc_attr( $separator ).get_post_meta(get_the_ID(), 'avator_tm_company_name', true); ?></span>
                <?php endif ?>
                
                <?php if ($settings['rating']) : ?>
                    <ul <?php echo $this->get_render_attribute_string( $element_key ); ?>>
						<li class="avt-rating-item"><span><i class="wipa-star-full" aria-hidden="true"></i></span></li>
						<li class="avt-rating-item"><span><i class="wipa-star-full" aria-hidden="true"></i></span></li>
						<li class="avt-rating-item"><span><i class="wipa-star-full" aria-hidden="true"></i></span></li>
						<li class="avt-rating-item"><span><i class="wipa-star-full" aria-hidden="true"></i></span></li>
						<li class="avt-rating-item"><span><i class="wipa-star-full" aria-hidden="true"></i></span></li>
	                </ul>
                <?php endif ?>

            </div>
        <?php endif;
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();
		$index = 1;

		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}
		
		$this->render_header('default', $id, $settings); ?>

			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

		  		<li class="avt-slider-item">
					<div class="avt-slider-item-inner">
						<?php if ('after' == $settings['meta_position']) : ?>
	                	<div class="avt-testimonial-text">
	                		<?php $this->render_excerpt(); ?>
	               		</div>
	               		<?php endif; ?>
	                	
	            		<div class="avt-flex avt-flex-center avt-flex-middle">

		                    <?php $this->render_image(); ?>

		                    <?php $this->render_meta('testmonial-meta-' . $index); ?>
	                    
	                	</div>

						<?php if ('before' == $settings['meta_position']) : ?>
	                	<div class="avt-testimonial-text">
	                		<?php $this->render_excerpt(); ?>
	               		</div>
	               		<?php endif; ?>
	               	</div>

                </li>

		  
				<?php 

                $index++;

			endwhile;	
			wp_reset_postdata();
			
		$this->render_footer($settings);
	}
}
