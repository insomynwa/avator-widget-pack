<?php
namespace WidgetPack\Modules\Offcanvas\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Repeater;
use WidgetPack\Widget_Pack_Loader;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Offcanvas Widget
 * @since 1.2.0
 */
class Offcanvas extends Widget_Base {

	public function get_name() {
		return 'avt-offcanvas';
	}

	public function get_title() {
		return AWP . esc_html__( 'Offcanvas', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-offcanvas';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'offcanvas', 'menu', 'navigator' ];
	}

	public function get_style_depends() {
		return [ 'wipa-offcanvas' ];
	}

	public function get_script_depends() {
		return [ 'wipa-offcanvas' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/CrrlirVfmQE';
	}

	protected function _register_controls() {

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
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'avator-widget-pack' ),
					'custom'  => esc_html__( 'Custom Link', 'avator-widget-pack' ),
				],				
			]
		);

		$this->add_control(
			'offcanvas_custom_id',
			[
				'label'       => esc_html__( 'Offcanvas Selector', 'avator-widget-pack' ),
				'description' => __( 'Set your offcanvas selector here. For example: <b>.custom-link</b> or <b>#customLink</b>. Set this selector where you want to link this offcanvas.' , 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '#avt-custom-offcanvas', 'avator-widget-pack' ),
				'condition'   => [
					'layout' => 'custom',
				],
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sidebar',
				'options' => [
					'sidebar'   => esc_html__( 'Sidebar', 'avator-widget-pack' ),
					'elementor' => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
					'anywhere'  => esc_html__( 'AE Template', 'avator-widget-pack' ),
				],				
			]
		);

        $this->add_control(
            'template_id',
            [
                'label'       => __( 'Choose Template', 'avator-widget-pack' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0',
                'options'     => widget_pack_et_options(),
                'label_block' => 'true',
                'condition'   => ['source' => 'elementor'],
            ]
        );

        $this->add_control(
            'sidebars',
            [
                'label'       => esc_html__( 'Choose Sidebar', 'avator-widget-pack' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0',
                'options'     => widget_pack_sidebar_options(),
                'label_block' => 'true',
                'condition'   => ['source' => 'sidebar'],
            ]
        );

        $this->add_control(
            'anywhere_id',
            [
                'label'       => esc_html__( 'Choose Template', 'avator-widget-pack' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0',
                'options'     => widget_pack_ae_options(),
                'label_block' => 'true',
                'condition'   => ['source' => 'anywhere'],
                'render_type' => 'template',
            ]
        );


		$this->add_control(
			'custom_content_before_switcher',
			[
				'label' => esc_html__( 'Custom Content Before', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'custom_content_after_switcher',
			[
				'label' => esc_html__( 'Custom Content After', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'offcanvas_overlay',
			[
				'label'        => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'offcanvas_animations',
			[
				'label'     => esc_html__( 'Animations', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slide',
				'options'   => [
					'slide'  => esc_html__( 'Slide', 'avator-widget-pack' ),
					'push'   => esc_html__( 'Push', 'avator-widget-pack' ),
					'reveal' => esc_html__( 'Reveal', 'avator-widget-pack' ),
					'none'   => esc_html__( 'None', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'offcanvas_flip',
			[
				'label'        => esc_html__( 'Flip', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'right',
			]
		);

		$this->add_control(
			'offcanvas_close_button',
			[
				'label'   => esc_html__( 'Close Button', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'offcanvas_bg_close',
			[
				'label'   => esc_html__( 'Close on Click Background', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'offcanvas_esc_close',
			[
				'label'   => esc_html__( 'Close on Press ESC', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'offcanvas_width',
			[
				'label'      => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 240,
						'max' => 1200,
					],
					'vw' => [
						'min' => 10,
						'max' => 100,
					]
				],
				'selectors' => [
					'body:not(.avt-offcanvas-flip) #avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'width: {{SIZE}}{{UNIT}};left: -{{SIZE}}{{UNIT}};',
					'body:not(.avt-offcanvas-flip) #avt-offcanvas-{{ID}}.avt-offcanvas.avt-open>.avt-offcanvas-bar' => 'left: 0;',
					'.avt-offcanvas-flip #avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'width: {{SIZE}}{{UNIT}};right: -{{SIZE}}{{UNIT}};',
					'.avt-offcanvas-flip #avt-offcanvas-{{ID}}.avt-offcanvas.avt-open>.avt-offcanvas-bar' => 'right: 0;',
				],
				'condition' => [
					'offcanvas_animations!' => ['push', 'reveal'],
				]
			]
		);


		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_custom_before',
			[
				'label'     => esc_html__( 'Custom Content Before', 'avator-widget-pack' ),
				'condition' => [
					'custom_content_before_switcher' => 'yes',
				]
			]
		);

		$this->add_control(
			'custom_content_before',
			[
				'label'   => esc_html__( 'Custom Content Before', 'avator-widget-pack' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'This is your custom content for before of your offcanvas.', 'avator-widget-pack' ),
			]
		);
		
		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_custom_after',
			[
				'label'     => esc_html__( 'Custom Content After', 'avator-widget-pack' ),
				'condition' => [
					'custom_content_after_switcher' => 'yes',
				]
			]
		);


		$this->add_control(
			'custom_content_after',
			[
				'label'   => esc_html__( 'Custom Content After', 'avator-widget-pack' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'This is your custom content for after of your offcanvas.', 'avator-widget-pack' ),
			]
		);
		
		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_offcanvas_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
				'condition'   => [
					'layout' => 'default',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Offcanvas', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Offcanvas', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'button_align',
			[
				'label'   => esc_html__( 'Button Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'default'      => 'left',
			]
		);

		$this->add_responsive_control(
			'button_offset',
			[
				'label' => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -150,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-button' => 'transform: translateX({{SIZE}}{{UNIT}});',
				],
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
			'offcanvas_button_icon',
			[
				'label'       => esc_html__( 'Button Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'button_icon',
				'default' => [
					'value' => 'fas fa-bars',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'button_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'offcanvas_button_icon[value]!' => '',
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
					'offcanvas_button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-button .avt-offcanvas-button-icon.elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-offcanvas-button .avt-offcanvas-button-icon.elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_content',
			[
				'label' => esc_html__( 'Offcanvas', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'offcanvas_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar a'   => 'color: {{VALUE}};',
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar a *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'offcanvas_content_shadow',
				'selector'  => '#avt-offcanvas-{{ID}}.avt-offcanvas > div',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'offcanvas_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_widget',
			[
				'label'     => esc_html__( 'Widget', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'source' => 'sidebar',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'offcanvas_widget_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar .widget',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'widget_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar .widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'offcanvas_widget_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar .widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'offcanvas_vertical_spacing',
			[
				'label'     => esc_html__( 'Vertical Spacing', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar .widget:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'layout' => 'default',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_offcanvas_button_style' );

		$this->start_controls_tab(
			'tab_offcanvas_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'offcanvas_button_text_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-button' => 'color: {{VALUE}};',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-offcanvas-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_background_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'offcanvas_button_shadow',
				'selector'  => '{{WRAPPER}} .avt-offcanvas-button',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'offcanvas_button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-offcanvas-button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'offcanvas_button_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-offcanvas-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-offcanvas-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'offcanvas_button_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-offcanvas-button',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_offcanvas_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'offcanvas_button_hover_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-offcanvas-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_background_hover_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_hover_border_color',
			[
				'label'     => esc_html__( 'Button Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'offcanvas_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Button Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_close_button',
			[
				'label'     => esc_html__( 'Close Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'offcanvas_close_button' => 'yes'
				]
			]
		);

		$this->start_controls_tabs( 'tabs_close_button_style' );

		$this->start_controls_tab(
			'tab_close_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'close_button_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_bg',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'close_button_shadow',
				'selector'  => '#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'close_button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'close_button_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'close_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_close_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'close_button_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'close_button_border_border!' => '',
				],
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = ('custom' == $settings['layout'] and ! empty($settings['offcanvas_custom_id'])) ? $settings['offcanvas_custom_id'] : 'avt-offcanvas-' . $this->get_id();

		$this->add_render_attribute( 'offcanvas', 'class', 'avt-offcanvas' );
		$this->add_render_attribute( 'offcanvas', 'id', $id );
        $this->add_render_attribute(
        	[
        		'offcanvas' => [
        			'data-settings' => [
        				wp_json_encode(array_filter([
							'id'      =>  $id,
							'layout'  => $settings['layout'],
        		        ]))
        			]
        		]
        	]
        );

		$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'mode: ' . $settings['offcanvas_animations'] . ';' );

		if ( $settings['offcanvas_overlay'] ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'overlay: true;' );
		}

		if ( 'right' == $settings['offcanvas_flip'] ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'flip: true;' );
		}

		if ( 'yes' !== $settings['offcanvas_bg_close'] ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'bg-close: false;' );
		}

		if ( 'yes' !== $settings['offcanvas_esc_close'] ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'esc-close: false;' );
		}

		

		?>

		
		<?php $this->render_button(); ?>

		
	    <div <?php echo $this->get_render_attribute_string( 'offcanvas' ); ?>>
	        <div class="avt-offcanvas-bar">
				
				<?php if ($settings['offcanvas_close_button']) : ?>
	        		<button class="avt-offcanvas-close" type="button" avt-close></button>
	        	<?php endif; ?>

	        	
				<?php if ($settings['custom_content_before_switcher'] or $settings['custom_content_after_switcher'] or !empty( $settings['source'] )) : ?>
		        	<?php if ($settings['custom_content_before_switcher'] === 'yes' and !empty($settings['custom_content_before'])) : ?>
		        	<div class="avt-offcanvas-custom-content-before widget">
		            	<?php echo wp_kses_post($settings['custom_content_before']); ?>		        		
		        	</div>
		        	<?php endif; ?>

		            <?php 
		            	if ( 'sidebar' == $settings['source'] and !empty( $settings['sidebars'] ) ) {
		            		dynamic_sidebar( $settings['sidebars'] );
		            	} elseif ('elementor' == $settings['source'] and !empty( $settings['template_id'] )) {
		            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['template_id'] );
		            		echo widget_pack_template_edit_link( $settings['template_id'] );
		            	} elseif ('anywhere' == $settings['source'] and !empty( $settings['anywhere_id'] )) {
		            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['anywhere_id'] );
		            		echo widget_pack_template_edit_link( $settings['anywhere_id'] );
		            	}
		            ?>

	            	<?php if ($settings['custom_content_after_switcher'] === 'yes' and !empty($settings['custom_content_after'])) : ?>
	            	<div class="avt-offcanvas-custom-content-after widget">
	                	<?php echo wp_kses_post($settings['custom_content_after']); ?>		        		
	            	</div>
	            	<?php endif; ?>
	            <?php else: ?>
					<div class="avt-offcanvas-custom-content-after widget">
						<div class="avt-alert-warning" avt-alert><?php esc_html_e('Ops you don\'t select or enter any content! Add your offcanvas content from editor.', 'avator-widget-pack'); ?></div>
					</div>
	            <?php endif; ?>
	        </div>
	    </div>

		<?php
	}

	protected function render_button() {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-offcanvas-' . $this->get_id();

		if ( 'default' !== $settings['layout'] ) {
			return;
		}

		$this->add_render_attribute( 'button', 'class', ['avt-offcanvas-button', 'elementor-button'] );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$this->add_render_attribute( 'button', 'avt-toggle', 'target: #' . esc_attr($id) );
		$this->add_render_attribute( 'button', 'href', '#' );

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['button_icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'avt-offcanvas-button-icon elementor-button-icon' );

		$this->add_render_attribute( 'text', 'class', 'elementor-button-text' );

		if ( ! isset( $settings['button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['button_icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['offcanvas_button_icon'] );
		$is_new    = empty( $settings['button_icon'] ) && Icons_Manager::is_migration_allowed();

		?>

		<div class="avt-offcanvas-button-wrapper">
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?> >
			
				<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
					<?php if ( ! empty( $settings['offcanvas_button_icon']['value'] ) ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>

						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $settings['offcanvas_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $settings['button_icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
					<?php endif; ?>
					<?php if ( ! empty( $settings['button_text'] ) ) : ?>
						<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo wp_kses( $settings['button_text'], widget_pack_allow_tags('title') ); ?></span>
					<?php endif; ?>
				</span>

			</a>
		</div>
		<?php
	}
}
