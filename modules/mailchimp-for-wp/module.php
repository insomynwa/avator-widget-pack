<?php
namespace WidgetPack\Modules\MailchimpForWP;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'mailchimp-for-wp';
	}

	public function get_widgets() {

		$widgets = ['Mailchimp_For_WP'];

		return $widgets;
	}
}
