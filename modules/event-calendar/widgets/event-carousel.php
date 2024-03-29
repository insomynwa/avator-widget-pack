<?php
namespace WidgetPack\Modules\EventCalendar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Utils;

use WidgetPack\Modules\EventCalendar\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Post Slider
 */
class Event_Carousel extends Widget_Base {
	public $_query = null;

	public function get_name() {
		return 'avt-event-carousel';
	}

	public function get_title() {
		return AWP . __( 'Event Carousel', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-event-calendar';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'event', 'carousel', 'calendar' ];
	}

	public function get_style_depends() {
		return ['wipa-event-calendar', 'widget-pack-font'];
	}

	public function get_script_depends() {
		return [ 'wipa-event-calendar' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/_ZPPBmKmGGg';
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Fable( $this ) );
	}

	public function get_query() {
		return $this->_query;
	}

	public function _register_controls() {

		// Layout Section
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
			]
		);

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
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'   => __( 'Show Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => __( 'Show Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		
		$this->add_control(
			'show_date',
			[
				'label'   => __( 'Show Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'   => __( 'Show Excerpt', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => __( 'Excerpt Length', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 15,
				'condition' => [
					'show_excerpt' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label'   => __( 'Show Meta', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_meta_cost',
			[
				'label'   => __( 'Show Cost', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_meta_website',
			[
				'label'   => __( 'Show Website', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_meta_location',
			[
				'label'   => __( 'Show Location', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_meta_more_btn',
			[
				'label'   => __( 'Show More Button', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_image',
			[
				'label' => __( 'Image', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'label'   => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'exclude' => [ 'custom' ],
				'default' => 'medium',
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => __( 'Image Width', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
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
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-image' => 'width: {{SIZE}}{{UNIT}};margin-left: auto;margin-right: auto;',
				],
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'image_ratio',
			[
				'label'   => __( 'Image Ratio', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.1,
						'max'  => 2,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-image'       => 'padding-bottom: calc( {{SIZE}} * 100% ); top: 0; left: 0; right: 0; bottom: 0;',
					'{{WRAPPER}} .avt-event-calendar .avt-event-image:after' => 'content: "{{SIZE}}"; position: absolute; color: transparent;',
					'{{WRAPPER}} .avt-event-calendar .avt-event-image img'   => 'height: 100%; width: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); font-size: {{SIZE}};',
				],
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_query',
			[
				'label' => __( 'Query', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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

		$this->add_control(
			'event_categories',
			[
				'label'       => esc_html__( 'Categories', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => widget_pack_get_category('tribe_events_cat'),
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);


		$this->add_control(
			'start_date',
			[
				'label'   => esc_html__( 'Start Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''           => esc_html__( 'Any Time', 'avator-widget-pack' ),
					'now'        => esc_html__( 'Now', 'avator-widget-pack' ),
					'today'      => esc_html__( 'Today', 'avator-widget-pack' ),
					'last month' => esc_html__( 'Last Month', 'avator-widget-pack' ),
					'custom'     => esc_html__( 'Custom', 'avator-widget-pack' ),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'custom_start_date',
			[
				'label'   => esc_html__( 'Custom Start Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::DATE_TIME,
				'condition' => [
					'start_date' => 'custom'
				]
			]
		);

		$this->add_control(
			'end_date',
			[
				'label'   => esc_html__( 'End Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''           => esc_html__( 'Any Time', 'avator-widget-pack' ),
					'now'        => esc_html__( 'Now', 'avator-widget-pack' ),
					'today'      => esc_html__( 'Today', 'avator-widget-pack' ),
					'next month' => esc_html__( 'Last Month', 'avator-widget-pack' ),
					'custom'     => esc_html__( 'Custom', 'avator-widget-pack' ),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'custom_end_date',
			[
				'label'   => esc_html__( 'Custom End Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::DATE_TIME,
				'condition' => [
					'end_date' => 'custom'
				]
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'event_date',
				'options' => [
					'event_date' => esc_html__( 'Event Date', 'avator-widget-pack' ),
					'title'      => esc_html__( 'Title', 'avator-widget-pack' ),
					'category'   => esc_html__( 'Category', 'avator-widget-pack' ),
					'rand'       => esc_html__( 'Random', 'avator-widget-pack' ),
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
			'section_content_navigation',
			[
				'label' => __( 'Navigation', 'avator-widget-pack' ),
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
				'render_type' => 'template',				
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
			'hide_arrows',
			[
				'label'     => __( 'Hide Arrows on Moblile ?', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'navigation' => ['arrows', 'both'],
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
			'section_carousel_settings',
			[
				'label' => __( 'Carousel Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => __( 'Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pauseonhover',
			[
				'label' => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'observer',
			[
				'label' => esc_html__( 'Observer', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => __( 'Loop', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => __( 'Animation Speed (ms)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 500,
				],
				'range' => [
					'px' => [
						'min'  => 1000,
						'max'  => 10000,
						'step' => 100,
					],
				],
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'section_style_item',
			[
				'label'     => __( 'Items', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('tabs_item_style');

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-event-calendar .avt-event-item',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-item:hover',
			]
		);

		$this->add_responsive_control(
			'item_shadow_padding',
			[
				'label'       => __( 'Match Padding', 'avator-widget-pack' ),
				'description' => __( 'You have to add padding for matching overlaping hover shadow', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					]
				],
				'default' => [
					'size' => 10
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container' => 'padding: {{SIZE}}{{UNIT}}; margin: 0 -{{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Content Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => [
					'_skin!' => [ 'fable' ],
				],
			]
		);

		$this->add_control(
			'item_hover_before_style_background',
			[
				'label'     => __( 'Hover Style', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item:before' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin!' => [ 'fable' ],
				],
			]
		);

		$this->add_control(
			'item_hover_before_style_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'_skin!' => [ 'fable' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => esc_html__( 'Image', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_image' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Image Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_opacity',
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'image_hover_opacity',
			[
				'label'   => __( 'Hover Opacity (%)', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-item:hover .avt-event-image img' => 'opacity: {{SIZE}};',
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-title-wrap',
			]
		);

		$this->add_control(
			'title_separator_color',
			[
				'label'     => esc_html__( 'Separator Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-intro .avt-event-title-wrap' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'_skin!' => 'fable',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-intro, {{WRAPPER}} .avt-event-carousel-skin-fable .avt-event-title-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_date',
			[
				'label'     => esc_html__( 'Date', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_date' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'day_color',
			[
				'label'     => esc_html__( 'Day Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-date a .avt-event-day' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'day_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-date a .avt-event-day',
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Month Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-date a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'_skin!' => [ 'fable' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'date_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-date',
				'condition' => [
					'_skin!' => [ 'fable' ],
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-excerpt',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_meta',
			[
				'label'     => esc_html__( 'Meta', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_meta' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-meta .avt-event-price a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_meta_cost' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'meta_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-meta .avt-address-website-icon a, {{WRAPPER}} .avt-event-carousel-skin-fable .avt-event-meta .avt-more-icon a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_meta_more_btn' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'meta_icon_border_color',
			[
				'label'     => esc_html__( 'Icon Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-carousel-skin-fable .avt-event-meta .avt-more-icon a' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'_skin!' => [ '' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-meta a',
			]
		);

		$this->add_responsive_control(
			'meta_padding',
			[
				'label'      => __( 'Meta Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'meta_border_top_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-meta' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_address_website',
			[
				'label'     => esc_html__( 'Address', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => [ '' ],
				],
			]
		);

		$this->add_control(
			'address_website_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-carousel-skin-fable .avt-address-website-icon a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'address_website_icon_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-carousel-skin-fable .avt-address-website-icon a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'address_website_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-carousel-skin-fable .avt-address-website-icon a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_website_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-event-carousel-skin-fable .avt-address-website-icon a',
			]
		);

		$this->add_responsive_control(
			'address_website_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-carousel-skin-fable .avt-address-website-icon a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev svg, {{WRAPPER}} .avt-event-calendar .avt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev, {{WRAPPER}} .avt-event-calendar .avt-navigation-next' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev:hover, {{WRAPPER}} .avt-event-calendar .avt-navigation-next:hover' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev svg, {{WRAPPER}} .avt-event-calendar .avt-navigation-next svg' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev:hover svg, {{WRAPPER}} .avt-event-calendar .avt-navigation-next:hover svg' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-next' => 'margin-left: {{SIZE}}px;',
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
				'label' => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev, {{WRAPPER}} .avt-event-calendar .avt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev, {{WRAPPER}} .avt-event-calendar .avt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-event-calendar .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_width',
			[
				'label' => __( 'Active Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-event-calendar .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-event-calendar .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-event-calendar .avt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-next' => 'right: {{SIZE}}px;',
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
					'{{WRAPPER}} .avt-event-calendar .avt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-event-calendar .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-event-calendar .avt-navigation-next' => 'right: {{SIZE}}px;',
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
					'{{WRAPPER}} .avt-event-calendar .avt-dots-container' => 'transform: translateY({{SIZE}}px);',
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

	public function render() {

		$settings = $this->get_settings_for_display();

		global $post;

		$start_date = ( 'custom' == $settings['start_date'] ) ? $settings['custom_start_date'] : $settings['start_date'];
		$end_date   = ( 'custom' == $settings['end_date'] ) ? $settings['custom_end_date'] : $settings['end_date'];

		$query_args = array_filter( [
			'start_date'     => $start_date,
			'end_date'       => $end_date,
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'eventDisplay' 	 => ( 'custom' == $settings['start_date'] or 'custom' == $settings['end_date'] ) ? 'custom' : 'all',
			'posts_per_page' => $settings['limit'],
			//'tag'          => 'donor-program', // or whatever the tag name is
		] );


		if ( 'by_name' === $settings['source'] and !empty($settings['event_categories']) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'tribe_events_cat',
				'field'    => 'slug',
				'terms'    => $settings['event_categories'],
			];
		}

		$query_args = tribe_get_events( $query_args );

		$this->render_header();

		foreach ( $query_args as $post ) {
			

			$this->render_loop_item( $post );
		}

		$this->render_footer();

		wp_reset_postdata();
	}

	public function render_image() {
		$settings = $this->get_settings();

		if ( ! $this->get_settings( 'show_image' ) ) {
			return;
		}

		$settings['image'] = [
			'id' => get_post_thumbnail_id(),
		];

		$image_html        = Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' );
		$placeholder_image_src = Utils::get_placeholder_image_src();

		if ( ! $image_html ) {
			$image_html = '<img src="' . esc_url( $placeholder_image_src ) . '" alt="' . get_the_title() . '">';
		}

		?>

		<div class="avt-event-image avt-background-cover">
			<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
				<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>" alt="<?php echo get_the_title(); ?>">
			</a>
		</div>
		<?php
	}

	public function render_title() {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		?>

		<h3 class="avt-event-title-wrap">
			<a href="<?php echo get_permalink() ?>" class="avt-event-title">
				<?php the_title() ?>
			</a>
		</h3>
		<?php
	}

	public function render_date() {
		if ( ! $this->get_settings( 'show_date' ) ) {
			return;
		}

		$start_datetime = tribe_get_start_date();
		$end_datetime = tribe_get_end_date();

		$event_day = tribe_get_start_date( null, false, 'j' );
		$event_month = tribe_get_start_date( null, false, 'M' );

		?>
		<span class="avt-event-date">
			<a href="#" title="<?php esc_html_e('Start Date:', 'avator-widget-pack'); echo esc_html($start_datetime); ?>  - <?php esc_html_e('End Date:', 'avator-widget-pack'); echo esc_html($end_datetime); ?>"> 
				<span class="avt-event-day">
					<?php echo esc_html($event_day); ?>
				</span>
				<span>
					<?php echo esc_html($event_month); ?>
				</span>
			</a>
		</span> 
		<?php
	}

	public function render_excerpt( $post ) {
		if ( ! $this->get_settings( 'show_excerpt' ) ) {
			return;
		}

		?>
		<div class="avt-event-excerpt">
			<?php 
				
				echo strip_shortcodes( wp_trim_words( $post->post_content, $this->get_settings( 'excerpt_length' ) ) );
				
			?>
		</div>
		<?php

	}

	public function render_meta() {
		$settings = $this->get_settings_for_display();
		if ( ! $this->get_settings( 'show_meta' ) ) {
			return;
		}

		$cost    = ($settings['show_meta_cost']) ? tribe_get_formatted_cost() : '';

		$address = ($settings['show_meta_location']) ? tribe_address_exists() : '';

		$website = ($settings['show_meta_website']) ? tribe_get_event_website_url() : '';
		

		?>

		<?php if ( !empty($cost) or $address or !empty( $website ) ) : ?>
		<div class="avt-event-meta avt-grid">

			<?php if (!empty($cost)) : ?>
			    <div class="avt-width-auto avt-padding-remove">
				    <div class="avt-event-price">
				    	<a href="#"><?php esc_html_e('Cost:', 'avator-widget-pack'); ?></a>
				    	<a href="#"><?php echo esc_html($cost); ?></a>
				    </div>
			    </div>
			<?php endif; ?>

			<?php if ( !empty($website) or $address ) : ?>
		    <div class="avt-width-expand avt-text-right">
			    <div class="avt-address-website-icon">

			    	<?php if (!empty($website)) : ?>
		    			<a href="<?php echo esc_url($website); ?>" target="_blank" class="wipa-earth" aria-hidden="true"></a>
			    	<?php endif; ?>
					
					<?php if ( $address ) : ?>
		    			<a href="#" avt-tooltip="<?php echo esc_html( tribe_get_full_address() ); ?>" class="wipa-location" aria-hidden="true"></a>
			    	<?php endif; ?>

			    </div>

			</div>
			<?php endif; ?>

		</div>
		<?php endif; ?>

		<?php
	}

	public function render_header() {
		$settings = $this->get_settings();
		
		$id       = 'avt-event-' . $this->get_id();

		$elementor_vp_lg = get_option( 'elementor_viewport_lg' );
		$elementor_vp_md = get_option( 'elementor_viewport_md' );
		$viewport_lg     = ! empty($elementor_vp_lg) ? $elementor_vp_lg - 1 : 1023;
		$viewport_md     = ! empty($elementor_vp_md) ? $elementor_vp_md - 1 : 767;

		$this->add_render_attribute( 'carousel', 'id', $id );
		$this->add_render_attribute( 'carousel', 'class', ['avt-event-carousel', 'avt-event-calendar'] );

		if ('arrows' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-arrows-align-'. $settings['arrows_position'] );
			
		}
		if ('dots' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-dots-align-'. $settings['dots_position'] );
		}
		if ('both' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-arrows-dots-align-'. $settings['both_position'] );
		}

		$this->add_render_attribute(
			[
				'carousel' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"autoplay"       => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"           => ($settings["loop"] == "yes") ? true : false,
							"speed"          => $settings["speed"]["size"],
							"pauseOnHover"   => ("yes" == $settings["pauseonhover"]) ? true : false,
							"slidesPerView"  => (int) $settings["columns"],
							"spaceBetween"   => $settings["item_gap"]["size"],
							"observer"       => ($settings["observer"]) ? true : false,
							"observeParents" => ($settings["observer"]) ? true : false,
							"breakpoints"    => [
								(int) $viewport_lg => [
									"slidesPerView" => (int) $settings["columns_tablet"],
									"spaceBetween"  => $settings["item_gap"]["size"],
								],
								(int) $viewport_md => [
									"slidesPerView" => (int) $settings["columns_mobile"],
									"spaceBetween"  => $settings["item_gap"]["size"],
								]
					      	],
			      	        "navigation" => [
			      				"nextEl" => "#" . $id . " .avt-navigation-next",
			      				"prevEl" => "#" . $id . " .avt-navigation-prev",
			      			],
			      			"pagination" => [
			      			  "el"         => "#" . $id . " .swiper-pagination",
			      			  "type"       => "bullets",
			      			  "clickable"  => true,
			      			],
				        ]))
					]
				]
			]
		);
		
		$this->add_render_attribute( 'event-carousel', 'class', 'swiper-container' );

		$this->add_render_attribute('event-carousel-wrapper', 'class', 'swiper-wrapper');

		?>
		<div <?php echo $this->get_render_attribute_string( 'carousel' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'event-carousel' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'event-carousel-wrapper' ); ?>>
		<?php
	}

	public function render_both_navigation() {
		$settings    = $this->get_settings();
		$hide_arrows = $settings['hide_arrows'] ? 'avt-visible@m' : '';
		?>

		<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="avt-arrows-dots-container avt-slidenav-container ">
				
				<div class="avt-flex avt-flex-middle">
					<div class="<?php echo esc_attr( $hide_arrows ); ?>">
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>	
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					
					<div class="<?php echo esc_attr( $hide_arrows ); ?>">
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>	
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	public function render_navigation() {
		$settings    = $this->get_settings();
		$hide_arrows = $settings['hide_arrows'] ? ' avt-visible@m' : '';
		
		if ( 'arrows' == $settings['navigation'] ) : ?>
			<div class="avt-position-z-index avt-position-<?php echo esc_attr( $settings['arrows_position'] . $hide_arrows ); ?>">
				<div class="avt-arrows-container avt-slidenav-container">
					<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>
					<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>
				</div>
			</div>
		<?php endif;
	}

	public function render_pagination() {
		$settings = $this->get_settings_for_display();
		
		if ( 'dots' == $settings['navigation'] ) : ?>
			<?php if ( 'arrows' !== $settings['navigation'] ) : ?>
				<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['dots_position']); ?>">
					<div class="avt-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				</div>
			<?php endif; 
		endif;
	}

	public function render_footer() {
		$settings = $this->get_settings();

				?>
				</div>
			</div>
			<?php if ('both' == $settings['navigation']) : ?>
				<?php $this->render_both_navigation(); ?>
				<?php if ('center' === $settings['both_position']) : ?>
					<div class="avt-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				<?php endif; ?>
			<?php else : ?>			
				<?php $this->render_pagination(); ?>
				<?php $this->render_navigation(); ?>
			<?php endif; ?>
		</div>
		<?php
	}

	public function render_loop_item( $post ) {
		$settings = $this->get_settings_for_display();		

		?> 
		<div class="avt-event-item swiper-slide">
			    
			<?php $this->render_image(); ?>

		    <div class="avt-event-content">
		        <div class="avt-event-intro">

		            <?php $this->render_date(); ?>

		            <?php $this->render_title(); ?>

		        </div>

	            <?php $this->render_excerpt( $post ); ?>

		    </div>

	        <?php $this->render_meta(); ?>
			
		</div>
		<?php
	}
}
