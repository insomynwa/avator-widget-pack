<?php
namespace WidgetPack\Modules\PostGrid\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Alter extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-alter';
	}

	public function get_title() {
		return __( 'Alter', 'avator-widget-pack' );
	}

	public function render_comments() {

		if ( ! $this->parent->get_settings('show_comments') ) {
			return;
		}
		
		echo 
			'<span class="avt-post-grid-comments"><i class="wipa-bubble" aria-hidden="true"></i> '.get_comments_number().'</span>';
	}

	public function render_category() {

		if ( ! $this->parent->get_settings( 'show_category' ) ) { return; }
		?>
		<div class="avt-post-grid-category avt-position-z-index avt-position-small avt-position-top-right">
			<?php echo get_the_category_list(' '); ?>
		</div>
		<?php
	}

	public function render_post_grid_layout_alter( $post_id, $image_size, $excerpt_length, $avt_post_class ) {
		$settings = $this->parent->get_settings();
		global $post;

		?>
			<div class="avt-child-width-1-2@m avt-post-grid-item avt-transition-toggle avt-position-relative avt-grid avt-grid-collapse" avt-grid>

				<div class="avt-position-relative">
					<?php $this->parent->render_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>
					<?php $this->render_category(); ?>
				</div>

		  		<div class="avt-post-grid-desc avt-padding<?php echo esc_attr( $avt_post_class ); ?>">
					<?php $this->parent->render_title(); ?>

					<?php $this->parent->render_excerpt($excerpt_length); ?>
					<?php $this->parent->render_readmore(); ?>
					
					<?php if ($settings['show_author'] or $settings['show_date'] or $settings['show_comments']) : ?>
						<div class="avt-post-grid-meta avt-subnav avt-flex-middle avt-margin-small-top avt-padding-remove-horizontal">
							<?php $this->parent->render_author(); ?>
							<?php $this->parent->render_date(); ?>
							<?php $this->render_comments(); ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
		<?php
	}

	public function render() {
		
		$settings = $this->parent->get_settings();
		$id       = $this->parent->get_id();

		$this->parent->query_posts( $settings['alter_item_limit']['size'] );
		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->parent->add_render_attribute( 'grid-height', 'class', ['avt-grid', 'avt-grid-collapse'] );
		$this->parent->add_render_attribute( 'grid-height', 'avt-grid', '' );

		?> 
		<div id="avt-post-grid-<?php echo esc_attr($id); ?>" class="avt-post-grid avt-post-grid-skin-alter">

			<?php $avt_count = 0;
		
			while ($wp_query->have_posts()) :
				$wp_query->the_post();
					
	  			$avt_count++;

	  			if ( $avt_count % 2 != 0) {
					$avt_post_class = ' avt-plane';
	  			} else {
					$avt_post_class = ' avt-flex-first@m avt-alter';
	  			}
				
				$this->render_post_grid_layout_alter( get_the_ID(), $settings['thumbnail_size'], $settings['excerpt_length'], $avt_post_class );

	  			?>	  			
	  			
			<?php endwhile; ?>
		</div>	
 		<?php

 		if ($settings['show_pagination']) {
 			widget_pack_post_pagination($wp_query);
 		}
		wp_reset_postdata();
	}
}

