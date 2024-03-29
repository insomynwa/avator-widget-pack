<?php
namespace WidgetPack\Modules\TrailerBox\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Trailer_Box extends Widget_Base {

	public function get_name() {
		return 'avt-trailer-box';
	}

	public function get_title() {
		return AWP . esc_html__( 'Trailer Box', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-trailer-box';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'trailer', 'box' ];
	}

	public function get_style_depends() {
		return [ 'wipa-trailer-box' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/3AR5RlBAAYg';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'pre_title',
			[
				'label'       => esc_html__( 'Pre Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Trailer box pre title', 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Trailer box title', 'avator-widget-pack' ),
				'default'     => esc_html__( 'Trailer Box Title', 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Trailer box text' , 'avator-widget-pack' ),
				'default'     => esc_html__( 'I am Trailer Box Description Text. You can change me anytime from settings.' , 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'origin',
			[
				'label'   => esc_html__( 'Origin', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-left',
				'options' => widget_pack_position(),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
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
				'description'  => 'Use align for matching position',
				'default'      => '',
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Maximum Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'   => esc_html__( 'Minimum Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-trailer-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => __( 'Link', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => __( 'None', 'avator-widget-pack' ),
					'button' => __( 'Button', 'avator-widget-pack' ),
					'item'   => __( 'Item', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'button',
			[
				'label'       => esc_html__( 'link', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'default'     => [
					'url' => '#',
				],
				'condition' => [
					'link_type!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'condition' => [
					'link_type' => 'button',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'View Details', 'avator-widget-pack' ),
				'default'     => esc_html__( 'View Details', 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Icon', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .avt-trailer-box .avt-trailer-box-button-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-trailer-box .avt-trailer-box-button-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
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

		$this->add_control(
			'pre_title_color',
			[
				'label'     => esc_html__( 'Pre Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-trailer-box .avt-trailer-box-pre-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pre_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'pre_title_typography',
				'label'     => esc_html__( 'Title Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'separator' => 'after',
				'selector'  => '{{WRAPPER}} .avt-trailer-box .avt-trailer-box-pre-title',
				'condition' => [
					'pre_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-trailer-box .avt-trailer-box-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-trailer-box .avt-trailer-box-title',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-trailer-box .avt-trailer-box-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'content!' => '',
				],
			]
		);

		$this->add_control(
			'text_spacing',
			[
				'label' => esc_html__('Sapce', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-trailer-box .avt-trailer-box-text' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'text_typography',
				'label'     => esc_html__( 'Text Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-trailer-box .avt-trailer-box-text',
				'condition' => [
					'content!' => '',
				],
			]
		);

		$this->add_control(
			'item_animation',
			[
				'label'        => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'content',
				'prefix_class' => 'avt-item-transition-',				
				'render_type'  => 'ui',
				'options'      => [
					'content'    => esc_html__( 'Content', 'avator-widget-pack' ),
					'scale-up'   => esc_html__( 'Image Scale Up', 'avator-widget-pack' ),
					'scale-down' => esc_html__( 'Image Scale Down', 'avator-widget-pack' ),
					'none'       => esc_html__( 'None', 'avator-widget-pack' ),
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
					'link_type' => 'button',
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
					'{{WRAPPER}} a.avt-trailer-box-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.avt-trailer-box-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.avt-trailer-box-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} a.avt-trailer-box-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.avt-trailer-box-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.avt-trailer-box-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} a.avt-trailer-box-button:hover' => 'border-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} a.avt-trailer-box-button',
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
					'{{WRAPPER}} a.avt-trailer-box-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} a.avt-trailer-box-button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.avt-trailer-box-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} a.avt-trailer-box-button',
			]
		);

		$this->end_controls_section();

		// Background Overlay
		$this->start_controls_section(
			'section_advanced_background_overlay',
			[
				'label'     => esc_html__( 'Background Overlay', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_ADVANCED,
				'condition' => [
					'_background_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_background_overlay' );

		$this->start_controls_tab(
			'tab_background_overlay_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_overlay',
				'selector' => '{{WRAPPER}} .elementor-widget-container > .elementor-background-overlay',
			]
		);

		$this->add_control(
			'background_overlay_opacity',
			[
				'label'   => esc_html__( 'Opacity (%)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => .5,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container > .elementor-background-overlay' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'background_overlay_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_background_overlay_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_overlay_hover',
				'selector' => '{{WRAPPER}}:hover .elementor-widget-container > .elementor-background-overlay',
			]
		);

		$this->add_control(
			'background_overlay_hover_opacity',
			[
				'label'   => esc_html__( 'Opacity (%)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => .5,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .elementor-widget-container > .elementor-background-overlay' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'background_overlay_hover_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render() {
		$settings               = $this->get_settings_for_display();
		
		$origin                 = ' avt-position-' . $settings['origin'];
		$has_background_overlay = in_array( $settings['background_overlay_background'], [ 'classic', 'gradient' ] ) ||
		in_array( $settings['background_overlay_hover_background'], [ 'classic', 'gradient' ] );
		
		$target                 = ($settings['button']['is_external']) ? '_blank' : '_self';

		if ( $has_background_overlay ) : ?>
			<div class="elementor-background-overlay"></div>
		<?php endif; ?>

		<?php if ('item' === $settings['link_type']) : ?>
			<div onclick="window.open('<?php echo esc_url($settings['button']['url']); ?>','<?php echo esc_attr($target); ?>');" style="cursor: pointer;">
		<?php endif; ?>

		<?php

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>

			<div class="avt-trailer-box avt-position-relative">
				<div class="avt-trailer-box-desc avt-position-medium<?php echo esc_attr($origin); ?>">
					<div class="avt-trailer-box-desc-inner">
						<?php if ( '' !== $settings['pre_title'] ) : ?>
							<h4 class="avt-trailer-box-pre-title">
								<?php echo wp_kses( $settings['pre_title'], widget_pack_allow_tags('title') ); ?>		
							</h4>
						<?php endif; ?>

						<?php if ( '' !== $settings['title'] ) : ?>
							<h3 class="avt-trailer-box-title">
								<?php echo wp_kses( $settings['title'], widget_pack_allow_tags('title') ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( '' !== $settings['content'] ) : ?>
							<div class="avt-trailer-box-text"><?php echo wp_kses_post($settings['content']); ?></div>
						<?php endif; ?>

						<?php if ('button' === $settings['link_type']) : ?>
							<?php if (( '' !== $settings['button']['url'] ) and ('' !== $settings['button_text'] )) :

								$this->add_render_attribute(
									[
										'trailer-box-button' => [
											'href'   => esc_url($settings['button']['url']),
											'target' => esc_attr($target),
											'class'  => [
												'avt-trailer-box-button',
												$settings['button_hover_animation'] ? 'elementor-animation-'.$settings['button_hover_animation'] : ''
											]
										]
									]
								);

								?>
								<a <?php echo $this->get_render_attribute_string( 'trailer-box-button' ); ?>>
									<?php echo esc_html($settings['button_text']); ?>

									<?php if ($settings['button_icon']['value']) : ?>
										<span class="avt-trailer-box-button-icon-<?php echo esc_attr($settings['icon_align']); ?>">

											<?php if ( $is_new || $migrated ) :
												Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
											else : ?>
												<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
											<?php endif; ?>

										</span>
									<?php endif; ?>

								</a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

		<?php if ('item' === $settings['link_type']) : ?>
			</div>
		<?php endif; ?>

		<?php
	}
}
