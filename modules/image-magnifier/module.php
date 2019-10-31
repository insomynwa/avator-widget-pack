<?php
namespace WidgetPack\Modules\ImageMagnifier;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'image-magnifier';
	}

	public function get_widgets() {

		$widgets = [
			'Image_Magnifier',
		];

		return $widgets;
	}
}
