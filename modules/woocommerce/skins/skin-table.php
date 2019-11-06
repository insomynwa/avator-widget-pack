<?php
namespace WidgetPack\Modules\Woocommerce\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Table extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-table';
	}

	public function get_title() {
		return esc_html__( 'Table', 'avator-widget-pack' );
	}

	public function render_header() {

		$settings = $this->parent->get_settings();
		$id = $this->parent->get_id();

		$this->parent->add_render_attribute('wc-products', 'class', ['avt-wc-products', 'avt-wc-products-skin-table']);

		$this->parent->add_render_attribute(
			[
				'wc-products' => [
					'data-settings' => [
						wp_json_encode([
				    		'paging'    => ($settings['show_pagination']) ? true : false,
				    		'info'      => ($settings['show_pagination'] and $settings['show_info']) ? true : false,
				    		'searching' => ($settings['show_searching']) ? true : false,
				    		'ordering'  => ($settings['show_ordering']) ? true : false,
				        ])
					]
				]
			]
		);

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'wc-products' ); ?>>

		<?php

	}

	public function render_loop_item() {
		$settings = $this->parent->get_settings();
		$id = 'avt-wc-products-skin-table-' . $this->parent->get_id();

		$wp_query = $this->parent->render_query();

		if($wp_query->have_posts()) {

			$this->parent->add_render_attribute('wc-product-table', 'class', ['avt-table-middle', 'avt-wc-product' ]);

			$this->parent->add_render_attribute('wc-product-table', 'id', esc_attr( $id ));

			if ($settings['cell_border']) {
				$this->parent->add_render_attribute('wc-product-table', 'class', 'cell-border');
			}

			if ($settings['stripe']) {
				$this->parent->add_render_attribute('wc-product-table', 'class', 'stripe');
			}

			if ($settings['hover_effect']) {
				$this->parent->add_render_attribute('wc-product-table', 'class', 'hover');
			}

			?>
			<table <?php echo $this->parent->get_render_attribute_string( 'wc-product-table' ); ?>>
				<thead>
					<tr>
						<?php if ( $settings['show_thumb'] ) : ?>
							<th class="avt-thumb"><?php esc_html_e('Image', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ( $settings['show_title'] ) : ?>
							<th class="avt-title"><?php esc_html_e('Title', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ( $settings['show_excerpt'] ) : ?>
							<th class="avt-excerpt"><?php esc_html_e('Description', 'avator-widget-pack'); ?></th>
						<?php endif; ?>


						<?php if ( $settings['show_categories'] ) : ?>
							<th class="avt-wipa-align avt-categories"><?php esc_html_e('Categories', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ( $settings['show_tags'] ) : ?>
							<th class="avt-wipa-align avt-tags"><?php esc_html_e('Tags', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ( $settings['show_rating'] ) : ?>
							<th class="avt-wipa-align avt-rating"><?php esc_html_e('Rating', 'avator-widget-pack'); ?></th>
						<?php endif; ?>
						
						<?php if ( $settings['show_price'] ) : ?>
							<th class="avt-wipa-align avt-price"><?php esc_html_e('Price', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ( $settings['show_cart'] ) : ?>
							<th class="avt-wipa-align avt-cart"><?php esc_html_e('Cart', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

					</tr>
				</thead>
  				<tbody>
			<?php
			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
				<?php global $product; ?>
					<tr>
						<?php if ( $settings['show_thumb']) : ?>
							<td class="avt-thumb">
								 <?php $this->render_image($settings); ?>
							</td>
						<?php endif; ?>


						<?php if ( $settings['show_title']) : ?>
							<td class="avt-title">
								<h4 class="avt-wc-product-title">
									<a href="<?php the_permalink(); ?>" class="avt-link-reset">
						               <?php the_title(); ?>
						           </a>
						       </h4>
						       <span class="avt-text-muted avt-text-small"><?php echo esc_html($product->get_sku()); ?></span>
							</td>
					    <?php endif; ?>

					    <?php if ( $settings['show_excerpt']) : ?>
							<td class="avt-excerpt">
								<div class="avt-wc-product-excerpt">
									<?php echo wp_kses_post(\widget_pack_helper::custom_excerpt($settings['excerpt_limit'])); ?>
								</div>
							</td>
					    <?php endif; ?>

						<?php if ( $settings['show_categories']) : ?>
							<td class="avt-wipa-align avt-categories">
								<span class="avt-wc-product-categories">
									<?php echo wc_get_product_category_list( get_the_ID(), ', ', '<span>', '</span>' ); ?>
								</span>
							</td>
					    <?php endif; ?>


						<?php if ( $settings['show_tags']) : ?>
							<td class="avt-wipa-align">
								<span class="avt-wc-product-tags avt-tags">
									<?php echo wc_get_product_tag_list( get_the_ID(), ', ', '<span>', '</span>' ); ?>
								</span>
							</td>
					    <?php endif; ?>


						 <?php if ($settings['show_rating']) : ?>
							<td class="avt-wipa-align avt-rating">
								<div class="avt-wc-rating">
						   			<?php woocommerce_template_loop_rating(); ?>
								</div>
							</td>
					    <?php endif; ?>
						

						<?php if ( $settings['show_price']) : ?>
							<td class="avt-wipa-align avt-price">
								<span class="avt-wc-product-price">
									<?php woocommerce_template_single_price(); ?>
								</span>
							</td>
					    <?php endif; ?>


						 <?php if ($settings['show_cart']) : ?>
							<td class="avt-wipa-align avt-cart">
								<div class="avt-wc-add-to-cart">
									<?php woocommerce_template_loop_add_to_cart();?>
								</div>
							</td>
					    <?php endif; ?>
					</tr>

			<?php endwhile;
				  wp_reset_postdata(); ?>

				</tbody>
			</table>
			<?php

		} else {
			echo '<div class="avt-alert-warning" avt-alert>'.esc_html__('Ops! There is no product', 'avator-widget-pack').'<div>';
		}
	}

	public function render_image($settings) {
		$this->parent->add_render_attribute( 'product_image_wrapper', 'class', 'avt-wc-product-image avt-display-inline-block', true );
		
		if ('yes' === $settings['open_thumb_in_lightbox']) {
			$this->parent->add_render_attribute( 'product_image', 'data-elementor-open-lightbox', 'no', true);
			$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$this->parent->add_render_attribute( 'product_image', 'href', $img_url[0], true );
			$this->parent->add_render_attribute( 'product_image_wrapper', 'avt-lightbox', '' );
		} else {
			$this->parent->add_render_attribute( 'product_image', 'href', get_the_permalink(), true );
		}

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'product_image_wrapper' ); ?>>
			<a <?php echo $this->parent->get_render_attribute_string( 'product_image' ); ?>>
				<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), 'thumbnail'); ?>" alt="<?php echo get_the_title(); ?>">
			</a>
		</div>
		<?php
	}

	public function render() {
		$this->render_header();
		$this->render_loop_item();
		$this->parent->render_footer();
	}
}

