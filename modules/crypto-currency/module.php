<?php
namespace WidgetPack\Modules\CryptoCurrency;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'crypto-currency';
	}

	public function get_widgets() {

		$cryptocurrency_card  = widget_pack_option('crypto-currency-card', 'widget_pack_active_modules', 'off' );
		$cryptocurrency_table = widget_pack_option('crypto-currency-table', 'widget_pack_active_modules', 'off' );
		

		$widgets = [];

		if ( 'on' === $cryptocurrency_card ) {
			$widgets[] = 'CryptoCurrencyCard';
		} 
		if ( 'on' === $cryptocurrency_table ) {
			$widgets[] = 'CryptoCurrencyTable';
		}

		return $widgets;
	}
}