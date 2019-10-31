<?php
namespace WidgetPack\Modules\CookieConsent;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'cookie-consent';
	}

	public function get_widgets() {

		$widgets = [
			'Cookie_Consent',
		];

		return $widgets;
	}
}
