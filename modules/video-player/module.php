<?php
namespace WidgetPack\Modules\VideoPlayer;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'video-player';
	}

	public function get_widgets() {
		$widgets = [
			'Video_Player',
		];

		return $widgets;
	}
}
