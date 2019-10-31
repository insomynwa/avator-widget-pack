<?php
namespace WidgetPack\Modules\AudioPlayer\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Poster extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-poster';
	}

	public function get_title() {
		return __( 'Poster', 'avator-widget-pack' );
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

		$poster = ( ! empty($settings['poster'] )) ? $settings['poster']['url'] : AWP_ASSETS_URL . 'images/audio-thumbnail.svg';

		?>
		<div class="avt-audio-player avt-audio-player-skin-poster">

			<div class="avt-audio-player-poster avt-position-cover"></div>
			
			<?php if ( $settings['thumb_style'] ) : ?>
				<div class="avt-audio-player-thumb avt-position-center">
					<img src="<?php echo esc_url( $poster ); ?>" alt="<?php echo get_the_title(); ?>">
				</div>
			<?php endif; ?>

			<div class="avt-audio-info avt-text-<?php echo esc_attr($settings['skin_poster_align']); ?>">

				<?php if ( '' !== $settings['title'] ) : ?>
					<div class="avt-audio-player-title">
						<?php echo esc_html($settings['title']); ?>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $settings['author_name'] ) : ?>
					<div class="avt-audio-player-artist">
						<span><?php echo esc_html__( 'By: ', 'avator-widget-pack' ); ?></span>
						<span><?php echo esc_html($settings['author_name']); ?></span>
					</div>
				<?php endif; ?>

			</div>		
			
			<?php $this->parent->render_audio_header(); ?>
			
			<div id="jp_container_<?php echo esc_attr($id); ?>" class="jp-audio" role="application" aria-label="media player">
				<div class="jp-type-playlist avt-width-1-1">
					<div class="jp-gui jp-interface">
						<div class="jp-controls avt-grid avt-grid-small avt-flex-middle" avt-grid>
							<?php $this->parent->render_play_button(); ?>
							
							<?php $this->parent->render_seek_bar(); ?>							
							
							<?php $this->parent->render_mute_button(); ?>
							
						</div>
					</div>
				</div>
			</div>
			
		</div>		
		<?php
	}
}

