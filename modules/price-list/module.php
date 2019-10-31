<?php
namespace WidgetPack\Modules\PriceList;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'price-list';
	}

	public function get_widgets() {
		return [
			'Price_List',
		];
	}
}
