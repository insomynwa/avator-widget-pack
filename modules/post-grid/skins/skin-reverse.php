<?php
namespace WidgetPack\Modules\PostGrid\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Reverse extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-reverse';
	}

	public function get_title() {
		return __( 'Reverse', 'avator-widget-pack' );
	}

	public function render_comments() {

		if ( ! $this->parent->get_settings('show_comments') ) {
			return;
		}
		
		echo 
			'<span class="avt-post-grid-comments"><i class="ep-bubble" aria-hidden="true"></i> '.get_comments_number().'</span>';
	}

	public function render_category() {

		if ( ! $this->parent->get_settings( 'show_category' ) ) { return; }
		?>
		<div class="avt-post-grid-category avt-position-z-index avt-position-small avt-position-top-right">
			<?php echo get_the_category_list(' '); ?>
		</div>
		<?php
	}

	public function render_post_grid_layout_plane( $post_id, $image_size, $excerpt_length ) {
		$settings = $this->parent->get_settings();

		?>
		<div class="avt-post-grid-item avt-transition-toggle avt-position-relative">								
			<?php $this->parent->render_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>

	  		
	  		<div class="avt-post-grid-desc avt-padding">
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

			<?php $this->render_category(); ?>
		</div>
		<?php
	}

	public function render_post_grid_layout_reverse( $post_id, $image_size, $excerpt_length ) {
		$settings = $this->parent->get_settings();

		?>
		<div class="avt-post-grid-item avt-transition-toggle avt-position-relative">								

	  		
	  		<div class="avt-post-grid-desc avt-padding">
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
			<div class="avt-position-relative">
			<?php $this->parent->render_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>
			<?php $this->render_category(); ?>
			</div>

		</div>
		<?php
	}

	public function render() {
		
		$settings = $this->parent->get_settings();
		$id       = $this->parent->get_id();

		$this->parent->query_posts( $settings['reverse_item_limit']['size'] );
		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->parent->add_render_attribute( 'grid-height', 'class', ['avt-grid', 'avt-grid-collapse'] );
		$this->parent->add_render_attribute( 'grid-height', 'avt-grid', '' );

		?> 
		<div id="avt-post-grid-<?php echo esc_attr($id); ?>" class="avt-post-grid avt-post-grid-skin-reverse">
	  		<div <?php echo $this->parent->get_render_attribute_string( 'grid-height' ); ?>>

				<?php $avt_count = 0;
			
				while ($wp_query->have_posts()) :
					$wp_query->the_post();

					if($avt_count == 3) {
		  				$avt_count = 0;
		  			}
						
		  			$avt_count++;

		  			if ( $avt_count % 2 != 0) {
						$avt_grid_raw   = ' avt-width-1-' . esc_attr($settings['columns']) . '@m avt-width-1-' . esc_attr($settings['columns_tablet']) . '@s avt-width-1-' . esc_attr($settings['columns_mobile']) ;
						$avt_post_class = ' avt-plane';

						?>
						<div class="<?php echo esc_attr($avt_grid_raw . $avt_post_class); ?>">
							<?php $this->render_post_grid_layout_plane( get_the_ID(), $settings['thumbnail_size'], $settings['excerpt_length']); ?>
						</div>
						<?php
		  			} else {
						$avt_grid_raw   = ' avt-width-1-' . esc_attr($settings['columns']) . '@m avt-width-1-' . esc_attr($settings['columns_tablet']) . '@s avt-width-1-' . esc_attr($settings['columns_mobile']) ;
						$avt_post_class = ' avt-reverse';

						?>
						<div class="<?php echo esc_attr($avt_grid_raw . $avt_post_class); ?>">
							<?php $this->render_post_grid_layout_reverse( get_the_ID(), $settings['thumbnail_size'], $settings['excerpt_length']); ?>
						</div>
						<?php
		  			}

		  			?>	  			
		  			
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

