<?php
namespace WidgetPack\Modules\EventCalendar;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'event-calendar';
	}

	public function get_widgets() {

		$widgets = [
			'Event_Carousel',
			'Event_Grid',
		];

		return $widgets;
	}
}