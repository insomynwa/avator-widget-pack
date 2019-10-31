<?php
namespace WidgetPack\Modules\DocumentViewer;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'document-viewer';
	}

	public function get_widgets() {

		$widgets = [
			'Document_Viewer',
		];

		return $widgets;
	}
}
