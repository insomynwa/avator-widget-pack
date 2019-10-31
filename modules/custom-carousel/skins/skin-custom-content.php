<?php
namespace WidgetPack\Modules\CustomCarousel\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;

use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Custom_Content extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-custom-content';
	}

	public function get_title() {
		return __( 'Custom Content', 'avator-widget-pack' );
	}

	public function render() {
		$this->parent->render();
	}
		
}

