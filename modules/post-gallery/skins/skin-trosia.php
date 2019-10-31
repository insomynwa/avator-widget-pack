<?php
namespace WidgetPack\Modules\PostGallery\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Trosia extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-trosia';
	}

	public function get_title() {
		return __( 'Trosia', 'avator-widget-pack' );
	}

	public function render_overlay() {
		$settings = $this->parent->get_settings();
		
		?>
		<div class="avt-position-cover avt-overlay avt-overlay-default">
			<div class="avt-post-gallery-content">
				<div class="avt-gallery-content-inner avt-transition-fade">
					<?php 

					$placeholder_img_src = Utils::get_placeholder_image_src();

					$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

					if ( ! $img_url ) {
						$img_url = $placeholder_img_src;
					} else {
						$img_url = $img_url[0];
					}

					$this->parent->add_render_attribute(
						[
							'lightbox-settings' => [
								'class' => [
									'avt-gallery-item-link',
									'avt-gallery-lightbox-item',
									('icon' == $settings['link_type']) ? 'avt-link-icon' : 'avt-link-text'
								],
								'data-elementor-open-lightbox' => 'no',
								'data-caption'                 => get_the_title(),
								'href'                         => esc_url($img_url)
							]
						], '', '', true
					);					
					
					if ( 'none' !== $settings['show_link'])  : ?>
						<div class="avt-flex-inline avt-gallery-item-link-wrapper">
							<?php if (( 'lightbox' == $settings['show_link'] ) || ( 'both' == $settings['show_link'] )) : ?>
								<a <?php echo $this->parent->get_render_attribute_string( 'lightbox-settings' ); ?>>
									<?php if ( 'icon' == $settings['link_type'] ) : ?>
										<span avt-icon="icon: search"></span>
									<?php elseif ( 'text' == $settings['link_type'] ) : ?>
										<span><?php esc_html_e( 'ZOOM', 'avator-widget-pack' ); ?></span>
									<?php endif; ?>
								</a>
							<?php endif; ?>
							
							<?php if (( 'post' == $settings['show_link'] ) || ( 'both' == $settings['show_link'] )) : ?>
								<?php 
									$link_type_class =  ( 'icon' == $settings['link_type'] ) ? ' avt-link-icon' : ' avt-link-text';
									$target =  ( $settings['external_link'] ) ? 'target="_blank"' : '';
								?>
								<a class="avt-gallery-item-link<?php echo esc_attr($link_type_class); ?>" href="<?php echo get_permalink(); ?>" <?php echo esc_attr($target); ?>>
									<?php if ( 'icon' == $settings['link_type'] ) : ?>
										<span avt-icon="icon: link"></span>
									<?php elseif ( 'text' == $settings['link_type'] ) : ?>
										<span><?php esc_html_e( 'VIEW', 'avator-widget-pack' ); ?></span>
									<?php endif; ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function render_post() {
		global $post;
		$settings = $this->parent->get_settings();

		if ($settings['tilt_show']) {
			$this->parent->add_render_attribute('post-gallery-item-inner', 'data-tilt', '', true);
			if ($settings['tilt_scale']) {
				$this->parent->add_render_attribute('post-gallery-item-inner', 'data-tilt-scale', '1.2', true);
			}
		}

		$this->parent->add_render_attribute('post-gallery-item', 'class', 'avt-gallery-item avt-transition-toggle', true);

		if ($settings['show_filter_bar']) {
			$tags_classes = array_map( function( $tag ) {
				return $tag->slug;
			}, $post->tags );
			$this->parent->add_render_attribute('post-gallery-item', 'data-filter', implode(' ', $tags_classes), true);
		}

		$this->parent->add_render_attribute('post-gallery-item', 'class', 'avt-width-1-'. $settings['columns_mobile']);
		$this->parent->add_render_attribute('post-gallery-item', 'class', 'avt-width-1-'. $settings['columns_tablet'] .'@s');
		$this->parent->add_render_attribute('post-gallery-item', 'class', 'avt-width-1-'. $settings['columns'] .'@m');

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'post-gallery-item' ); ?>>
			<div class="avt-post-gallery-inner" <?php echo $this->parent->get_render_attribute_string( 'post-gallery-item-inner' ); ?>>
				<?php
					$this->parent->render_thumbnail();
					$this->render_overlay();
				?>
				<div class="avt-post-gallery-desc avt-text-left avt-position-z-index avt-position-bottom">
					<?php
					$this->parent->render_title(); 
					$this->parent->render_excerpt();
					?>
				</div>
				<div class="avt-position-top-left">
					<?php
					$this->parent->render_categories_names();
					?>
				</div>
			</div>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->parent->get_settings();

		$this->parent->query_posts();
		
		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->parent->get_posts_tags();

		$this->parent->render_header("trosia");

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post();
		}

		$this->parent->render_footer();

		if ($settings['show_pagination']) {
			widget_pack_post_pagination($wp_query);
		}
		
		wp_reset_postdata();

	}
}

