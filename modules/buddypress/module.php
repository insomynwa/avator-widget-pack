<?php
namespace WidgetPack\Modules\Buddypress;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'buddypress';
	}

	public function get_widgets() {


		$bp_member  = widget_pack_option('bp_member', 'widget_pack_third_party_widget', 'on' );
		$bp_group   = widget_pack_option('bp_group', 'widget_pack_third_party_widget', 'on' );
		$bp_friends = widget_pack_option('bp_friends', 'widget_pack_third_party_widget', 'on' );
		

		$widgets = [];

		if ( 'on' === $bp_member ) {
			$widgets[] = 'Buddypress_Member';
		}
		if ( 'on' === $bp_group ) {
			$widgets[] = 'Buddypress_Group';
		} 
		if ( 'on' === $bp_friends ) {
			$widgets[] = 'Buddypress_Friends';
		}

		return $widgets;
	}
}
