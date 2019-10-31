<?php
namespace WidgetPack\Modules\Member\Skins;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Calm extends Elementor_Skin_Base {
	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/avt-member/section_style/before_section_start', [ $this, 'register_calm_style_controls' ] );

	}

	public function get_id() {
		return 'avt-calm';
	}

	public function get_title() {
		return __( 'Calm', 'avator-widget-pack' );
	}

	public function register_calm_style_controls() {
		$this->start_controls_section(
			'section_style_calm',
			[
				'label' => __( 'Calm', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'calm_overlay_color',
			[
				'label'     => __( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-member .avt-member-overlay' => 'background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,{{VALUE)}} 100%);',
					'{{WRAPPER}} .avt-member .avt-member-overlay' => 'background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,{{VALUE)}} 100%);',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$calm_id  = 'calm' . $this->parent->get_id();
		$settings = $this->parent->get_settings();

		$this->parent->add_render_attribute( 'skin-calm', 'class', ['avt-member', 'avt-member-skin-calm', 'avt-transition-toggle', 'avt-inline'] );

		if(($settings['member_alternative_photo']) and ( ! empty( $settings['alternative_photo']['url']))) {
			$this->parent->add_render_attribute( 'skin-calm', 'class', ['avt-position-relative', 'avt-overflow-hidden', 'avt-transition-toggle'] );
			$this->parent->add_render_attribute( 'skin-calm', 'avt-toggle', 'target: > div > .avt-member-photo-flip; mode: hover; animation: avt-animation-fade; queued: true; duration: 300;' );
		}

		if ( ! isset( $settings['social_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['social_icon'] = 'fab fa-facebook-f';
		}

		$migrated  = isset( $link['__fa4_migrated']['social_share_icon'] );
		$is_new    = empty( $link['social_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'skin-calm' ); ?>>
		<?php

			if ( ! empty( $settings['photo']['url'] ) ) :
				$photo_hover_animation = ( '' != $settings['photo_hover_animation'] ) ? ' avt-transition-scale-'.$settings['photo_hover_animation'] : ''; ?>

				<div class="avt-member-photo-wrapper">

					<?php if(($settings['member_alternative_photo']) and ( ! empty( $settings['alternative_photo']['url']))) : ?>
						<div class="avt-member-photo-flip avt-position-absolute avt-position-z-index">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'alternative_photo' ); ?>
						</div>
					<?php endif; ?>

					<div class="avt-member-photo">
						<div class="<?php echo ($photo_hover_animation); ?>">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'photo' ); ?>
						</div>
					</div>

				</div>

			<?php endif; ?>

			<div class="avt-member-overlay avt-overlay avt-position-bottom avt-text-center">
				<div class="avt-member-desc">
					<div class="avt-member-description avt-transition-slide-bottom-small">
						<?php if ( ! empty( $settings['name'] ) ) : ?>
							<span class="avt-member-name"><?php echo wp_kses( $settings['name'], widget_pack_allow_tags('title') ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $settings['role'] ) ) : ?>
							<span class="avt-member-role"><?php echo wp_kses( $settings['role'], widget_pack_allow_tags('title') ); ?></span>
						<?php endif; ?>
					</div>
					
					<?php if ( 'yes' == $settings['member_social_icon'] ) : ?>
					<div class="avt-member-icons avt-transition-slide-bottom">
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
			</div>			
		</div>
		<?php
	}
}

