<?php
namespace WidgetPack\Modules\Modal\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Modal extends Widget_Base {
	public function get_name() {
		return 'avt-modal';
	}

	public function get_title() {
		return AWP . esc_html__( 'Modal', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-modal';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'modal', 'lightbox', 'popup' ];
	}

	public function get_script_depends() {
		return [ 'wipa-modal' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/4qRa-eYDGZU';
	}

	protected function _register_controls() {


		$this->start_controls_section(
			'section_modal_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'avator-widget-pack' ),
					'splash'  => esc_html__( 'Splash Screen', 'avator-widget-pack' ),
					'exit'    => esc_html__( 'Exit Popup', 'avator-widget-pack' ),
					'custom'  => esc_html__( 'Custom Link', 'avator-widget-pack' ),
				],				
			]
		);

		$this->add_control(
			'modal_custom_id',
			[
				'label'       => esc_html__( 'Modal Selector', 'avator-widget-pack' ),
				'description' => __( 'Set your modal selector here. For example: <b>.custom-link</b> or <b>#customLink</b>. Set this selector where you want to link this modal.' , 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '#avt-custom-modal', 'avator-widget-pack' ),
				'condition'   => [
					'layout' => 'custom',
				],
			]
		);

		$this->add_control(
			'splash_after',
			[
				'label'   => esc_html__( 'Splash After (s)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 60,
					],
				],
				'condition' => [
					'layout' => 'splash',
				],
			]
		);

		$this->add_control(
			'dev_mode',
			[
				'label'       => __( 'Dev Mode', 'avator-widget-pack' ),
				'default'     => 'yes',
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Turn off dev move when your website live so splash screen will show only once.', 'avator-widget-pack' ),
				'condition'   => [
					'layout' => ['splash', 'exit'],
				],
			]
		);

