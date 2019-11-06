<?php
namespace WidgetPack\Modules\TestimonialGrid\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Testimonial_Grid extends Widget_Base {

	public function get_name() {
		return 'avt-testimonial-grid';
	}

	public function get_title() {
		return AWP . esc_html__( 'Testimonial Grid', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-testimonial-grid';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'grid' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font', 'wipa-testimonial-grid' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'tilt' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/pYMTXyDn8g4';
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Default', 'avator-widget-pack' ),
					'2' => esc_html__( 'Top Avatar', 'avator-widget-pack' ),
					'3' => esc_html__( 'Reverse', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'posts',
			[
				'label'   => esc_html__( 'Posts Per Page', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
			]
		);

		// $this->add_control(
		// 	'show_pagination',
		// 	[
		// 		'label' => esc_html__( 'Pagination', 'avator-widget-pack' ),
		// 		'type'  => Controls_Manager::SWITCHER,
		// 	]
		// );

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid > .avt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .avt-testimonial-grid > .avt-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid > .avt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .avt-testimonial-grid > .avt-grid > *' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'   => esc_html__( 'Testimonial Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_address',
			[
				'label'   => esc_html__( 'Address', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'   => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'text_limit',
			[
				'label'     => esc_html__( 'Text Limit', 'avator-widget-pack' ),
				'description' => 'Its just work for text , but not working excerpt.',
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'   => esc_html__( 'Rating', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_filter_bar',
			[
				'label' => esc_html__( 'Filter Bar', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'item_match_height',
			[
				'label' => esc_html__( 'Item Match Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'item_masonry',
			[
				'label' => esc_html__( 'Masonry', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
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
			'section_style_item',
			[
				'label' => esc_html__( 'Item', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-item-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-item-inner',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-item-inner',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-item-inner:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-item-inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-item-inner:hover',
			]
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => esc_html__( 'Image', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-img-wrapper',
				'separator'   => 'before',
			]
		);
		
		$this->add_control(
			'image_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'image_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-img-wrapper:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-img-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-img-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_address',
			[
				'label'     => esc_html__( 'Address', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_address' => 'yes',
				],
			]
		);

		$this->add_control(
			'address_color',
			[
				'label'     => esc_html__( 'Company Name/Address Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-address' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'address_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-address' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-address',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label'     => esc_html__( 'Text', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-testimonial-grid .avt-testimonial-grid-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_rating',
			[
				'label'     => esc_html__( 'Rating', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
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
					'{{WRAPPER}} .avt-testimonial-grid .avt-rating .avt-rating-item' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => esc_html__( 'Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-rating.avt-rating-1 .avt-rating-item:nth-child(1)'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-grid .avt-rating.avt-rating-2 .avt-rating-item:nth-child(-n+2)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-grid .avt-rating.avt-rating-3 .avt-rating-item:nth-child(-n+3)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-grid .avt-rating.avt-rating-4 .avt-rating-item:nth-child(-n+4)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-testimonial-grid .avt-rating.avt-rating-5 .avt-rating-item:nth-child(-n+5)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-testimonial-grid .avt-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_filter',
			[
				'label'     => esc_html__( 'Filter Bar', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter_bar' => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_alignment',
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
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters-wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_filter',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li',
			]
		);

		$this->add_control(
			'filter_spacing',
			[
				'label'     => esc_html__( 'Bottom Space', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_style_desktop' );

		$this->start_controls_tab(
			'filter_tab_desktop',
			[
				'label' => __( 'Desktop', 'avator-widget-pack' )
			]
		);

		$this->add_control(
			'desktop_filter_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_filter_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_filter_padding',
			[
				'label'      => __('Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'desktop_filter_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wipa-grid-filters li'
			]
		);

		$this->add_control(
			'desktop_filter_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_filter_shadow',
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li'
			]
		);

		$this->add_control(
			'filter_item_spacing',
			[
				'label'     => esc_html__( 'Space Between', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters > li.avt-wipa-grid-filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .avt-wipa-grid-filters > li.avt-wipa-grid-filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_control(
			'desktop_filter_active',
			[
				'label' => esc_html__( 'Active', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter_active',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_active_filter_shadow',
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li.avt-active'
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'filter_tab_mobile',
			[
				'label' => __( 'Mobile', 'avator-widget-pack' )
			]
		);

		$this->add_control(
			'filter_mbtn_width',
			[
				'label' => __('Button Width(%)', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 100
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'width: {{SIZE}}%;'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_color',
			[
				'label'     => __( 'Button Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_background',
			[
				'label'     => __( 'Button Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropdown-nav li' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_background',
			[
				'label'     => __( 'Dropdown Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropdown' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filter_mbtn_dropdown_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-dropdown-nav li',
			]
		);

		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_image( $image_id ) {
		$settings = $this->get_settings();
		
		if( ! $settings['show_image'] ) {
			return;
		}

		$testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $image_id ), 'medium' );

		?>
		<div>
			<div class="avt-testimonial-grid-img-wrapper avt-overflow-hidden avt-border-circle avt-background-cover">
				<img src="<?php echo esc_url($testimonial_thumb[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
			</div>
		</div>
		<?php
	}

	public function render_title( $post_id ) {
		$settings = $this->get_settings();

		if( ! $settings['show_title'] ) {
			return;
		}

		?>
		<h4 class="avt-testimonial-grid-title avt-margin-remove-bottom"><?php echo esc_attr(get_the_title( $post_id )); ?></h4>
		<?php
	}

	public function render_address( $post_id ) {
		$settings = $this->get_settings();

		if( ! $settings['show_address'] ) {
			return;
		}

		?>
        <p class="avt-testimonial-grid-address avt-text-meta avt-margin-remove">
        	<?php echo get_post_meta( $post_id, 'avator_tm_company_name', true ); ?>
    	</p>
		<?php
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'text_limit' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {

		if ( ! $this->get_settings( 'show_text' ) ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="avt-testimonial-grid-text">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_rating( $post_id ) {
		$settings = $this->get_settings();

		if( ! $settings['show_rating'] ) {
			return;
		}

		?>
		<div class="avt-testimonial-grid-rating">
			<ul class="avt-rating avt-rating-<?php echo get_post_meta( $post_id, 'avator_tm_rating', true ); ?> avt-grid avt-grid-collapse" avt-grid>
				<li class="avt-rating-item"><i class="wipa-star-full" aria-hidden="true"></i></li>
				<li class="avt-rating-item"><i class="wipa-star-full" aria-hidden="true"></i></li>
				<li class="avt-rating-item"><i class="wipa-star-full" aria-hidden="true"></i></li>
				<li class="avt-rating-item"><i class="wipa-star-full" aria-hidden="true"></i></li>
				<li class="avt-rating-item"><i class="wipa-star-full" aria-hidden="true"></i></li>
			</ul>
		</div>
		<?php
	}

	public function render_filter_menu() {
		$settings         = $this->get_settings();
		$testi_categories = [];
		$wp_query         = $this->render_query();

		if ( 'by_name' === $settings['source'] and ! empty($settings['post_categories'] ) ) {
			$testi_categories = $settings['post_categories'];
		} else {

			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$terms = get_the_terms( get_the_ID(), 'testimonial_categories' );
				foreach ($terms as $term) {
					$testi_categories[] = esc_attr($term->slug);
				};
			endwhile;

			$testi_categories = array_unique($testi_categories);

			wp_reset_postdata();

		}
		
		?>

		<div class="avt-wipa-grid-filters-wrapper">
			
			<button class="avt-button avt-button-default avt-hidden@m" type="button"><?php esc_html_e( 'Filter', 'avator-widget-pack' ); ?></button>
			<div avt-dropdown="mode: click;" class="avt-dropdown avt-margin-remove-top avt-margin-remove-bottom">
			    <ul class="avt-nav avt-dropdown-nav">

					<li class="avt-wipa-grid-filter avt-active" avt-filter-control><?php esc_html_e( 'All', 'avator-widget-pack' ); ?></li>
					
					<?php foreach($testi_categories as $testi_category => $value) : ?>
						<?php $filter_name = get_term_by('slug', $value, 'testimonial_categories'); ?>
						<li class="avt-wipa-grid-filter" avt-filter-control="[data-filter*='avtf-<?php echo esc_attr(trim($value)); ?>']">
							<?php echo esc_html($filter_name->name); ?>
						</li>				
					<?php endforeach; ?>
			    
			    </ul>
			</div>


			<ul class="avt-wipa-grid-filters avt-visible@m" avt-margin>
				<li class="avt-wipa-grid-filter avt-active" avt-filter-control><?php esc_html_e( 'All', 'avator-widget-pack' ); ?></li>
		
				<?php foreach($testi_categories as $product_category => $value) : ?>
					<?php $filter_name = get_term_by('slug', $value, 'testimonial_categories'); ?>
					<li class="avt-wipa-grid-filter" avt-filter-control="[data-filter*='avtf-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo esc_html($filter_name->name); ?>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
		<?php		
	}

	public function render_header() {
		$settings = $this->get_settings();

		$this->add_render_attribute('testimonial-grid-wrapper', 'class', ['avt-testimonial-grid-layout-'.$settings['layout'], 'avt-testimonial-grid', 'avt-wipa-grid-filter-container']);

		$this->add_render_attribute('testimonial-grid', 'avt-grid', '');
		$this->add_render_attribute('testimonial-grid', 'class', 'avt-grid');

		if ( $settings['show_filter_bar'] ) {
			$this->add_render_attribute('testimonial-grid-wrapper', 'avt-filter', 'target: #avt-testimonial-grid-' . $this->get_id());
		}

		if ( $settings['item_match_height'] ) {
			$this->add_render_attribute('testimonial-grid', 'avt-height-match', 'div > .avt-testimonial-grid-item-inner');
		}

		if ( $settings['item_masonry'] ) {
			$this->add_render_attribute('testimonial-grid', 'avt-grid', 'masonry: true;');
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'testimonial-grid-wrapper' ); ?>>
	
		<?php if ( $settings['show_filter_bar'] ) {
			$this->render_filter_menu();
		}

		?>
		<div id="avt-testimonial-grid-<?php echo $this->get_id(); ?>" <?php echo $this->get_render_attribute_string( 'testimonial-grid' ); ?>>
		<?php
	}

	public function render_footer() {
				?>
			</div>
		</div>
		<?php
	}

	public function render_query() {
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

		$wp_query = new \WP_Query($args);

		return $wp_query;
	}

	public function render_loop_item() {
		$settings = $this->get_settings();
		$wp_query = $this->render_query();

		if($wp_query->have_posts()) {			

			$this->add_render_attribute('testimonial-grid-item', 'class', 'avt-testimonial-grid-item');
			$this->add_render_attribute('testimonial-grid-item', 'class', 'avt-width-1-'. $settings['columns_mobile']);
			$this->add_render_attribute('testimonial-grid-item', 'class', 'avt-width-1-'. $settings['columns_tablet'] .'@s');
			$this->add_render_attribute('testimonial-grid-item', 'class', 'avt-width-1-'. $settings['columns'] .'@m');

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

				<?php 

				if( $settings['show_filter_bar'] ) {
					$item_filters = get_the_terms( get_the_ID(), 'testimonial_categories' ); 
	    			foreach ($item_filters as $item_filter) {
	    				$this->add_render_attribute('testimonial-grid-item', 'data-filter', 'avtf-' . $item_filter->slug, true);
	    			}
	    		}
	    		?>

		  		<div <?php echo $this->get_render_attribute_string( 'testimonial-grid-item' ); ?>>
	  				<?php if ('1' == $settings['layout']) : ?>
			  			<div class="avt-testimonial-grid-item-inner">
				  			<div class="avt-grid avt-position-relative avt-grid-small avt-flex-middle" avt-grid>
				               <?php $this->render_image( get_the_ID() ); ?>
			               		<?php if ( $settings['show_title'] || $settings['show_address'] ) : ?>
				           			<div class="avt-testimonial-grid-title-address">
						               <?php
						               $this->render_title( get_the_ID() );
						               $this->render_address( get_the_ID() );
						              
						              if ($settings['show_rating']) : ?>
					               			<?php if ('3' <= $settings['columns']) : ?>
						           				<?php $this->render_rating( get_the_ID() ); ?>
						                	<?php endif; ?>
					                	
					               			<?php if ('2' >= $settings['columns']) : ?>
									           	<div class="avt-position-center-right">
								           			<?php $this->render_rating( get_the_ID() ); ?>
									           	</div>
						                	<?php endif; ?>
				                		<?php endif; ?>

						           	</div>
			                	<?php endif; ?>
			            	</div>
			          		<?php $this->render_excerpt(); ?>
						</div>
					<?php endif; ?>

					<?php if ('2' == $settings['layout']) : ?>
			  			<div class="avt-testimonial-grid-item-inner avt-position-relative avt-text-center">
			               <div class=""><?php $this->render_image( get_the_ID() ); ?></div>
		               		<?php if ( $settings['show_title'] || $settings['show_address'] ) : ?>
			           			<div class="avt-testimonial-grid-title-address">
					               <?php
					               $this->render_title( get_the_ID() );
					               $this->render_address( get_the_ID() );
					               ?>
					           	</div>
		                	<?php endif; ?>			          
		          			<?php $this->render_excerpt(); ?>
		           			<?php $this->render_rating( get_the_ID() ); ?>			            
						</div>
					<?php endif; ?>

					<?php if ('3' == $settings['layout']) : ?>
			  			<div class="avt-testimonial-grid-item-inner">
			          		<?php $this->render_excerpt(); ?>
				  			<div class="avt-grid avt-position-relative avt-grid-small avt-flex-middle" avt-grid>
				               <?php $this->render_image( get_the_ID() ); ?>
			               		<?php if ( $settings['show_title'] || $settings['show_address'] ) : ?>
				           			<div class="avt-testimonial-grid-title-address">
						               <?php
						               $this->render_title( get_the_ID() );
						               $this->render_address( get_the_ID() );
						               
						               if ($settings['show_rating']) : ?>
					               			<?php if ('3' <= $settings['columns']) : ?>
						           				<?php $this->render_rating( get_the_ID() ); ?>
						                	<?php endif; ?>

					               			<?php if ('2' >= $settings['columns']) : ?>
									           	<div class="avt-position-center-right">
								           			<?php $this->render_rating( get_the_ID() ); ?>
									           	</div>
						                	<?php endif; ?>
					                	<?php endif; ?>

						           	</div>
			                	<?php endif; ?>
			            	</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endwhile;

			// if ($settings['show_pagination']) {
			// 	widget_pack_post_pagination($wp_query);
			// }

			wp_reset_postdata();

		} else {
			echo '<div class="avt-alert-warning" avt-alert>Oppps!! There is no post, please select actual post or categories.<div>';
		}
	}

	public function render() {
		$this->render_header();
		$this->render_loop_item();
		$this->render_footer();
	}
}
