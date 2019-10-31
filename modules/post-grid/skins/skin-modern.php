<?php
namespace WidgetPack\Modules\PostGrid\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Modern extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-modern';
	}

	public function get_title() {
		return __( 'Modern', 'avator-widget-pack' );
	}

	public function render() {
		
		$settings = $this->parent->get_settings();
		$id       = $this->parent->get_id();
		
		$this->parent->query_posts(5);
		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		?> 
		<div id="avt-post-grid-<?php echo esc_attr($id); ?>" class="avt-post-grid avt-post-grid-skin-modern">
	  		<div class="avt-grid avt-grid-<?php echo esc_attr($settings['column_gap']); ?>" avt-grid>

				<?php 
				$avt_count = 0;
			
				while ($wp_query->have_posts()) :
					$wp_query->the_post();
					$avt_count++;
		  			?>


					<?php if ( 1 == $avt_count ) : ?>
					    <div class="avt-width-2-5@m avt-primary">
					        <?php $this->parent->render_post_grid_item( get_the_ID(), $settings['primary_thumbnail_size'], $settings['excerpt_length'] ); ?>
					    </div>

					    <div class="avt-width-2-5@m avt-secondary">
					        <div class="avt-grid avt-grid-<?php echo esc_attr($settings['column_gap']); ?>" avt-grid>

					<?php endif; ?>
					            <?php if ( 2 == $avt_count ) : ?>
						            <div class="avt-width-1-1@m">
						                <?php $this->parent->render_post_grid_item( get_the_ID(), $settings['secondary_thumbnail_size'], $settings['excerpt_length'] ); ?>
						            </div>
					            <?php endif; ?>

								<?php if ( 3 == $avt_count or 4 == $avt_count ) : ?>
						            <div class="avt-width-1-2@m">
						                <?php $this->parent->render_post_grid_item( get_the_ID(), $settings['secondary_thumbnail_size'], $settings['excerpt_length'] ); ?>
						            </div>
					            <?php endif; ?>

					<?php if ( 5 == $avt_count ) : ?>
					        </div>
					    </div>

					    <div class="avt-width-1-5@m avt-primary avt-tertiary">
					        <?php $this->parent->render_post_grid_item( get_the_ID(), $settings['primary_thumbnail_size'], $settings['excerpt_length'] ); ?>
					    </div>

					<?php endif; ?>

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

