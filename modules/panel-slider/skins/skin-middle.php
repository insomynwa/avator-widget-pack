<?php
namespace WidgetPack\Modules\PanelSlider\Skins;


use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Middle extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-middle';
	}

	public function get_title() {
		return __( 'Middle', 'avator-widget-pack' );
	}

	public function render() {
		$this->parent->render();
	}
}

