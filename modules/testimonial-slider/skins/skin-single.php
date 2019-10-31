<?php
namespace WidgetPack\Modules\TestimonialSlider\Skins;


use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Single extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-single';
	}

	public function get_title() {
		return __( 'Single', 'avator-widget-pack' );
	}

	public function render_image() {

		$testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );		

		if ( ! $testimonial_thumb ) {
			$testimonial_thumb = AWP_ASSETS_URL.'images/member.svg';
		} else {
			$testimonial_thumb = $testimonial_thumb[0];
		}

		?>
		<div>
    		<div class="avt-testimonial-thumb">
				<img src="<?php echo esc_url( $testimonial_thumb ); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
			</div>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();
		$index = 1;

    	$rating_align = ($settings['thumb']) ? '' : ' avt-flex-center';


    	$this->parent->query_posts();

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

			$this->parent->render_header('single', $id, $settings);

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

		  		<li class="avt-slider-item">
	             
	            	<div class="avt-grid avt-flex-middle" avt-grid avt-height-match="target: > div > div">

	            		<?php if ('right' !== $settings['alignment']) : ?>
		            	<div class="avt-testimonial-image-part avt-width-auto@m">
		            		<?php $this->render_image(); ?>
		        		</div>
		        		<?php endif; ?>

	                	<div class="avt-testimonial-desc-part avt-width-expand@m">

	                		<div class="avt-slider-item-inner avt-grid-item-match">
		                	
								<?php if ('after' == $settings['meta_position']) : ?>
				                	<div class="avt-testimonial-text avt-text-<?php echo esc_attr($settings['alignment']); ?>">
				                		<?php $this->parent->render_excerpt(); ?>
				                			
			                		</div>
			                	<?php endif; ?>
			                	
		                		<div class="avt-flex avt-flex-<?php echo esc_attr($settings['alignment']); ?> avt-flex-middle">

				                    <?php $this->parent->render_meta('testmonial-meta-' . $index); ?>

				                </div>

		    					<?php if ('before' == $settings['meta_position']) : ?>
		                    		<div class="avt-testimonial-text avt-text-<?php echo esc_attr($settings['alignment']); ?>">
				                		<?php $this->parent->render_excerpt(); ?>
				                			
			                		</div>
		                   		<?php endif; ?>
		                   	</div>
		                </div>

	            		<?php if ('right' == $settings['alignment']) : ?>
		            	<div class="avt-testimonial-image-part avt-width-auto@m">
		            		<?php $this->render_image( get_the_ID() ); ?>
		        		</div>
		        		<?php endif; ?>

	                </div>
	            </li>
		  
				<?php 
			$index++;
			endwhile;	

			wp_reset_postdata();
			
		$this->parent->render_footer($settings);
	}
}

