<?php
namespace WidgetPack\Modules\Dropbar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Dropbar extends Widget_Base {

	public function get_name() {
		return 'avt-dropbar';
	}

	public function get_title() {
		return AWP . esc_html__( 'Dropbar', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-dropbar';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'dropbar', 'popup', 'dropdown' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/cXMq8nOCdqk';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_dropbar',
			[
				'label' => esc_html__( 'Dropbar Content', 'avator-widget-pack' ),
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
				'placeholder' => esc_html__( 'Dropbar content goes here', 'avator-widget-pack' ),
				'show_label'  => false,
				'default'     => esc_html__( 'A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.', 'avator-widget-pack' ),
				'condition'   => ['source' => 'custom'],
			]
		);

		$this->add_control(
			'template_id',
			[
				'label'       => __( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_et_options(),
				// 'type' => QueryControlModule::QUERY_CONTROL_ID,
				// 'filter_type' => 'library_widget_templates',		
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Open Dropbar', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'button_align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'condition'    => [
					'button_position' => '',
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
			'button_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
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
					'button_icon[value]!' => '',
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
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-dropbar-wrapper .avt-dropbar-button-icon.avt-flex-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-dropbar-wrapper .avt-dropbar-button-icon.avt-flex-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'button_position',
			[
				'label'   => esc_html__( 'Fixed Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => widget_pack_position(),
			]
		);

		$this->add_responsive_control(
			'btn_horizontal_offset',
			[
				'label' => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
				'condition' => [
					'button_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'btn_vertical_offset',
			[
				'label' => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
				'condition' => [
					'button_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'button_rotate',
			[
				'label'   => esc_html__( 'Rotate', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .avt-dropbar-button' => 'transform: translate({{btn_horizontal_offset.SIZE}}px, {{btn_vertical_offset.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .avt-dropbar-button' => 'transform: translate({{btn_horizontal_offset_tablet.SIZE}}px, {{btn_vertical_offset_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .avt-dropbar-button' => 'transform: translate({{btn_horizontal_offset_mobile.SIZE}}px, {{btn_vertical_offset_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
				'condition' => [
					'button_position!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_option',
			[
				'label'     => esc_html__( 'Dropbar Options', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'drop_position',
			[
				'label'   => esc_html__( 'Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-left',
				'options' => widget_pack_drop_position(),
			]
		);

		$this->add_control(
			'drop_mode',
			[
				'label'   => esc_html__( 'Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'click'    => esc_html__('Click', 'avator-widget-pack'),
					'hover'  => esc_html__('Hover', 'avator-widget-pack'),
				],
			]
		);

		$this->add_responsive_control(
			'drop_width',
			[
				'label' => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-drop' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'drop_flip',
			[
				'label' => esc_html__( 'Flip Dropbar', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);
		
		$this->add_control(
			'drop_offset',
			[
				'label'   => esc_html__( 'Dropbar Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'step' => 5,
					],
				],
			]
		);

		$this->add_control(
			'drop_animation',
			[
				'label'     => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => widget_pack_transition_options(),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'drop_duration',
			[
				'label'   => esc_html__( 'Animation Duration', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 200,
				],
				'range' => [
					'px' => [
						'max' => 4000,
						'step' => 50,
					],
				],
				'condition' => [
					'drop_animation!' => '',
				],
			]
		);

		$this->add_control(
			'drop_show_delay',
			[
				'label'   => esc_html__( 'Show Delay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 1000,
						'step' => 100,
					],
				],
			]
		);

		$this->add_control(
			'drop_hide_delay',
			[
				'label'   => esc_html__( 'Hide Delay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 800,
				],
				'range' => [
					'px' => [
						'max' => 10000,
						'step' => 100,
					],
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
					'button_text!' => '',
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
					'{{WRAPPER}} .avt-dropbar-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropbar-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-dropbar-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-dropbar-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-dropbar-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-dropbar-button',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-dropbar-button',
			]
		);

		$this->add_control(
			'dropbar_button_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropbar-button .avt-dropbar-button-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-dropbar-button .avt-dropbar-button-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
				'separator' => 'before',
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
					'{{WRAPPER}} .avt-dropbar-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropbar-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropbar-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'avator-widget-pack' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_control(
			'dropbar_button_hover_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropbar-button:hover .avt-dropbar-button-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-dropbar-button:hover .avt-dropbar-button-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label'     => esc_html__( 'Dropbar Content', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-drop-{{ID}}.avt-drop .avt-card-body' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'#avt-drop-{{ID}}.avt-drop .avt-card-body' => 'background-color: {{VALUE}};',
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
					'#avt-drop-{{ID}}.avt-drop .avt-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#avt-drop-{{ID}}.avt-drop .avt-card-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_box_shadow',
				'selector' => '#avt-drop-{{ID}}.avt-drop .avt-card-body',
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-drop-' . $this->get_id();

		$this->add_render_attribute(
			[
				'drop-settings' => [
					'id'       => $id,
					'class'    => 'avt-drop',
					'avt-drop' => [
						wp_json_encode([
							"pos"        => $settings["drop_position"],
							"mode"       => $settings["drop_mode"],
							"delay-show" => $settings["drop_show_delay"]["size"],
							"delay-hide" => $settings["drop_hide_delay"]["size"],
							"flip"       => $settings["drop_flip"] ? true : false,
							"offset"     => $settings["drop_offset"]["size"],
							"animation"  => $settings["drop_animation"] ? "avt-animation-" . $settings["drop_animation"] : false,
							"duration"   => ($settings["drop_duration"]["size"] and $settings["drop_animation"]) ? $settings["drop_duration"]["size"] : "0"
						]),
					],
				],
			]
		);

		$this->add_render_attribute( 'button', 'class', ['avt-dropbar-button', 'elementor-button'] );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$this->add_render_attribute( 'button', 'href', 'javascript:void(0)' );
		
		$this->add_render_attribute( 'dropbar-wrapper', 'class', 'avt-dropbar-wrapper' );
		
		if ($settings['button_position']) {
			$this->add_render_attribute( 'dropbar-wrapper', 'class', ['avt-position-fixed', 'avt-position-' . $settings['button_position']] );
		}

        ?>
		<div <?php echo $this->get_render_attribute_string( 'dropbar-wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?> >
				<?php $this->render_text($settings); ?>
			</a>
	        <div <?php echo $this->get_render_attribute_string( 'drop-settings' ); ?>>
	            <div class="avt-card avt-card-body avt-card-default avt-text-left">
	                <?php 
		            	if ( 'custom' == $settings['source'] and !empty( $settings['content'] ) ) {
		            		echo wp_kses_post( $settings['content'] );
		            	} elseif ("elementor" == $settings['source'] and !empty( $settings['template_id'] )) {
		            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['template_id'] );
		            		echo widget_pack_template_edit_link( $settings['template_id'] );
		            	} elseif ('anywhere' == $settings['source'] and !empty( $settings['anywhere_id'] )) {
		            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['anywhere_id'] );
		            		echo widget_pack_template_edit_link( $settings['anywhere_id'] );
		            	}
		            ?>


	            </div>
	        </div>
        </div>
	    <?php
	}

	protected function render_text($settings) {

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );

		if ( 'left' == $settings['button_icon_align'] or 'right' == $settings['button_icon_align'] ) {
			$this->add_render_attribute( 'dropbar-button', 'class', 'avt-flex avt-flex-middle' );
		}

		$this->add_render_attribute( 'icon-align', 'class', 'avt-flex-align-' . $settings['button_icon_align'] );

		$this->add_render_attribute( 'icon-align', 'class', 'avt-dropbar-button-icon elementor-button-icon' );

		$this->add_render_attribute( 'text', 'class', 'elementor-button-text' );

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<span <?php echo $this->get_render_attribute_string( 'dropbar-button' ); ?>>

				<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo wp_kses( $settings['button_text'], widget_pack_allow_tags('title') ); ?></span>

				<?php if ( ! empty( $settings['button_icon']['value'] ) ) : ?>
				<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
					
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

				</span>
				<?php endif; ?>

			</span>
		</span>
		<?php
	}
}
