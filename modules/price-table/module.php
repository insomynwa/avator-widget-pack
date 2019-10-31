<?php
namespace WidgetPack\Modules\PriceTable;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'price-table';
	}

	public function get_widgets() {
		return [
			'Price_Table',
		];
	}
}
