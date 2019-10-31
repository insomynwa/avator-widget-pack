<?php
namespace WidgetPack\Modules\TestimonialCarousel\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Twyla extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-twyla';
	}

	public function get_title() {
		return __( 'Twyla', 'avator-widget-pack' );
	}

	public function render() {
		$settings = $this->parent->get_settings();
		$wp_query = $this->parent->render_query();

		if( $wp_query->have_posts() ) : ?>

			<?php $this->parent->render_header('twyla'); ?>

				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			  		<div class="swiper-slide avt-testimonial-carousel-item">
				  		<div class="avt-testimonial-carousel-item-wrapper avt-text-center">
					  		<div class="testimonial-item-header">
					  			<?php $this->parent->render_image( get_the_ID() ); ?>
				            </div>

			            	<?php
			            	$this->parent->render_excerpt();
			            	$this->parent->render_title( get_the_ID() );
							$this->parent->render_address( get_the_ID() );

	                        if (( $settings['show_rating'] ) && ( $settings['show_text'] )) : ?>
		                    	<div class="avt-testimonial-carousel-rating avt-display-inline-block">
								    <?php $this->parent->render_rating( get_the_ID() ); ?>
				                </div>
	                        <?php endif; ?>

		                </div>
	                </div>
				<?php endwhile; wp_reset_postdata(); ?>					

		 	<?php $this->parent->render_footer();
		 	
		endif;
	}
}

