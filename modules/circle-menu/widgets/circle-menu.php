<?php
namespace WidgetPack\Modules\CircleMenu\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Circle_Menu extends Widget_Base {
	public function get_name() {
		return 'avt-circle-menu';
	}

	public function get_title() {
		return AWP . esc_html__( 'Circle Menu', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-circle-menu';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'circle', 'menu', 'rounded' ];
	}

	public function get_script_depends() {
		return [ 'circle-menu', 'avt-uikit-icons' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_iconnav',
			[
				'label' => esc_html__( 'Circle Menu', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'toggle_icon',
			[
				'label'   => __( 'Choose Toggle Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'plus' => [
						'title' => __( 'Plus', 'avator-widget-pack' ),
						'icon'  => 'fas fa-plus',
					],
					'plus-circle' => [
						'title' => __( 'Plus Circle', 'avator-widget-pack' ),
						'icon'  => 'fas fa-plus-circle',
					],
					'close' => [
						'title' => __( 'Close', 'avator-widget-pack' ),
						'icon'  => 'fas fa-times',
					],
					'cog' => [
						'title' => __( 'Settings', 'avator-widget-pack' ),
						'icon'  => 'fas fa-cog',
					],
					'menu' => [
						'title' => __( 'Bars', 'avator-widget-pack' ),
						'icon'  => 'fas fa-bars',
					],
				],
				'default' => 'plus',
			]
		);

		$this->add_control(
			'circle_menu',
			[
				'label'   => esc_html__( 'Circle Menu Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'circle_menu_icon'  => ['value' => 'fas fa-home', 'library' => 'fa-solid'],
						'iconnav_link' 		=> [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						], 
						'title' 			=> esc_html__( 'Home', 'avator-widget-pack' ) 
					],
					[
						'circle_menu_icon'  => ['value' => 'fas fa-shopping-bag', 'library' => 'fa-solid'],
						'iconnav_link' => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						],
						'title' 			=> esc_html__( 'Products', 'avator-widget-pack' ) 
					],
					[
						'circle_menu_icon'  => ['value' => 'fas fa-wrench', 'library' => 'fa-solid'],
						'iconnav_link' 		=> [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						],
						'title' 			=> esc_html__( 'Settings', 'avator-widget-pack' ) 
					],
					[
						'circle_menu_icon'  => ['value' => 'fas fa-book', 'library' => 'fa-solid'],
						'iconnav_link' 		=> [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						],
						'title' 			=> esc_html__( 'Documentation', 'avator-widget-pack' ) 
					],
					[
						'circle_menu_icon'  => ['value' => 'fas fa-envelope', 'library' => 'fa-solid'],
						'iconnav_link' 		=> [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						],
						'title' 			=> esc_html__( 'Contact Us', 'avator-widget-pack' ) 
					],
				],
				'fields' => [
					[
						'name'    => 'title',
						'label'   => esc_html__( 'Menu Title', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'dynamic' => [ 'active' => true ],
						'default' => 'Home',
					],
					[
						'name'    => 'circle_menu_icon',
						'label'   => esc_html__( 'Icon', 'avator-widget-pack' ),
						'type'    => Controls_Manager::ICONS,
						'fa4compatibility' => 'icon',
						'default' => [
							'value' => 'fas fa-home',
							'library' => 'fa-solid',
						],
					],
					[
						'name'        => 'iconnav_link',
						'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::URL,
						'default'     => [ 'url' => '#' ],
						'dynamic'     => [ 'active' => true ],
						'description' => 'Add your section id WITH the # key. e.g: #my-id also you can add internal/external URL',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'toggle_icon_position',
			[
				'label'   => __( 'Toggle Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => widget_pack_position(),			
			]
		);

		$this->add_control(
			'toggle_icon_x_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' =>  0,
				],
				'range' => [
					'px' => [
						'min'  => -500,
						'step' => 10,
						'max'  => 500,
					],
				],
			]
		);

		$this->add_control(
			'toggle_icon_y_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,'default' => [
					'size' =>  0,
				],
				'range' => [
					'px' => [
						'min'  => -500,
						'step' => 10,
						'max'  => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu-container' => 'transform: translate({{toggle_icon_x_position.size}}px, {{SIZE}}px);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional_settings',
			[
				'label' => esc_html__( 'Additional Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'direction',
			[
				'label'   => __( 'Menu Direction', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-right',
				'options' => [
					'top'          => esc_html__('Top', 'avator-widget-pack'),
					'right'        => esc_html__('Right', 'avator-widget-pack'),
					'bottom'       => esc_html__('Bottom', 'avator-widget-pack'),
					'left'         => esc_html__('Left', 'avator-widget-pack'),
					'top'          => esc_html__('Top', 'avator-widget-pack'),
					'full'         => esc_html__('Full', 'avator-widget-pack'),
					'top-left'     => esc_html__('Top-Left', 'avator-widget-pack'),
					'top-right'    => esc_html__('Top-Right', 'avator-widget-pack'),
					'top-half'     => esc_html__('Top-Half', 'avator-widget-pack'),
					'bottom-left'  => esc_html__('Bottom-Left', 'avator-widget-pack'),
					'bottom-right' => esc_html__('Bottom-Right', 'avator-widget-pack'),
					'bottom-half'  => esc_html__('Bottom-Half', 'avator-widget-pack'),
					'left-half'    => esc_html__('Left-Half', 'avator-widget-pack'),
					'right-half'   => esc_html__('Right-Half', 'avator-widget-pack'),
				]
			]
		);

		$this->add_control(
			'item_diameter',
			[
				'label'   => __( 'Circle Menu Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min'  => 20,
						'step' => 1,
						'max'  => 50,
					],
				],
			]
		);

		$this->add_control(
			'circle_radius',
			[
				'label'   => __( 'Circle Menu Distance', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min'  => 20,
						'step' => 5,
						'max'  => 500,
					],
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => __( 'Speed', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 500,
				],
				'range' => [
					'px' => [
						'min'  => 100,
						'step' => 10,
						'max'  => 1000,
					],
				],
			]
		);

		$this->add_control(
			'delay',
			[
				'label'   => __( 'Delay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1000,
				],
				'range' => [
					'px' => [
						'min'  => 100,
						'step' => 10,
						'max'  => 2000,
					],
				],
			]
		);

		$this->add_control(
			'step_out',
			[
				'label'   => __( 'Step Out', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min'  => -200,
						'step' => 5,
						'max'  => 200,
					],
				],
			]
		);

		$this->add_control(
			'step_in',
			[
				'label'   => __( 'Step In', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -20,
				],
				'range' => [
					'px' => [
						'min'  => -200,
						'step' => 5,
						'max'  => 200,
					],
				],
			]
		);

		$this->add_control(
			'trigger',
			[
				'label'   => __( 'Trigger', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover' => esc_html__('Hover', 'avator-widget-pack'),
					'click' => esc_html__('Click', 'avator-widget-pack'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'toggle_icon_size',
			[
				'label' => esc_html__( 'Toggle Icon Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 48,
					],
				],
				'default' => [
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon a svg' => 'height: {{SIZE}}px; width: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'transition_function',
			[
				'label'   => esc_html__( 'Transition', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ease',
				'options' => [
					'ease'        => esc_html('Ease', 'avator-widget-pack'),
					'linear'      => esc_html('Linear', 'avator-widget-pack'),
					'ease-in'     => esc_html('Ease-In', 'avator-widget-pack'),
					'ease-out'    => esc_html('Ease-Out', 'avator-widget-pack'),
					'ease-in-out' => esc_html('Ease-In-Out', 'avator-widget-pack'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_toggle_icon',
			[
				'label' => esc_html__( 'Toggle Icon', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
	
		$this->start_controls_tabs( 'tabs_toggle_icon_style' );

		$this->start_controls_tab(
			'tab_toggle_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);
		
		$this->add_control(
			'toggle_icon_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'toggle_icon_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon',
			]
		);

		$this->add_responsive_control(
			'toggle_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'toggle_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon',
			]
		);

		$this->add_responsive_control(
			'toggle_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'toggle_icon_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'toggle_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li.avt-toggle-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_circle_menu_icon',
			[
				'label' => esc_html__( 'Circle Icon', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
	
		$this->start_controls_tabs( 'tabs_circle_menu_icon_style' );

		$this->start_controls_tab(
			'tab_circle_menu_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);
		
		$this->add_control(
			'circle_menu_icon_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li.avt-menu-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_menu_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu-container .avt-menu-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-circle-menu-container .avt-menu-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'circle_menu_icon_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-circle-menu li.avt-menu-icon',
			]
		);

		$this->add_responsive_control(
			'circle_menu_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-circle-menu li.avt-menu-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'circle_menu_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-circle-menu li.avt-menu-icon',
			]
		);

		$this->add_responsive_control(
			'circle_menu_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .avt-circle-menu li.avt-menu-icon' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'circle_menu_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-circle-menu li.avt-menu-icon' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'circle_menu_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'circle_menu_icon_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_menu_icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu-container .avt-menu-icon:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-circle-menu-container .avt-menu-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_menu_icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'circle_menu_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-circle-menu li:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_loop_iconnav_list($settings, $list) {

		$this->add_render_attribute(
			[
				'iconnav-link' => [
					'class' => [
						'avt-position-center',
					],
					'target' => [
						$list['iconnav_link']['is_external'] ? '_blank' : '_self',
					],
					'rel' => [
						$list['iconnav_link']['nofollow'] ? 'nofollow' : '',
					],
					'title' => [
						esc_html($list['title']),
					],
					'href' => [
						esc_url($list['iconnav_link']['url']),
					],
				],
			], '', '', true
		);

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $list['__fa4_migrated']['circle_menu_icon'] );
		$is_new    = empty( $list['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
	    <li class="avt-menu-icon">
			<a <?php echo $this->get_render_attribute_string( 'iconnav-link' ); ?>>
				<?php if ($list['circle_menu_icon']['value']) : ?>
					<span>

						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $list['circle_menu_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $list['icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>

				<?php endif; ?>
			</a>
		</li>
		<?php
	}

	protected function render() {
		$settings    = $this->get_settings();
		$id          = 'avt-circle-menu-' . $this->get_id();
		$toggle_icon = ($settings['toggle_icon']) ? : 'plus';

		$this->add_render_attribute(
			[
				'circle-menu-container' => [
					'id' => [
						esc_attr($id),
					],
					'class' => [
						'avt-circle-menu-container',
						$settings['toggle_icon_position'] ? 'avt-position-fixed avt-position-' . $settings['toggle_icon_position'] : '',
					],
				],
			]
		);		

		$this->add_render_attribute(
			[
				'toggle-icon' => [
					'href' => [
						'javascript:void(0)',
					],
					'class' => [
						'avt-icon avt-link-reset',
						'avt-position-center',
					],
					'avt-icon' => [
						'icon: ' . esc_attr($toggle_icon) . '; ratio: 1.1',
					],
					'title' => [
						esc_html('Click me to show menus.', 'avator-widget-pack'),
					],
				],
			]
		);


		$circle_menu_settings = wp_json_encode(
			array_filter([
				"direction"           => $settings["direction"],
				"direction"           => $settings["direction"],
				"item_diameter"       => $settings["item_diameter"]["size"],
				"circle_radius"       => $settings["circle_radius"]["size"],
				"speed"               => $settings["speed"]["size"],
				"delay"               => $settings["delay"]["size"],
				"step_out"            => $settings["step_out"]["size"],
				"step_in"             => $settings["step_in"]["size"],
				"trigger"             => $settings["trigger"],
				"transition_function" => $settings["transition_function"]
			])
		);

		$this->add_render_attribute('circle-menu-settings', 'data-settings', $circle_menu_settings);			
		
		?>
		<div <?php echo $this->get_render_attribute_string( 'circle-menu-container' ); ?>>
            <ul class="avt-circle-menu" <?php echo $this->get_render_attribute_string( 'circle-menu-settings' ); ?>>
            	<li class="avt-toggle-icon">
            		<a <?php echo $this->get_render_attribute_string( 'toggle-icon' ); ?>></a>
            	</li>
				<?php
				foreach ($settings['circle_menu'] as $key => $nav) : 
					$this->render_loop_iconnav_list($settings, $nav);
				endforeach;
				?>
			</ul>
		</div>
	    <?php
	}
}
