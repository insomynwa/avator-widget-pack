<?php
namespace WidgetPack\Modules\Woocommerce\Skins;

use Elementor\Controls_Manager;
use Elementor\Skin_Base;
use Elementor\Widget_Base;
use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Slade extends Skin_Base {

	public function get_id() {
		return 'wc-slider-slade';
	}

	public function get_title() {
		return esc_html__( 'Slade', 'avator-widget-pack' );
	}

	public function render_thumbnav() {
		$settings = $this->parent->get_settings();

		?>
		<?php if ($settings['show_thumbnav']) : ?>
		<div class="thumbnav avt-position-center-right avt-position-small">
            <ul class="avt-thumbnav avt-thumbnav-vertical">


        	    <?php		
        		$avt_counter = 0;
        		      
        		$wp_query = $this->parent->render_query();

        		while ( $wp_query->have_posts() ) : $wp_query->the_post();

        			$image_src = wp_get_attachment_image_url(get_post_thumbnail_id(), 'thumbnail');
        			?>

        			<li avt-slideshow-item="<?php echo esc_html($avt_counter); ?>">
        				<a href="#">
        					<img src="<?php echo esc_url($image_src); ?>" width="100" alt="<?php echo get_the_title(); ?>">
        				</a>
        			</li>


        			<?php


    				$avt_counter++;
    			endwhile; 

    			wp_reset_postdata(); 

    			?>
            </ul>
        </div>
    	<?php endif; ?>

		<?php
	}

	public function render_header() {
		$settings        = $this->parent->get_settings_for_display();
		$slides_settings = [];

		$ratio = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'].":".$settings['slider_size_ratio']['height'] : '1920:750';

		$slider_settings['avt-slideshow'] = wp_json_encode(array_filter([
			"animation"         => $settings["slider_animations"],
			"ratio"             => $ratio,
			"min-height"        => $settings["slider_min_height"]["size"],
			"autoplay"          => ($settings["autoplay"]) ? true : false,
			"autoplay-interval" => $settings["autoplay_interval"],
			"pause-on-hover"    => ("yes" === $settings["pause_on_hover"]) ? true : false,
	    ]));

    	$slider_settings['class'][] = 'avt-wc-slider';
    	$slider_settings['class'][] = 'avt-wc-slider-slade-skin';

	    if ('both' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'avt-arrows-dots-align-'. $settings['both_position'];
		} elseif ('arrows' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'avt-arrows-align-'. $settings['arrows_position'];
		} elseif ('dots' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'avt-dots-align-'. $settings['dots_position'];
		}

	    $slider_fullscreen = ( $settings['slider_fullscreen'] ) ? ' avt-height-viewport="offset-top: true"' : '';

		?>
		<div <?php echo \widget_pack_helper::attrs($slider_settings); ?>>
			<div class="avt-position-relative avt-visible-toggle">
				<ul class="avt-slideshow-items"<?php echo esc_attr($slider_fullscreen); ?>>
		<?php
	}

	public function render_footer() {
		$settings = $this->parent->get_settings_for_display();

				?>
				</ul>
				
				<?php $this->render_thumbnav(); ?>
				
				<?php if ('both' == $settings['navigation']) : ?>
					<?php $this->parent->render_both_navigation(); ?>

					<?php if ( 'center' === $settings['both_position'] ) : ?>
						<?php $this->parent->render_dotnavs(); ?>
					<?php endif; ?>

				<?php elseif ('arrows' == $settings['navigation']) : ?>			
					<?php $this->parent->render_navigation(); ?>
				<?php elseif ('dots' == $settings['navigation']) : ?>			
					<?php $this->parent->render_dotnavs(); ?>
				<?php endif; ?>


			</div>
		</div>
		<?php
	}

	public function render_item_content() {
		$settings        = $this->parent->get_settings_for_display();

		?>
		<div class="avt-grid">
			<div class="avt-width-2-5 avt-flex avt-flex-<?php echo esc_attr( $settings['vertical_align'] ); ?>">
		        <div class="avt-slide-img">
		            <?php $this->parent->render_item_image(); ?>
		        </div>
			</div>
			<div class="avt-width-3-5 avt-flex avt-flex-<?php echo esc_attr( $settings['vertical_align'] ); ?>">
		        <div class="avt-text-<?php echo esc_attr($settings['text_align']); ?>">
		            <div class="avt-slideshow-content-wrapper avt-slider-content" avt-slideshow-parallax="scale: 1,1,0.8">

		            	<?php if ($settings['show_title']) : ?>
		                <h2 class="avt-wc-slider-title"  avt-slideshow-parallax="y: -100,0,0; opacity: 1,1,0"><?php the_title(); ?></h2>
		            	<?php endif; ?>

		            	<?php if ($settings['show_text']) : ?>
		                <div class="avt-wc-slider-text" avt-slideshow-parallax="x: 200,0,-200;"><?php the_excerpt(); ?></div>
		                <?php endif; ?>

		                <?php if ($settings['show_price']) : ?>
		                <div avt-slideshow-parallax="x: 300,0,-200">
							<span class="avt-slider-skin-price"><?php woocommerce_template_single_price(); ?></span>
						</div>
						<?php endif; ?>

		                <?php if ($settings['show_cart']) : ?>
                		<div avt-slideshow-parallax="y: 100,0,0; opacity: 1,1,0" class="avt-wc-add-to-cart">
							<?php woocommerce_template_loop_add_to_cart();?>
						</div>
						<?php endif; ?>

		            </div>
		        </div>
			</div>
		</div>
		<?php
	}

    public function render() {
		$settings  = $this->parent->get_settings_for_display();

		$content_reverse = $settings['content_reverse'] ? ' avt-flex-first' : '';

		$this->render_header('slade');

		$wp_query = $this->parent->render_query();

		while ( $wp_query->have_posts() ) : $wp_query->the_post(); global $product; ?>
				    
	        <li class="avt-slideshow-item">

                <?php $this->render_item_content(); ?>

	        </li>

		<?php endwhile; wp_reset_postdata();

		$this->render_footer();
	}
}