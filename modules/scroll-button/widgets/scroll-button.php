<?php
namespace WidgetPack\Modules\ScrollButton\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Scroll Button Widget
 */
class Scroll_Button extends Widget_Base {

	public function get_name() {
		return 'avt-scroll-button';
	}

	public function get_title() {
		return AWP . esc_html__( 'Scroll Button', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-scroll-button';
	}

	public function get_categories() {
	 	return [ 'widget-pack' ];
 	}

 	public function get_keywords() {
		return [ 'scroll', 'button', 'link' ];
	}

	public function get_style_depends() {
		return [ 'wipa-scroll-button' ];
	}

	public function get_script_depends() {
		return [ 'wipa-scroll-button' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/y8LJCO3tQqk';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_scroll_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'duration',
			[
				'label'      => esc_html__( 'Duration', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 5000,
						'step' => 50,
					],
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => -200,
						'max'  => 200,
						'step' => 10,
					],
				],
			]
		);

		$this->add_control(
			'scroll_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Scroll Up', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Scroll Up', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'section_id',
			[
				'label'       => esc_html__( 'Section ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'my-header',
				'description' => esc_html__( "By clicking this scroll button, to which section in your page you want to go? Just write that's section ID here such 'my-header'. N.B: No need to add '#'.", 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'scroll_button_position',
			[
				'label'   => __( 'Scroll Button Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => widget_pack_position(),			
			]
		);

		$this->add_responsive_control(
			'scroll_button_offset',
			[
				'label'     => __( 'Button Offset', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .avt-scroll-button-wrapper' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'scroll_button_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_button_align',
			[
				'label'        => esc_html__( 'Button Alignment', 'avator-widget-pack' ),
				'type'         => Controls_Manager::CHOOSE,
				'prefix_class' => 'elementor%s-align-',
				'default'      => 'center',
				'options'      => [
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
				'condition' => [
					'scroll_button_position' => '',
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'       => esc_html__( 'Button Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'scroll_button_icon',
				'default' => [
					'value' => 'fas fa-angle-up',
					'library' => 'fa-solid',
				],
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
					'button_icon[value]!' => '',
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
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-scroll-button .avt-scroll-button-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-scroll-button .avt-scroll-button-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_scroll_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_scroll_button_style' );

		$this->start_controls_tab(
			'tab_scroll_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'scroll_button_text_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scroll-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-scroll-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_button_background_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scroll-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'scroll_button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-scroll-button',
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
					'{{WRAPPER}} .avt-scroll-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'scroll_button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-scroll-button',
			]
		);

		$this->add_control(
			'scroll_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-scroll-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'scroll_button_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-scroll-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_scroll_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'scroll_button_hover_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scroll-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-scroll-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_button_background_hover_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scroll-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_button_hover_border_color',
			[
				'label'     => esc_html__( 'Button Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'scroll_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-scroll-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_button_hover_animation',
			[
				'label' => esc_html__( 'Button Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render_text($settings) {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'content-wrapper', 'class', 'avt-scroll-button-content-wrapper' );
		$this->add_render_attribute( 'text', 'class', 'avt-scroll-button-text' );

		if ( ! isset( $settings['scroll_button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['scroll_button_icon'] = 'fas fa-arrow-down';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_icon'] );
		$is_new    = empty( $settings['scroll_button_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['button_icon']['value'] ) ) : ?>
			<span class="avt-scroll-button-align-icon-<?php echo esc_attr($settings['icon_align']); ?>">

				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
				else : ?>
					<i class="<?php echo esc_attr( $settings['scroll_button_icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>

			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo esc_html($settings['scroll_button_text']); ?></span>
		</span>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'avt-scroll-button', 'class', ['avt-scroll-button', 'avt-button', 'avt-button-primary'] );
		
		//$this->add_render_attribute( 'avt-scroll-button', 'avt-scroll', '' );

		if ( $settings['scroll_button_hover_animation'] ) {
			$this->add_render_attribute( 'avt-scroll-button', 'class', 'elementor-animation-'.esc_attr($settings['scroll_button_hover_animation']) );
		}

		$this->add_render_attribute(
			[
				'avt-scroll-button' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							'duration' => ( '' != $settings['duration']['size'] ) ? $settings['duration']['size'] : '',
							'offset' => ( '' != $settings['offset']['size'] ) ? $settings['offset']['size'] : '',
				        ]))
					]
				]
			]
		);

		if ( '' !== $settings['scroll_button_position'] ) {
			$this->add_render_attribute( 'avt-scroll-wrapper', 'class', ['avt-position-fixed', 'avt-position-' . $settings['scroll_button_position']] );
		}

		$this->add_render_attribute( 'avt-scroll-button', 'data-selector', '#' . esc_attr($settings['section_id']) );

		$this->add_render_attribute( 'avt-scroll-wrapper', 'class', 'avt-scroll-button-wrapper' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'avt-scroll-wrapper' ); ?>>
			<button <?php echo $this->get_render_attribute_string( 'avt-scroll-button' ); ?>>
				<?php $this->render_text($settings); ?>
			</button>
		</div>

		<?php
	}

	protected function _content_template() {
		?>
		
		<#
		var scroll_button_position = (settings.scroll_button_position) ? ' avt-position-fixed avt-position-' + settings.scroll_button_position : '';
		var scroll_button_duration = (settings.duration.size) ? 'duration:' + settings.duration.size + ';' : '';
		var scroll_button_offset = (settings.offset.size) ? 'offset:' + settings.offset.size + ';' : '';

		var iconHTML = elementor.helpers.renderIcon( view, settings.button_icon, { 'aria-hidden': true }, 'i' , 'object' );

		var migrated = elementor.helpers.isIconMigrated( settings, 'button_icon' );

		#>

		<div class="avt-scroll-button-wrapper{{scroll_button_position}}">
			<button class="avt-scroll-button avt-button avt-button-primary elementor-animation-{{ settings.scroll_button_hover_animation }}" data-selector="#{{ settings.section_id }}" data-settings="{{scroll_button_duration}}{{scroll_button_offset}}">
				<span class="avt-scrollr-button-content-wrapper">
					<# if ( settings.button_icon.value ) { #>
					<span class="avt-scroll-button-icon avt-scroll-button-align-icon-{{ settings.icon_align }}">
						
						<# if ( iconHTML && iconHTML.rendered && ( ! settings.scroll_button_icon || migrated ) ) { #>
							{{{ iconHTML.value }}}
						<# } else { #>
							<i class="{{ settings.scroll_button_icon }}" aria-hidden="true"></i>
						<# } #>

					</span>
					<# } #>
					<span class="avt-scroll-button-text">{{{ settings.scroll_button_text }}}</span>
				</span>
			</button>
		</div>
		<?php
	}
}
