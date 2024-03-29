<?php
namespace WidgetPack\Modules\UserRegister\Skins;
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

class Skin_Dropdown extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/avt-user-register/section_style/before_section_start', [ $this, 'register_dropdown_button_style_controls' ] );
		add_action( 'elementor/element/avt-user-register/section_style/before_section_start', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/avt-user-register/section_forms_additional_options/before_section_start', [ $this, 'register_dropdown_button_controls' ] );

	}

	public function get_id() {
		return 'avt-dropdown';
	}

	public function get_title() {
		return __( 'Dropdown', 'avator-widget-pack' );
	}

	public function register_dropdown_button_controls() {
		$this->start_controls_section(
			'section_dropdown_button',
			[
				'label' => esc_html__( 'Dropdown Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'dropdown_button_text',
			[
				'label'   => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Register', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'dropdown_button_size',
			[
				'label'   => esc_html__( 'Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => widget_pack_button_sizes(),
			]
		);

		$this->add_responsive_control(
			'dropdown_button_align',
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
			'user_register_dropdown_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'dropdown_button_icon',
			]
		);

		$this->add_control(
			'dropdown_button_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					$this->get_control_id( 'user_register_dropdown_icon[value]!' ) => '',
				],
			]
		);

		$this->add_control(
			'dropdown_button_icon_indent',
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
					$this->get_control_id( 'user_register_dropdown_icon[value]!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-button-dropdown .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-button-dropdown .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function register_dropdown_button_style_controls() {
		$this->start_controls_section(
			'section_style_dropdown_button',
			[
				'label' => esc_html__( 'Dropdown Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_dropdown_button_style' );

		$this->start_controls_tab(
			'tab_dropdown_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'dropdown_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-dropdown' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-button-dropdown svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dropdown_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-button-dropdown',
			]
		);

		$this->add_control(
			'dropdown_button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-dropdown' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'dropdown_button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-button-dropdown',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'dropdown_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-button-dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-button-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'dropdown_button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-dropdown:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-button-dropdown:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-dropdown:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button-dropdown:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'dropdown_button_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'dropdown_button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->end_controls_section();
	}

	public function register_controls(Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_dropdown_style',
			[
				'label' => esc_html__( 'Dropdown Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dropdown_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#dropdown{{ID}}.avt-user-register .avt-dropdown' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'dropdown_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#dropdown{{ID}}.avt-user-register .avt-dropdown',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'dropdown_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#dropdown{{ID}}.avt-user-register .avt-dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_text_padding',
			[
				'label'      => esc_html__( 'Text Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#dropdown{{ID}}.avt-user-register .avt-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_offset',
			[
				'label' => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

		$this->add_control(
			'dropdown_position',
			[
				'label'   => esc_html__( 'Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-right',
				'options' => widget_pack_drop_position(),
			]
		);

		$this->add_control(
			'dropdown_mode',
			[
				'label'   => esc_html__( 'Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover' => esc_html__('Hover', 'avator-widget-pack'),
					'click' => esc_html__('Clicked', 'avator-widget-pack'),
				],
			]
		);

		$this->end_controls_section();
	}	

	public function render() {
		$id       = 'dropdown' . $this->parent->get_id();
		
		$settings    = $this->parent->get_settings();
		$current_url = remove_query_arg( 'fake_arg' );

		if ( $settings['redirect_after_register'] && ! empty( $settings['redirect_url']['url'] ) ) {
			$redirect_url = $settings['redirect_url']['url'];
		} else {
			$redirect_url = $current_url;
		}

		$dropdown_offset = $this->get_instance_value('dropdown_offset');

		if (Widget_Pack_Loader::elementor()->editor->is_edit_mode()) {

		    $this->parent->add_render_attribute(
				[
					'dropdown-settings' => [
						'class'         => 'avt-dropdown',
						'avt-dropdown' => [
							wp_json_encode(array_filter([
								"mode"   => "click",
								"pos"    => $this->get_instance_value("dropdown_position"),
								"offset" => $dropdown_offset["size"]
							]))
						]
					]
				]
			);

		} else {

		    $this->parent->add_render_attribute(
				[
					'dropdown-settings' => [
						'class'        => 'avt-dropdown',
						'avt-dropdown' => [
							wp_json_encode(array_filter([
								"mode"   => $this->get_instance_value("dropdown_mode"),
								"pos"    => $this->get_instance_value("dropdown_position"),
								"offset" => $dropdown_offset["size"]
							]))
						]
					]
				]
			);
		}

		$this->parent->add_render_attribute(
			[
				'dropdown-button' => [
					'class' => [
						'elementor-button',
						'avt-button-dropdown',
						'elementor-size-' . $this->get_instance_value('dropdown_button_size'),
						$this->get_instance_value('dropdown_button_animation') ? 'elementor-animation-' . $this->get_instance_value('dropdown_button_animation') : ''
					],
					'href' => wp_logout_url( $current_url )
				]
			]
		);
		
		if ( is_user_logged_in() && ! Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			if ( $settings['show_logged_in_message'] ) {
				?>
				<div id="<?php echo esc_attr($id); ?>" class="avt-user-register avt-user-register-skin-dropdown">
					<a <?php echo $this->parent->get_render_attribute_string( 'dropdown-button' ); ?>>
						<?php $this->render_text(); ?>
					</a>
				</div>
				<?php
			}

			return;
		}

		$this->parent->form_fields_render_attributes();

		$this->parent->add_render_attribute(
			[
				'dropdown-button-settings' => [
					'class' => [
						'elementor-button',
						'avt-button-dropdown',
						'elementor-size-' . $this->get_instance_value('dropdown_button_size'),
						$this->get_instance_value('dropdown_button_animation') ? 'elementor-animation-' . $this->get_instance_value('dropdown_button_animation') : ''
					],
					'href' => 'javascript:void(0)'
				]
			]
		);

		?>
		<div id="<?php echo esc_attr($id); ?>" class="avt-user-register avt-user-register-skin-dropdown">
			<a <?php echo $this->parent->get_render_attribute_string( 'dropdown-button-settings' ); ?>>
				<?php $this->render_text(); ?>
			</a>

			<div <?php echo $this->parent->get_render_attribute_string( 'dropdown-settings' ); ?>>
				<div class="elementor-form-fields-wrapper avt-text-left">
					<?php $this->parent->user_register_form(); ?>
				</div>
			</div>
		</div>
		<?php

		$this->parent->user_register_ajax_script();
	}

	protected function render_text() {
		$settings = $this->parent->get_settings_for_display();

		$this->parent->add_render_attribute(
			[
				'button-icon' => [
					'class' => [
						'avt-dropdown-button-icon',
						'elementor-button-icon',
						'avt-button-icon-align-' . $this->get_instance_value('dropdown_button_icon_align')
					],
				]
			]
		);

		$dropdown_icon = $this->get_instance_value('user_register_dropdown_icon');

		if ( is_user_logged_in() && ! Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			$button_text = esc_html__( 'Logout', 'avator-widget-pack' );
		} else {
			$button_text = $this->get_instance_value('dropdown_button_text');
		}

		if ( ! isset( $settings['dropdown_button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['dropdown_button_icon'] = 'fas fa-user';
		}

		$migrated  = isset( $settings['__fa4_migrated']['user_register_dropdown_icon'] );
		$is_new    = empty( $settings['dropdown_button_icon'] ) && Icons_Manager::is_migration_allowed();
		
		?>

		<span class="elementor-button-content-wrapper">
			<?php if ( ! empty( $dropdown_icon['value'] ) ) : ?>
				<span <?php echo $this->parent->get_render_attribute_string( 'button-icon' ); ?>>

					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $dropdown_icon, [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['dropdown_button_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

				</span>
			<?php else : ?>
				<?php $this->parent->add_render_attribute('button-icon', 'class', [ 'avt-hidden@l' ]); ?>
				<span <?php echo $this->parent->get_render_attribute_string('button-icon'); ?>>
					<i class="wipa-lock" aria-hidden="true"></i>
				</span>

			<?php endif; ?>

			<span class="elementor-button-text avt-visible@l">
				<?php echo esc_html($button_text); ?>
			</span>
		</span>
		<?php
	}
}

