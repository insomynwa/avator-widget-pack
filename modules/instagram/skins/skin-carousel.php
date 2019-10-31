<?php
namespace WidgetPack\Modules\Instagram\Skins;

use Elementor\Controls_Manager;
use Elementor\Skin_Base;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Carousel extends Skin_Base {

	public function get_id() {
		return 'avt-instagram-carousel';
	}

	public function get_title() {
		return esc_html__( 'Carousel', 'avator-widget-pack' );
	}

    public function render() {
		$settings  = $this->parent->get_settings_for_display();

		$options   = get_option( 'widget_pack_api_settings' );
		$access_token    = (!empty($options['instagram_access_token'])) ? $options['instagram_access_token'] : '';


		if (!$access_token) {
			widget_pack_alert('Ops! You did not set Instagram Access Token in widget pack settings!');
			return;
		}

		
		$this->parent->add_render_attribute('instagram-wrapper', 'class', 'avt-instagram avt-instagram-carousel' );
		$this->parent->add_render_attribute('instagram-wrapper', 'avt-slider', '' );

		$this->parent->add_render_attribute('instagram-carousel', 'class', 'avt-grid avt-slider-items' );

		$this->parent->add_render_attribute('instagram-carousel', 'class', 'avt-grid-' . esc_attr($settings["column_gap"]) );
		
		$this->parent->add_render_attribute('instagram-carousel', 'class', 'avt-child-width-1-' . esc_attr($settings["columns"]) . '@m');
		$this->parent->add_render_attribute('instagram-carousel', 'class', 'avt-child-width-1-' . esc_attr($settings["columns_tablet"]). '@s');
		$this->parent->add_render_attribute('instagram-carousel', 'class', 'avt-child-width-1-' . esc_attr($settings["columns_mobile"]) );	 

		if ( 'yes' == $settings['show_lightbox'] ) {
			$this->parent->add_render_attribute('instagram-carousel', 'avt-lightbox', 'animation:' . $settings['lightbox_animation'] . ';');
			if ($settings['lightbox_autoplay']) {
				$this->parent->add_render_attribute('instagram-carousel', 'avt-lightbox', 'autoplay: 500;');
				
				if ($settings['lightbox_pause']) {
					$this->parent->add_render_attribute('instagram-carousel', 'avt-lightbox', 'pause-on-hover: true;');
				}
			}
		}

		$this->parent->add_render_attribute(
			[
				'instagram-wrapper' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							'action'              => 'widget_pack_instagram_ajax_load',
							'show_comment'        => ( $settings['show_comment'] ) ? true : false,
							'show_like'           => ( $settings['show_like'] ) ? true : false,
							'show_link'           => ( $settings['show_link'] ) ? true : false,
							'show_lightbox'       => ( $settings['show_lightbox'] ) ? true : false,
							'current_page'        => 1,
							'load_more_per_click' => 4,
							'item_per_page'       => $settings["items"]["size"],
				        ]))
					]
				]
			]
		);


		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'instagram-wrapper' ); ?>>

			<?php if ( $settings['show_follow_me'] ) : 

				$insta_user = get_transient( 'ep_instagram_user' );
				$username = isset($insta_user) ? $insta_user['username'] : '';

			?>

			<div class='avt-instagram-follow-me avt-position-z-index avt-position-center'>
				<a href='https://www.instagram.com/<?php echo esc_html($username);  ?>'><?php echo esc_html($settings['follow_me_text']); ?> <?php echo esc_html($username);  ?></a>
			</div>

			<?php endif; ?>
			
			<div <?php echo $this->parent->get_render_attribute_string( 'instagram-carousel' ); ?>>
			
				<?php  for ( $dummy_item_count = 1; $dummy_item_count <= $settings["items"]["size"]; $dummy_item_count++ ) : ?>
				
				<div class="avt-instagram-item"><div class="avt-dummy-loader"></div></div>

				<?php endfor; ?>
				
			</div>
			
			<a class='avt-position-center-left avt-position-small avt-hidden-hover avt-visible@m' href='#' avt-slidenav-previous avt-slider-item='previous'></a>
			<a class='avt-position-center-right avt-position-small avt-hidden-hover avt-visible@m' href='#' avt-slidenav-next avt-slider-item='next'></a>

		
		</div>

		<?php
	}
}