<?php
namespace WidgetPack\Modules\CallOut\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Call_Out extends Widget_Base {

	public function get_name() {
		return 'avt-call-out';
	}

	public function get_title() {
		return AWP . esc_html__( 'Call Out', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-call-out';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'callout', 'action' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'This is your call to action title', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Call to action title', 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Call to action description', 'avator-widget-pack' ),
				'label_block' => true,
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
				'default' => esc_html__( 'Click Here', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'default'     => [
					'url'         => '#',
					'is_external' => '',
				],
			]
		);

		$this->add_control(
			'button_align',
			[
				'label'   => esc_html__( 'Align', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => esc_html__( 'Left', 'avator-widget-pack' ),
					'right'  => esc_html__( 'Right', 'avator-widget-pack' ),
					'center' => esc_html__( 'Center', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'callout_icon',
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
					'callout_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'callout_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-callout .avt-flex-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-callout .avt-flex-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
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
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout .avt-callout-title' => 'color: {{VALUE}};',
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
				'selector'  => '{{WRAPPER}} .avt-callout .avt-callout-title',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout .avt-callout-description' => 'color: {{VALUE}};',
				],
				'condition' => [
					'description!' => '',
				],
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'description_typography',
				'selector'  => '{{WRAPPER}} .avt-callout .avt-callout-description',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_footer_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'     => esc_html__( 'Normal', 'avator-widget-pack' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'attention_button',
			[
				'label' => __( 'Attention', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout a.avt-callout-button' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout a.avt-callout-button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-callout a.avt-callout-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-callout a.avt-callout-button',
				'condition'   => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-callout a.avt-callout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Text Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-callout a.avt-callout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-callout a.avt-callout-button',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => esc_html__( 'Hover', 'avator-widget-pack' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout a.avt-callout-button:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout a.avt-callout-button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .avt-callout a.avt-callout-button:hover',
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout a.avt-callout-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'callout_icon[value]!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_callout_icon_style' );

		$this->start_controls_tab(
			'tab_callout_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'callout_button_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout .avt-callout-button .avt-callout-button-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-callout .avt-callout-button .avt-callout-button-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'callout_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-callout .avt-callout-button .avt-callout-button-icon',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'callout_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-callout .avt-callout-button .avt-callout-button-icon',
			]
		);

		$this->add_control(
			'callout_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-callout .avt-callout-button .avt-callout-button-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'callout_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-callout .avt-callout-button .avt-callout-button-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'callout_icon_size',
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
					'{{WRAPPER}} .avt-callout .avt-callout-button .avt-callout-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_callout_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'callout_button_hover_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-callout .avt-callout-button:hover .avt-callout-button-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-callout .avt-callout-button:hover .avt-callout-button-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'callout_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-callout .avt-callout-button:hover .avt-callout-button-icon',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-callout .avt-callout-button:hover .avt-callout-button-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	public function render() {
		$settings  = $this->get_settings_for_display();
		
		$external  = ($settings['link']['is_external']) ? "_blank" : "_self";
		$link_url  = empty( $settings['link']['url'] ) ? '#' : $settings['link']['url'];
		$animation = ($settings['button_hover_animation']) ? ' elementor-animation-'.$settings['button_hover_animation'] : '';
		$attention = ($settings['attention_button']) ? ' avt-wp-attention-button' : '';

		if ($settings['attention_button']) {
			$this->add_render_attribute( 'avt_callout', 'class', 'avt-wp-attention-button' );
		}

		$this->add_render_attribute( 'callout', 'class', ['avt-callout', 'avt-callout-button-align-' . esc_attr($settings['button_align'])] );

		if ( 'center' !== $settings['button_align']) {
			$this->add_render_attribute( 'callout', 'class', ['avt-grid', 'avt-grid-large', 'avt-flex-middle'] );
		}

		if ( 'left' == $settings['icon_align'] or 'right' == $settings['icon_align'] ) {
			$this->add_render_attribute( 'callout-button', 'class', 'avt-flex avt-flex-middle' );
		}
		

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['callout_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
        <div <?php echo $this->get_render_attribute_string( 'callout' ); ?>>
            <div class="avt-width-expand avt-first-column">
            	<?php if ($settings['title']) : ?>
                	<h3 class="avt-callout-title"><?php echo esc_html($settings['title']); ?></h3>
            	<?php endif; ?>
				<?php if ($settings['description']) : ?>
                	<div class="avt-callout-description"><?php echo strip_tags($settings['description']); ?></div>
				<?php endif; ?>
           </div>

            <div class="avt-width-auto@m">
                <a class="avt-callout-button<?php echo esc_html($animation.$attention); ?>" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($external); ?>">

	                <span <?php echo $this->get_render_attribute_string( 'callout-button' ); ?>>

	                	<?php echo esc_html( $settings['button_text'] ); ?>
	                	
	                	<?php if ($settings['callout_icon']['value']) : ?>
							<span class="avt-callout-button-icon avt-flex-align-<?php echo esc_html($settings['icon_align']); ?>">

								<?php if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['callout_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
								else : ?>
									<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
								<?php endif; ?>

							</span>
						<?php endif; ?>
					</span>

                </a>
            </div>
        </div>
		<?php
	}

	public function _content_template() {
		?>

		<#
			var animation  = ( settings.button_hover_animation ) ? ' elementor-animation-' + settings.button_hover_animation : '';
			var attention  = ( settings.attention_button ) ? ' avt-wp-attention-button' : '';
			var grid_class = ( 'center' !== settings.button_align ) ? ' avt-grid avt-grid-large avt-flex-middle' : '';

			if (settings.icon_align == 'left' || settings.icon_align == 'right') {
				view.addRenderAttribute( 'callout-button', 'class', 'avt-flex avt-flex-middle' );
			}

			iconHTML = elementor.helpers.renderIcon( view, settings.callout_icon, { 'aria-hidden': true }, 'i' , 'object' );

			migrated = elementor.helpers.isIconMigrated( settings, 'callout_icon' );

		#>

        <div class="avt-callout avt-callout-button-align-{{ settings.button_align }}{{ grid_class }}">
            <div class="avt-width-expand avt-first-column">
            	<# 
	            	if ('' !== settings.title) { 
	                	print('<h3 class="avt-callout-title">' + settings.title +'</h3>');
	            	}
					if ('' !== settings.description) {
	                	print('<div class="avt-callout-description">' + settings.description + '</div>');
					}
				#>
           </div>

            <div class="avt-width-auto@m">
                <a class="avt-callout-button{{animation}}{{attention}}" href="{{ settings.link }}" target="{{ settings.link.is_external }}">
					<span {{{ view.getRenderAttributeString( 'callout-button' ) }}}>
                	{{ settings.button_text }}
						<# if (settings.callout_icon.value) { #>
							<span class="avt-callout-button-icon avt-flex-align-{{settings.icon_align}}">

								<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
									{{{ iconHTML.value }}}
								<# } else { #>
									<i class="{{ settings.icon }}" aria-hidden="true"></i>
								<# } #>

							</span>
						<# } #>
					</span>

                </a>
            </div>
        </div>
        <?php
	}
}
