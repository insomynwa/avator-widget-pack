<?php
namespace WidgetPack\Modules\PostGrid\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Harold extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-harold';
	}

	public function get_title() {
		return __( 'Harold', 'avator-widget-pack' );
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
		<div class="avt-post-grid-category avt-position-small avt-position-top-right">
			<?php echo get_the_category_list(' '); ?>
		</div>
		<?php
	}

	public function render_post_grid_item( $post_id, $image_size, $excerpt_length ) {
		$settings = $this->parent->get_settings();
		global $post;

		?>
		<div class="avt-post-grid-item avt-transition-toggle avt-position-relative avt-box-shadow-small">								
			<?php $this->parent->render_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>

	  		
	  		<div class="avt-post-grid-desc avt-padding">
				<?php $this->parent->render_title(); ?>

				<?php $this->parent->render_excerpt($excerpt_length); ?>
				<?php $this->parent->render_readmore(); ?>
			</div>

			<?php if ($settings['show_author'] or $settings['show_date'] or $settings['show_comments']) : ?>
				<div class="avt-post-grid-meta avt-subnav avt-flex-middle">
					<?php $this->parent->render_author(); ?>
					<?php $this->parent->render_date(); ?>
					<?php $this->render_comments(); ?>
				</div>
			<?php endif; ?>

			<?php $this->render_category(); ?>
		</div>
		<?php
	}

	public function render() {
		
		$settings = $this->parent->get_settings();
		$id       = $this->parent->get_id();

		$this->parent->query_posts($settings['harold_item_limit']['size']);
		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		if ( $page > '1' ) {
			$this->parent->query_posts($settings['harold_item_limit']['size'] - 1);
			$wp_query = $this->parent->get_query();
		}

		$this->parent->add_render_attribute( 'grid-height', 'class', ['avt-grid', 'avt-grid-medium', 'avt-grid-' . esc_attr($settings['column_gap'])] );
		$this->parent->add_render_attribute( 'grid-height', 'avt-grid', '' );

		if ( 'match-height' == $settings['secondary_grid_height'] ) {
			$this->parent->add_render_attribute( 'grid-height', 'avt-height-match', 'target: > div ~ div .avt-post-grid-desc' );
		} /*elseif ( 'masonry' == $settings['secondary_grid_height'] ) {
			$this->parent->add_render_attribute( 'grid-height', 'avt-grid', 'masonry: true' );
		}*/
		

		?> 
		<div id="avt-post-grid-<?php echo esc_attr($id); ?>" class="avt-post-grid avt-post-grid-skin-harold">
	  		<div <?php echo $this->parent->get_render_attribute_string( 'grid-height' ); ?>>

				<?php $avt_count = 0;
			
				while ($wp_query->have_posts()) :
					$wp_query->the_post();
						
		  			$avt_count++;

	  				if( $page == '1' ) {
			  			if ( $avt_count <= 1) {
							$avt_grid_raw   = ' avt-width-1-1@m avt-width-1-1@s avt-width-1-1';
							$avt_post_class = ' avt-primary avt-text-center';
							$thumbnail_size = $settings['primary_thumbnail_size'];
							$excerpt_length = $settings['primary_excerpt_length'];
			  			} else {
							$avt_grid_raw   = ' avt-width-1-' . esc_attr($settings['columns']) . '@m avt-width-1-' . esc_attr($settings['columns_tablet']) . '@s avt-width-1-' . esc_attr($settings['columns_mobile']) ;
							$avt_post_class = ' avt-secondary';
							$thumbnail_size = $settings['secondary_thumbnail_size'];
							$excerpt_length = $settings['secondary_excerpt_length'];
			  			}
		  			} else {
						$avt_grid_raw   = ' avt-width-1-' . esc_attr($settings['columns']) . '@m avt-width-1-' . esc_attr($settings['columns_tablet']) . '@s avt-width-1-' . esc_attr($settings['columns_mobile']) ;
						$avt_post_class = ' avt-secondary';
						$thumbnail_size = $settings['secondary_thumbnail_size'];
						$excerpt_length = $settings['secondary_excerpt_length'];
		  			}

		  			?>	  			
		  			<div class="<?php echo esc_attr($avt_grid_raw . $avt_post_class); ?>">
						<?php $this->render_post_grid_item( get_the_ID(), $thumbnail_size, $excerpt_length); ?>
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

