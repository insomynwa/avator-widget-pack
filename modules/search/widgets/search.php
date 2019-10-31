<?php
namespace WidgetPack\Modules\Search\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Search extends Widget_Base {

	public function get_name() {
		return 'avt-search';
	}

	public function get_title() {
		return AWP . esc_html__( 'Search', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-search';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'search', 'find' ];
	}

	public function get_script_depends() {
		return [ 'avt-search' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_search_layout',
			[
				'label' => esc_html__( 'Search Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'skin',
			[
				'label'   => esc_html__( 'Skin', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Default', 'avator-widget-pack' ),
					'dropbar'  => esc_html__( 'Dropbar', 'avator-widget-pack' ),
					'dropdown' => esc_html__( 'Dropdown', 'avator-widget-pack' ),
					'modal'    => esc_html__( 'Modal', 'avator-widget-pack' ),
				],
				'prefix_class' => 'elementor-search-form-skin-',
				'render_type'  => 'template',
			]
		); 

		$this->add_control(
			'search_query',
			[
				'label'       => esc_html__( 'Specific Post Type', 'avator-widget-pack' ),
				'description' => esc_html__( 'Select post type if you need to search only this post type content.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 0,
				'options'     => widget_pack_get_post_types(),
			]
		);

		$this->add_control(
			'placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [ 'active' => true ],
				'separator' => 'before',
				'default'   => esc_html__( 'Search', 'avator-widget-pack' ) . '...',
			]
		);

		$this->add_control(
			'search_icon',
			[
				'label'   => esc_html__( 'Search Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'search_icon_flip',
			[
				'label'     => esc_html__( 'Icon Flip', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => ['search_icon' => 'yes'],
			]
		);

		$this->add_control(
			'search_toggle_icon',
			[
				'label'       => esc_html__('Choose Toggle Icon', 'avator-widget-pack'),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'toggle_icon',
				'default' => [
					'value' => 'fas fa-search',
					'library' => 'fa-solid',
				],
				'condition'   => ['skin!' => 'default'],
			]
		);		

		$this->add_responsive_control(
			'search_align',
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
				'prefix_class' => 'elementor-align%s-',
			]
		);

		$this->add_control(
			'dropbar_position',
			[
				'label'   => esc_html__( 'Dropbar Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'bottom-left'    => esc_html('Bottom Left', 'avator-widget-pack'),
					'bottom-center'  => esc_html('Bottom Center', 'avator-widget-pack'),
					'bottom-right'   => esc_html('Bottom Right', 'avator-widget-pack'),
					'bottom-justify' => esc_html('Bottom Justify', 'avator-widget-pack'),
					'top-left'       => esc_html('Top Left', 'avator-widget-pack'),
					'top-center'     => esc_html('Top Center', 'avator-widget-pack'),
					'top-right'      => esc_html('Top Right', 'avator-widget-pack'),
					'top-justify'    => esc_html('Top Justify', 'avator-widget-pack'),
					'left-top'       => esc_html('Left Top', 'avator-widget-pack'),
					'left-center'    => esc_html('Left Center', 'avator-widget-pack'),
					'left-bottom'    => esc_html('Left Bottom', 'avator-widget-pack'),
					'right-top'      => esc_html('Right Top', 'avator-widget-pack'),
					'right-center'   => esc_html('Right Center', 'avator-widget-pack'),
					'right-bottom'   => esc_html('Right Bottom', 'avator-widget-pack'),
				],
				'condition' => [
					'skin' => [ 'dropbar', 'dropdown' ]
				],
			]
		);

		$this->add_control(
			'dropbar_offset',
			[
				'label' => esc_html__( 'Dropbar Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'skin' => ['dropbar', 'dropdown']
				],
			]
		);

		$this->add_responsive_control(
			'search_width',
			[
				'label' => esc_html__( 'Search Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 150,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-search-container .avt-search-default, 
					 {{WRAPPER}} .avt-search-container .avt-navbar-dropdown, 
					 {{WRAPPER}} .avt-search-container .avt-drop' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'skin!' => ['modal']
				],
			]
		);

		$this->add_control(
			'show_ajax_search',
			[
				'label'   => esc_html__( 'Ajax Search', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'skin' => ['default']
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_toggle_icon',
			[
				'label'     => esc_html__( 'Toggle Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin!' => 'default'
				]
			]
		);

		$this->add_control(
			'toggle_icon_size',
			[
				'label'     => esc_html__( 'Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-search-toggle' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_color',
			[
				'label'     => esc_html__('Color', 'avator-widget-pack'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-toggle' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-search-toggle svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_background',
			[
				'label'     => esc_html__('Background', 'avator-widget-pack'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-toggle' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'toggle_icon_padding',
			[
				'label'      => esc_html__('Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'toggle_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-search-toggle'
			]
		);

		$this->add_control(
			'toggle_icon_radius',
			[
				'label'      => esc_html__('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'toggle_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-search-toggle'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_layout_style',
			[
				'label' => esc_html__( 'Search Container', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'search_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-navbar-dropdown-close.avt-icon.avt-close svg' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin!' => 'default',
				],
			]
		);

		$this->add_control(
			'search_container_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-container .avt-search:not(.avt-search-navbar), 
					 {{WRAPPER}} .avt-search-container .avt-navbar-dropdown,
					 {{WRAPPER}} .avt-search-container .avt-drop' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_container_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search-container .avt-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_container_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search-container .avt-search:not(.avt-search-navbar), 
					 {{WRAPPER}} .avt-search-container .avt-navbar-dropdown,
					 {{WRAPPER}} .avt-search-container .avt-drop' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'search_container_shadow',
				'selector' => '{{WRAPPER}} .avt-search-container .avt-search:not(.avt-search-navbar), 
							   {{WRAPPER}} .avt-search-container .avt-navbar-dropdown,
					           {{WRAPPER}} .avt-search-container .avt-drop',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_style',
			[
				'label' => esc_html__( 'Input', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'selector' => '{{WRAPPER}} .avt-search-input, #modal-search-{{ID}} .avt-search-input',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'search_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-search .avt-search-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
				'condition' => [
					'skin' => 'default'
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search .avt-search-icon svg' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin' => 'default'
				]
			]
		);

		$this->add_control(
			'modal_search_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'#modal-search-{{ID}} .avt-search-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
				'condition' => [
					'skin' => 'modal'
				]
			]
		);

		$this->start_controls_tabs( 'tabs_input_colors' );

		$this->start_controls_tab(
			'tab_input_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'  => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-search-input,
					 #modal-search-{{ID}} .avt-search-icon svg' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'input_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-container .avt-search .avt-search-input' => 'background-color: {{VALUE}}',
					'#modal-search-{{ID}} .avt-search-container .avt-search .avt-search-input' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'skin!' => 'modal',
				],
			]
		);
		
		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-input::placeholder' => 'color: {{VALUE}}',
					'#modal-search-{{ID}} .avt-search-input::placeholder' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'input_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-input' => 'border-color: {{VALUE}}',
					'#modal-search-{{ID}} .avt-search-input' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'#modal-search-{{ID}} .avt-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'input_shadow',
				'selector'       => '{{WRAPPER}} .avt-search-input',
				'fields_options' => [
					'shadow_type' => [
						'separator' => 'default',
					],
				],
				'condition' => [
					'skin!' => 'modal',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus',
			[
				'label' => esc_html__( 'Focus', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'input_text_color_focus',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-input:focus' => 'color: {{VALUE}}',
					'#modal-search-{{ID}} .avt-search-input:focus' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'input_background_color_focus',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-input:focus' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'skin!' => 'modal',
				],
			]
		);

		$this->add_control(
			'input_border_color_focus',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-input:focus' => 'border-color: {{VALUE}}',
					'#modal-search-{{ID}} .avt-search-input:focus' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'input_shadow_focus',
				'selector'       => '{{WRAPPER}} .avt-search-input:focus',
				'fields_options' => [
					'shadow_type' => [
						'separator' => 'default',
					],
				],
				'condition' => [
					'skin!' => 'modal',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_border_width',
			[
				'label'     => esc_html__( 'Border Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .avt-search-input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'#modal-search-{{ID}} .avt-search-input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-search-input' => 'border-radius: {{SIZE}}{{UNIT}}',
					'#modal-search-{{ID}} .avt-search-input' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_search_ajax_style',
			[
				'label' => esc_html__( 'Ajax Search Dropdown', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'  => 'skin',
							'value' => 'default',
						],
						[
							'name'  => 'show_ajax_search',
							'value' => 'yes',
						],
					],
				],
			]
		);


		$this->add_control(
			'search_ajax_background_color',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-result' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'search_ajax_shadow',
				'selector'       => '{{WRAPPER}} .avt-search-result',
			]
		);

		
		$this->start_controls_tabs( 'tabs_search_ajax_style' );

		$this->start_controls_tab(
			'tab_search_ajax_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'search_ajax_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a .avt-search-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ajax_title_typography',
				'selector' => '{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a .avt-search-title',
			]
		);

		$this->add_control(
			'search_ajax_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a .avt-search-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ajax_text_typography',
				'selector' => '{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a .avt-search-text',
			]
		);

		$this->add_control(
			'search_ajax_item_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a' => 'background-color: {{VALUE}}',
				],
			]
		);
		

		$this->add_responsive_control(
			'search_ajax_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'search_ajax_item_shadow',
				'selector'       => '{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_search_ajax_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'search_ajax_title_hover_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a:hover .avt-search-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_ajax_text_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a:hover .avt-search-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_ajax_item_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'search_ajax_item_hover_shadow',
				'selector'       => '{{WRAPPER}} .avt-search-result .avt-nav .avt-search-item a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'search_ajax_loader_background_color',
			[
				'label'     => esc_html__( 'Search Loader Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search.avt-search-loading:after' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);


		$this->end_controls_section();

	}

	public function render() {
		$settings    = $this->get_settings();
		$current_url = remove_query_arg( 'fake_arg' );
		$id          = $this->get_id();

		?>
		<div class="avt-search-container">
			<?php $this->search_form($settings); ?>
		</div>
		<?php		
	}

	public function search_form($settings) {
		$current_url = remove_query_arg( 'fake_arg' );
		$id          = $this->get_id();

		$search            = [];
		$attrs['class']    = array_merge(['avt-search'], isset($attrs['class']) ? (array) $attrs['class'] : []);
		$search['class']   = [];
		$search['class'][] = 'avt-search-input';

		$this->add_render_attribute(
			'input', [
				'placeholder' => $settings['placeholder'],
				'class'       => 'avt-search-input',
				'type'        => 'search',
				'name'        => 's',
				'title'       => esc_html__( 'Search', 'avator-widget-pack' ),
				'value'       => get_search_query(),
			]
		);
		
		$this->add_render_attribute( 'search', 'class', 'avt-search' );
		$this->add_render_attribute( 'search', 'role', 'search' );
		$this->add_render_attribute( 'search', 'method', 'get' );
		$this->add_render_attribute( 'search', 'action', esc_url( home_url( '/' ) ) );

		if ($settings['show_ajax_search']) {
			$this->add_render_attribute( 'input', 'onkeyup', 'widgetPackAjaxSearch(this.value)' );
			$this->add_render_attribute( 'search', 'class', 'avt-ajax-search' );
		}

		if ('default' === $settings['skin']) : ?>
			
			<?php $this->add_render_attribute( 'search', 'class', 'avt-search-default' ); ?>

			<form <?php echo $this->get_render_attribute_string('search'); ?>>
				<div class="avt-position-relative">
					<?php $this->search_icon($settings); ?>
					<input <?php echo $this->get_render_attribute_string('input'); ?>>
				</div>
				
				<?php if ($settings['search_query']) : ?>
				<input name="post_type" type="hidden" value="<?php echo $settings['search_query']; ?>">
				<?php endif; ?>
				
				<?php if ($settings['show_ajax_search']) : ?>
				<div class="avt-search-result">
					
				</div>
				<?php endif; ?>
			</form>

		<?php elseif ('dropbar' === $settings['skin']) :

			$this->add_render_attribute(
				[
					'dropbar' => [
						'avt-drop' => [
							wp_json_encode(array_filter([
							    "mode"           => "click",
							    "boundary"       => false,
							    "pos"            => ($settings["dropbar_position"]) ? $settings["dropbar_position"] : "left-center",
							    "flip"           => "x",
							    "offset"         => $settings["dropbar_offset"]["size"],								
					        ]))
						],
						'class' => 'avt-drop',
					]
				]
			);

			$this->add_render_attribute( 'search', 'class', 'avt-search-navbar avt-width-1-1' );
			
			?>

			<?php $this->render_toggle_icon( $settings ); ?>
	        <div <?php echo $this->get_render_attribute_string('dropbar'); ?>>
	            <form <?php echo $this->get_render_attribute_string('search'); ?>>
	            	<div class="avt-position-relative">
	            		<?php $this->add_render_attribute( 'input', 'class', 'avt-padding-small' ); ?>
		                <input <?php echo $this->get_render_attribute_string('input'); ?> autofocus>
		            </div>

		            <?php if ($settings['search_query']) : ?>
		            <input name="post_type" type="hidden" value="<?php echo $settings['search_query']; ?>">
		            <?php endif; ?>
	            </form>
	        </div>

	    <?php elseif ('dropdown' === $settings['skin']) :

	    	$this->add_render_attribute(
	    		[
	    			'dropdown' => [
	    				'avt-drop' => [
	    					wp_json_encode(array_filter([
	    					    "mode"     => "click",
								"boundary" => false,
								"pos"      => ($settings["dropbar_position"]) ? $settings["dropbar_position"] : "bottom-right",
								"flip"     => "x",
								"offset"   => $settings["dropbar_offset"]["size"],				
	    			        ]))
	    				],
	    				'class' => 'avt-navbar-dropdown',
	    			]
	    		]
	    	);

			$this->add_render_attribute( 'search', 'class', 'avt-search-navbar avt-width-1-1' );


	    	?>
			<?php $this->render_toggle_icon( $settings ); ?>
			
            <div <?php echo $this->get_render_attribute_string('dropdown'); ?>>

                <div class="avt-grid-small avt-flex-middle" avt-grid>
                    <div class="avt-width-expand">
                        <form <?php echo $this->get_render_attribute_string('search'); ?>>
                        	<div class="avt-position-relative">
                        		<?php $this->add_render_attribute( 'input', 'class', 'avt-padding-small' ); ?>
	                            <input <?php echo $this->get_render_attribute_string('input'); ?> autofocus>
	                        </div>

	                        <?php if ($settings['search_query']) : ?>
	                        <input name="post_type" type="hidden" value="<?php echo $settings['search_query']; ?>">
	                        <?php endif; ?>
                        </form>
                    </div>
                    <div class="avt-width-auto">
                        <a class="avt-navbar-dropdown-close" href="#" avt-close></a>
                    </div>
                </div>

            </div>

        <?php elseif ('modal' === $settings['skin']) : 


			$this->add_render_attribute( 'search', 'class', 'avt-search-large' );
        	?>
			
			<?php $this->render_toggle_icon( $settings ); ?>

			<div id="modal-search-<?php echo esc_attr($id); ?>" class="avt-modal-full avt-modal" avt-modal>
			    <div class="avt-modal-dialog avt-flex avt-flex-center avt-flex-middle" avt-height-viewport>
			        <button class="avt-modal-close-full" type="button" avt-close></button>
			        <form <?php echo $this->get_render_attribute_string('search'); ?>>
						<div class="avt-position-relative">	
							<?php $this->add_render_attribute('input', ['class' => 'avt-text-center']); ?>
			            	<?php $this->search_icon($settings); ?>
			                <input <?php echo $this->get_render_attribute_string('input'); ?> autofocus>
			            </div>

			            <?php if ($settings['search_query']) : ?>
			            <input name="post_type" type="hidden" value="<?php echo $settings['search_query']; ?>">
			            <?php endif; ?>
			        </form>
			    </div>
			</div>
		<?php endif;
	}

	private function search_icon($settings) {
		$icon_class = ( $settings['search_icon_flip'] ) ? 'avt-search-icon-flip' : '';

		if ( $settings['search_icon'] ) :
			echo '<span class="' . esc_attr($icon_class) . '" avt-search-icon></span>';
		endif;
	}

	private function render_toggle_icon($settings) {
		$id                = $this->get_id();

		$this->add_render_attribute( 'toggle-icon', 'class', 'avt-search-toggle' );

		if ('modal' === $settings['skin']) {
			$this->add_render_attribute( 'toggle-icon', 'avt-toggle' );
			$this->add_render_attribute( 'toggle-icon', 'href', '#modal-search-' . esc_attr($id) );
		} else {
			$this->add_render_attribute( 'toggle-icon', 'href', '#' );
		}

		if ( ! isset( $settings['toggle_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['toggle_icon'] = 'fas fa-search';
		}

		$migrated  = isset( $settings['__fa4_migrated']['search_toggle_icon'] );
		$is_new    = empty( $settings['toggle_icon'] ) && Icons_Manager::is_migration_allowed();

		?>

		<a  <?php echo $this->get_render_attribute_string( 'toggle-icon' ); ?>>

			<?php if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['search_toggle_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
				else : ?>
					<i class="<?php echo esc_attr( $settings['toggle_icon'] ); ?>" aria-hidden="true"></i>
			<?php endif; ?>
				
		</a>
		<?php

	}
}