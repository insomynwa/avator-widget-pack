<?php
namespace WidgetPack\Modules\AdvancedImageGallery;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'advanced-image-gallery';
	}

	public function get_widgets() {

		$widgets = [
			'Advanced_Image_Gallery',
		];

		return $widgets;
	}
}
