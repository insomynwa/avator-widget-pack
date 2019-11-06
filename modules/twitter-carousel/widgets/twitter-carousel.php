<?php
namespace WidgetPack\Modules\TwitterCarousel\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;

use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;
use WidgetPack\Modules\QueryControl\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Twitter_Carousel extends Widget_Base {

	private $_query = null;

	public function get_name() {
		return 'avt-twitter-carousel';
	}

	public function get_title() {
		return AWP . __( 'Twitter Carousel', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-twitter-carousel';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'twitter', 'carousel' ];
	}

	public function get_style_depends() {
		return [ 'wipa-twitter-carousel' ];
	}

	public function get_script_depends() {
		return [ 'avt-uikit-icons', 'wipa-twitter-carousel' ];
	}

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

	public function get_custom_help_url() {
		return 'https://youtu.be/IrQVteaaAow';
	}

	protected function _register_controls() {
		$this->register_query_section_controls();
	}

	private function register_query_section_controls() {

		$this->start_controls_section(
			'section_carousel_layout',
			[
				'label' => __( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => __( 'Columns', 'avator-widget-pack' ),
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
			'num_tweets',
			[
				'label'   => __( 'Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'cache_time',
			[
				'label'   => __( 'Cache Time(m)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 60,
			]
		);

		$this->add_control(
			'show_avatar',
			[
				'label' => __( 'Show Avatar', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'avatar_link',
			[
				'label'     => __( 'Avatar Link', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'show_avatar' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_time',
			[
				'label'   => __( 'Show Time', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'long_time_format',
			[
				'label'     => __( 'Long Time Format', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'show_time' => 'yes',
				]
			]
		);


		$this->add_control(
			'show_meta_button',
			[
				'label'   => __( 'Execute Buttons', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'exclude_replies',
			[
				'label' => __( 'Exclude Replies', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
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

		$this->add_control(
			'hide_arrow_on_mobile',
			[
				'label'     => __( 'Hide Arrow on Mobile ?', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
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
			'match_height',
			[
				'label'   => __( 'Item Match Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				
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
				'label'     => esc_html__( 'Autoplay Speed', 'avator-widget-pack' ),
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
					'min'  => 100,
					'max'  => 5000,
					'step' => 50,
				],
			]
		);

		$this->add_control(
			'observer',
			[
				'label'       => __( 'Observer', 'avator-widget-pack' ),
				'description' => __( 'When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,				
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_layout',
			[
				'label' => __( 'Items', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item .avt-twitter-text,
					{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item .avt-twitter-text *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_align',
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
					'{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item .avt-card-body' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_gap',
			[
				'label'   => __( 'Item Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '40',
					'bottom' => '40',
					'left'   => '40',
					'right'  => '40',
					'unit'   => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'shadow_mode',
			[
				'label'        => esc_html__( 'Shadow Mode', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-wipa-shadow-mode-',
			]
		);

		$this->add_control(
			'shadow_color',
			[
				'label'     => esc_html__( 'Shadow Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'shadow_mode' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container:before' => 'background: linear-gradient(to right, {{VALUE}} 5%,rgba(255,255,255,0) 100%);',
					'{{WRAPPER}} .elementor-widget-container:after'  => 'background: linear-gradient(to right, rgba(255,255,255,0) 0%, {{VALUE}} 95%);',
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
					'{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-twitter-carousel .avt-carousel-item:hover',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_avatar',
			[
				'label'     => __( 'Avatar', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_control(
			'avatar_width',
			[
				'label' => __( 'Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 48,
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-thumb-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'avatar_align',
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
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-thumb' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'avatar_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-thumb-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-thumb-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-thumb-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-thumb-wrapper, {{WRAPPER}} .avt-twitter-carousel .avt-twitter-thumb-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'avatar_opacity',
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
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-thumb-wrapper img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
		

		$this->start_controls_section(
			'section_style_meta',
			[
				'label'     => __( 'Execute Buttons', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_meta_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-meta-button > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_hover_color',
			[
				'label'     => __( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-meta-button > a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_time',
			[
				'label'     => __( 'Time', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_time' => 'yes',
				],
			]
		);

		$this->add_control(
			'time_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-meta-wrapper a.avt-twitter-time-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'time_hover_color',
			[
				'label'     => __( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-twitter-carousel .avt-twitter-meta-wrapper a.avt-twitter-time-link:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev svg,
					{{WRAPPER}} .avt-carousel .avt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev,
					{{WRAPPER}} .avt-carousel .avt-navigation-next' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev:hover,
					{{WRAPPER}} .avt-carousel .avt-navigation-next:hover' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev svg,
					{{WRAPPER}} .avt-carousel .avt-navigation-next svg' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev:hover svg,
					{{WRAPPER}} .avt-carousel .avt-navigation-next:hover svg' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .avt-carousel .avt-navigation-next' => 'margin-left: {{SIZE}}px;',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev, {{WRAPPER}} .avt-carousel .avt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev,
					{{WRAPPER}} .avt-carousel .avt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-carousel .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-carousel .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-carousel .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-carousel .avt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-carousel .avt-navigation-next' => 'right: {{SIZE}}px;',
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
					'{{WRAPPER}} .avt-carousel .avt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-carousel .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-carousel .avt-navigation-next' => 'right: {{SIZE}}px;',
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
					'{{WRAPPER}} .avt-carousel .avt-dots-container' => 'transform: translateY({{SIZE}}px);',
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

	public function render_loop_twitter( $consumerKey, $consumerSecret, $accessToken, $accessTokenSecret, $twitter_name ) {
		$settings          = $this->get_settings();		
		
		$name              = $twitter_name;
		$exclude_replies   = ('yes' === $settings['exclude_replies'] ) ? true : false;
		$transName         = 'avt-tweets-'.$name; // Name of value in database. [added $name for multiple account use]
		$backupName        = $transName . '-backup'; // Name of backup value in database.


		if(false === ($tweets = get_transient( $name ) ) ) :
		
			$connection = new \TwitterOAuth( $consumerKey, $consumerSecret, $accessToken, $accessTokenSecret );

			// If excluding replies, we need to fetch more than requested as the
			// total is fetched first, and then replies removed.
			$totalToFetch = ($exclude_replies) ? max(50, $settings['num_tweets'] * 3) : $settings['num_tweets'];

			$fetchedTweets = $connection->get(
				'statuses/user_timeline',
				array(
					'screen_name'     => $name,
					'count'           => $totalToFetch,
					'exclude_replies' => $exclude_replies
				)
			);

			// Did the fetch fail?
			if($connection->http_code != 200) :
				$tweets = get_option($backupName); // False if there has never been data saved.
			else :
				// Fetch succeeded.
				// Now update the array to store just what we need.
				// (Done here instead of PHP doing this for every page load)
				$limitToDisplay = min($settings['num_tweets'], count($fetchedTweets));

				for($i = 0; $i < $limitToDisplay; $i++) :
					$tweet = $fetchedTweets[$i];

						// Core info.
						$name = $tweet->user->name;
						// COMMUNITY REQUEST !!!!!! (2)
						$screen_name = $tweet->user->screen_name;
						$permalink = 'https://twitter.com/'. $screen_name .'/status/'. $tweet->id_str;
						$tweet_id = $tweet->id_str;

						/* Alternative image sizes method: http://dev.twitter.com/doc/get/users/profile_image/:screen_name */
						//  Check for SSL via protocol https then display relevant image - thanks SO - this should do
						if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
							// $protocol = 'https://';
							$image = $tweet->user->profile_image_url_https;
						}
						else {
							// $protocol = 'http://';
							$image = $tweet->user->profile_image_url;
						}

						// Process Tweets - Use Twitter entities for correct URL, hash and mentions
						$text  = $this->process_links($tweet);
						// lets strip 4-byte emojis
						$text  = $this->twitter_api_strip_emoji( $text );
						
						// Need to get time in Unix format.
						$time  = $tweet->created_at;
						$time  = date_parse($time);
						$uTime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);

						// Now make the new array.
						$tweets[] = array(
							'text'      => $text,
							'name'      => $name,
							'permalink' => $permalink,
							'image'     => $image,
							'time'      => $uTime,
							'tweet_id'  => $tweet_id
							);
				endfor;

				set_transient($transName, $tweets, 60 * $settings['cache_time']);
				update_option($backupName, $tweets );
			endif;
		endif;

		?>
		
		<?php

		// Now display the tweets, if we can.
		if($tweets) : ?>
			<?php foreach( (array) $tweets as $t) : // casting array to array just in case it's empty - then prevents PHP warning ?>
					<div class="avt-carousel-item swiper-slide">
						<div class="avt-card">
							<div class="avt-card-body">
								<?php if ('yes' === $settings['show_avatar']) : ?>

									<?php if ('yes' === $settings['avatar_link']) : ?>
										<a href="https://twitter.com/<?php echo esc_attr( $name ); ?>">
									<?php endif; ?>
										<div class="avt-twitter-thumb">
											<div class="avt-twitter-thumb-wrapper">
												<img src="<?php echo esc_url($t['image']); ?>" alt="<?php echo esc_html($t['name']); ?>" />
											</div>
										</div>
									<?php if ('yes' === $settings['avatar_link']) : ?>									
										</a>
									<?php endif; ?>
									
								<?php endif; ?>

								<div class="avt-twitter-text avt-clearfix">								
									<?php echo wp_kses_post($t['text']); ?>						
								</div>

								<div class="avt-twitter-meta-wrapper">
									
									<?php if('yes' === $settings['show_time']) : ?>
									<a href="<?php echo esc_url($t['permalink']); ?>" target="_blank" class="avt-twitter-time-link">
										<?php
											// Original - long time ref: hours...
											if('yes' === $settings['long_time_format']){
												// New - short Twitter style time ref: h...
												$timeDisplay = human_time_diff($t['time'], current_time('timestamp'));
											} else {
												$timeDisplay = $this->twitter_time_diff($t['time'], current_time('timestamp'));
											}
											$displayAgo = _x('ago', 'leading space is required', 'avator-widget-pack');
											// Use to make il8n compliant
											printf(__( '%1$s %2$s', 'avator-widget-pack' ), $timeDisplay, $displayAgo);
										?>
									</a>
									<?php endif; ?>	


									<?php if ('yes' === $settings['show_meta_button']) : ?>
									<div class="avt-twitter-meta-button">
										<a href="https://twitter.com/intent/tweet?in_reply_to=<?php echo esc_url($t['tweet_id']); ?>" data-lang="en" class="avt-tmb-reply" title="<?php _e('Reply','avator-widget-pack'); ?>" target="_blank">
											<span aria-hidden="true" avt-icon="icon: reply; ratio: 0.7;"></span>
										</a>
										<a href="https://twitter.com/intent/retweet?tweet_id=<?php echo esc_url($t['tweet_id']); ?>" data-lang="en" class="avt-tmb-retweet" title="<?php _e('Retweet','avator-widget-pack'); ?>" target="_blank">
											<span aria-hidden="true" avt-icon="icon: refresh; ratio: 0.7;"></span>
										</a>
										<a href="https://twitter.com/intent/favorite?tweet_id=<?php echo esc_url($t['tweet_id']); ?>" data-lang="en" class="avt-tmb-favorite" title="<?php _e('Favourite','avator-widget-pack'); ?>" target="_blank">
											<span aria-hidden="true" avt-icon="icon: star; ratio: 0.7;"></span>
										</a>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
			<?php endforeach; ?>
		<?php endif;
	}

	public function render() {

		if ( ! class_exists('TwitterOAuth') ) {
			include AWP_PATH . 'includes/twitteroauth/twitteroauth.php';
		}

		$settings          = $this->get_settings();
		$options           = get_option( 'widget_pack_api_settings' );
		
		$consumerKey       = (!empty($options['twitter_consumer_key'])) ? $options['twitter_consumer_key'] : '';
		$consumerSecret    = (!empty($options['twitter_consumer_secret'])) ? $options['twitter_consumer_secret'] : '';
		$accessToken       = (!empty($options['twitter_access_token'])) ? $options['twitter_access_token'] : '';
		$accessTokenSecret = (!empty($options['twitter_access_token_secret'])) ? $options['twitter_access_token_secret'] : '';
		$twitter_name      = (!empty($options['twitter_name'])) ? $options['twitter_name'] : '';

		$this->render_loop_header();

		if ( $consumerKey and $consumerSecret and $accessToken and $accessTokenSecret  ) {
			$this->render_loop_twitter( $consumerKey, $consumerSecret, $accessToken, $accessTokenSecret, $twitter_name );
		} else {
			?>
			<div class="avt-alert-warning" avt-alert>
			    <a class="avt-alert-close" avt-close></a>
			    <?php $ep_setting_url = esc_url( admin_url('admin.php?page=widget_pack_options#widget_pack_api_settings')); ?>
			    <p><?php printf(__( 'Please set your twitter API settings from here <a href="%s">widget pack settings</a> to show your map correctly.', 'avator-widget-pack' ), $ep_setting_url); ?></p>
			</div>
			<?php
		}
		
		$this->render_footer();

	}

	private function twitter_api_strip_emoji( $text ){
		// four byte utf8: 11110www 10xxxxxx 10yyyyyy 10zzzzzz
		return preg_replace('/[\xF0-\xF7][\x80-\xBF]{3}/', '', $text );
	}

	private function process_links($tweet) {

		// Is the Tweet a ReTweet - then grab the full text of the original Tweet
		if(isset($tweet->retweeted_status)) {
			// Split it so indices count correctly for @mentions etc.
			$rt_section = current(explode(":", $tweet->text));
			$text = $rt_section.": ";
			// Get Text
			$text .= $tweet->retweeted_status->text;
		} else {
			// Not a retweet - get Tweet
			$text = $tweet->text;
		}

		// NEW Link Creation from clickable items in the text
		$text = preg_replace('/((http)+(s)?:\/\/[^<>\s]+)/i', '<a href="$0" target="_blank" rel="nofollow">$0</a>', $text );
		// Clickable Twitter names
		$text = preg_replace('/[@]+([A-Za-z0-9-_]+)/', '<a href="http://twitter.com/$1" target="_blank" rel="nofollow">@$1</a>', $text );
		// Clickable Twitter hash tags
		$text = preg_replace('/[#]+([A-Za-z0-9-_]+)/', '<a href="http://twitter.com/search?q=%23$1" target="_blank" rel="nofollow">$0</a>', $text );
		// END TWEET CONTENT REGEX
		return $text;
	}

	private function twitter_time_diff( $from, $to = '' ) {
		$diff = human_time_diff($from,$to);
		$replace = array(
				' hour'    => 'h',
				' hours'   => 'h',
				' day'     => 'd',
				' days'    => 'd',
				' minute'  => 'm',
				' minutes' => 'm',
				' second'  => 's',
				' seconds' => 's',
		);
		return strtr($diff,$replace);
	}

	protected function render_loop_header() {
		$id              = 'avt-twitter-carousel-' . $this->get_id();
		$settings        = $this->get_settings();
		
		$elementor_vp_lg = get_option( 'elementor_viewport_lg' );
		$elementor_vp_md = get_option( 'elementor_viewport_md' );
		$viewport_lg     = !empty($elementor_vp_lg) ? $elementor_vp_lg : 1025;
		$viewport_md     = !empty($elementor_vp_md) ? $elementor_vp_md : 768;
		
		$this->add_render_attribute( 'carousel', 'id', $id );
		$this->add_render_attribute( 'carousel', 'class', 'avt-twitter-carousel avt-carousel' );

		if ('arrows' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-arrows-align-'. $settings['arrows_position'] );
			
		}
		if ('dots' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-dots-align-'. $settings['dots_position'] );
		}
		if ('both' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-arrows-dots-align-'. $settings['both_position'] );
		}

		if ( $settings['match_height'] ) {
			$this->add_render_attribute( 'carousel', 'avt-height-match', 'target: > div > div > .avt-carousel-item > div > div > .avt-twitter-text' );
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



		?>
		<div <?php echo $this->get_render_attribute_string( 'carousel' ); ?>>
			<div class="swiper-container">
				<div class="swiper-wrapper">
		<?php
	}

	protected function render_both_navigation() {
		$settings             = $this->get_settings();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'avt-visible@m' : '';

		?>
		<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="avt-arrows-dots-container avt-slidenav-container ">
				
				<div class="avt-flex avt-flex-middle">
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>	
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>	
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	protected function render_navigation() {
		$settings             = $this->get_settings();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? ' avt-visible@m' : '';
		
		if ( 'arrows' == $settings['navigation'] ) : ?>
				<div class="avt-position-z-index avt-position-<?php echo esc_attr( $settings['arrows_position'] . $hide_arrow_on_mobile ); ?>">
					<div class="avt-arrows-container avt-slidenav-container">
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>
					</div>
				</div>
		<?php endif;
	}

	protected function render_pagination() {
		$settings = $this->get_settings();
		
		if ( 'dots' == $settings['navigation'] ) : ?>
			<?php if ( 'arrows' !== $settings['navigation'] ) : ?>
				<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['dots_position']); ?>">
					<div class="avt-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				</div>
			<?php endif; ?>
			
		<?php endif;
	}

	protected function render_footer() {
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
}
