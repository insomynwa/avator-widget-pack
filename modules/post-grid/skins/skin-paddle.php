<?php
namespace WidgetPack\Modules\PostGrid\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Paddle extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-paddle';
	}

	public function get_title() {
		return __( 'Paddle', 'avator-widget-pack' );
	}

	public function render() {
		$settings     = $this->parent->get_settings();
		$id           = $this->parent->get_id();
		
		$odd_columns  = $settings['odd_item_columns'];
		$even_columns = $settings['even_item_columns'];

		$this->parent->query_posts( $settings['paddle_item_limit']['size'] );

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		?> 
		<div id="avt-post-grid-<?php echo esc_attr($id); ?>" class="avt-post-grid avt-post-grid-skin-default">
	  		<div class="avt-grid avt-grid-<?php echo esc_attr($settings['column_gap']); ?>" avt-grid>

				<?php $avt_count = 0;

				$avt_sum = $odd_columns + $even_columns;
			
				while ($wp_query->have_posts()) :
					$wp_query->the_post();						

		  			if ( $avt_count == $avt_sum ) {
		  				$avt_count = 0;
		  			}

		  			$avt_count++;

		  			if ( $avt_count <= $odd_columns ) {
						$avt_grid_cols   = $odd_columns;
						$avt_post_class = ' avt-primary';
						$thumbnail_size = $settings['primary_thumbnail_size'];
		  			} else {
						$avt_grid_cols   = $even_columns;
						$avt_post_class = ' avt-secondary';
						$thumbnail_size = $settings['secondary_thumbnail_size'];
		  			}

		  			?>
		  			<div class="avt-width-1-<?php echo esc_attr($avt_grid_cols); ?>@m<?php echo esc_attr($avt_post_class); ?>">
						<?php $this->parent->render_post_grid_item( get_the_ID(), $thumbnail_size, $settings['excerpt_length'] ); ?>
					</div>

				<?php endwhile; ?>
			</div>
		</div>
	
 		<?php 

 		if ($settings['show_pagination']) {
 			widget_pack_post_pagination($wp_query);
 		}
		wp_reset_postdata();
	}
}

