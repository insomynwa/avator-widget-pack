<?php
namespace WidgetPack\Modules\PortfolioGallery\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Abetis extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-abetis';
	}

	public function get_title() {
		return __( 'Abetis', 'avator-widget-pack' );
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$wp_query = $this->parent->query_posts();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->parent->render_header('abetis');

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->parent->render_post();
		}

		$this->parent->render_footer();

		if ($settings['show_pagination']) {
			widget_pack_post_pagination($wp_query);
		}
		
		wp_reset_postdata();

	}
}

