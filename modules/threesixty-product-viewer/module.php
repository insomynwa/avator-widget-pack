<?php
namespace WidgetPack\Modules\ThreesixtyProductViewer;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'threesixty-product-viewer';
	}

	public function get_widgets() {

		$widgets = [
			'Threesixty_Product_Viewer'
		];

		return $widgets;
	}
}
