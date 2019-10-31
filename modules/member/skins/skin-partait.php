<?php
namespace WidgetPack\Modules\Member\Skins;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Partait extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-partait';
	}

	public function get_title() {
		return __( 'Partait', 'avator-widget-pack' );
	}

	public function render() {
		$partait_id = 'partait' . $this->parent->get_id();
		$settings   = $this->parent->get_settings();

		if ( ! isset( $settings['social_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['social_icon'] = 'fab fa-facebook-f';
		}

		$migrated  = isset( $link['__fa4_migrated']['social_share_icon'] );
		$is_new    = empty( $link['social_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div class="avt-member avt-member-skin-partait">
			<div class="avt-grid avt-grid-collapse avt-child-width-1-2@m" avt-grid>
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

				<div class="avt-member-desc avt-position-relative">
					<div class="avt-position-center avt-text-center">
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
								$tooltip = ( 'yes' == $settings['social_icon_tooltip'] ) ? ' title="'.esc_attr( $link['social_link_title'] ).'" avt-tooltip' : '';
							?>
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
		</div>
		<?php
	}
}

