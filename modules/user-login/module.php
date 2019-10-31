<?php
namespace WidgetPack\Modules\UserLogin;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'user-login';
	}

	public function get_widgets() {

		$widgets = [
			'User_Login',
		];
		
		return $widgets;
	}

}
