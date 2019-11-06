<?php
namespace WidgetPack\Modules\PortfolioGallery\Skins;

use Elementor\Utils;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Fedara extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-fedara';
	}

	public function get_title() {
		return __( 'Fedara', 'avator-widget-pack' );
	}

	public function render_overlay() {
		$settings = $this->parent->get_settings_for_display();

		$this->parent->add_render_attribute(
			[
				'content-position' => [
					'class' => [
						'avt-position-cover',
					]
				]
			], '', '', true
		);

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'content-position' ); ?>>
			<div class="avt-portfolio-content">
				<div class="avt-gallery-content-inner">
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
										<span avt-icon="icon: plus"></span>
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
								<a class="avt-gallery-item-link<?php echo esc_attr($link_type_class); ?>" href="<?php echo esc_attr(get_permalink()); ?>" <?php echo $target; ?>>
									<?php if ( 'icon' == $settings['link_type'] ) : ?>
										<span avt-icon="icon: sign-in"></span>
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

	public function render_desc() {
		?>
		<div class="avt-position-bottom-center">
			<div class="avt-portfolio-skin-fedara-desc">
				<?php
				$this->parent->render_title();
				$this->parent->render_excerpt();
				?>
			</div>
		</div>
		<?php
	}
	public function render_post() {
		$settings = $this->parent->get_settings_for_display();
		global $post;

		$element_key = 'portfolio-item-' . $post->ID;
		$item_filters = get_the_terms( $post->ID, 'portfolio_filter' );

		if ($settings['tilt_show']) {
			$this->parent->add_render_attribute('portfolio-item-inner', 'data-tilt', '', true);
			if ($settings['tilt_scale']) {
				$this->parent->add_render_attribute('portfolio-item-inner', 'data-tilt-scale', '1.2', true);
			}
		}

		$this->parent->add_render_attribute('portfolio-item-inner', 'class', 'avt-portfolio-inner', true);

		$this->parent->add_render_attribute('portfolio-item', 'class', 'avt-gallery-item avt-transition-toggle', true);

		if( $settings['show_filter_bar'] and is_array($item_filters) ) {
			foreach ($item_filters as $item_filter) {
				$this->parent->add_render_attribute($element_key, 'data-filter', 'avtp-' . $item_filter->slug);
			}
		}

		?>
		<div <?php echo $this->parent->get_render_attribute_string( $element_key ); ?>>
			<div <?php echo $this->parent->get_render_attribute_string( 'portfolio-item' ); ?>>
				<div <?php echo $this->parent->get_render_attribute_string( 'portfolio-item-inner' ); ?>>
					<?php
					$this->parent->render_thumbnail();
					$this->render_overlay();
					?>
				<?php $this->render_desc(); ?>
				<?php $this->parent->render_categories_names(); ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$wp_query = $this->parent->query_posts();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->parent->render_header('fedara');

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

