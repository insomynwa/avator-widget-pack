<?php
namespace WidgetPack\Modules\NewsTicker;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'news-ticker';
	}

	public function get_widgets() {

		$widgets = [
			'News_Ticker',
		];
		
		return $widgets;
	}
}