		$this->add_control(
			'modal_width',
			[
				'label' => esc_html__( 'Modal Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 320,
						'max' => 1200,
					],
				],
				'selectors' => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-dialog' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'condition' => [
					'layout' => 'default',
				],
			]
		);
		

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Open Modal', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'button_align',
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
					'justify' => [
						'title' => __( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => __( 'Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => widget_pack_button_sizes(),
			]
		);

		$this->add_control(
			'modal_button_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'button_icon',
			]
		);

		$this->add_control(
			'button_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'modal_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'button_icon_indent',
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
					'modal_button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button-icon.avt-flex-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button-icon.avt-flex-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_modal',
			[
				'label' => esc_html__( 'Modal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'header',
			[
				'label'       => esc_html__( 'Header', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'This is your modal header title', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Modal header title', 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'    => esc_html__( 'Custom', 'avator-widget-pack' ),
					"elementor" => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
					'anywhere'  => esc_html__( 'AE Template', 'avator-widget-pack' ),
				],				
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [ 'active' => true ],
				'show_label'  => false,
				'condition'   => ['source' => 'custom'],
				'default'     => esc_html__( 'A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Modal content goes here', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'template_id',
			[
				'label'       => __( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_et_options(),
				'label_block' => 'true',
				'condition'   => ['source' => "elementor"],
			]
		);

		$this->add_control(
			'anywhere_id',
			[
				'label'       => esc_html__( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_ae_options(),
				'label_block' => 'true',
				'condition'   => ['source' => 'anywhere'],
			]
		);

		$this->add_control(
			'footer',
			[
				'label'       => esc_html__( 'Footer', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Modal footer goes here', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Modal footer goes here', 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_modal_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'content_overflow',
			[
				'label'       => __( 'Overflow Scroll', 'avator-widget-pack' ),
				'description' => __( 'Show scroll bar when you add huge content in modal.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'close_button',
			[
				'label'       => esc_html__( 'Close Button', 'avator-widget-pack' ),
				'description' => esc_html__('When you set modal full screen make sure you don\'t set colse button outside', 'avator-widget-pack'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'options'     => [
					'default' => esc_html__( 'Default', 'avator-widget-pack' ),
					'outside' => esc_html__( 'Outside', 'avator-widget-pack' ),
					'none'    => esc_html__( 'No Close Button', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'modal_size',
			[
				'label'        => esc_html__( 'Full screen', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'full',
				'condition'    => [
					'close_button!' => 'outside',
				],
			]
		);

		$this->add_control(
			'modal_center',
			[
				'label'        => esc_html__( 'Center Position', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition'    => [
					'modal_size!' => 'full',
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
					'layout' => 'default',
				],
			]
		);

		$this->add_control(
			'heading_footer_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
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
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-modal-wrapper .avt-modal-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-modal-wrapper .avt-modal-button',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-modal-wrapper .avt-modal-button',
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
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-modal-wrapper .avt-modal-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'tab_content_header',
			[
				'label'     => esc_html__( 'Header', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'header!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'header_align',
			[
				'label'       => esc_html__( 'Titlt Align', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
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
				'default' => 'left',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'header_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.avt-modal-{{ID}}.avt-modal .avt-modal-header',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'header_box_shadow',
				'selector' => '.avt-modal-{{ID}}.avt-modal .avt-modal-header',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '.avt-modal-{{ID}}.avt-modal .avt-modal-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_modal',
			[
				'label' => esc_html__( 'Modal Content', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-body' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-body' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '.avt-modal-{{ID}}.avt-modal .avt-modal-body',
			]
		);

		$this->add_control(
			'close_button_color',
			[
				'label'     => esc_html__( 'Close Button Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-dialog button.avt-close' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'tab_content_footer',
			[
				'label'     => esc_html__( 'Footer', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'footer!' => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-footer' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'footer_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-footer' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'footer_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'.avt-modal-{{ID}}.avt-modal .avt-modal-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'footer_align',
			[
				'label'       => esc_html__( 'Text Align', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
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
				'default' => 'left',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'footer_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.avt-modal-{{ID}}.avt-modal .avt-modal-footer',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'footer_box_shadow',
				'selector' => '.avt-modal-{{ID}}.avt-modal .avt-modal-footer',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '.avt-modal-{{ID}}.avt-modal .avt-modal-footer',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings  = $this->get_settings_for_display();
		$id        = 'avt-modal-' . $this->get_id();
		$edit_mode = Widget_Pack_Loader::elementor()->editor->is_edit_mode();

        $this->add_render_attribute( 'button', 'class', ['avt-modal-button', 'elementor-button'] );

        $this->add_render_attribute( 'modal', 'id', $id );
        $this->add_render_attribute( 'modal', 'class', 'avt-modal-' . $this->get_id() );
        $this->add_render_attribute( 'modal', 'avt-modal', '' );

        if ( $settings['modal_size'] !== 'full' ) {
        	$this->add_render_attribute( 'modal', 'class', 'avt-modal' );
        } else {
        	$this->add_render_attribute( 'modal', 'class', 'avt-modal avt-modal-full' );
        	$this->add_render_attribute( 'modal-body', 'avt-height-viewport', 'offset-top: .avt-modal-header; offset-bottom: .avt-modal-footer' );
        }

        if ( $settings['modal_center'] === 'yes' ) {
        	$this->add_render_attribute( 'modal', 'class', 'avt-flex-top' );
        }

        $this->add_render_attribute( 'modal-dialog', 'class', 'avt-modal-dialog' );

        if ($settings['modal_center'] === 'yes' ) {
        	$this->add_render_attribute( 'modal-dialog', 'class', 'avt-margin-auto-vertical' );
        }

        if ( ! empty( $settings['size'] ) ) {
        	$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
        }

        if ( $settings['hover_animation'] ) {
        	$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }


        $this->add_render_attribute( 'button', 'avt-toggle', 'target: #'.$id );
        $this->add_render_attribute( 'button', 'href', 'javascript:void(0)' );

        $this->add_render_attribute( 'modal-body', 'class', 'avt-modal-body' );

        if ( 'yes' === $settings['content_overflow'] ) {
        	$this->add_render_attribute( 'modal-body', 'avt-overflow-auto', '' );
        }

		$splash_after = ($settings['splash_after']) ?  ($settings['splash_after']['size'] * 1000) : 500;

        $this->add_render_attribute(
        	[
        		'modal' => [
        			'data-settings' => [
        				wp_json_encode(array_filter([
							"id"      => ("custom" == $settings["layout"] and ! empty($settings["modal_custom_id"])) ? $settings["modal_custom_id"] : "avt-modal-" . $this->get_id(),
							"layout"  => $settings["layout"],
							"delayed" => ("splash" == $settings["layout"]) ? $splash_after : false,
							"dev"     => ("yes" == $settings["dev_mode"]) ? true : false,
        		        ]))
        			]
        		]
        	]
        );

        ?>
		<div class="avt-modal-wrapper">
		    
		    <?php $this->render_button(); ?>	

	        <div <?php echo $this->get_render_attribute_string( 'modal' ); ?>>
	            <div <?php echo $this->get_render_attribute_string( 'modal-dialog' ); ?>>
	                            
	                <?php if ( $settings['close_button'] != 'none' ) : ?>
	                	<button class="avt-modal-close-<?php echo esc_attr($settings['close_button']); ?>" type="button" avt-close></button>
	                <?php endif; ?>
	                
	                <?php if ( $settings['header'] ) : ?>
	                    <div class="avt-modal-header avt-text-<?php echo esc_attr($settings['header_align']); ?>">
	                    	<h3 class="avt-modal-title"><?php echo wp_kses_post($settings['header']); ?></h3>
	                    </div>
	                <?php endif; ?>
	                
	                <div <?php echo $this->get_render_attribute_string( 'modal-body' ); ?>>
	                	<?php 
			            	if ( 'custom' == $settings['source'] and !empty( $settings['content'] ) ) {
			            		echo do_shortcode( $settings['content'] );
			            	} elseif ("elementor" == $settings['source'] and !empty( $settings['template_id'] )) {
			            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['template_id'] );
			            		echo widget_pack_template_edit_link( $settings['template_id'] );
			            	} elseif ('anywhere' == $settings['source'] and !empty( $settings['anywhere_id'] )) {
			            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['anywhere_id'] );
			            		echo widget_pack_template_edit_link( $settings['anywhere_id'] );
			            	}
			            ?>
	                </div>

	                <?php if ( $settings['footer'] ) : ?>
	                    <div class="avt-modal-footer avt-text-<?php echo esc_attr($settings['header_align']); ?>">
	                    	<?php echo wp_kses_post($settings['footer']); ?>
	                    </div>
	                <?php endif; ?>
		        </div>
		    </div>
	    </div>

		<?php
	}

	protected function render_button() {
		$settings = $this->get_settings_for_display();

		if ( 'default' !== $settings['layout'] ) {
			return;
		}

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );

		if ( 'left' == $settings['button_icon_align'] or 'right' == $settings['button_icon_align'] ) {
			$this->add_render_attribute( 'content-wrapper', 'class', 'avt-flex avt-flex-middle' );
		}

		$this->add_render_attribute( 'icon-align', 'class', 'avt-flex-align-' . $settings['button_icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'avt-modal-button-icon elementor-button-icon avt-flex-inline' );

		$this->add_render_attribute( 'text', 'class', 'elementor-button-text' );

		if ( ! isset( $settings['button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['button_icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['modal_button_icon'] );
		$is_new    = empty( $settings['button_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
			<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
				<?php if ( ! empty( $settings['modal_button_icon']['value'] ) ) : ?>

				<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>

					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['modal_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['button_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

				</span>

				<?php endif; ?>
				<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo wp_kses( $settings['button_text'], widget_pack_allow_tags('title') ); ?></span>
			</span>
		</a>
		<?php
	}
}
