<?php
namespace WidgetPack\Modules\Elementor;

use Elementor;
use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use WidgetPack;
use WidgetPack\Plugin;
use WidgetPack\Base\Widget_Pack_Module_Base;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public $sections_data = [];

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'avt-elementor';
	}

	public function register_controls_bg_parallax($section, $section_id, $args) {

		static $bg_sections = [ 'section_background' ];

		if ( !in_array( $section_id, $bg_sections ) ) { return; }
		
		$section->add_control(
			'section_parallax_on',
			[
				'label'        => AWP_CP . esc_html__( 'Enable Parallax?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set parallax background by enable this option.', 'avator-widget-pack' ),
				'separator'    => 'before',
				'condition'    => [
					'background_background' => ['classic'],
				],
			]
		);

		$section->add_control(
			'section_parallax_value',
			[
				'label' => esc_html__( 'Parallax Amount', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'   => -500,
						'max'   => 500,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -200,
				],
				'description'  => esc_html__( 'How much parallax move happen on scroll.', 'avator-widget-pack' ),
				'condition'    => [
					'section_parallax_on' => 'yes',
				],
			]
		);

	}

	public function register_controls_sticky($section, $section_id, $args) {

		static $layout_sections = [ 'section_advanced'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }
		

		$section->start_controls_section(
			'section_sticky_controls',
			[
				'label' => AWP_CP . __( 'Sticky', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);


		$section->add_control(
			'section_sticky_on',
			[
				'label'        => esc_html__( 'Enable Sticky', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set sticky options by enable this option.', 'avator-widget-pack' ),
			]
		);

		$section->add_control(
			'section_sticky_offset',
			[
				'label'   => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_active_bg',
			[
				'label'     => esc_html__( 'Active Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-sticky.avt-active' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_active_padding',
			[
				'label'      => esc_html__( 'Active Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.avt-sticky.avt-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label'     => esc_html__( 'Active Box Shadow', 'avator-widget-pack' ),
				'name'     => 'section_sticky_active_shadow',
				'selector' => '{{WRAPPER}}.avt-sticky.avt-active',
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_animation',
			[
				'label'     => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => widget_pack_transition_options(),
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_bottom',
			[
				'label' => esc_html__( 'Scroll Until', 'avator-widget-pack' ),
				'description'  => esc_html__( 'If you don\'t want to scroll after specific section so set that section ID/CLASS here. for example: #section1 or .section1 it\'s support ID/CLASS', 'avator-widget-pack' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);

		$section->add_control(
			'section_sticky_on_scroll_up',
			[
				'label'        => esc_html__( 'Sticky on Scroll Up', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'description'  => esc_html__( 'Set sticky options when you scroll up your mouse.', 'avator-widget-pack' ),
				'condition' => [
					'section_sticky_on' => 'yes',
				],
			]
		);


		$section->add_control(
			'section_sticky_off_media',
			[
				'label'       => __( 'Turn Off', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'options' => [
					'960' => [
						'title' => __( 'On Tablet', 'avator-widget-pack' ),
						'icon'  => 'fas fa-tablet',
					],
					'768' => [
						'title' => __( 'On Mobile', 'avator-widget-pack' ),
						'icon'  => 'fas fa-mobile',
					],
				],
				'condition' => [
					'section_sticky_on' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$section->end_controls_section();

	}

	public function register_controls_particles($section, $section_id, $args) {

		static $bg_sections = [ 'section_background' ];

		if ( !in_array( $section_id, $bg_sections ) ) { return; }

		$section->add_control(
			'section_particles_on',
			[
				'label'        => AWP_CP . esc_html__( 'Enable Particles?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => __( 'Switch on to enable Particles options! Note that currently particles are not visible in edit/preview mode for better elementor performance. It\'s only can viewed on the frontend. <b>Z-Index Problem: set column z-index 1 so particles will set behind the content.</b>', 'avator-widget-pack' ),
				'prefix_class' => 'avt-particles-',
				//'render_type'  => 'template',
			]
		);
		
		$section->add_control(
			'section_particles_js',
			[
				'label'     => esc_html__( 'Particles JSON', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => [
					'section_particles_on' => 'yes',
				],
				'description'   => __( 'Paste your particles JSON code here - Generate it from <a href="http://vincentgarreau.com/particles.js/#default" target="_blank">Here</a>.', 'avator-widget-pack' ),
				'default'       => '',
				'dynamic'       => [ 'active' => true ],
				//'render_type' => 'template',
			]
		);

	}


	public function register_controls_scheduled($section, $section_id, $args) {

		static $layout_sections = [ 'section_advanced'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }

		// Schedule content controls
		$section->start_controls_section(
			'section_scheduled_content_controls',
			[
				'label' => AWP_CP . __( 'Schedule Content', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);
		
		$section->add_control(
			'section_scheduled_content_on',
			[
				'label'        => __( 'Schedule Content?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => __( 'Switch on to schedule the contents of this column|section!.', 'avator-widget-pack' ),
			]
		);
		
		$section->add_control(
			'section_scheduled_content_start_date',
			[
				'label' => __( 'Start Date', 'avator-widget-pack' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2018-02-01 00:00:00',
				'condition' => [
					'section_scheduled_content_on' => 'yes',
				],
				'description' => __( 'Set start date for show this section.', 'avator-widget-pack' ),
			]
		);
		
		$section->add_control(
			'section_scheduled_content_end_date',
			[
				'label' => __( 'End Date', 'avator-widget-pack' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2018-02-28 00:00:00',
				'condition' => [
					'section_scheduled_content_on' => 'yes',
				],
				'description' => __( 'Set end date for hide the section.', 'avator-widget-pack' ),
			]
		);

		$section->end_controls_section();

	}

	public function register_controls_parallax($section, $section_id, $args) {

		static $style_sections = [ 'section_background'];

		if ( ! in_array( $section_id, $style_sections ) ) { return; }

		// parallax controls
		$section->start_controls_section(
			'section_parallax_content_controls',
			[
				'label' => AWP_CP . __( 'Parallax', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$section->add_control(
			'section_parallax_elements',
			[
				'label'   => __( 'Parallax Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name'        => 'section_parallax_title',
						'label'       => __( 'Title', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => __( 'Parallax 1' , 'avator-widget-pack' ),
						'label_block' => true,
						'render_type' => 'ui',
					],
					[
						'name'      => 'section_parallax_image',
						'label'     => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'      => Controls_Manager::MEDIA,
						//'condition' => [ 'parallax_content' => 'parallax_image' ],
					],
					[
						'name'    => 'section_parallax_depth',
						'label'   => __( 'Depth', 'avator-widget-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'default' => 0.1,
						'min'     => 0,
						'max'     => 1,
						'step'    => 0.1,
					],
					[
						'name'    => 'section_parallax_bgp_x',
						'label'   => __( 'Image X Position', 'avator-widget-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					],
					[
						'name'    => 'section_parallax_bgp_y',
						'label'   => __( 'Image Y Position', 'avator-widget-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					],
					[
						'name'    => 'section_parallax_bg_size',
						'label'   => __( 'Image Size', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'cover',
						'options' => [
							'auto'    => __( 'Auto', 'avator-widget-pack' ),
							'cover'   => __( 'Cover', 'avator-widget-pack' ),
							'contain' => __( 'Contain', 'avator-widget-pack' ),
						],
					],		
									
				],
				'title_field' => '{{{ section_parallax_title }}}',
			]
		);


		$section->add_control(
			'section_parallax_mode',
			[
				'label'   => esc_html__( 'Parallax Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''         => esc_html__( 'Relative', 'avator-widget-pack' ),
					'clip'     => esc_html__( 'Clip', 'avator-widget-pack' ),
					'hover'    => esc_html__( 'Hovar (Mobile also turn off)', 'avator-widget-pack' ),
				],
			]
		);
		

		$section->end_controls_section();

	}


	public function register_controls_widget_parallax($widget, $widget_id, $args) {
		static $widgets = [
			'_section_style', /* Section */
		];

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$widget->add_control(
			'_widget_parallax_on',
			[
				'label'        => AWP_CP . esc_html__( 'Enable Parallax?', 'avator-widget-pack' ),
				'description'  => esc_html__( 'Enable parallax for this element set below option after switch yes.', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'separator'    => 'before',
			]
		);

		$widget->add_control(
			'_widget_parallax_x_value',
			[
				'label'       => esc_html__( 'Parallax X', 'avator-widget-pack' ),
				'description' => esc_html__( 'If you need to parallax horizontally (x direction) so use this.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -200,
						'max'   => 200,
						'step' => 10,
					],
				],
				'condition'    => [
					'_widget_parallax_on' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_y_value',
			[
				'label'       => esc_html__( 'Parallax Y', 'avator-widget-pack' ),
				'description' => esc_html__( 'If you need to parallax vertically (y direction) so use this.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -200,
						'max'   => 200,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'condition'    => [
					'_widget_parallax_on' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_viewport_value',
			[
				'label'       => esc_html__( 'ViewPort Start', 'avator-widget-pack' ),
				'description' => esc_html__('Animation range depending on the viewport.', 'avator-widget-pack'),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.2,
				],
				'condition'    => [
					'_widget_parallax_on' => 'yes',
				],
			]
		);

		$widget->add_control(
			'_widget_parallax_opacity_value',
			[
				'label'       => esc_html__( 'Opacity', 'avator-widget-pack' ),
				'description' => esc_html__( 'This option set your element opacity when happen the parallax.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0,1',
				'options'     => [
					''  => esc_html__( 'None', 'avator-widget-pack' ),
					'0,1' => esc_html__( '0 -> 1', 'avator-widget-pack' ),
					'1,0' => esc_html__( '1 -> 0', 'avator-widget-pack' ),
				],
				'condition'    => [
					'_widget_parallax_on' => 'yes',
				],
			]
		);

	}


	public function register_controls_widget_tooltip($widget, $widget_id, $args) {
		static $widgets = [
			'_section_style', /* Section */
		];

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$widget->add_control(
			'widget_pack_widget_tooltip',
			[
				'label'        => AWP_CP . esc_html__( 'Use Tooltip?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'avator-widget-pack' ),
				'label_off'    => esc_html__( 'No', 'avator-widget-pack' ),
				'render_type'  => 'template',
			]
		);

		$widget->start_controls_tabs( 'widget_pack_widget_tooltip_tabs' );

		$widget->start_controls_tab(
			'widget_pack_widget_tooltip_settings_tab',
			[
				'label' => esc_html__( 'Settings', 'avator-widget-pack' ),
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_text',
			[
				'label'       => esc_html__( 'Description', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'render_type' => 'template',
				'default'     => 'This is Tooltip',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_placement',
			[
				'label'   => esc_html__( 'Placement', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top-start'    => esc_html__( 'Top Left', 'avator-widget-pack' ),
					'top'          => esc_html__( 'Top', 'avator-widget-pack' ),
					'top-end'      => esc_html__( 'Top Right', 'avator-widget-pack' ),
					'bottom-start' => esc_html__( 'Bottom Left', 'avator-widget-pack' ),
					'bottom'       => esc_html__( 'Bottom', 'avator-widget-pack' ),
					'bottom-end'   => esc_html__( 'Bottom Right', 'avator-widget-pack' ),
					'left'         => esc_html__( 'Left', 'avator-widget-pack' ),
					'right'        => esc_html__( 'Right', 'avator-widget-pack' ),
				],
				'render_type'  => 'template',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_animation',
			[
				'label'   => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shift-toward',
				'options' => [
					'shift-away'   => esc_html__( 'Shift-Away', 'avator-widget-pack' ),
					'shift-toward' => esc_html__( 'Shift-Toward', 'avator-widget-pack' ),
					'fade'         => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale'        => esc_html__( 'Scale', 'avator-widget-pack' ),
					'perspective'  => esc_html__( 'Perspective', 'avator-widget-pack' ),
				],
				'render_type'  => 'template',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_x_offset',
			[
				'label'   => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => -1000,
				'max'     => 1000,
				'step'    => 1,
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_y_offset',
			[
				'label'   => esc_html__( 'Distance', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => -1000,
				'max'     => 1000,
				'step'    => 1,
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_arrow',
			[
				'label'        => esc_html__( 'Arrow', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'condition'    => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'widget_pack_widget_tooltip_styles_tab',
			[
				'label' => esc_html__( 'Style', 'avator-widget-pack' ),
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_tooltip_width',
			[
				'label'      => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em',
				],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
				'render_type'  => 'template',
			]
		);

		
		$widget->add_control(
			'widget_pack_widget_tooltip_color',
			[
				'label'  => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'color: {{VALUE}}',
				],
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);
		
		$widget->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'widget_pack_widget_tooltip_background',
				'selector' => '{{WRAPPER}} .tippy-tooltip, {{WRAPPER}} .tippy-tooltip .tippy-backdrop',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_arrow_color',
			[
				'label'  => esc_html__( 'Arrow Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
				'condition' => [
					'widget_pack_widget_tooltip'       => 'yes',
				],
				'separator' => 'after',
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_tooltip_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'  => 'template',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'widget_pack_widget_tooltip_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .tippy-tooltip',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_text_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
				],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'widget_pack_widget_tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .tippy-tooltip',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'widget_pack_widget_tooltip_typography',
				'selector' => '{{WRAPPER}} .tippy-tooltip .tippy-content',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->end_controls_tabs();



	}



	public function register_controls_widget_motion_effect($widget, $widget_id, $args) {
		static $widgets = [
			'section_effects', /* Section */
		];

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$widget->add_control(
			'widget_pack_widget_transform',
			[
				'label'        => AWP_CP . esc_html__( 'Use Transform?', 'avator-widget-pack' ),
				'description'        => esc_html__( 'Don\'t use with others addon effect so it will work abnormal.' , 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-motion-effect-'
			]
		);


		$widget->start_controls_tabs( 'widget_pack_widget_motion_effect_tabs' );

		$widget->start_controls_tab(
			'widget_pack_widget_motion_effect_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
				'condition' => [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->add_control(
			'widget_pack_translate_toggle_normal',
			[
				'label' 		=> __( 'Translate', 'avator-widget-pack' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->start_popover();


		$widget->add_responsive_control(
			'widget_pack_widget_effect_transx_normal',
			[
				'label'      => esc_html__( 'Translate X', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'condition' => [
					'widget_pack_translate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_effect_transy_normal',
			[
				'label'      => esc_html__( 'Translate Y', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate({{widget_pack_widget_effect_transx_normal.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal.SIZE || 0}}px);',
					'(tablet){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate({{widget_pack_widget_effect_transx_normal_tablet.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal_tablet.SIZE || 0}}px);',
					'(mobile){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate({{widget_pack_widget_effect_transx_normal_mobile.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal_mobile.SIZE || 0}}px);',
				],
				'condition' => [
					'widget_pack_translate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->end_popover();



		$widget->add_control(
			'widget_pack_rotate_toggle_normal',
			[
				'label' 		=> __( 'Rotate', 'avator-widget-pack' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->start_popover();


		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatex_normal',
			[
				'label'      => esc_html__( 'Rotate X', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'condition' => [
					'widget_pack_rotate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatey_normal',
			[
				'label'      => esc_html__( 'Rotate Y', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'condition' => [
					'widget_pack_rotate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatez_normal',
			[
				'label'   => __( 'Rotate Z', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate( {{widget_pack_widget_effect_transx_normal.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_normal.SIZE || 0}}deg);',
					'(tablet){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate( {{widget_pack_widget_effect_transx_normal_tablet.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal_tablet.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_normal.SIZE || 0}}deg);',
					'(mobile){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate( {{widget_pack_widget_effect_transx_normal_mobile.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal_mobile.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_normal.SIZE || 0}}deg);',
				],
				'condition' => [
					'widget_pack_rotate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->end_popover();

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'widget_pack_widget_motion_effect_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
				'condition' => [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_translate_toggle_hover',
			[
				'label' 		=> __( 'Translate', 'avator-widget-pack' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->start_popover();


		$widget->add_responsive_control(
			'widget_pack_widget_effect_transx_hover',
			[
				'label'      => esc_html__( 'Translate X', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'condition' => [
					'widget_pack_translate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_effect_transy_hover',
			[
				'label'      => esc_html__( 'Translate Y', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate({{widget_pack_widget_effect_transx_hover.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover.SIZE || 0}}px);',
					'(tablet){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate({{widget_pack_widget_effect_transx_hover_tablet.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover_tablet.SIZE || 0}}px);',
					'(mobile){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate({{widget_pack_widget_effect_transx_hover_mobile.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover_mobile.SIZE || 0}}px);',
				],
				'condition' => [
					'widget_pack_translate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->end_popover();



		$widget->add_control(
			'widget_pack_rotate_toggle_hover',
			[
				'label' 		=> __( 'Rotate', 'avator-widget-pack' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->start_popover();


		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatex_hover',
			[
				'label'      => esc_html__( 'Rotate X', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'condition' => [
					'widget_pack_rotate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatey_hover',
			[
				'label'      => esc_html__( 'Rotate Y', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'condition' => [
					'widget_pack_rotate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatez_hover',
			[
				'label'   => __( 'Rotate Z', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate( {{widget_pack_widget_effect_transx_hover.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_hover.SIZE || 0}}deg);',
					'(tablet){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate( {{widget_pack_widget_effect_transx_hover_tablet.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover_tablet.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_hover.SIZE || 0}}deg);',
					'(mobile){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate( {{widget_pack_widget_effect_transx_hover_mobile.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover_mobile.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_hover.SIZE || 0}}deg);',
				],
				'condition' => [
					'widget_pack_rotate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->end_popover();


		$widget->end_controls_tab();

		$widget->end_controls_tabs();


	}


	protected function add_actions() {

		$bg_parallax              = widget_pack_option('section_parallax_show', 'widget_pack_elementor_extend', 'on' );
		$widget_parallax          = widget_pack_option('widget_parallax_show', 'widget_pack_elementor_extend', 'on' );
		$widget_tooltip           = widget_pack_option('widget_tooltip_show', 'widget_pack_elementor_extend', 'off' );
		$widget_motion            = widget_pack_option('widget_motion_show', 'widget_pack_elementor_extend', 'off' );
		$section_particles        = widget_pack_option('section_particles_show', 'widget_pack_elementor_extend', 'on' );
		$section_schedule         = widget_pack_option('section_schedule_show', 'widget_pack_elementor_extend', 'on' );
		$section_sticky           = widget_pack_option('section_sticky_show', 'widget_pack_elementor_extend', 'on' );
		$section_parallax_content = widget_pack_option('section_parallax_content_show', 'widget_pack_elementor_extend', 'on' );

		if ( 'on' === $bg_parallax ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_bg_parallax' ], 10, 3 );		
			add_action( 'elementor/frontend/section/before_render', [ $this, 'parallax_before_render' ], 10, 1 );
		}
		
		if ( 'on' === $widget_parallax ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_widget_parallax' ], 10, 3 );
			add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_parallax_before_render' ], 10, 1 );
		}

		if ( 'on' === $widget_tooltip ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_widget_tooltip' ], 10, 3 );
			add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_tooltip_before_render' ], 10, 1 );
		}

		if ( 'on' === $widget_motion ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_widget_motion_effect' ], 10, 3 );
			add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_motion_effect_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_particles ) {
			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_particles' ], 10, 3 );		
			add_action( 'elementor/frontend/section/before_render', [ $this, 'particles_before_render' ], 10, 1 );
			add_action( 'elementor/frontend/section/after_render', [ $this, 'particles_after_render' ], 10, 1 );

			//add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'particles_scripts' ], 10, 1 );
		}
		
		if ( 'on' === $section_schedule ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_scheduled' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'schedule_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_parallax_content ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_parallax' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'section_parallax_before_render' ], 10, 1 );
		}

		if ( 'on' === $section_sticky ) {
			add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_sticky' ], 10, 3 );
			add_action( 'elementor/frontend/section/before_render', [ $this, 'sticky_before_render' ], 10, 1 );
		}

		add_action( 'elementor/element/after_section_end', [$this, 'lightbox_settings'],10, 3);
		add_action( 'elementor/element/after_section_end', [$this, 'tooltip_settings'],10, 3);
		
	}



	public function parallax_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_parallax_on' ) == 'yes' ) {
			$parallax_settings = $section->get_settings( 'section_parallax_value' );
			$section->add_render_attribute( '_wrapper', 'avt-parallax', 'bgy: '.$parallax_settings['size'] );
		}
	}


	public function schedule_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_scheduled_content_on' ) == 'yes' ) {
			$star_date    = strtotime($settings['section_scheduled_content_start_date']);
			$end_date     = strtotime($settings['section_scheduled_content_end_date']);
			$current_date = strtotime(gmdate( 'Y-m-d H:i', ( time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ) ));

			if ( ($current_date >= $star_date) and ($current_date <= $end_date) ) {
				$section->add_render_attribute( '_wrapper', 'class', 'avt-scheduled' );
			} else {
				$section->add_render_attribute( '_wrapper', 'class', 'avt-hidden' );
			}
		}
	}

	public function sticky_before_render($section) {    		
		$settings = $section->get_settings();
		if( !empty($settings[ 'section_sticky_on' ]) == 'yes' ) {
			$sticky_option = [];
			if ( !empty($settings[ 'section_sticky_on_scroll_up' ]) ) {
				$sticky_option['show-on-up'] = 'show-on-up: true';
			}

			if ( !empty($settings[ 'section_sticky_offset' ]['size']) ) {
				$sticky_option['offset'] = 'offset: ' . $settings[ 'section_sticky_offset' ]['size'];
			}

			if ( !empty($settings[ 'section_sticky_animation' ]) ) {
				$sticky_option['animation'] = 'animation: avt-animation-' . $settings[ 'section_sticky_animation' ] . '; top: 100';
			}

			if ( !empty($settings[ 'section_sticky_bottom' ]) ) {
				$sticky_option['bottom'] = 'bottom: ' . $settings[ 'section_sticky_bottom' ];
			}

			if ( !empty($settings[ 'section_sticky_off_media' ]) ) {
				$sticky_option['media'] = 'media: ' . $settings[ 'section_sticky_off_media' ];
			}
			
			$section->add_render_attribute( '_wrapper', 'avt-sticky', implode(";",$sticky_option) );
			$section->add_render_attribute( '_wrapper', 'class', 'avt-sticky' );
		}
	}
	

	public function widget_parallax_before_render($widget) {    		
		$settings = $widget->get_settings();
		if( $settings['_widget_parallax_on'] == 'yes' ) {
			$slider_settings = [];
			if (!empty($settings['_widget_parallax_opacity_value'])) {
				$slider_settings['opacity'] = 'opacity: ' . $settings['_widget_parallax_opacity_value'] . ';';	
			}
			if (!empty($settings['_widget_parallax_x_value']['size'])) {
				$slider_settings['x'] = 'x: ' . $settings['_widget_parallax_x_value']['size'] . ',0;';	
			}
			if (!empty($settings['_widget_parallax_y_value']['size'])) {
				$slider_settings['y'] = 'y: ' . $settings['_widget_parallax_y_value']['size'] . ',0;';
			}
			if (!empty($settings['_widget_parallax_viewport_value']['size'])) {
				$slider_settings['viewport'] = 'viewport: ' . $settings['_widget_parallax_viewport_value']['size'] . ';';
			}

			$widget->add_render_attribute( '_wrapper', 'avt-parallax', implode(" ",$slider_settings) );
		}
	}

	public function widget_tooltip_before_render($widget) {    		
		$settings = $widget->get_settings();

		if( $settings['widget_pack_widget_tooltip'] == 'yes' ) {
			$element_id = $widget->get_settings( '_element_id' );
			if (empty($element_id)) {
				$id = 'avt-widget-tooltip-'.$widget->get_id();
				$widget->add_render_attribute( '_wrapper', 'id', $id, true );
			} else {
				$id = $widget->get_settings( '_element_id' );
			}
			
			$widget->add_render_attribute( '_wrapper', 'class', 'avt-tippy-tooltip' );
			$widget->add_render_attribute( '_wrapper', 'data-tippy', '', true );

			if (!empty($settings['widget_pack_widget_tooltip_text'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-content', $settings['widget_pack_widget_tooltip_text'], true );
			}
			if (!empty($settings['widget_pack_widget_tooltip_placement'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-placement', $settings['widget_pack_widget_tooltip_placement'], true );
			}
			if (!empty($settings['widget_pack_widget_tooltip_arrow'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-arrow', 'true', true );
			}
			if (!empty($settings['widget_pack_widget_tooltip_animation'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-animation', $settings['widget_pack_widget_tooltip_animation'], true );
			}
			
			if (!empty($settings['widget_pack_widget_tooltip_x_offset']) or !empty($settings['widget_pack_widget_tooltip_y_offset']) ) {
				$xoffset = ( !empty($settings['widget_pack_widget_tooltip_x_offset'] ) ? $settings['widget_pack_widget_tooltip_x_offset'] : '0' ) ;
				$yoffset = ( !empty($settings['widget_pack_widget_tooltip_y_offset'] ) ? $settings['widget_pack_widget_tooltip_y_offset'] : '0' ) ;
				$offset  = $xoffset .','. $yoffset;
				$widget->add_render_attribute( '_wrapper', 'data-tippy-offset', $offset, true );
			}
			

			$handle = 'tippyjs';
			$list = 'enqueued';
			if (wp_script_is( $handle, $list )) {
				return;
			} else {
				wp_enqueue_script( 'popper' );
				wp_enqueue_script( 'tippyjs' );
			}
			

		}
	}

	public function widget_motion_effect_before_render($widget) {    		
		$settings = $widget->get_settings();

		// if( $settings['widget_pack_widget_tooltip'] == 'yes' ) {
		// 	$element_id = $widget->get_settings( '_element_id' );
		// 	if (empty($element_id)) {
		// 		$id = 'avt-widget-tooltip-'.$widget->get_id();
		// 		$widget->add_render_attribute( '_wrapper', 'id', $id, true );
		// 	} else {
		// 		$id = $widget->get_settings( '_element_id' );
		// 	}
			
		// 	$widget->add_render_attribute( '_wrapper', 'class', 'avt-tippy-tooltip' );
		// 	$widget->add_render_attribute( '_wrapper', 'data-tippy', '', true );
		// }
	}
	
	public function particles_before_render($section) {    		
		$settings = $section->get_settings();
		$id       = $section->get_id();
		
		if( $settings['section_particles_on'] == 'yes' ) {

			$particle_js = $settings['section_particles_js'];
			
			if (empty($particle_js)) {
				$particle_js = '{"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}';
			}

			$this->sections_data[$id] = [ 'particles_js' => $particle_js ];
			
			WidgetPack\widget_pack_config()->elements_data['sections'] = $this->sections_data;
		}

		
					

	}

	public function particles_after_render($section) {
		$settings = $section->get_settings();
		$handle   = 'particles';
		$list     = 'enqueued';
		if (! wp_script_is( $handle, $list ) and $section->get_settings( 'section_particles_on' ) == 'yes' ) {
			wp_enqueue_script( 'particles' );
		}
		
	}


	public function section_parallax_before_render($section) {
		$parallax_elements = $section->get_settings('section_parallax_elements');
		$settings          = $section->get_settings();

		if( empty($parallax_elements) ) {
			return;
		}

		wp_enqueue_script( 'parallax' );

		$id = $section->get_id();
		$section->add_render_attribute( 'scene', 'class', 'parallax-scene' );
		$section->add_render_attribute( '_wrapper', 'class', 'has-avt-parallax' );

		if ( 'relative' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-relative-input', 'true' );
		} elseif ( 'clip' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-clip-relative-input', 'true' );
		} elseif ( 'hover' === $settings['section_parallax_mode']) {
			$section->add_render_attribute( 'scene', 'data-hover-only', 'true' );
		}


		?>
		<div data-parallax-id="avt_scene<?php echo esc_attr($id); ?>" id="avt_scene<?php echo esc_attr($id); ?>" <?php echo $section->get_render_attribute_string( 'scene' ); ?>>
			<?php foreach ( $parallax_elements as $index => $item ) : ?>
			
				<?php 

				$image_src = wp_get_attachment_image_src( $item['section_parallax_image']['id'], 'full' ); 

				if ($item['section_parallax_bgp_x']) {
					$section->add_render_attribute( 'item', 'style', 'background-position-x: ' . $item['section_parallax_bgp_x'] . '%;', true );
				}
				if ($item['section_parallax_bgp_y']) {
					$section->add_render_attribute( 'item', 'style', 'background-position-y: ' . $item['section_parallax_bgp_y'] . '%;' );
				}
				if ($item['section_parallax_bg_size']) {
					$section->add_render_attribute( 'item', 'style', 'background-size: ' . $item['section_parallax_bg_size'] . ';' );
				}

				if ($image_src[0]) {
					$section->add_render_attribute( 'item', 'style', 'background-image: url(' . esc_url($image_src[0]) .');' );
				}

				?>
				
				<div data-depth="<?php echo esc_attr($item['section_parallax_depth']); ?>" class="avt-scene-item" <?php echo $section->get_render_attribute_string( 'item' ); ?>></div>
				
			<?php endforeach; ?>
		</div>

		<?php
	}


	public function lightbox_settings($section, $section_id) {

		static $layout_sections = [ 'section_page_style'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }

		$section->start_controls_section(
			'widget_pack_lightbox_style',
			[
				'label' => AWP_CP . esc_html__( 'Lightbox Global Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$section->add_control(
			'widget_pack_lightbox_bg',
			[
				'label'     => esc_html__( 'Lightbox Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox' => 'background-color: {{VALUE}};',
				],
			]
		);


		$section->add_control(
			'widget_pack_cb_color',
			[
				'label'     => esc_html__( 'Close Button Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox .avt-close.avt-icon' => 'color: {{VALUE}};',
				],
			]
		);
		
		$section->add_control(
			'widget_pack_cb_bg',
			[
				'label'     => esc_html__( 'Close Button Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox .avt-close.avt-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$section->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'widget_pack_cb_border',
				'label'       => esc_html__( 'Close Button Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.avt-lightbox .avt-close.avt-icon',
			]
		);

		$section->add_control(
			'widget_pack_cb_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'.avt-lightbox .avt-close.avt-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$section->add_control(
			'widget_pack_cb_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'.avt-lightbox .avt-close.avt-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$section->add_control(
			'widget_pack_toolbar_color',
			[
				'label'     => esc_html__( 'Toolbar Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox .avt-lightbox-toolbar' => 'color: {{VALUE}};',
				],
			]
		);
		
		$section->add_control(
			'widget_pack_toolbar_bg',
			[
				'label'     => esc_html__( 'Toolbar Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox .avt-lightbox-toolbar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$section->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'widget_pack_toolbar_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '.avt-lightbox .avt-lightbox-toolbar',
			]
		);



		$section->add_control(
			'widget_pack_lightbox_max_height',
			[
				'label'      => esc_html__( 'Max Height (vh)', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'vh',
				],
				'range'      => [
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'.avt-lightbox .avt-lightbox-items>*>*' => 'max-height: {{SIZE}}vh;',
				],
				'render_type'=> 'template',
				'separator'  => 'before',
			]
		);


		$section->end_controls_section();
	}


	public function tooltip_settings($section, $section_id) {
		
		static $layout_sections = [ 'section_page_style'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }


		$section->start_controls_section(
			'widget_pack_global_tooltip_style',
			[
				'label' => AWP_CP . esc_html__( 'Tooltip Global Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$section->add_responsive_control(
			'widget_pack_global_tooltip_width',
			[
				'label'      => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em',
				],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'  => [
					'.elementor-widget .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type'  => 'template',
			]
		);

		$section->add_control(
			'widget_pack_global_tooltip_color',
			[
				'label'  => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'.elementor-widget .tippy-tooltip' => 'color: {{VALUE}}',
				],
			]
		);

		$section->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'widget_pack_global_tooltip_background',
				'selector' => '.elementor-widget .tippy-tooltip, .elementor-widget .tippy-tooltip .tippy-backdrop',
			]
		);

		$section->add_control(
			'widget_pack_global_tooltip_arrow_color',
			[
				'label'  => esc_html__( 'Arrow Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'.elementor-widget .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'.elementor-widget .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'.elementor-widget .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'.elementor-widget .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
				'condition' => [
					'widget_pack_global_tooltip'       => 'yes',
				],
			]
		);

		$section->add_responsive_control(
			'widget_pack_global_tooltip_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'.elementor-widget .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);

		$section->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'widget_pack_global_tooltip_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.elementor-widget .tippy-tooltip',
			]
		);

		$section->add_responsive_control(
			'widget_pack_global_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'.elementor-widget .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$section->add_control(
			'widget_pack_global_tooltip_text_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
				],
				'selectors'  => [
					'.elementor-widget .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);


		$section->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'widget_pack_global_tooltip_box_shadow',
				'selector' => '.elementor-widget .tippy-tooltip',
			]
		);
		
		$section->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'widget_pack_global_tooltip_typography',
				'selector' => '.elementor-widget .tippy-tooltip .tippy-content',
			]
		);

		$section->end_controls_section();

	}


}
