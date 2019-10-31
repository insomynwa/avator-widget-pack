<?php
namespace WidgetPack\Modules\SinglePost;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'single-post';
	}

	public function get_widgets() {

		$widgets = [
			'Single_Post',
		];
		
		return $widgets;
	}
}
