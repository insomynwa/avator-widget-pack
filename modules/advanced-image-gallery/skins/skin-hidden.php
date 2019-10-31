<?php
namespace WidgetPack\Modules\AdvancedImageGallery\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Hidden extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-hidden';
	}

	public function get_title() {
		return __( 'Hidden', 'avator-widget-pack' );
	}

	public function render_header() {

		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

		$this->parent->add_render_attribute('advanced-image-gallery', 'id', 'avt-avdg-' . esc_attr($id) );

		$this->parent->add_render_attribute('advanced-image-gallery', 'class', ['avt-advanced-image-gallery', 'avt-skin-' . $settings['_skin'] ] );

		if ($settings['show_lightbox'] or 'avt-hidden' === $settings['_skin'] ) {
			$this->parent->add_render_attribute('advanced-image-gallery', 'avt-lightbox', 'animation: slide');
		}

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'advanced-image-gallery' ); ?>>
		<?php
	}

	public function render_loop_item() {
		$settings = $this->parent->get_settings_for_display();

		$this->parent->add_render_attribute('advanced-image-gallery-item', 'class', ['avt-gallery-item', 'avt-transition-toggle']);

		$this->parent->add_render_attribute('advanced-image-gallery-inner', 'class', 'avt-advanced-image-gallery-inner');
		
		if ($settings['tilt_show']) {
			$this->parent->add_render_attribute('advanced-image-gallery-inner', 'data-tilt', '');
		}

		foreach ( $settings['avd_gallery_images'] as $index => $item ) : ?>
			
			<?php $this->parent->link_only($item); ?>

		<?php endforeach;
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

		if ( empty( $settings['avd_gallery_images'] ) ) {
			return;
		}

		$this->render_header();
		$this->render_loop_item();
		$this->parent->render_footer();
	}
}

