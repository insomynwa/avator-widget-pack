<?php
namespace WidgetPack\Modules\EasyDigitalDownloads;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'easy-digital-downloads';
	}

	public function get_widgets() {

		$widgets = [
			'Easy_Digital_Downloads',
			'EDD_Download_History',
			'EDD_Purchase_History',
			'EDD_Profile_Editor',
		];

		return $widgets;
	}
}
