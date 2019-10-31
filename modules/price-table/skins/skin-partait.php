<?php
namespace WidgetPack\Modules\PriceTable\Skins;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Partait extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-partait';
	}

	public function get_title() {
		return __( 'Partait', 'avator-widget-pack' );
	}

	public function register_partait_style_controls() {
		$this->start_controls_section(
			'section_style_partait',
			[
				'label' => __( 'Partait', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->parent->get_settings();

		?>
		<div class="avt-price-table avt-price-table-skin-partait">

			<div class="avt-grid avt-grid-collapse avt-child-width-1-2@m" avt-grid avt-height-match="target: > div > .avt-pricing-column">
				<div>
					<div class="avt-pricing-column">
						<?php
						$this->parent->render_header();
						$this->parent->render_price();
						$this->parent->render_footer();
						?>
					</div>
				</div>

				<div>
					<div class="avt-pricing-column avt-price-table-features-list-wrap avt-flex avt-flex-middle avt-price-table-features-list-wrap">
						<?php
						$this->parent->render_features_list();
						?>
					</div>
				</div>
			</div>
		</div>
		<?php $this->parent->render_ribbon();
	}
}

