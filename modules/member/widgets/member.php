<?php
namespace WidgetPack\Modules\Member\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\Member\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Member extends Widget_Base {
	public function get_name() {
		return 'avt-member';
	}

	public function get_title() {
		return AWP . esc_html__( 'Member', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-member';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'member', 'team', 'experts' ];
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Phaedra( $this ) );
		$this->add_skin( new Skins\Skin_Calm( $this ) );
		$this->add_skin( new Skins\Skin_Partait( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'photo',
			[
				'label'   => esc_html__( 'Choose Photo', 'avator-widget-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => AWP_ASSETS_URL.'images/member.svg',
				],
			]
		);

		$this->add_control(
			'member_alternative_photo',
			[
				'label'   => esc_html__( 'Alternative Photo', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'alternative_photo',
			[
				'label'   => esc_html__( 'Choose Photo', 'avator-widget-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => AWP_ASSETS_URL.'images/member.svg',
				],
				'condition' => [
					'member_alternative_photo' => 'yes',
				],
			]
		);

		$this->add_control(
			'name',
			[
				'label'       => esc_html__( 'Name', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'John Doe', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Member Name', 'avator-widget-pack' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'role',
			[
				'label'       => esc_html__( 'Role', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Managing Director', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Member Role', 'avator-widget-pack' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'description_text',
			[
				'label'       => esc_html__( 'Description', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Type here some info about this team member, the man very important person of our company.', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Member Description', 'avator-widget-pack' ),
				'rows'        => 10,
				'condition'   => ['_skin' => ['', 'avt-partait']],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'member_social_icon',
			[
				'label'   => esc_html__( 'Social Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_social_link',
			[
				'label'     => esc_html__( 'Social Icon', 'avator-widget-pack' ),
				'condition' => ['member_social_icon' => 'yes'],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_link_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Facebook',
			]
		);

		$repeater->add_control(
			'social_link',
			[
				'label'   => esc_html__( 'Link', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'http://www.facebook.com/avator/', 'avator-widget-pack' ),
			]
		);

		$repeater->add_control(
			'social_share_icon',
			[
				'label'   => esc_html__( 'Choose Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'social_icon',
				'default' => [
					'value' => 'fab fa-facebook-f',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'icon_background',
			[
				'label'     => esc_html__( 'Icon Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icons {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icons {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'social_link_list',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => [
					[
						'social_link'        => esc_html__( 'http://www.facebook.com/avator/', 'avator-widget-pack' ),
						'social_share_icon'  => ['value' => 'fab fa-facebook-f', 'library' => 'fa-solid'],
						'social_link_title'  => 'Facebook',
					],
					[
						'social_link'        => esc_html__( 'http://www.twitter.com/avator/', 'avator-widget-pack' ),
						'social_share_icon'  => ['value' => 'fab fa-twitter', 'library' => 'fa-solid'],
						'social_link_title'  => 'Twitter',
					],
					[
						'social_link'        => esc_html__( 'http://www.google-plus.com/avator/', 'avator-widget-pack' ),
						'social_share_icon'  => ['value' => 'fab fa-google-plus-g', 'library' => 'fa-solid'],
						'social_link_title'  => 'Google-Plus',
					],
				],
				'title_field' => '{{{ social_link_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => esc_html__( 'Member', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
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
				'selectors' => [
					'{{WRAPPER}} .avt-member' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desc_padding',
			[
				'label'      => esc_html__( 'Description Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-member .avt-member-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	
		$this->start_controls_section(
			'section_style_photo',
			[
				'label' => esc_html__( 'Photo', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('tabs_photo_style');

		$this->start_controls_tab(
			'tab_photo_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'photo_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-photo' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'photo_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-member .avt-member-photo',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'photo_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-member .avt-member-photo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'photo_opacity',
			[
				'label'   => esc_html__( 'Opacity (%)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-photo img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'photo_spacing',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-photo'  => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_photo_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'photo_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-photo:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'photo_hover_opacity',
			[
				'label'   => esc_html__( 'Opacity (%)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-photo:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'photo_hover_animation',
			[
				'label'   => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''     => 'None',
					'up'   => 'Scale Up',
					'down' => 'Scale Down',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_name',
			[
				'label' => esc_html__( 'Name', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .avt-member .avt-member-name',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_responsive_control(
			'name_bottom_space',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-member-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_role',
			[
				'label' => esc_html__( 'Role', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				]
		);

		$this->add_control(
			'role_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'role_bottom_space',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-role' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'role_typography',
				'selector' => '{{WRAPPER}} .avt-member .avt-member-role',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label'     => esc_html__( 'Text', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .avt-member .avt-member-text',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_social_icon',
			[
				'label'     => esc_html__( 'Social Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => ['member_social_icon' => 'yes'],
			]
		);

		$this->add_control(
			'icon_content_background',
			[
				'label'     => esc_html__( 'Icons Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icons' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_content_padding',
			[
				'label'      => esc_html__( 'Icons Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-member .avt-member-icons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_social_icon_style' );

		$this->start_controls_tab(
			'tab_social_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icon' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-member .avt-member-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icons_top_border_color',
			[
				'label'     => esc_html__( 'Top Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icons' => 'border-top-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'social_icon_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-member .avt-member-icon',
			]
		);

		$this->add_control(
			'social_icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-member .avt-member-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-member .avt-member-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icon i'        => 'min-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-member .avt-member-icon i:before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-member .avt-member-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_indent',
			[
				'label'     => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icon + .avt-member-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_tooltip',
			[
				'label'   => esc_html__( 'Tooltip', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_social_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_hover_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icon:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icon:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-member .avt-member-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'social_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-icon:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( ! isset( $settings['social_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['social_icon'] = 'fab fa-facebook-f';
		}
		
		$migrated  = isset( $link['__fa4_migrated']['social_share_icon'] );
		$is_new    = empty( $link['social_icon'] ) && Icons_Manager::is_migration_allowed();

		?>


		<div class="avt-member avt-member-skin-default avt-transition-toggle">	
		<?php

			if ( ! empty( $settings['photo']['url'] ) ) :
				$photo_hover_animation = ( '' != $settings['photo_hover_animation'] ) ? ' avt-transition-scale-'.$settings['photo_hover_animation'] : ''; ?>

				<div class="avt-member-photo-wrapper">

					<?php if(($settings['member_alternative_photo']) and ( ! empty( $settings['alternative_photo']['url']))) : ?>
						<div class="avt-position-relative avt-overflow-hidden" avt-toggle="target: > .avt-member-photo-flip; mode: hover; animation: avt-animation-fade; queued: true; duration: 300;">
					
						<div class="avt-member-photo-flip avt-position-absolute avt-position-z-index">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'alternative_photo' ); ?>
						</div>
					<?php endif; ?>

					<div class="avt-member-photo">
						<div class="<?php echo ($photo_hover_animation); ?>">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'photo' ); ?>
						</div>
					</div>

					<?php if(($settings['member_alternative_photo']) and ( ! empty( $settings['alternative_photo']['url']))) : ?>
						</div>
					<?php endif; ?>

				</div>
			<?php endif; ?>
			
			<div class="avt-member-description">
				<?php if ( ! empty( $settings['name'] ) ) : ?>
					<span class="avt-member-name"><?php echo wp_kses( $settings['name'], widget_pack_allow_tags('title') ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $settings['role'] ) ) : ?>
					<span class="avt-member-role"><?php echo wp_kses( $settings['role'], widget_pack_allow_tags('title') ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $settings['description_text'] ) ) : ?>
					<div class="avt-member-text avt-content-wrap"><?php echo wp_kses( $settings['description_text'], widget_pack_allow_tags('text') ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( 'yes' == $settings['member_social_icon'] ) : ?>
			<div class="avt-member-icons">
				<?php 
				foreach ( $settings['social_link_list'] as $link ) :
					$tooltip = ( 'yes' == $settings['social_icon_tooltip'] ) ? ' title="'.esc_attr( $link['social_link_title'] ).'" avt-tooltip' : ''; ?>
					
					<a href="<?php echo esc_url( $link['social_link'] ); ?>" class="avt-member-icon elementor-repeater-item-<?php echo esc_attr($link['_id']); ?>" target="_blank"<?php echo esc_html($tooltip); ?>>

						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $link['social_share_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $link['social_icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			
		</div>
		<?php
	}
}
