<?php
namespace WidgetPack\Modules\PortfolioGallery\Skins;

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
						$this->parent->render_overlay();
					?>
					<div class="avt-portfolio-desc avt-position-z-index avt-position-bottom">
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
		</div>
		<?php
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$wp_query = $this->parent->query_posts();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->parent->render_header('trosia');

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

