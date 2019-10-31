<?php
namespace WidgetPack\Modules\PostSlider\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Hazel extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-hazel';
	}

	public function get_title() {
		return __( 'Hazel', 'avator-widget-pack' );
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

		$slider_max_height = $settings['slider_max_height']['size'] ? 'style="height:' . $settings['slider_max_height']['size'] . 'px"': '';

		?>
		<div class="avt-post-slider-item">
			<div class="avt-grid avt-grid-collapse" avt-grid>
				<div class="avt-position-relative avt-width-1-2 avt-width-2-3@m avt-post-slider-thumbnail">
					<div>
						<img src="<?php echo esc_url($slider_thumbnail); ?>" alt="<?php echo get_the_title(); ?>">						
					</div>
				</div>

				<div class="avt-width-1-2 avt-width-1-3@m">
					<div class="avt-post-slider-content" <?php echo esc_attr($slider_max_height); ?>>

			            <?php if ($settings['show_tag']) : ?>
			        		<?php $tags_list = get_the_tag_list('<span class="avt-background-primary">','</span> <span class="avt-background-primary">','</span>'); ?>
			        		<?php if ($tags_list) : ?> 
			            		<div class="avt-post-slider-tag-wrap"><?php  echo  wp_kses_post($tags_list); ?></div>
			            	<?php endif; ?>
			            <?php endif; ?>

						<?php $this->render_title(); ?>

						<?php if ($settings['show_meta']) : ?>
							<div class="avt-post-slider-meta avt-flex-inline avt-flex-middile avt-subnav avt-margin-small-top">
								<div class="avt-display-inline-block avt-text-capitalize avt-author"><?php echo esc_attr(get_the_author()); ?></div> 
								<span class="avt-padding-remove-horizontal"><?php esc_html_e('On', 'avator-widget-pack'); ?> <?php echo get_the_date(); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( 'yes' == $this->parent->get_settings( 'show_text' ) ) : ?> 
							<?php $this->render_excerpt(); ?>
							<?php $this->render_read_more_button(); ?>
						<?php else : ?>
							<?php $this->render_content(); ?>
						<?php endif; ?>
					</div>
				</div>
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

		$ratio = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'].":".$settings['slider_size_ratio']['height'] : '';

	    $this->parent->add_render_attribute(
			[
				'slider-settings' => [
					'id'    => esc_attr($id),
					'class' => [
						'avt-post-slider',
						'avt-post-slider-skin-hazel',
						'avt-position-relative'
					],
					'avt-slideshow' => [
						wp_json_encode(array_filter([
							"animation"         => $settings["slider_animations"],
							"min-height"        => $settings["slider_min_height"]["size"],
							"max-height"        => $settings["slider_max_height"]["size"],
							"ratio"             => $ratio,
							"autoplay"          => $settings["autoplay"],
							"autoplay-interval" => $settings["autoplay_interval"],
							"pause-on-hover"    => $settings["pause_on_hover"]
						]))
					],
					'avt-height-match' => '.avt-post-slider-match-height'
				]
			]
		);
	    
		?>
		<div <?php echo ( $this->parent->get_render_attribute_string( 'slider-settings' ) ); ?>>
			<div class="avt-slideshow-items avt-child-width-1-1">
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
				<<?php echo esc_attr($tag) ?> class="avt-post-slider-title avt-margin-remove-bottom">
					<?php the_title() ?>
				</<?php echo esc_attr($tag) ?>>
			</a>
		</div>
		<?php
	}

	public function render_footer() {
		?>

			</div>
			<?php $this->render_navigation(); ?>			
		</div>
		
		<?php
	}

	public function render_navigation() {
		$id     = $this->parent->get_id();
		$is_rtl = is_rtl() ? 'dir="ltr"' : '';

		?>
		<div id="<?php echo esc_attr($id); ?>_nav"  class="avt-post-slider-navigation avt-position-bottom-right avt-width-1-2 avt-width-1-3@m">
			<div class="avt-post-slider-navigation-inner avt-grid avt-grid-collapse" <?php echo esc_attr($is_rtl); ?>>
				<a class="avt-hidden-hover avt-width-1-2" href="#" avt-slideshow-item="previous">
					<svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
						<polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
					</svg>
					<span class="avt-slider-nav-text"><?php esc_html_e( 'PREV', 'avator-widget-pack' ) ?></span>
				</a>
				<a class="avt-hidden-hover avt-width-1-2" href="#" avt-slideshow-item="next">
					<span class="avt-slider-nav-text"><?php esc_html_e( 'NEXT', 'avator-widget-pack' ) ?></span>
					<svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
						<polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "></polyline>
					</svg>
				</a>
			</div>
		</div>
		<?php
	}

	public function render_content() {
		?>
		<div class="avt-post-slider-text avt-visible@m">
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
		<div class="avt-post-slider-button-wrap">
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