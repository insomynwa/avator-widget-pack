<?php
namespace WidgetPack\Modules\TableOfContent;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'table-of-content';
	}

	public function get_widgets() {

		$widgets = [
			'Table_Of_Content',
		];

		return $widgets;
	}
}
