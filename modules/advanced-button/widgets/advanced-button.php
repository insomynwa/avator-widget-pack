<?php
namespace WidgetPack\Modules\AdvancedButton\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class AdvancedButton extends Widget_Base {
	public function get_name() {
		return 'avt-advanced-button';
	}

	public function get_title() {
		return AWP . esc_html__( 'Advanced Button', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-advanced-button';
	}	

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'button', 'advanced', 'link' ];
	}

	public function get_style_depends() {
		return [ 'avt-advanced-button' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Click me', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Click me', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'https://your-link.com', 'avator-widget-pack' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => esc_html__( 'Button Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => esc_html__( 'Extra Small', 'avator-widget-pack' ),
					'sm' => esc_html__( 'Small', 'avator-widget-pack' ),
					'md' => esc_html__( 'Medium', 'avator-widget-pack' ),
					'lg' => esc_html__( 'Large', 'avator-widget-pack' ),
					'xl' => esc_html__( 'Extra Large', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'onclick',
			[
				'label'   => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( esc_html__('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'onclick' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'        => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'         => Controls_Manager::CHOOSE,
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
				'options'      => [
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
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => esc_html__( 'Left', 'avator-widget-pack' ),
					'right'  => esc_html__( 'Right', 'avator-widget-pack' ),
					'top'    => esc_html__( 'Top', 'avator-widget-pack' ),
					'bottom' => esc_html__( 'Bottom', 'avator-widget-pack' ),
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
					'default' => [
						'size' => 8,
					],
				'condition' => [
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button .avt-flex-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button .avt-flex-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button .avt-flex-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button .avt-flex-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label'     => esc_html__( 'Style', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_effect',
			[
				'label'   => esc_html__( 'Effect', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'a',
				'options' => [
					'a' => esc_html__( 'Effect A', 'avator-widget-pack' ),
					'b' => esc_html__( 'Effect B', 'avator-widget-pack' ),
					'c' => esc_html__( 'Effect C', 'avator-widget-pack' ),
					'd' => esc_html__( 'Effect D', 'avator-widget-pack' ),
					'e' => esc_html__( 'Effect E', 'avator-widget-pack' ),
					'f' => esc_html__( 'Effect F', 'avator-widget-pack' ),
					'g' => esc_html__( 'Effect G', 'avator-widget-pack' ),
					'h' => esc_html__( 'Effect H', 'avator-widget-pack' ),
					'i' => esc_html__( 'Effect I', 'avator-widget-pack' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'attention_button',
			[
				'label' => esc_html__( 'Attention', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'tabs_advanced_button_style' );

		$this->start_controls_tab(
			'tab_advanced_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'advanced_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button, 
								{{WRAPPER}} .avt-advanced-button.avt-advanced-button-effect-i .avt-advanced-button-content-wrapper:after,
								{{WRAPPER}} .avt-advanced-button.avt-advanced-button-effect-i .avt-advanced-button-content-wrapper:before,
								{{WRAPPER}} .avt-advanced-button.avt-advanced-button-effect-h:hover',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'avator-widget-pack' ),
					'solid'  => esc_html__( 'Solid', 'avator-widget-pack' ),
					'dotted' => esc_html__( 'Dotted', 'avator-widget-pack' ),
					'dashed' => esc_html__( 'Dashed', 'avator-widget-pack' ),
					'groove' => esc_html__( 'Groove', 'avator-widget-pack' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_width',
			[
				'label' => esc_html__( 'Border Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 3,
					'right'  => 3,
					'bottom' => 3,
					'left'   => 3,
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				],
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'advanced_button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'advanced_button_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-button',
			]
		);

		$this->add_responsive_control(
			'advanced_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'advanced_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-advanced-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_advanced_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'advanced_button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button:after, 
								{{WRAPPER}} .avt-advanced-button:hover,
								{{WRAPPER}} .avt-advanced-button.avt-advanced-button-effect-i,
								{{WRAPPER}} .avt-advanced-button.avt-advanced-button-effect-h:after',
			]
		);

		$this->add_control(
			'button_hover_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'avator-widget-pack' ),
					'solid'  => esc_html__( 'Solid', 'avator-widget-pack' ),
					'dotted' => esc_html__( 'Dotted', 'avator-widget-pack' ),
					'dashed' => esc_html__( 'Dashed', 'avator-widget-pack' ),
					'groove' => esc_html__( 'Groove', 'avator-widget-pack' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button:hover' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_hover_border_width',
			[
				'label' => esc_html__( 'Border Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 3,
					'right'  => 3,
					'bottom' => 3,
					'left'   => 3,
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_hover_border_style!' => 'none'
				]
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_hover_border_style!' => 'none'
				]
			]
		);

		$this->add_responsive_control(
			'advanced_button_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'advanced_button_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-button:hover',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'avator-widget-pack' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_advanced_button_icon_style' );

		$this->start_controls_tab(
			'tab_advanced_button_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'advanced_button_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button .avt-advanced-button-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-advanced-button .avt-advanced-button-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'advanced_button_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button .avt-advanced-button-icon .avt-advanced-button-icon-inner',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'advanced_button_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-advanced-button .avt-advanced-button-icon .avt-advanced-button-icon-inner',
			]
		);

		$this->add_control(
			'advanced_button_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button .avt-advanced-button-icon .avt-advanced-button-icon-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'advanced_button_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button .avt-advanced-button-icon .avt-advanced-button-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'advanced_button_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-button .avt-advanced-button-icon .avt-advanced-button-icon-inner',
			]
		);

		$this->add_responsive_control(
			'advanced_button_icon_size',
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
					'{{WRAPPER}} .avt-advanced-button .avt-advanced-button-icon .avt-advanced-button-icon-inner' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_advanced_button_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'advanced_button_hover_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button:hover .avt-advanced-button-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-advanced-button:hover .avt-advanced-button-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'advanced_button_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button:hover .avt-advanced-button-icon .avt-advanced-button-icon-inner',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button:hover .avt-advanced-button-icon .avt-advanced-button-icon-inner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_text() {
		$settings = $this->get_settings();
		$this->add_render_attribute( 'content-wrapper', 'class', 'avt-advanced-button-content-wrapper' );

		if ( 'left' == $settings['icon_align'] or 'right' == $settings['icon_align'] ) {
			$this->add_render_attribute( 'content-wrapper', 'class', 'avt-flex avt-flex-middle' );
		}
		$this->add_render_attribute( 'content-wrapper', 'class', ( 'top' == $settings['icon_align'] ) ? 'avt-flex avt-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper', 'class', ( 'bottom' == $settings['icon_align'] ) ? 'avt-flex avt-flex-column-reverse' : '' );
		$this->add_render_attribute( 'content-wrapper', 'data-text', esc_attr($settings['text']));

		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'avt-advanced-button-icon' );

		$this->add_render_attribute( 'text', 'class', 'avt-advanced-button-text' );
		$this->add_inline_editing_attributes( 'text', 'none' );

		$migrated  = isset( $settings['__fa4_migrated']['button_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['button_icon']['value'] ) ) : ?>
				<div class="avt-advanced-button-icon avt-flex-center avt-flex-align-<?php echo esc_attr($settings['icon_align']); ?>">
					<div class="avt-advanced-button-icon-inner">

					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

					</div>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo esc_html($settings['text']); ?></div>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'avt-advanced-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'advanced_button', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'advanced_button', 'target', '_blank' );
			}

			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'advanced_button', 'rel', 'nofollow' );
			}

		}

		if ( $settings['link']['nofollow'] ) {
			$this->add_render_attribute( 'advanced_button', 'rel', 'nofollow' );
		}

		if ($settings['onclick']) {
			$this->add_render_attribute( 'advanced_button', 'onclick', $settings['onclick_event'] );
		}

		if ($settings['attention_button']) {
			$this->add_render_attribute( 'advanced_button', 'class', 'avt-wp-attention-button' );
		}

		$this->add_render_attribute( 'advanced_button', 'class', 'avt-advanced-button' );		
		$this->add_render_attribute( 'advanced_button', 'class', 'avt-advanced-button-effect-' . esc_attr($settings['button_effect']) );
		$this->add_render_attribute( 'advanced_button', 'class', 'avt-advanced-button-size-' . esc_attr($settings['button_size']) );
		

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'advanced_button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'advanced_button' ); ?>>
				<?php $this->render_text(); ?>
			</a>
		</div>
		<?php
	}


	protected function _content_template() {
		?>
		<#
		view.addRenderAttribute( 'text', 'class', 'avt-advanced-button-text' );

		view.addInlineEditingAttributes( 'text', 'none' );
		
		
		view.addRenderAttribute( 'button', 'onclick', settings.onclick_event );

		var animation = (settings.hover_animation) ? ' elementor-animation-' + settings.hover_animation : '';
		var attention = (settings.attention_button) ? ' avt-wp-attention-button' : '';

		view.addRenderAttribute( 'content-wrapper', 'class', 'avt-advanced-button-content-wrapper' );

		if (settings.icon_align == 'left' || settings.icon_align == 'right') {
			view.addRenderAttribute( 'content-wrapper', 'class', 'avt-flex avt-flex-middle' );
		}

		if (settings.icon_align == 'bottom') {
			view.addRenderAttribute( 'content-wrapper', 'class', 'avt-flex avt-flex-column-reverse' );
		}
		
		view.addRenderAttribute( 'content-wrapper', 'data-text', settings.readmore_text);

		var iconHTML = elementor.helpers.renderIcon( view, settings.button_icon, { 'aria-hidden': true }, 'i' , 'object' );

		var migrated = elementor.helpers.isIconMigrated( settings, 'button_icon' );

		#>
		<div class="elementor-button-wrapper">
			<a class="avt-advanced-button avt-advanced-button-effect-{{ settings.button_effect }} avt-advanced-button-size-{{ settings.button_size }}{{animation}}{{attention}}" href="{{ settings.link.url }}" role="button" {{{ view.getRenderAttributeString( 'button' ) }}}>
				<div {{{ view.getRenderAttributeString( 'content-wrapper' ) }}}>
					<# if ( settings.button_icon.value ) { #>
					<div class="avt-advanced-button-icon avt-flex-center avt-flex-align-{{ settings.icon_align }}">

						<div class="avt-advanced-button-icon-inner">
						

							<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
								{{{ iconHTML.value }}}
							<# } else { #>
								<i class="{{ settings.icon }}" aria-hidden="true"></i>
							<# } #>
							
						</div>

					</div>
					<# } #>
					<div {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</div>
				</div>
			</a>
		</div>
		<?php
	}
}
