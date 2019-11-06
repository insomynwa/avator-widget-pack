<?php
namespace WidgetPack\Modules\PostGrid\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Filter extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-filter';
	}

	public function get_title() {
		return __( 'Filter', 'avator-widget-pack' );
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

	public function render_query() {
		$settings        = $this->parent->get_settings();
		$post_categories = [];

		$cat_args = array(
			'orderby'    => $settings['orderby'],
			'order'      => $settings['order'],
			'child_of'   => 0,
			'parent'     => '',
			'type'       => 'post',
			'hide_empty' => true,
			'taxonomy'   => 'category',
	    );

	    if ( 'by_name' === $settings['source'] and ! empty($settings['post_categories'] ) ) {	    	
	    	$categories = $settings['post_categories'];
		} else {
	    	$categories = get_categories( $cat_args );
		}

		return $categories;
	}

	public function render_filter_menu() {
		$settings = $this->parent->get_settings();
		
		$categories = $this->render_query();

	    foreach ( $categories as $category ) {

	        $query_args = array(
				'post_type'      => 'post',
				'category_name'  => ( 'by_name' === $settings['source'] and ! empty($settings['post_categories'] ) ) ? $category : $category->slug,
				'posts_per_page' => 3,
				'orderby'        => $settings['orderby'],
				'order'          => $settings['order'],
	        );

	        $wp_query = new \WP_Query( $query_args );

	        if ( ! $wp_query->found_posts ) {
				return;
			}

        	while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$post_categories[] = ( 'by_name' === $settings['source'] and ! empty($settings['post_categories'] ) ) ? $category : $category->slug;
			endwhile;

			wp_reset_postdata();
		}

		$post_categories = array_unique($post_categories);

        ?>
		<div class="avt-wipa-grid-filters-wrapper">

			<ul class="avt-wipa-grid-filters">
		
				<?php foreach($post_categories as $post_category => $value) : ?>
					<?php $filter_name = get_term_by('slug', $value, 'category'); ?>
					<li class="avt-wipa-grid-filter avt-active" avt-filter-control="[data-filter*='avtf-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo esc_html($filter_name->name); ?>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
        <?php
	}

	public function render() {
		
		$settings   = $this->parent->get_settings();
		$id         = 'avt-post-grid-skin-filter-' . $this->parent->get_id();

		?>
		<div avt-filter="target: #<?php echo esc_attr( $id ); ?>">
			<?php $this->render_filter_menu(); ?>
			<div class="avt-grid avt-child-width-1-3" id="<?php echo esc_attr( $id ); ?>" avt-grid>
		<?php

		$categories = $this->render_query();

	    foreach ( $categories as $category ) {

	        $query_args = array(
				'post_type'      => 'post',
				'category_name'  => ( 'by_name' === $settings['source'] and ! empty($settings['post_categories'] ) ) ? $category : $category->slug,
				'posts_per_page' => 3,
				'orderby'        => $settings['orderby'],
				'order'          => $settings['order'],
	        );

	        $wp_query = new \WP_Query( $query_args );

	        if ( ! $wp_query->found_posts ) {
				return;
			}

	        while( $wp_query->have_posts() ) : $wp_query->the_post();

	        	$avt_filter_name = ( 'by_name' === $settings['source'] and ! empty($settings['post_categories'] ) ) ? $category : $category->slug;

	        	?>
				<div class="avt-post-grid-item avt-transition-toggle avt-position-relative avtf-<?php echo esc_attr($avt_filter_name); ?>" data-filter="avtf-<?php echo esc_attr($avt_filter_name); ?>">

					<?php $this->parent->render_image(get_post_thumbnail_id( get_the_ID() ), $settings['thumbnail_size'] ); ?>
			  		
			  		<div class="avt-post-grid-desc avt-padding">
						<?php $this->parent->render_title(); ?>

						<?php $this->parent->render_excerpt( $settings['excerpt_length'] ); ?>
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
			<?php endwhile; wp_reset_postdata();

		}
		    ?>
		    </div>
		</div>
	    <?php
	}
}