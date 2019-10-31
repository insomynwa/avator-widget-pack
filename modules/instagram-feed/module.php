<?php
namespace WidgetPack\Modules\InstagramFeed;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'instagram-feed';
	}

	public function get_widgets() {

		$widgets = ['Instagram_Feed'];

		return $widgets;
	}
}
