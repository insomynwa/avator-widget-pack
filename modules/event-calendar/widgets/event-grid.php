<?php
namespace WidgetPack\Modules\EventCalendar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Utils;

use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;
use WidgetPack\Modules\QueryControl\Module;

use WidgetPack\Modules\EventCalendar\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Post Slider
 */
class Event_Grid extends Widget_Base {
	public $_query = null;

	public function get_name() {
		return 'avt-event-grid';
	}

	public function get_title() {
		return AWP . __( 'Event Grid', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-event-calendar';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'event', 'carousel', 'calendar', 'grid' ];
	}

	public function get_style_depends() {
		return ['avt-event-calendar', 'widget-pack-font'];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Annal( $this ) );
	}

	// public function get_script_depends() {
	// 	return [ 'imagesloaded' ];
	// }

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'post';
		}

		return $element;
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
		return $element;
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
					'5' => '5',
					'6' => '6',
				],
			]
		);

		$this->add_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'small'    => esc_html__( 'Small', 'avator-widget-pack' ),
					'medium'   => esc_html__( 'Medium', 'avator-widget-pack' ),
					'large'    => esc_html__( 'Large', 'avator-widget-pack' ),
					'collapse' => esc_html__( 'Collapse', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Row Gap', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item, .avt-event-calendar .avt-event-item-inner' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-item-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-event-calendar .avt-event-item-inner',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-item-inner:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-item-inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-event-calendar .avt-event-item-inner:hover',
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
					'_skin!' => [ 'avt-event-grid-skin-annal' ],
				],
			]
		);

		$this->add_control(
			'item_hover_before_style_background',
			[
				'label'     => __( 'Hover Style', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-calendar .avt-event-item-inner:before' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin!' => [ 'avt-event-grid-skin-annal' ],
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-item-inner:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'_skin!' => [ 'avt-event-grid-skin-annal' ],
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-item-inner:hover .avt-event-image img' => 'opacity: {{SIZE}};',
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-intro, {{WRAPPER}} .avt-event-grid-skin-annal .avt-event-title-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'_skin!' => [ 'avt-event-grid-skin-annal' ],
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
					'_skin!' => [ 'avt-event-grid-skin-annal' ],
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
					'{{WRAPPER}} .avt-event-calendar .avt-event-meta .avt-address-website-icon a, {{WRAPPER}} .avt-event-grid-skin-annal .avt-event-meta .avt-more-icon a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-event-grid-skin-annal .avt-event-meta .avt-more-icon a' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-event-grid-skin-annal .avt-address-website-icon a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'address_website_icon_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-grid-skin-annal .avt-address-website-icon a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'address_website_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-event-grid-skin-annal .avt-address-website-icon a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_website_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-event-grid-skin-annal .avt-address-website-icon a',
			]
		);

		$this->add_responsive_control(
			'address_website_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-event-grid-skin-annal .avt-address-website-icon a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
		    			<a href="<?php echo esc_url($website); ?>" target="_blank" class="ep-earth" aria-hidden="true"></a>
			    	<?php endif; ?>
					
					<?php if ( $address ) : ?>
		    			<a href="#" avt-tooltip="<?php echo esc_html( tribe_get_full_address() ); ?>" class="ep-location" aria-hidden="true"></a>
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
		$id       = $this->get_id();

		$desktop_cols = $settings['columns'];
		$tablet_cols = $settings['columns_tablet'];
		$mobile_cols = $settings['columns_mobile'];


		?> 
		<div id="avt-event-<?php echo esc_attr($id); ?>" class="avt-event-grid avt-event-calendar">
	  		<div class="avt-grid avt-grid-<?php echo esc_attr($settings['column_gap']); ?> avt-child-width-1-<?php echo esc_attr($mobile_cols); ?> avt-child-width-1-<?php echo esc_attr($tablet_cols); ?>@s avt-child-width-1-<?php echo esc_attr($desktop_cols); ?>@l" avt-grid>

		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings();

					?>
				
			</div>
		</div>
		<?php
	}

	public function render_loop_item( $post ) {
		$settings = $this->get_settings();		

		?> 
		<div class="avt-event-grid-item">

			<div class="avt-event-item-inner">
			    
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
			
		</div>
		<?php
	}
}
