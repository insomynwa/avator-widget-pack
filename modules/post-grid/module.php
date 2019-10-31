<?php
namespace WidgetPack\Modules\PostGrid;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'post-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Post_Grid',
		];
		
		return $widgets;
	}
}
