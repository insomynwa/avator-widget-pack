<?php
namespace WidgetPack\Modules\Slider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Slider
 */
class Slider extends Widget_Base {

	/**
	 * @var \WP_Query
	 */
	private $_query = null;

	public function get_name() {
		return 'avt-slider';
	}

	public function get_title() {
		return AWP . esc_html__( 'Slider', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-slider';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'slider', 'hero' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'services';
		}

		return $element;
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
		return $element;
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_sliders',
			[
				'label' => esc_html__( 'Sliders', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Slider Items', 'avator-widget-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title'   => esc_html__( 'Slide #1', 'avator-widget-pack' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => esc_html__( 'Slide #2', 'avator-widget-pack' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => esc_html__( 'Slide #3', 'avator-widget-pack' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => esc_html__( 'Slide #4', 'avator-widget-pack' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
				],
				'fields' => [
					[
						'name'        => 'tab_title',
						'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Slide Title' , 'avator-widget-pack' ),
						'label_block' => true,
					],
					[
						'name'    => 'tab_image',
						'label'   => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'    => Controls_Manager::MEDIA,
						'dynamic' => [ 'active' => true ],
					],
					[
						'name'       => 'tab_content',
						'label'      => esc_html__( 'Content', 'avator-widget-pack' ),
						'type'       => Controls_Manager::WYSIWYG,
						'dynamic'    => [ 'active' => true ],
						'default'    => esc_html__( 'Slide Content', 'avator-widget-pack' ),
						'show_label' => false,
					],
					[
						'name'        => 'tab_link',
						'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::URL,
						'dynamic'     => [ 'active' => true ],
						'placeholder' => 'http://your-link.com',
						'default'     => [
							'url' => '#',
						],
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'   => esc_html__( 'Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 600,
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'origin',
			[
				'label'   => esc_html__( 'Origin', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => widget_pack_position(),
			]
		);

		$this->add_responsive_control(
			'align',
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'description'  => 'Use align to match position',
				'default'      => 'center',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Show Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);


		$this->add_control(
			'show_button',
			[
				'label'   => esc_html__( 'Show Button', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'scroll_to_section',
			[
				'label' => esc_html__( 'Scroll to Section', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'section_id',
			[
				'label'       => esc_html__( 'Section ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'Section ID Here',
				'description' => 'Enter section ID of this page, ex: #my-section',
				'label_block' => true,
				'condition'   => [
					'scroll_to_section' => 'yes',
				],
			]
		);

		$this->add_control(
			'slider_scroll_to_section_icon',
			[
				'label'       => esc_html__( 'Scroll to Section Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'scroll_to_section_icon',
				'default' => [
					'value' => 'fas fa-angle-double-down',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'scroll_to_section' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settings',
			[
				'label' => esc_html__( 'Slider Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'avator-widget-pack' ),
					'arrows' => esc_html__( 'Arrows', 'avator-widget-pack' ),
					'dots'   => esc_html__( 'Dots', 'avator-widget-pack' ),
					'none'   => esc_html__( 'None', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'hide_arrows',
			[
				'label'     => esc_html__( 'Hide arrows on mobile devices?', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'transition',
			[
				'label'   => esc_html__( 'Transition', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide'     => esc_html__( 'Slide', 'avator-widget-pack' ),
					'fade'      => esc_html__( 'Fade', 'avator-widget-pack' ),
					'cube'      => esc_html__( 'Cube', 'avator-widget-pack' ),
					'coverflow' => esc_html__( 'Coverflow', 'avator-widget-pack' ),
					'flip'      => esc_html__( 'Flip', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'animation_kenburns',
			[
				'label'        => esc_html__( 'Animation Kenburns', 'avator-widget-pack' ),
				'prefix_class' => 'avt-animation-kenburns-',
				'type'         => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'effect',
			[
				'label'   => esc_html__( 'Text Effect', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
				'left'    => esc_html__( 'Slide Right to Left', 'avator-widget-pack' ),
				'bottom'  => esc_html__( 'Slider Bottom to Top', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'avator-widget-pack' ),
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
			'loop',
			[
				'label'   => __( 'Loop', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				
			]
		);

		$this->add_control(
			'pauseonhover',
			[
				'label' => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'slider_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'slider_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'slider_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-slider .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Slider', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slider_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#14ABF4',
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-desc' => 'margin: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-title',
			]
		);

		$this->add_responsive_control(
			'title_space',
			[
				'label' => esc_html__( 'Space', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => esc_html__( 'Text', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Text Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-text',
			]
		);

		$this->add_responsive_control(
			'text_space',
			[
				'label' => esc_html__( 'Text Space', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-slider .avt-slide-item .avt-slide-link',
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
			'heading_style_arrows',
			[
				'label'     => __( 'Arrows', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_style',
			[
				'label'   => __( 'Arrows Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'dark'  => __( 'Dark', 'avator-widget-pack' ),
					'light' => __( 'Light', 'avator-widget-pack' ),
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Arrows Position', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-slider .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label'   => __( 'Arrows Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .swiper-button-prev, {{WRAPPER}} .avt-slider .swiper-button-next' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label'     => __( 'Dots', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .avt-slider .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Dot Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .avt-slider .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Dots Position', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -80,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .swiper-pagination-bullets' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
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
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_scroll_to_top',
			[
				'label'      => esc_html__( 'Scroll to Top', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'scroll_to_section',
							'value' => 'yes',
						],
						[
							'name'     => 'section_id',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_scroll_to_top_style' );

		$this->start_controls_tab(
			'scroll_to_top_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'scroll_to_top_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_to_top_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'scroll_to_top_shadow',
				'selector' => '{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'scroll_to_top_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'scroll_to_top_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_to_top_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_to_top_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_to_top_bottom_space',
			[
				'label' => esc_html__( 'Bottom Space', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 300,
						'step' => 5,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'scroll_to_top_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'scroll_to_top_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_to_top_hover_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_to_top_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'scroll_to_top_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider .avt-wp-scroll-to-section a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	
	protected function render_loop_header() {
		$settings = $this->get_settings();
		$id       = 'avt-slider-' . $this->get_id();

		$this->add_render_attribute( 'slider', 'id', $id );
		$this->add_render_attribute( 'slider', 'class', 'avt-slider' );

		$this->add_render_attribute(
			[
				'slider' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"autoplay"     => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"         => ($settings["loop"] == "yes") ? true : false,
							"speed"        => $settings["speed"]["size"],
							"pauseOnHover" => ("yes" == $settings["pauseonhover"]) ? true : false,
							"effect"       => $settings["transition"],
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

		if ( ! isset( $settings['scroll_to_section_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['scroll_to_section_icon'] = 'fas fa-arrow-down';
		}

		$migrated  = isset( $settings['__fa4_migrated']['slider_scroll_to_section_icon'] );
		$is_new    = empty( $settings['scroll_to_section_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'slider' ); ?>>
			<div class="swiper-container">
				<?php if ($settings['scroll_to_section'] && $settings['section_id']): ?>
					<div class="avt-wp-scroll-to-section avt-position-bottom-center">
						<a href="<?php echo esc_url($settings['section_id']); ?>" avt-scroll>
							<span class="avt-wp-scroll-to-section-icon">

								<?php if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['slider_scroll_to_section_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
								else : ?>
									<i class="<?php echo esc_attr( $settings['scroll_to_section_icon'] ); ?>" aria-hidden="true"></i>
								<?php endif; ?>

							</span>
						</a>
					</div>
				<?php endif;
	}

	protected function render_loop_footer() {
		$settings    = $this->get_settings_for_display();
		$id          = 'avt-slider-' . $this->get_id();
		$hide_arrows = $settings['hide_arrows'] ? ' avt-visible@m' : '';

		?>
		</div>
		<?php if ( 'none' !== $settings['navigation'] ) : ?>
			<?php if ( 'arrows' !== $settings['navigation'] ) : ?>
				<div class="swiper-pagination"></div>
			<?php endif; ?>
			
			<?php if ( 'dots' !== $settings['navigation'] ) : 
				$nav_style = ($settings['arrows_style'] == 'light') ? 'swiper-button-white' : 'swiper-button-black'; 
			?>
				<div class="swiper-button-next avt-navigation-next <?php echo esc_attr($nav_style.$hide_arrows); ?>"></div>
				<div class="swiper-button-prev avt-navigation-prev <?php echo esc_attr($nav_style.$hide_arrows); ?>"></div>
			<?php endif; ?>
		<?php endif; ?>
		</div>

		<?php
	}

	public function render() {
		$settings  = $this->get_settings_for_display();

		$this->render_loop_header();

		?>
		<div class="swiper-wrapper">
			<?php $counter = 1; ?>
			<?php foreach ( $settings['tabs'] as $item ) : ?>

				<?php 
				$image_src = wp_get_attachment_image_src( $item['tab_image']['id'], 'full' );
				$image     =  $image_src ? $image_src[0] : '';

				$this->add_render_attribute(
					[
						'slide-item' => [
							'class' => [
								'avt-slide-item',
								'swiper-slide',
								'avt-slide-effect-' . $settings['effect']
							],
						]
					], '', '', true
				);

				$this->add_render_attribute(
					[
						'slider-link' => [
							'class' => [
								'avt-slide-link',
								$settings['button_hover_animation'] ? 'elementor-animation-' . $settings['button_hover_animation'] : '',
							],
							'href'   => $item['tab_link']['url'] ? esc_url($item['tab_link']['url']) : '#',
							'target' => $item['tab_link']['is_external'] ? '_blank' : '_self'
						]
					], '', '', true
				);

				if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
					// add old default
					$settings['icon'] = 'fas fa-arrow-right';
				}

				$migrated  = isset( $settings['__fa4_migrated']['slider_icon'] );
				$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

				?>				
				<div <?php echo $this->get_render_attribute_string( 'slide-item' ); ?>>

					<?php if ($image) : ?>
					<div class="avt-slider-image-wrapper">
						<img src="<?php echo esc_url($image); ?>" alt="<?php echo wp_kses_post($item['tab_title']); ?>" avt-cover>
					</div>
		        	
					<?php endif; ?>

		        	<div class="avt-slide-desc avt-position-large avt-position-<?php echo ($settings['origin']); ?> avt-position-z-index">

						<?php if (( '' !== $item['tab_title'] ) && ( $settings['show_title'] )) : ?>
							<h2 class="avt-slide-title avt-clearfix"><?php echo wp_kses_post($item['tab_title']); ?></h2>
						<?php endif; ?>

						<?php if ( '' !== $item['tab_content'] ) : ?>
							<div class="avt-slide-text"><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></div>
						<?php endif; ?>

						<?php if (( ! empty( $item['tab_link']['url'] )) && ( $settings['show_button'] )): ?>
							<div class="avt-slide-link-wrapper">
								<a <?php echo $this->get_render_attribute_string( 'slider-link' ); ?>>

									<?php echo esc_html($settings['button_text']); ?>
								
									<?php if ($settings['slider_icon']['value']) : ?>
										<span class="avt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">

											<?php if ( $is_new || $migrated ) :
												Icons_Manager::render_icon( $settings['slider_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
											else : ?>
												<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
											<?php endif; ?>

										</span>
									<?php endif; ?>
								</a>
							</div>
						<?php endif; ?>
			  		</div>
				</div>
				<?php
				$counter++;
			endforeach;
			?>
		</div>
		<?php
		$this->render_loop_footer();
	}
}
