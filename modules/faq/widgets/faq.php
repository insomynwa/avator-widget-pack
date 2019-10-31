<?php
namespace WidgetPack\Modules\Faq\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\QueryControl\Module;
use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class FAQ extends Widget_Base {
	private $_query = null;


	public function get_name() {
		return 'avt-faq';
	}

	public function get_title() {
		return AWP . esc_html__( 'FAQ', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-faq';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'faq', 'accordion', 'tabs', 'toggle' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'faq';
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

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'collapsible',
			[
				'label'   => __( 'Collapsible All Item', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'multiple',
			[
				'label' => __( 'Multiple Open', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Show Icon', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
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
			'excerpt_length',
			[
				'label'     => __( 'Excerpt Length', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 50,
			]
		);
		
		$this->add_control(
			'show_read_more',
			[
				'label'   => __( 'Read More', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'active_item',
			[
				'label' => __( 'Active Item No', 'avator-widget-pack' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 20,
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

		

		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => widget_pack_get_category('faq_filter'),
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
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
			'section_content_button',
			[
				'label'     => esc_html__( 'Read More Button', 'avator-widget-pack' ),
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'more_button_button_text',
			[
				'label'       => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'faq_more_button_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'more_button_icon',
			]
		);

		$this->add_control(
			'more_button_icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left' => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'faq_more_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'more_button_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'faq_more_button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_item',
			[
				'label' => __( 'Item', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title'   => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_spacing',
			[
				'label' => __( 'Item Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-faq-item + .avt-faq-item' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_title',
			[
				'label' => __( 'Title', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-accordion .avt-accordion-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'title_shadow',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-faq-item .avt-accordion-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-accordion .avt-faq-item .avt-accordion-title',
			]
		);

		$this->add_control(
			'title_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-faq-item .avt-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-accordion-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_active',
			[
				'label' => __( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'active_title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-accordion .avt-faq-item.avt-open .avt-accordion-title',
			]
		);

		$this->add_control(
			'active_title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-faq-item.avt-open .avt-accordion-title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'active_title_shadow',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-faq-item.avt-open .avt-accordion-title',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'active_title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-accordion .avt-faq-item.avt-open .avt-accordion-title',
			]
		);

		$this->add_control(
			'active_title_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-faq-item.avt-open .avt-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'hover_title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-accordion .avt-faq-item .avt-accordion-title:hover',
			]
		);

		$this->add_control(
			'hover_title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-faq-item .avt-accordion-title:hover' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hover_title_shadow',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-faq-item .avt-accordion-title:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'hover_title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-accordion .avt-faq-item .avt-accordion-title:hover',
			]
		);

		$this->add_control(
			'hover_title_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-faq-item .avt-accordion-title:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label'     => __( 'Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Start', 'avator-widget-pack' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'End', 'avator-widget-pack' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'     => is_rtl() ? 'right' : 'left',
				'toggle'      => false,
				'label_block' => false,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title .avt-accordion-icon .fa:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-icon.avt-accordion-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-icon.avt-accordion-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_active',
			[
				'label' => __( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-faq-item.avt-open .avt-accordion-icon .fa:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-faq-item:hover .avt-accordion-icon .fa:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_content',
			[
				'label'     => __( 'Content', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'content_background_color',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .avt-accordion .avt-accordion-content',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-content' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_shadow',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-accordion-content',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'content_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-accordion .avt-accordion-content',
			]
		);

		$this->add_control(
			'content_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-accordion-content',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
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
					'{{WRAPPER}} .avt-wp-grid-filters-wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_filter',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-wp-grid-filters li',
			]
		);

		$this->add_control(
			'filter_spacing',
			[
				'label'     => esc_html__( 'Bottom Space', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wp-grid-filters-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .avt-wp-grid-filters li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_filter_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wp-grid-filters li' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-wp-grid-filters li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'desktop_filter_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wp-grid-filters li'
			]
		);

		$this->add_control(
			'desktop_filter_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wp-grid-filters li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_filter_shadow',
				'selector' => '{{WRAPPER}} .avt-wp-grid-filters li'
			]
		);

		$this->add_control(
			'filter_item_spacing',
			[
				'label'     => esc_html__( 'Space Between', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wp-grid-filters > li.avt-wp-grid-filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .avt-wp-grid-filters > li.avt-wp-grid-filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
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
					'{{WRAPPER}} .avt-wp-grid-filters li.avt-active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wp-grid-filters li.avt-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wp-grid-filters li.avt-active' => 'border-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-wp-grid-filters li.avt-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_active_filter_shadow',
				'selector' => '{{WRAPPER}} .avt-wp-grid-filters li.avt-active'
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

		$this->start_controls_section(
			'section_style_more_button',
			[
				'label'     => esc_html__( 'Read More Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_more_button_style' );

		$this->start_controls_tab(
			'tab_more_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'more_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'more_button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_more_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'more_button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'more_button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'more_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'more_button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'more_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'more_button_shadow',
				'selector' => '{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button',
			]
		);

		$this->add_control(
			'more_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'more_button_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button',
			]
		);

		$this->add_control(
			'more_button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_control(
			'more_button_spacing',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 35,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-faq .avt-faq-item .avt-faq-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		
	}

	public function query_posts() {
		$settings = $this->get_settings();

		$args = array(
			'post_type'      => 'faq',
			'posts_per_page' => $settings['limit'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish'
		);
		
		if ( 'by_name' === $settings['source'] and !empty($settings['post_categories']) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'faq_filter',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		}		

		$query = new \WP_Query( $args );

		return $query;
	}

	public function render_title() {
		$settings = $this->get_settings();
		$faq_icon = get_post_meta( get_the_ID(), 'avator_faq_icon', true);
		$faq_icon = (!empty($faq_icon)) ? $faq_icon : 'ep-question';

		?>
		<div class="avt-accordion-title">
			<?php if ( $settings['icon'] ) : ?>
				<span class="avt-accordion-icon avt-accordion-icon-<?php echo esc_attr( $settings['icon_align'] ); ?>" aria-hidden="true">
					<i class="avt-accordion-icon-closed <?php echo esc_attr($faq_icon); ?>"></i>
					<i class="avt-accordion-icon-opened ep-checkmark"></i>
				</span>
			<?php endif; ?>
			<?php echo esc_html(get_the_title()) ; ?>
		</div>
		<?php
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {
		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="avt-faq-excerpt">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_more_button_button($post) {
		$settings = $this->get_settings();
		$animation = ($settings['more_button_hover_animation']) ? ' elementor-animation-'.$settings['more_button_hover_animation'] : '';

		if ( ! isset( $settings['more_button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['more_button_icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['faq_more_button_icon'] );
		$is_new    = empty( $settings['more_button_icon'] ) && Icons_Manager::is_migration_allowed();


		if ('yes' == $settings['show_read_more']) : ?>
			<div class="avt-clearfix"></div>
			<a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="avt-faq-button<?php echo esc_attr($animation); ?>"><?php echo esc_html($settings['more_button_button_text']); ?>

				<?php if ($settings['faq_more_button_icon']['value']) : ?>
					<span class="avt-button-icon-align-<?php echo esc_attr($settings['more_button_icon_align']); ?>">

						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $settings['faq_more_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $settings['more_button_icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
				<?php endif; ?>

			</a>
		<?php endif;
	}

	public function render_filter_menu() {
		$settings       = $this->get_settings();
		$faq_categories = [];

		$wp_query = $this->query_posts();

		if ( 'by_name' === $settings['source'] and !empty($settings['faq_categories'] ) ) {
			$faq_categories = $settings['faq_categories'];
		} else {

			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$terms = get_the_terms( get_the_ID(), 'faq_filter' );
				if (is_array($terms)) {
					foreach ($terms as $term) {
						$faq_categories[] = esc_attr($term->slug);
					};
				}
			endwhile;

			$faq_categories = array_unique($faq_categories);

			wp_reset_postdata();

		}
		
		?>

		<div class="avt-wp-grid-filters-wrapper">
			
			<button class="avt-button avt-button-default avt-hidden@m" type="button"><?php esc_html_e( 'Filter', 'avator-widget-pack' ); ?></button>
			<div avt-dropdown="mode: click;" class="avt-dropdown avt-margin-remove-top avt-margin-remove-bottom">
			    <ul class="avt-nav avt-dropdown-nav">

					<li class="avt-wp-grid-filter avt-active" avt-filter-control><?php esc_html_e( 'All', 'avator-widget-pack' ); ?></li>
					
					<?php foreach($faq_categories as $faq_category => $value) : ?>
						<?php $filter_name = get_term_by('slug', $value, 'faq_filter'); ?>
						<li class="avt-wp-grid-filter" avt-filter-control="[data-filter*='avtf-<?php echo esc_attr(trim($value)); ?>']">
							<?php echo $filter_name->name; ?>
						</li>				
					<?php endforeach; ?>
			    
			    </ul>
			</div>


			<ul class="avt-wp-grid-filters avt-visible@m" avt-margin>
				<li class="avt-wp-grid-filter avt-active" avt-filter-control><?php esc_html_e( 'All', 'avator-widget-pack' ); ?></li>
		
				<?php foreach($faq_categories as $product_category => $value) : ?>
					<?php $filter_name = get_term_by('slug', $value, 'faq_filter'); ?>
					<li class="avt-wp-grid-filter" avt-filter-control="[data-filter*='avtf-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo $filter_name->name; ?>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
		<?php		
	}

	public function render_header($settings, $id) {

		$this->add_render_attribute(
			[
				'accordion-settings' => [
					'id'            => $id,
					'class'         => 'avt-accordion',
					'avt-accordion' => [
						wp_json_encode([
							"collapsible" => $settings["collapsible"] ? true : false,
							"multiple"    => $settings["multiple"] ? true : false,
							"transition"  => "ease-in-out",
							"active"      => ( "" !== $settings["active_item"] ) ? $settings["active_item"]-1 : false,
						]),
					],
				],
			]
		);

		$this->add_render_attribute('faq-wrapper', 'class', 'avt-faq-wrapper');
		
		if ( $settings['show_filter_bar'] ) {
			$this->add_render_attribute('faq-wrapper', 'avt-filter', 'target: #avt-accordion-' . $this->get_id());
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'faq-wrapper' ); ?>>

			<?php if ( $settings['show_filter_bar'] ) {
				$this->render_filter_menu();
			}

			?>
			<div class="avt-faq">
				<div <?php echo $this->get_render_attribute_string( 'accordion-settings' ); ?>>
		<?php
	}

	public function render_footer() {

		?>
				</div>
			</div>
		</div>

		<?php
	}

	public function render_post($settings) {
		global $post;
		$element_key = 'faq-item-' . $post->ID;
		$item_filters = get_the_terms( $post->ID, 'faq_filter' ); 

		$this->add_render_attribute($element_key, 'class', 'avt-faq-item');

		if( $settings['show_filter_bar'] and is_array($item_filters) ) {
			foreach ($item_filters as $item_filter) {
				$this->add_render_attribute($element_key, 'data-filter', 'avtf-' . $item_filter->slug);
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( $element_key ); ?>>				
			<?php $this->render_title(); ?>

			<div class="avt-accordion-content">
				<?php 
				$this->render_excerpt();
				$this->render_more_button_button($post);
				?>
			</div>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-accordion-' . $this->get_id();
		
		$wp_query = $this->query_posts();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->render_header($settings, $id);

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post($settings);
		}

		$this->render_footer();

		wp_reset_postdata();
	}
}
