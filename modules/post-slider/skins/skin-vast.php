<?php
namespace WidgetPack\Modules\PostSlider\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Vast extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-vast';
	}

	public function get_title() {
		return __( 'Vast', 'avator-widget-pack' );
	}

	public function render_loop_item() {
		$settings              = $this->parent->get_settings();		
		
		$placeholder_image_src = Utils::get_placeholder_image_src();
		$slider_thumbnail      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

		if ( ! $slider_thumbnail ) {
			$slider_thumbnail = $placeholder_image_src;
		} else {
			$slider_thumbnail = $slider_thumbnail[0];
		}

		?>
		<div class="avt-post-slider-item">
			<div class="avt-position-relative avt-post-slider-thumbnail">
				<img src="<?php echo esc_url($slider_thumbnail); ?>" alt="<?php echo get_the_title(); ?>">
				<?php $this->render_navigation(); ?>
			</div>

			<div class="avt-post-slider-content avt-padding-large avt-background-muted">

	            <?php if ($settings['show_tag']) : ?>
	        		<?php $tags_list = get_the_tag_list('<span class="avt-background-primary">','</span> <span class="avt-background-primary">','</span>'); ?>
	        		<?php if ($tags_list) : ?> 
	            		<div class="avt-post-slider-tag-wrap" avt-slider-parallax="y: -200,200">
	            			<?php  echo  wp_kses_post($tags_list); ?>
            			</div>
	            	<?php endif; ?>
	            <?php endif; ?>

				<?php $this->render_title(); ?>

				<?php if ($settings['show_meta']) : ?>
					<div class="avt-post-slider-meta avt-flex-inline avt-flex-middile" avt-slider-parallax="x: 250,-250">
						<div class="avt-post-slider-author avt-border-circle avt-overflow-hidden avt-visible@m"><?php echo get_avatar( get_the_author_meta( 'ID' ) , 28 ); ?></div>
						<div class="avt-subnav avt-flex avt-flex-middle avt-margin-remove">
							<span class="avt-margin-remove">
								<?php echo esc_attr(get_the_author()); ?>
								<span class="avt-display-inline-block avt-margin-remove">
									<?php esc_html_e('On', 'avator-widget-pack'); ?> <?php echo get_the_date(); ?>
								</span>
							</span>
							
							<span><?php echo esc_attr(the_category(', ')); ?></span>
						</div>

					</div>
				<?php endif; ?>
				
				<?php if ( $settings['show_text'] ) : ?> 
					<?php $this->render_excerpt(); ?>
					<?php $this->render_read_more_button(); ?>
				<?php else : ?>
					<?php $this->render_content(); ?>
				<?php endif; ?>

			</div>
		</div>
		<?php
	}

	public function render_excerpt() {
		if ( ! $this->parent->get_settings( 'show_text' ) ) {
			return;
		}

		?>
		<div class="avt-post-slider-text avt-visible@m" avt-slideshow-parallax="x: 500,-500">
			<?php echo \widget_pack_helper::custom_excerpt(intval($this->parent->get_settings( 'excerpt_length' ))); ?>
		</div>
		<?php
	}

	public function render_header() {
		$settings = $this->parent->get_settings();
		$id       = 'avt-post-slider-' . $this->parent->get_id();

	    $this->parent->add_render_attribute(
			[
				'slider-settings' => [
					'id'    => esc_attr($id),
					'class' => [
						'avt-post-slider',
						'avt-post-slider-skin-vast',
						'avt-position-relative'
					],
					'avt-slider' => [
						wp_json_encode(array_filter([
							"animation"         => $settings["slider_animations"],
							"autoplay"          => $settings["autoplay"],
							"autoplay-interval" => $settings["autoplay_interval"],
							"pause-on-hover"    => $settings["pause_on_hover"]
						]))
					]
				]
			]
		);
	    
		?>
		<div <?php echo ( $this->parent->get_render_attribute_string( 'slider-settings' ) ); ?>>
			<div class="avt-slider-items avt-child-width-1-1">
		<?php
	}

	public function render_title() {
		if ( ! $this->parent->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->parent->get_settings( 'title_tag' );
		
		?>
		<div class="avt-post-slider-title-wrap">
			<a href="<?php echo get_permalink(); ?>">
				<<?php echo esc_attr($tag) ?> class="avt-post-slider-title avt-margin-remove-bottom" avt-slider-parallax="x: 200,-200">
					<?php the_title() ?>
				</<?php echo esc_attr($tag) ?>>
			</a>
		</div>
		<?php
	}

	public function render_footer() {
		?>
			</div>
			
		</div>
		
		<?php
	}

	public function render_navigation() {
		$settings = $this->parent->get_settings();
		$id       = $this->parent->get_id();

		?>
		<div id="<?php echo esc_attr($id); ?>_nav"  class="avt-post-slider-navigation">
			<a class="avt-position-center-left avt-position-small avt-hidden-hover" href="#" avt-slidenav-previous avt-slider-item="previous"></a>
			<a class="avt-position-center-right avt-position-small avt-hidden-hover" href="#" avt-slidenav-next avt-slider-item="next"></a>
		</div>
		<?php
	}

	public function render_content() {
		?>
		<div class="avt-post-slider-text avt-visible@m" avt-slider-parallax="x: 500,-500">
			<?php the_content(); ?>
		</div>
		<?php
	}

	public function render_read_more_button() {
		if ( ! $this->parent->get_settings( 'show_button' ) ) {
			return;
		}
		$settings  = $this->parent->get_settings();
		$animation = ($settings['button_hover_animation']) ? ' elementor-animation-'.$settings['button_hover_animation'] : '';
		?>
		<div class="avt-post-slider-button-wrap" avt-slider-parallax="y: 200,-200">
			<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-slider-button avt-display-inline-block<?php echo esc_attr($animation); ?>">
				<?php echo esc_attr($this->parent->get_settings( 'button_text' )); ?>

				<?php if ($settings['icon']) : ?>
					<span class="avt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
						<i class="<?php echo esc_attr($settings['icon']); ?>"></i>
					</span>
				<?php endif; ?>
			</a>
		</div>
		<?php
	}

	public function render() {
		$this->parent->query_posts();

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->render_header();

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();
			$this->render_loop_item();
		}

		$this->render_footer();

		wp_reset_postdata();
	}
}