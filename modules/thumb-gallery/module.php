<?php
namespace WidgetPack\Modules\ThumbGallery;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'thumb-gallery';
	}

	public function get_widgets() {

		$widgets = [
			'Thumb_Gallery',
		];

		return $widgets;
	}
}
