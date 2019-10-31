<?php
namespace WidgetPack\Modules\AdvancedImageGallery\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Carousel extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-carousel';
	}

	public function get_title() {
		return __( 'Carousel', 'avator-widget-pack' );
	}

	public function render_header() {

		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

		$this->parent->add_render_attribute('advanced-image-gallery', 'id', 'avt-avdg-' . esc_attr($id) );
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', ['avt-advanced-image-gallery', 'avt-skin-carousel'] );
		$this->parent->add_render_attribute('advanced-image-gallery', 'avt-grid', '');
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', ['avt-grid', 'avt-grid-small'] );
		
		if ( 'masonry' == $settings['grid_type'] ) {
			$this->parent->add_render_attribute('advanced-image-gallery', 'avt-grid', 'masonry: true');
		}
		if ( $settings['show_lightbox'] ) {
			$this->parent->add_render_attribute('advanced-image-gallery', 'avt-lightbox', 'animation: slide');
		}

		$this->parent->add_render_attribute('advanced-image-gallery', 'class', 'avt-slider-items');
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', 'avt-child-width-1-' . esc_attr($settings['columns_mobile']));
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', 'avt-child-width-1-' . esc_attr($settings['columns_tablet']) .'@s');
		$this->parent->add_render_attribute('advanced-image-gallery', 'class', 'avt-child-width-1-' . esc_attr($settings['columns']) .'@m');

		$this->parent->add_render_attribute(
			[
				'slider-settings' => [
					'class' => [
						( 'both' == $settings['navigation'] ) ? 'avt-arrows-dots-align-' . $settings['both_position'] : '',
						( 'arrows' == $settings['navigation'] or 'arrows-thumbnavs' == $settings['navigation'] ) ? 'avt-arrows-align-' . $settings['arrows_position'] : '',
						( 'dots' == $settings['navigation'] ) ? 'avt-dots-align-'. $settings['dots_position'] : '',
					],
					'avt-slider' => [
						wp_json_encode(array_filter([
							"autoplay"          => ( $settings["autoplay"] ) ? true : false,
							"autoplay-interval" => $settings["autoplay_interval"],
							"finite"            => ($settings["loop"]) ? false : true,
							"pause-on-hover"    => ( $settings["pause_on_hover"] ) ? true : false,
							"center"            => ( $settings["center_slide"] ) ? true : false
						]))
					]
				]
			]
		);

		?>
		<div <?php echo ( $this->parent->get_render_attribute_string( 'slider-settings' ) ); ?>>
			<div <?php echo $this->parent->get_render_attribute_string( 'advanced-image-gallery' ); ?>>
		<?php
	}

	public function render_footer($settings) {

		?>
		</div>
		<?php if ('both' == $settings['navigation']) : ?>
			<?php $this->render_both_navigation($settings); ?>

			<?php if ( 'center' === $settings['both_position'] ) : ?>
				<?php $this->render_dotnavs($settings); ?>
			<?php endif; ?>

		<?php elseif ('arrows' == $settings['navigation']) : ?>
			<?php $this->render_navigation($settings); ?>
		<?php elseif ('dots' == $settings['navigation']) : ?>
			<?php $this->render_dotnavs($settings); ?>
		<?php endif; ?>
	</div>
	<?php
	}

	public function render_navigation($settings) {

		if (('both' == $settings['navigation']) and ('center' == $settings['both_position'])) {
			$arrows_position = 'center';
		} else {
			$arrows_position = $settings['arrows_position'];
		}

		?>
		<div class="avt-position-z-index avt-visible@m avt-position-<?php echo esc_attr($arrows_position); ?>">
			<div class="avt-arrows-container avt-slidenav-container">
				<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9" avt-slider-item="previous"></a>
				<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9" avt-slider-item="next"></a>
			</div>
		</div>
		<?php
	}

	public function render_dotnavs($settings) {

		if (('both' == $settings['navigation']) and ('center' == $settings['both_position'])) {
			$dots_position = 'bottom-center';
		} else {
			$dots_position = $settings['dots_position'];
		}

		?>
		<div class="avt-position-z-index avt-visible@m avt-position-<?php echo esc_attr($dots_position); ?>">
			<div class="avt-dotnav-wrapper avt-dots-container">
				<ul class="avt-dotnav avt-flex-center">

				    <?php		
					$avt_counter = 0;

					foreach ( $settings['avd_gallery_images'] as $index => $item ) :
					      
						echo '<li class="avt-slider-dotnav avt-active" avt-slider-item="' . esc_attr($avt_counter) . '"><a href="#"></a></li>';
						$avt_counter++;

					endforeach; ?>

				</ul>
			</div>
		</div>
		<?php
	}

	public function render_both_navigation($settings) {
		?>
		<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="avt-arrows-dots-container avt-slidenav-container ">
				
				<div class="avt-flex avt-flex-middle">
					<div>
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9" avt-slider-item="previous"></a>						
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="avt-dotnav-wrapper avt-dots-container">
							<ul class="avt-dotnav">
							    <?php		
								$avt_counter = 0;

								foreach ( $settings['avd_gallery_images'] as $index => $item ) :								      
									echo '<li class="avt-slider-dotnav avt-active" avt-slider-item="' . esc_attr($avt_counter) . '"><a href="#"></a></li>';
									$avt_counter++;
								endforeach; ?>

							</ul>
						</div>
					<?php endif; ?>
					
					<div>
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9" avt-slider-item="next"></a>						
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	public function render_loop_item($settings) {

		$this->parent->add_render_attribute('advanced-image-gallery-item', 'class', ['avt-gallery-item', 'avt-transition-toggle']);

		$this->parent->add_render_attribute('advanced-image-gallery-inner', 'class', 'avt-advanced-image-gallery-inner');
		
		if ($settings['tilt_show']) {
			$this->parent->add_render_attribute('advanced-image-gallery-inner', 'data-tilt', '');
		}

		foreach ( $settings['avd_gallery_images'] as $index => $item ) : ?>
				
			<div <?php echo $this->parent->get_render_attribute_string( 'advanced-image-gallery-item' ); ?>>
				<div <?php echo $this->parent->get_render_attribute_string( 'advanced-image-gallery-inner' ); ?>>
					<?php
					$this->parent->render_thumbnail($item);
					if ($settings['show_lightbox'] or $settings['show_caption'] )  :
						$this->parent->render_overlay($item);
					endif;
					?>
				</div>

				<?php if ($settings['show_caption'] and 'yes' == $settings['caption_all_time'])  : ?>
					<?php $this->parent->render_caption($item); ?>
				<?php endif; ?>
			</div>

		<?php endforeach;
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

		if ( empty( $settings['avd_gallery_images'] ) ) {
			return;
		}

		$this->render_header();
		$this->render_loop_item($settings);
		$this->render_footer($settings);
	}
}

