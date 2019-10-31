<?php
namespace WidgetPack\Modules\PostGridTab;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'post-grid-tab';
	}

	public function get_widgets() {

		$widgets = [
			'Post_Grid_Tab',
		];

		return $widgets;
	}
}
