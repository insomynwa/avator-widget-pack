<?php
namespace WidgetPack\Modules\ProtectedContent\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

use WidgetPack\Modules\ProtectedContent\Module;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Protected_Content extends Widget_Base {

	public function get_name() {
		return 'avt-protected-content';
	}

	public function get_title() {
		return AWP . esc_html__( 'Protected Content', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-protected-content';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'protected', 'content', 'safe' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'protection_type_section',
			[
				'label' => esc_html__( 'Protection Type', 'avator-widget-pack' )
			]
		);
		
		$this->add_control(
			'protection_type',
			[
				'label'       => esc_html__('Protection Type', 'avator-widget-pack'),
				'label_block' => false,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'user',
				'options'     => [
					'user'     => esc_html__('User Based', 'avator-widget-pack'),
					'password' => esc_html__('Password Based', 'avator-widget-pack')
				]
			]
		);

		$this->add_control(
            'user_type',
            [
				'label'       => __( 'Select User Type', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => Module::pc_user_roles(),
				'condition'   => [
					'protection_type' => 'user'
				]
            ]
		);

		$this->add_control(
			'content_password',
			[
				'label'     => esc_html__( 'Set Password', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '123456',
				'condition' => [
					'protection_type' => 'password'
				]
			]
		);	
		
		$this->end_controls_section();

		$this->start_controls_section(
			'protected_content',
			[
				'label' => esc_html__( 'Protected Content', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'protected_content_type',
			[
				'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom_content',
				'options' => [
					'custom_content' => esc_html__( 'Custom Content', 'avator-widget-pack' ),
					'elementor'      => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
					'anywhere'       => esc_html__( 'AE Template', 'avator-widget-pack' ),
				],				
			]
		);

		$this->add_control(
			'protected_elementor_template',
			[
				'label'       => __( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_et_options(),
				'label_block' => 'true',
				'condition'   => ['protected_content_type' => 'elementor'],
			]
		);


		$this->add_control(
			'protected_anywhere_template',
			[
				'label'       => esc_html__( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_ae_options(),
				'label_block' => 'true',
				'condition'   => ['protected_content_type' => 'anywhere'],
				'render_type' => 'template',
			]

		);
		
		$this->add_control(
			'protected_custom_content',
			[
				'label'       => esc_html__( 'Custom Content', 'avator-widget-pack' ),
				'type'        => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'This is your content that you want to be protected by either user role or password.', 'avator-widget-pack' ),
				'condition'   => [
					'protected_content_type' => 'custom_content',
				],
			]
		);

		$this->add_control(
			'avt_show_content',
			[
				'label'       => __( 'Show Forcefully for Edit', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'You can show your protected content in editor for design it.', 'avator-widget-pack' ),
				'condition'   => [
					'protection_type'	=> 'password'
				]
			]
		);	
		
		$this->end_controls_section();

		$this->start_controls_section(
			'warning_message',
			[
				'label' => esc_html__( 'Warning Message' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'warning_message_type',
			[
				'label'   => esc_html__( 'Message Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom_content',
				'options' => [
					'custom_content' => esc_html__( 'Custom Message', 'avator-widget-pack' ),
					'elementor'      => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
					'anywhere'       => esc_html__( 'AE Template', 'avator-widget-pack' ),
					'none'           => esc_html__( 'None', 'avator-widget-pack' ),
				],				
			]
		);

		$this->add_control(
			'warning_message_template',
			[
				'label'       => __( 'Enter Template ID', 'avator-widget-pack' ),
				'description' => __( 'Go to your template > Edit template > look at here: http://prntscr.com/md5qvr for template ID.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => 'true',
				'condition'   => ['warning_message_type' => 'elementor'],
			]
		);


		$this->add_control(
			'warning_message_anywhere_template',
			[
				'label'       => esc_html__( 'Enter Template ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => 'true',
				'condition'   => ['warning_message_type' => 'anywhere'],
				'render_type' => 'template',
			]

		);

		$this->add_control(
			'warning_message_text',
			[
				'label'     => esc_html__('Custom Message', 'avator-widget-pack'),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => esc_html__('You don\'t have permission to see this content.','avator-widget-pack'),
				'dynamic'   => [ 'active' => true	],
				'condition' => [
					'warning_message_type' => 'custom_content'
				]
			]
		);

		$this->add_control(
			'warning_message_close_button',
			[
				'label'   => esc_html__('Close Button', 'avator-widget-pack'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'protected_content_style',
			[
				'label'     => esc_html__( 'Protected Content', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'protected_content_type' => 'custom_content'
				]
			]
		);

		$this->add_control(
			'protected_content_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-protected-content .protected-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'protected_content_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-protected-content .protected-content' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'protected_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-protected-content .protected-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'protected_content_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'after',
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-protected-content .protected-content' => 'Margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'protected_content_typography',
				'selector' => '{{WRAPPER}} .avt-protected-content .protected-content',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'warning_message_style',
			[
				'label'     => esc_html__( 'Warning Message', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'warning_message_type' => 'custom_content'
				]
			]
		);

		$this->add_control(
			'warning_message_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-protected-content-message-text .avt-alert' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'warning_message_close_button_color',
			[
				'label'     => esc_html__( 'Close Button Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-alert-close.avt-close.avt-icon' => 'color: {{VALUE}};',
				], 
				'condition' => [
					'warning_message_close_button' => 'yes'
				]
			]
		);

		$this->add_control(
			'warning_message_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-protected-content-message-text .avt-alert' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'warning_message_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .avt-protected-content-message-text .avt-alert' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'warning_message_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .avt-protected-content-message-text .avt-alert' => 'Margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'warning_message_typography',
				'selector' => '{{WRAPPER}} .avt-protected-content-message-text .avt-alert'
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'protected_content_password_input',
			[
				'label'     => esc_html__( 'Password Input', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'protection_type'	=> 'password'
				]
			]
		);

		$this->start_controls_tabs('protected_content_password_input_control_tabs');

		$this->start_controls_tab('protected_content_password_input_normal', [
			'label' => esc_html__( 'Normal', 'avator-widget-pack' )
		]);

		$this->add_control(
			'protected_content_password_input_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-password-protected-content-fields input.avt-password' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'protected_content_password_input_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-password-protected-content-fields input.avt-password' => 'background: {{VALUE}};'
				] 
			]
		);

		$this->add_responsive_control(
			'protected_content_password_input_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .avt-password-protected-content-fields input.avt-password' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				], 
			]
		);

		$this->add_responsive_control(
			'protected_content_password_input_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-password-protected-content-fields input.avt-password' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				], 
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'protected_content_password_input_border',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .avt-password-protected-content-fields input.avt-password',
			]
		);

		$this->add_responsive_control(
			'protected_content_password_input_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'after',
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-password-protected-content-fields input.avt-password' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				], 
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'protected_content_password_input_shadow',
				'selector' => '{{WRAPPER}} .avt-password-protected-content-fields input.avt-password',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'protected_content_password_input_typography',
				'selector' => '{{WRAPPER}} .avt-password-protected-content-fields input.avt-password',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('protected_content_password_input_hover', [
			'label' => esc_html__( 'Hover', 'avator-widget-pack' )
		]);

		$this->add_control(
			'protected_content_password_input_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-password-protected-content-fields input.avt-password:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'protected_content_password_input_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-password-protected-content-fields input.avt-password:hover' => 'background: {{VALUE}};'
				] 
			]
		);

		$this->add_control(
			'protected_content_password_input_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-password-protected-content-fields input.avt-password:hover' => 'border-color: {{VALUE}};'
				],
				'condition' => [
					'protected_content_password_input_border!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'protected_content_password_input_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-password-protected-content-fields input.avt-password:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'protected_content_submit_button',
			[
				'label'     => esc_html__( 'Submit Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'protection_type'	=> 'password'
				]
			]
		);

		$this->start_controls_tabs('protected_content_submit_button_control_tabs');

		$this->start_controls_tab('protected_content_submit_button_normal', [
			'label' => esc_html__( 'Normal', 'avator-widget-pack' )
		]);

			$this->add_control(
				'protected_content_submit_button_color',
				[
					'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .avt-password-protected-content-fields input.avt-button' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'protected_content_submit_button_background',
				[
					'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .avt-password-protected-content-fields input.avt-button' => 'background: {{VALUE}};'
					] 
				]
			);

			$this->add_responsive_control(
				'protected_content_submit_button_padding',
				[
					'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'separator'  => 'before',
					'selectors'  => [
						'{{WRAPPER}} .avt-password-protected-content-fields input.avt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					], 
				]
			);

			$this->add_responsive_control(
				'protected_content_submit_button_margin',
				[
					'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .avt-password-protected-content-fields input.avt-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					], 
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'protected_content_submit_button_border',
					'separator' => 'before',
					'selector'  => '{{WRAPPER}} .avt-password-protected-content-fields input.avt-button',
				]
			);

			$this->add_responsive_control(
				'protected_content_submit_button_border_radius',
				[
					'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'separator'  => 'after',
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .avt-password-protected-content-fields input.avt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					], 
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'protected_content_submit_button_shadow',
					'selector' => '{{WRAPPER}} .avt-password-protected-content-fields input.avt-button',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'protected_content_submit_button_typography',
					'selector' => '{{WRAPPER}} .avt-password-protected-content-fields input.avt-button',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab('protected_content_submit_button_hover', [
			'label' => esc_html__( 'Hover', 'avator-widget-pack' )
		]);

			$this->add_control(
				'protected_content_submit_button_hover_color',
				[
					'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .avt-password-protected-content-fields input.avt-button:hover' => 'color: {{VALUE}};'
					]
				]
			);

			$this->add_control(
				'protected_content_submit_button_hover_background',
				[
					'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .avt-password-protected-content-fields input.avt-button:hover' => 'background: {{VALUE}};'
					] 
				]
			);

			$this->add_control(
				'protected_content_submit_button_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .avt-password-protected-content-fields input.avt-button:hover' => 'border-color: {{VALUE}};'
					],
					'condition' => [
						'protected_content_submit_button_border!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'protected_content_submit_button_hover_shadow',
					'selector' => '{{WRAPPER}} .avt-password-protected-content-fields input.avt-button:hover',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();		
	}

	// Check current user rights.
	protected function current_user_rights() {
		if( !is_user_logged_in() ) { return; }
		$user_type    = $this->get_settings('user_type');
		$user_role    = reset(wp_get_current_user()->roles);
		$content_role = ( $user_type ) ? $user_type : [];
		$output       = in_array($user_role, $content_role);
		return $output;
	}

	// Output the protected message content
	protected function render_protected_message() {
		$settings = $this->get_settings_for_display();
		$close_button = ('yes' == $settings['warning_message_close_button']) ? true : false;
		?>
		<div class="avt-protected-content-message">
			<?php
			if ( 'custom_content' == $settings['warning_message_type'] ) { ?>

				<?php if( !isset($_POST['content_password']) ) : ?>

					<?php if ( !empty( $settings['warning_message_text'] ) ) : ?>
						<div class="avt-protected-content-message-text">
							<?php widget_pack_alert($settings['warning_message_text'], 'warning', $close_button); ?>
						</div>
					<?php endif; ?>
				
				<?php elseif(isset($_POST['content_password']) && ($settings['content_password'] !== $_POST['content_password'])) : ?>
					<?php widget_pack_alert( esc_html__('Ops, You entered wrong password!', 'avator-widget-pack'), 'warning', $close_button); ?>
				<?php endif; ?>

				<?php 
			} elseif ( 'elementor' == $settings['warning_message_type'] and !empty( $settings['warning_message_template'] ) ) {
				echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['warning_message_template'] );
				echo widget_pack_template_edit_link( $settings['warning_message_template'] );
			} elseif ( 'anywhere' == $settings['warning_message_type'] and !empty( $settings['warning_message_anywhere_template'] ) ) {
				echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['warning_message_anywhere_template'] );
				echo widget_pack_template_edit_link( $settings['warning_message_anywhere_template'] );
			}
			?>
		</div>  
		<?php
	}

	public function render_protected_form() {
	    ?>
	    <div class="avt-password-protected-content-fields">
	        <form method="post" class="avt-grid avt-grid-small" avt-grid>
	            <div class="avt-width-auto">
	                <input type="password" name="content_password" class="avt-input avt-password avt-form-width-medium" placeholder="<?php esc_html_e( 'Enter Password', 'avator-widget-pack' ); ?>" />
	            </div>
	            <div class="avt-width-auto">
	                <input type="submit" value="<?php esc_html_e( 'Submit', 'avator-widget-pack' ); ?>" class="avt-button avt-button-primary" />
	            </div>
	        </form>

	    </div>
	    <?php
	}

	// Output protected content
	public function render_protected_content() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="protected-content">
			<?php 
				if ( 'custom_content' == $settings['protected_content_type'] and !empty( $settings['protected_custom_content'] ) ) { ?>
					<div class="avt-protected-content-message">
						<?php echo wp_kses( $settings['protected_custom_content'], widget_pack_allow_tags('text') ); ?>
					</div>
					<?php
				} elseif ('elementor' == $settings['protected_content_type'] and !empty( $settings['protected_elementor_template'] )) {
					echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['protected_elementor_template'] );
					echo widget_pack_template_edit_link( $settings['protected_elementor_template'] );
				} elseif ('anywhere' == $settings['protected_content_type'] and !empty( $settings['protected_anywhere_template'] )) {
					echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['protected_anywhere_template'] );
					echo widget_pack_template_edit_link( $settings['protected_anywhere_template'] );
				}
			?>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		
		<div class="avt-protected-content"> 

			<?php
			if ( 'user' == $settings['protection_type'] ) {
				if( true === $this->current_user_rights() ) {
					$this->render_protected_content(); 
				} else {
					$this->render_protected_message();
				}
			} elseif ( 'password' == $settings['protection_type'] ) {

	        	if ( Widget_Pack_Loader::elementor()->editor->is_edit_mode()) {
	        		if( 'yes' !== $settings['avt_show_content'] ) {
	            		$this->render_protected_message(); 
	            		$this->render_protected_form();
	            	} else {
	                    $this->render_protected_content();
	            	}
	        	} else {

                    if( !empty($settings['content_password']) ) {

                        if( isset($_POST['content_password']) && ($settings['content_password'] === $_POST['content_password']) ) {
                            if( !session_status() ) { session_start(); }
                            $_SESSION['content_password'] = true;
                            $this->render_protected_content();
                        }
                    } else {
                        widget_pack_alert( esc_html__('Ops, You Forget to set password!', 'avator-widget-pack') );
                    }

                    if( ! isset($_SESSION['content_password']) ) {
                        $this->render_protected_message();
                        $this->render_protected_form();
                    }
                }


            } ?>
	    </div>

	    <?php
	}
}
