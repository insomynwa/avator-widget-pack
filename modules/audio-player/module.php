<?php
namespace WidgetPack\Modules\AudioPlayer;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'audio-player';
	}

	public function get_widgets() {
		$widgets = [
			'Audio_Player',
		];

		return $widgets;
	}
}
