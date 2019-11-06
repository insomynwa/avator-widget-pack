<?php
namespace WidgetPack\Modules\Instagram\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use WidgetPack\Modules\Instagram\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Instagram extends Widget_Base {

	public function get_name() {
		return 'avt-instagram';
	}

	public function get_title() {
		return AWP . esc_html__( 'Instagram', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-instagram-feed';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'instagram', 'gallery', 'photos', 'images' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font', 'wipa-instagram' ];
	}

	public function get_script_depends() {
		return [ 'wipa-instagram' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/K6CSO2rxVnA';
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Carousel( $this ) );
		$this->add_skin( new Skins\Classic_Grid( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'masonry',
			[
				'label'   => esc_html__( 'Masonry', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'item_ratio',
			[
				'label'   => esc_html__( 'Image Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 250,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-instagram-thumbnail img' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'masonry!' => 'yes',

				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '3',
				'mobile_default' => '2',
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
			'items',
			[
				'label' => esc_html__( 'Item Limit', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
					],
				],
				'default' => [
					'size' => 12,
				],
			]
		);

		$this->add_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'small',
				'options' => [
					'small'    => esc_html__( 'Small', 'avator-widget-pack' ),
					'medium'   => esc_html__( 'Medium', 'avator-widget-pack' ),
					'large'    => esc_html__( 'Large', 'avator-widget-pack' ),
					'collapse' => esc_html__( 'Collapse', 'avator-widget-pack' ),
				],
			]
		);

		// $this->add_control(
		// 	'show_profile',
		// 	[
		// 		'label'     => esc_html__( 'Profile', 'avator-widget-pack' ),
		// 		'type'      => Controls_Manager::SWITCHER,
		// 		'condition' => [
		// 			'layout!' => 'carousel',
		// 		],
		// 	]
		// );

		$this->add_control(
			'show_loadmore',
			[
				'label'   => esc_html__( 'Show Load More', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_follow_me',
			[
				'label'     => esc_html__( 'Follow Me', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin' => 'avt-instagram-carousel',
				],
			]
		);

		$this->add_control(
			'follow_me_text',
			[
				'label'       => esc_html__( 'Follow Me Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'follow me @', 'avator-widget-pack' ),
				'default'     => esc_html__( 'follow me @', 'avator-widget-pack' ),
				'condition'   => [
					'_skin'          => 'avt-instagram-carousel',
					'show_follow_me' => 'yes',
				],
			]
		);



		$this->add_control(
			'show_lightbox',
			[
				'label'   => esc_html__( 'Lightbox', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'lightbox_animation',
			[
				'label'   => esc_html__( 'Lightbox Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'avator-widget-pack' ),
					'fade'  => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale' => esc_html__( 'Scale', 'avator-widget-pack' ),
				],
				'condition' => [
					'show_lightbox' => 'yes',
				],
				//'separator' => 'before',
			]
		);

		$this->add_control(
			'lightbox_autoplay',
			[
				'label'   => __( 'Lightbox Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'lightbox_pause',
			[
				'label'   => __( 'Lightbox Pause on Hover', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_lightbox' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_link',
			[
				'label'   => esc_html__( 'Link Image to Post', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_lightbox!' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_comment',
			[
				'label'   => esc_html__( 'Comment Count', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'show_link',
							'value' => 'yes',
						],
						[
							'name'  => 'show_lightbox',
							'value' => 'yes',
						],
						[
							'name'  => '_skin',
							'value' => 'avt-classic-grid',
						],
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_like',
			[
				'label'   => esc_html__( 'Like Count', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'show_link',
							'value' => 'yes',
						],
						[
							'name'  => 'show_lightbox',
							'value' => 'yes',
						],
						[
							'name'  => '_skin',
							'value' => 'avt-classic-grid',
						],
					],
				],
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-instagram-profile' => 'text-align: {{VALUE}}',
				],
				'condition'   => [
					'show_profile' => 'yes',
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
					'{{WRAPPER}} .avt-instagram .avt-instagram-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-instagram .avt-instagram-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-instagram .avt-instagram-item',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-instagram .avt-instagram-item, {{WRAPPER}} .avt-instagram .avt-overlay.avt-overlay-default' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'image_section_layout',
			[
				'label'      => __( 'Image', 'avator-widget-pack' ),
				'placeholder' => 'Image Style Here',
				'separator'   => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'label'       => __( 'Image Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-instagram .avt-instagram-thumbnail img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Image Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-instagram .avt-instagram-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .avt-instagram .avt-instagram-item img',
			]
		);

		$this->add_control(
			'item_opacity',
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
					'{{WRAPPER}} .avt-instagram .avt-instagram-item img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'shadow_mode',
			[
				'label'        => esc_html__( 'Shadow Mode', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-wipa-shadow-mode-',
				'condition' => [
					'_skin' => 'avt-instagram-carousel',
				],
			]
		);

		$this->add_control(
			'shadow_color',
			[
				'label'     => esc_html__( 'Shadow Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container:before' => 'background: linear-gradient(to right, {{VALUE}} 0%,rgba(255,255,255,0) 100%);',
					'{{WRAPPER}} .elementor-widget-container:after'  => 'background: linear-gradient(to right, rgba(255,255,255,0) 0%, {{VALUE}} 100%);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => '_skin',
							'value' => 'avt-instagram-carousel',
						],
						[
							'name'     => 'shadow_mode',
							'value'    => 'yes',
						],
					],
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
			'item_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-instagram-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .avt-instagram .avt-instagram-item:hover img',
			]
		);

		$this->add_control(
			'item_hover_opacity',
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
					'{{WRAPPER}} .avt-instagram .avt-instagram-item:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_overlay',
			[
				'label'      => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'show_comment',
							'value' => 'yes',
						],
						[
							'name'  => 'show_like',
							'value' => 'yes',
						],
						[
							'name'  => 'show_lightbox',
							'value' => 'yes',
						],
						[
							'name'  => 'show_link',
							'value' => 'yes',
						],
						[
							'name'  => '_skin!',
							'value' => 'avt-classic-grid',
						],
					],
				],
				// 'condition' => [
				// 	'_skin!' => 'avt-classic-grid',
				// ],
			]
		);

		$this->add_responsive_control(
			'overlay_gap',
			[
				'label' => __('Overlay Gap', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15
				],
				'selectors' => [
					'{{WRAPPER}} .avt-overlay' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_icon_size',
			[
				'label' => __('Overlay Icon Size', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40
				],
				'selectors' => [
					'{{WRAPPER}} .avt-overlay-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-overlay.avt-overlay-default' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-instagram-item.avt-transition-toggle *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_lightbox_icon',
			[
				'label'      => esc_html__( 'Lightbox Icon', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-classic-grid',
				],
			]
		);

		$this->add_responsive_control(
			'lightbox_icon_size',
			[
				'label' => __('Icon Size', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .avt-classic-grid .avt-lightbox-icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-classic-grid .avt-lightbox-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_icon_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-classic-grid .avt-lightbox-icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'lightbox_icon_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-classic-grid .avt-lightbox-icon',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'lightbox_icon_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-classic-grid .avt-lightbox-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'lightbox_icon_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-classic-grid .avt-lightbox-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_like_comment_icon',
			[
				'label'      => esc_html__( 'Like Comment Icon', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-classic-grid',
				],
			]
		);

		$this->add_responsive_control(
			'like_comment_icon_size',
			[
				'label' => __('Size', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .avt-classic-grid .avt-instagram-like-comment' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'like_comment_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-classic-grid .avt-instagram-like-comment' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'like_comment_icon_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-classic-grid .avt-instagram-like-comment' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'like_comment_icon _shadow',
				'selector' => '{{WRAPPER}} .avt-classic-grid .avt-instagram-like-comment',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_follow_me',
			[
				'label'      => __( 'Follow Me', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms'    => [
						[
							'name'  => '_skin',
							'value' => 'avt-instagram-carousel',
						],
						[
							'name'  => 'show_follow_me',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'follow_me_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram-follow-me a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'follow_me_text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram-follow-me a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'follow_me_text_hover_color',
			[
				'label'     => __( 'Text Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram-follow-me a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'follow_me_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-instagram-follow-me a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'follow_me_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-instagram-follow-me a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'follow_me_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-instagram-follow-me a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'follow_me_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-instagram-follow-me a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-instagram-carousel',
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 12,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-slidenav-previous svg, {{WRAPPER}} .avt-instagram .avt-slidenav-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-slidenav-previous, {{WRAPPER}} .avt-instagram .avt-slidenav-next' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-slidenav-previous:hover, {{WRAPPER}} .avt-instagram .avt-slidenav-next:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-slidenav-previous svg, {{WRAPPER}} .avt-instagram .avt-slidenav-next svg' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-instagram .avt-slidenav-previous:hover svg, {{WRAPPER}} .avt-instagram .avt-slidenav-next:hover svg' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .avt-instagram .avt-slidenav-previous' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .avt-instagram .avt-slidenav-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-instagram .avt-slidenav-previous, {{WRAPPER}} .avt-instagram .avt-slidenav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_position',
			[
				'label' => __( 'Position', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 150,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slidenav-previous' => 'transform: translateY(-50%) translateY(-15px) translateX(-{{SIZE}}px);',
					'{{WRAPPER}} .avt-slidenav-next'     => 'transform: translateY(-50%) translateY(-15px) translateX({{SIZE}}px);',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings();
		$insta_feeds = [];

		$options   = get_option( 'widget_pack_api_settings' );
		$access_token    = (!empty($options['instagram_access_token'])) ? $options['instagram_access_token'] : '';

		if (!$access_token) {
			widget_pack_alert('Ops! You did not set Instagram Access Token in widget pack settings!');
			return;
		}

		
		$this->add_render_attribute('instagram-wrapper', 'class', 'avt-instagram' );

		$this->add_render_attribute('instagram', 'class', 'avt-grid' );

		$this->add_render_attribute('instagram', 'class', 'avt-grid-' . esc_attr($settings["column_gap"]) );
		
		$this->add_render_attribute('instagram', 'class', 'avt-child-width-1-' . esc_attr($settings["columns"]) . '@m');
		$this->add_render_attribute('instagram', 'class', 'avt-child-width-1-' . esc_attr($settings["columns_tablet"]). '@s');
		$this->add_render_attribute('instagram', 'class', 'avt-child-width-1-' . esc_attr($settings["columns_mobile"]) );

		$this->add_render_attribute('instagram', 'avt-grid', '' );
		if ($settings['masonry']) {
			$this->add_render_attribute('instagram', 'avt-grid', 'masonry: true;' );
		}

		
		$this->add_render_attribute('instagram', 'class', 'avt-instagram-grid' );
	 

		if ( 'yes' == $settings['show_lightbox'] ) {
			$this->add_render_attribute('instagram', 'avt-lightbox', 'animation:' . $settings['lightbox_animation'] . ';');
			if ($settings['lightbox_autoplay']) {
				$this->add_render_attribute('instagram', 'avt-lightbox', 'autoplay: 500;');
				
				if ($settings['lightbox_pause']) {
					$this->add_render_attribute('instagram', 'avt-lightbox', 'pause-on-hover: true;');
				}
			}
		}

		$this->add_render_attribute(
			[
				'instagram-wrapper' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							'action'              => 'widget_pack_instagram_ajax_load',
							'show_comment'        => ( $settings['show_comment'] ) ? true : false,
							'show_like'           => ( $settings['show_like'] ) ? true : false,
							'show_link'           => ( $settings['show_link'] ) ? true : false,
							'show_lightbox'       => ( $settings['show_lightbox'] ) ? true : false,
							'current_page'        => 1,
							'load_more_per_click' => 4,
							'item_per_page'       => $settings['items']['size'],
							'skin'       		  => ($settings['_skin']) ? $settings['_skin'] : '',
				        ]))
					]
				]
			]
		);


		?>
		<div <?php echo $this->get_render_attribute_string( 'instagram-wrapper' ); ?>>
			
			<div <?php echo $this->get_render_attribute_string( 'instagram' ); ?>>
			
				<?php  for ( $dummy_item_count = 1; $dummy_item_count <= $settings["items"]["size"]; $dummy_item_count++ ) : ?>
				
				<div class="avt-instagram-item"><div class="avt-dummy-loader"></div></div>

				<?php endfor; ?>

			</div>


		<?php if ($settings['show_loadmore']) : ?>
		<div class="avt-text-center avt-margin">
			<a href="javascript:;" class="avt-load-more avt-button avt-button-primary">
				<span avt-spinner></span>
				<span class="loaded-txt">
					<?php esc_html_e('Load More', 'avator-widget-pack'); ?>
				</span>
			</a>
		</div>
		<?php endif; ?>
		
		</div>

		<?php
	}
}
