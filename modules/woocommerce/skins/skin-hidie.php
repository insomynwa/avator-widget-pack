<?php
namespace WidgetPack\Modules\Woocommerce\Skins;

use Elementor\Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Hidie extends Skin_Base {

	public function get_id() {
		return 'wc-carousel-hidie';
	}

	public function get_title() {
		return esc_html__( 'Hidie', 'avator-widget-pack' );
	}

	public function render() {
		$this->parent->render_header('hidie');
		$this->render_loop_item();
		$this->parent->render_footer();
	}


	public function render_loop_item() {
		$settings = $this->parent->get_settings_for_display();

		$text_align = $settings['text_align'] ? : 'left';

		$wp_query = $this->parent->render_query();

		if($wp_query->have_posts()) {			

			$this->parent->add_render_attribute('wc-carousel-item', 'class', ['avt-wc-carousel-item', 'swiper-slide', 'avt-transition-toggle']);

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); global $product; ?>
		  		<div <?php echo $this->parent->get_render_attribute_string( 'wc-carousel-item' ); ?>>

					<div class="avt-item-skin-hidie">
			  			<div class="avt-products-skin-inner">
			  				<div class="avt-products-skin-image">
			  					
				  				<?php if ( 'yes' == $settings['show_badge'] and $product->is_on_sale() ) : ?>
						  			<div class="avt-badge avt-position-top-left avt-position-small">
							  			<?php woocommerce_show_product_loop_sale_flash(); ?>
						  			</div>
					  			<?php endif; ?>

				               <?php $this->parent->render_image(); ?>
								
								<!-- <?php //if ('yes' == $settings['show_add_to_link']) : ?>
								<div class="avt-products-skin-add-to-links">
		                            <ul>
		                                <li class="wishlist"><a href="#" avt-tooltip="Add to Wishlist" avt-icon="icon: heart"></a></li>
		                                <li class="quick"><a href="#" avt-tooltip="Add to Quick" avt-icon="icon: search"></a></li>
		                                <li class="compare"><a href="#" avt-tooltip="Add to Compare" avt-icon="icon: shrink"></a></li>
		                            </ul>
		                        </div>
		                        <?php //endif; ?> -->

	                        </div>

		           			<div class="avt-products-skin-desc avt-text-<?php echo esc_attr($text_align); ?>">
			               		<?php if ( 'yes' == $settings['show_title']) : ?>
				           			<h2 class="avt-products-skin-title">
				           				<a class="avt-wc-carousel-title" href="<?php the_permalink(); ?>" class="avt-link-reset">
							               <?php the_title(); ?>
							           </a>
					               </h2>
					            <?php endif; ?>

			           			<?php if (('yes' == $settings['show_price']) or ('yes' == $settings['show_rating'])) : ?>
			           			
					               	<?php if ('yes' == $settings['show_rating']) : ?>
						               	<div class="avt-wc-rating">
						           			<?php woocommerce_template_loop_rating(); ?>
					           			</div>
				                	<?php endif; ?>

				               		<?php if ( 'yes' == $settings['show_price']) : ?>
					           			<span class="avt-products-skin-price"><?php woocommerce_template_single_price(); ?></span>
						            <?php endif; ?>

			                	<?php endif; ?>
							</div>
						</div>
					</div>

				</div>
			<?php endwhile; wp_reset_postdata();

		} else {
			echo '<div class="avt-alert-warning" avt-alert>Oppps!! There is no product<div>';
		}
	}

	public function render_image() {
		$settings = $this->parent->get_settings();
		?>
		<div class="avt-wc-carousel-image avt-background-cover">
			<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
				<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>" alt="<?php echo get_the_title(); ?>">
			</a>
		</div>
		<?php
	}
}