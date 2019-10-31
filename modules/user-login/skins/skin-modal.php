<?php
namespace WidgetPack\Modules\UserLogin\Skins;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use Elementor\Skin_Base as Elementor_Skin_Base;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Modal extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/avt-user-login/section_style/before_section_start', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/avt-user-login/section_forms_additional_options/before_section_start', [ $this, 'register_modal_button_controls' ] );
		add_action( 'elementor/element/avt-user-login/section_style/before_section_start', [ $this, 'register_modal_button_style_controls' ] );

	}

	public function get_id() {
		return 'avt-modal';
	}

	public function get_title() {
		return __( 'Modal', 'avator-widget-pack' );
	}

	public function register_modal_button_controls(Widget_Base $widget) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_modal_button',
			[
				'label' => esc_html__( 'Modal Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'modal_button_text',
			[
				'label'   => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Log In', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'modal_button_size',
			[
				'label'   => esc_html__( 'Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => widget_pack_button_sizes(),
			]
		);

		$this->add_responsive_control(
			'modal_button_align',
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
				'default'      => '',
			]
		);

		$this->add_control(
			'user_login_modal_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'modal_button_icon',
			]
		);

		$this->add_control(
			'modal_button_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					$this->get_control_id( 'user_login_modal_icon[value]!' ) => '',
				],
			]
		);

		$this->add_control(
			'modal_button_icon_indent',
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
					$this->get_control_id( 'user_login_modal_icon[value]!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-button-modal .avt-modal-button-icon.elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-button-modal .avt-modal-button-icon.elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function register_modal_button_style_controls(Widget_Base $widget) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_style_modal_button',
			[
				'label' => esc_html__( 'Modal Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_modal_button_style' );

		$this->start_controls_tab(
			'tab_modal_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'modal_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-modal' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'modal_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-button-modal',
			]
		);

		$this->add_control(
			'modal_button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-modal' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'modal_button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-button-modal',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'modal_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-button-modal' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'modal_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-button-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_modal_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'modal_button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-modal:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'modal_button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-modal:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'modal_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-modal:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'modal_button_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'modal_button_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_control(
			'modal_avatar_size',
			[
				'label'   => esc_html__( 'Avatar Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 32,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-user-login-button-avatar img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	public function register_controls(Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_modal_style',
			[
				'label' => esc_html__( 'Modal Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'modal_text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#modal{{ID}} .avt-modal-dialog .avt-modal-header *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'modal_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#modal{{ID}} .avt-modal-dialog' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'modal_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#modal{{ID}} .avt-modal-dialog',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'modal_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#modal{{ID}} .avt-modal-dialog' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'modal_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#modal{{ID}} .avt-modal-dialog .avt-modal-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'modal_close_button',
			[
				'label'   => esc_html__( 'Close Button', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'modal_header',
			[
				'label'   => esc_html__( 'Modal Header', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->parent->get_settings();
		$id       = 'modal' . $this->parent->get_id();

		$this->parent->add_render_attribute(
			[
				'modal-button' => [
					'class' => [
						'elementor-button',
						'avt-button-modal',
						'elementor-size-' . $this->get_instance_value('modal_button_size'),
						$this->get_instance_value('modal_button_animation') ? 'elementor-animation-' . $this->get_instance_value('modal_button_animation') : ''

					],
					'href' => '#',
				]
			]
		);		

		if ( is_user_logged_in() && ! Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			
				$current_user = wp_get_current_user(); ?>
				<div id="<?php echo esc_attr($id); ?>" class="avt-user-login avt-user-login-skin-dropdown">
					<a <?php echo $this->parent->get_render_attribute_string('modal-button'); ?>>
						<?php if ( $settings['show_logged_in_message'] ) : ?>
						    <span class="avt-user-name avt-visible@l">
                                <?php if ($settings['show_custom_message'] and $settings['logged_in_custom_message']) : ?>
                                <?php echo esc_html($settings['logged_in_custom_message']); ?>
                                <?php else : ?>
                                <?php esc_html_e( 'Hi', 'avator-widget-pack' ); ?>,
                                <?php endif; ?>
                                <?php echo esc_html($current_user->display_name); ?>
                            </span>
						<?php endif; ?>

						<span class="avt-user-login-button-avatar<?php echo ( '' == $settings['show_avatar_in_button'] ) ? ' avt-hidden@l' : ''; ?>"><?php echo get_avatar( $current_user->user_email, 32 ); ?></span>
					</a>

					<?php $this->parent->user_dropdown_menu(); ?>

				</div>
				<?php
			

			return;
		}

		$this->parent->form_fields_render_attributes();

		$this->parent->add_render_attribute(
			[
				'modal-button-settings' => [
					'class' => [
						'elementor-button',
						'avt-button-modal',
						'elementor-size-' . $this->get_instance_value('modal_button_size'),
						$this->get_instance_value('modal_button_animation') ? 'elementor-animation-' . $this->get_instance_value('modal_button_animation') : ''

					],
					'href'       => 'javascript:void(0)',
					'avt-toggle' => 'target: #' . esc_attr($id),
				]
			]
		);

		?>
		<div class="avt-user-login avt-user-login-skin-modal">

			<a <?php echo $this->parent->get_render_attribute_string('modal-button-settings'); ?>>
				<?php $this->render_text(); ?>
			</a>

			<div id="<?php echo esc_attr($id); ?>" class="avt-flex-top avt-user-login-modal" avt-modal>
				<div class="avt-modal-dialog avt-margin-auto-vertical">
					<?php if ($this->get_instance_value('modal_close_button')) : ?>
						<button class="avt-modal-close-default" type="button" avt-close></button>
					<?php endif; ?>
					<?php if ($this->get_instance_value('modal_header')) : ?>
					<div class="avt-modal-header">
			            <h2 class="avt-modal-title"><span avt-icon="user"></span> <?php esc_html_e('User Login!', 'avator-widget-pack'); ?></h2>
			        </div>
					<?php endif; ?>
					<div class="elementor-form-fields-wrapper avt-modal-body">
						<?php $this->parent->user_login_form(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php

		$this->parent->user_login_ajax_script();
	}

	protected function render_text() {
		$settings = $this->parent->get_settings_for_display();
		
		$this->parent->add_render_attribute('button-icon', 'class', ['avt-modal-button-icon', 'elementor-button-icon', 'elementor-align-icon-' . $this->get_instance_value('modal_button_icon_align')]);

		if ( is_user_logged_in() && ! Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			$button_text = esc_html__( 'Logout', 'avator-widget-pack' );
		} else {
			$button_text = $this->get_instance_value('modal_button_text');
		}

		if ( ! isset( $settings['modal_button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['modal_button_icon'] = 'fas fa-user';
		}

		$migrated  = isset( $settings['__fa4_migrated']['user_login_modal_icon'] );
		$is_new    = empty( $settings['modal_button_icon'] ) && Icons_Manager::is_migration_allowed();

		$user_login_modal_icon = $this->get_instance_value('user_login_modal_icon');
		
		?>

		<span class="elementor-button-content-wrapper">
			<?php if ( ! empty( $user_login_modal_icon['value'] ) ) : ?>

				<span <?php echo $this->parent->get_render_attribute_string('button-icon'); ?>>

					<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $user_login_modal_icon, [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['modal_button_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

				</span>

			<?php else : ?>
				<?php $this->parent->add_render_attribute('button-icon', 'class', [ 'avt-hidden@l' ]); ?>
				<span <?php echo $this->parent->get_render_attribute_string('button-icon'); ?>>
					<i class="ep-lock" aria-hidden="true"></i>
				</span>

			<?php endif; ?>


			<span class="elementor-button-text avt-visible@l">
				<?php echo esc_html($button_text); ?>
			</span>
		</span>
		<?php
	}

}

