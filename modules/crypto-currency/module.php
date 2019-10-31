<?php
namespace WidgetPack\Modules\CryptoCurrency;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'crypto-currency';
	}

	public function get_widgets() {

		$widgets = [
			'CryptoCurrencyCard',
			'CryptoCurrencyTable',
			//'CryptoCurrencyPriceMarquee'
		];

		return $widgets;
	}
}