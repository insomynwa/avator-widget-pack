<?php
namespace WidgetPack\Modules\Accordion\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Accordion extends Widget_Base {

	public function get_name() {
		return 'avt-accordion';
	}

	public function get_title() {
		return AWP . esc_html__( 'Accordion', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-accordion';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'accordion', 'tabs', 'toggle' ];
	}

	public function get_style_depends() {
		return [ 'wipa-accordion' ];
	}

	public function get_script_depends() {
		return [ 'wipa-accordion' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/DP3XNV1FEk0';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Accordion', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'   => __( 'Accordion Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title'   => __( 'Accordion #1', 'avator-widget-pack' ),
						'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => __( 'Accordion #2', 'avator-widget-pack' ),
						'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => __( 'Accordion #3', 'avator-widget-pack' ),
						'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'avator-widget-pack' ),
					],
				],
				'fields' => [
					[
						'name'        => 'tab_title',
						'label'       => __( 'Title & Content', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => __( 'Accordion Title' , 'avator-widget-pack' ),
						'label_block' => true,
					],
					[
						'name'    => 'source',
						'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'custom',
						'options' => [
							'custom'    => esc_html__( 'Custom', 'avator-widget-pack' ),
							"elementor" => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
							'anywhere'  => esc_html__( 'AE Template', 'avator-widget-pack' ),
						],
					],
					[
						'name'       => 'tab_content',
						'label'      => __( 'Content', 'avator-widget-pack' ),
						'type'       => Controls_Manager::WYSIWYG,
						'dynamic'    => [ 'active' => true ],
						'default'    => __( 'Accordion Content', 'avator-widget-pack' ),
						'show_label' => false,
						'condition'  => ['source' => 'custom'],
					],
					[
						'name'        => 'template_id',
						'label'       => __( 'Select Template', 'avator-widget-pack' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => '0',
						'options'     => widget_pack_et_options(),
						'label_block' => 'true',
						'condition'   => ['source' => "elementor"],
					],
					[
						'name'        => 'anywhere_id',
						'label'       => esc_html__( 'Select Template', 'avator-widget-pack' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => '0',
						'options'     => widget_pack_ae_options(),
						'label_block' => 'true',
						'condition'   => ['source' => 'anywhere'],
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'view',
			[
				'label'   => __( 'View', 'avator-widget-pack' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'   => __( 'Title HTML Tag', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => widget_pack_title_tags(),
				'default' => 'div',
			]
		);

		$this->add_control(
			'accordion_icon',
			[
				'label'       => __( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'accordion_active_icon',
			[
				'label'       => __( 'Active Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon_active',
				'default' => [
					'value' => 'fas fa-minus',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'accordion_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => __( 'Additional', 'avator-widget-pack' ),
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

		$this->add_control(
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
				'default' => [
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item + .avt-accordion-item' => 'margin-top: {{SIZE}}{{UNIT}};',
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
				'separator' => 'after',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
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
				'selector' => '{{WRAPPER}} .avt-accordion .avt-accordion-item .avt-accordion-title',
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
				'selector'    => '{{WRAPPER}} .avt-accordion .avt-accordion-item .avt-accordion-title',
			]
		);

		$this->add_control(
			'title_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item .avt-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
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
				'selector'  => '{{WRAPPER}} .avt-accordion .avt-accordion-item:hover .avt-accordion-title',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'hover_title_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item:hover .avt-accordion-title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
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
				'selector'  => '{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-title',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'active_title_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'active_title_shadow',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-title',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'active_title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-title',
			]
		);

		$this->add_control(
			'active_title_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
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
				'condition' => [
					'accordion_icon[value]!' => '',
				],
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
				'default'     => is_rtl() ? 'left' : 'right',
				'toggle'      => false,
				'label_block' => false,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title .avt-accordion-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-title .avt-accordion-icon svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .avt-accordion .avt-accordion-icon.avt-flex-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-icon.avt-flex-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
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
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item:hover .avt-accordion-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-item:hover .avt-accordion-icon svg' => 'fill: {{VALUE}};',
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
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 10,
						'max'  => 100,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title .avt-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

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
				'name'      => 'content_background_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-accordion .avt-accordion-content',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-content' => 'color: {{VALUE}};',
				'separator' => 'before',
				],
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

		$this->add_control(
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
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-accordion-' . $this->get_id();


		$this->add_render_attribute(
			[
				'accordion' => [
					'id'            => $id,
					'class'         => 'avt-accordion',
					'avt-accordion' => [
						wp_json_encode(array_filter([
							"collapsible" => $settings["collapsible"] ? true : false,
							"multiple"    => $settings["multiple"] ? true : false,
							"transition"  => "ease-in-out"
						]))
					]
				]
			]
		);

		$id_int = substr( $this->get_id_int(), 0, 3 );

		$migrated  = isset( $settings['__fa4_migrated']['accordion_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		$active_migrated  = isset( $settings['__fa4_migrated']['accordion_active_icon'] );
		$active_is_new    = empty( $settings['icon_active'] ) && Icons_Manager::is_migration_allowed();
		
		?>
		<div class="avt-accordion-container">
			<div <?php echo $this->get_render_attribute_string( 'accordion' ); ?>>
				<?php foreach ( $settings['tabs'] as $index => $item ) :
					$acc_count = $index + 1;

					$acc_id   = ($item['tab_title']) ? widget_pack_string_id($item['tab_title']) : $id . $acc_count;
					$acc_id   = 'avt-accordion-'. $acc_id;

					$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

					$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

					$this->add_render_attribute( $tab_title_setting_key, [
						'class' => [ 'avt-accordion-title avt-flex avt-flex-middle' ],
					]);

					$this->add_render_attribute( $tab_title_setting_key, 'class', ( 'right' == $settings['icon_align'] ) ? 'avt-flex-between' : '' );


					$this->add_render_attribute( $tab_content_setting_key, [
						'class' => [ 'avt-accordion-content' ],
					]);

					$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
					?>
					<div class="avt-accordion-item<?php echo ($acc_count === $settings['active_item']) ? ' avt-open' : ''; ?>">
						<<?php echo esc_attr($settings['title_html_tag']) ; ?> <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> href="#" id="<?php echo esc_attr($acc_id); ?>" data-accordion-index="<?php echo esc_attr($index); ?>">

							<?php if ( $settings['accordion_icon']['value'] ) : ?>
							<span class="avt-accordion-icon avt-flex-align-<?php echo esc_attr( $settings['icon_align'] ); ?>" aria-hidden="true">

								<?php if ( $is_new || $migrated ) : ?>
									<span class="avt-accordion-icon-closed">
										
									<?php Icons_Manager::render_icon( $settings['accordion_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
									</span>
								<?php else : ?>
									<i class="avt-accordion-icon-closed <?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
								<?php endif; ?>

								<?php if ( $active_is_new || $active_migrated ) : ?>
									<span class="avt-accordion-icon-opened">
										
									<?php Icons_Manager::render_icon( $settings['accordion_active_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
									</span>
								<?php else : ?>
									<i class="avt-accordion-icon-opened <?php echo esc_attr( $settings['icon_active'] ); ?>" aria-hidden="true"></i>
								<?php endif; ?>

							</span>
							<?php endif; ?>
							<?php echo esc_html($item['tab_title']); ?>

						</<?php echo esc_attr($settings['title_html_tag']); ?>>
						<div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
							<?php 
				            	if ( 'custom' == $item['source'] and !empty( $item['tab_content'] ) ) {
				            		echo $this->parse_text_editor( $item['tab_content'] );
				            	} elseif ("elementor" == $item['source'] and !empty( $item['template_id'] )) {
				            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $item['template_id'] );
				            		echo widget_pack_template_edit_link( $item['template_id'] );
				            	} elseif ('anywhere' == $item['source'] and !empty( $item['anywhere_id'] )) {
				            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $item['anywhere_id'] );
				            		echo widget_pack_template_edit_link( $item['anywhere_id'] );
				            	}
				            ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
