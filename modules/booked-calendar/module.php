<?php
namespace WidgetPack\Modules\BookedCalendar;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'booked-calendar';
	}

	public function get_widgets() {

		$widgets = ['BookedCalendar'];

		return $widgets;
	}
}
