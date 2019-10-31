<?php
namespace WidgetPack\Modules\Timeline\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Olivier extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-olivier';
	}

	public function get_title() {
		return __( 'Olivier', 'avator-widget-pack' );
	}

	public function render_script() {
		$settings = $this->parent->get_settings_for_display();

		$this->parent->add_render_attribute( 'timeline', 'class', [ 'avt-timeline', 'avt-timeline-skin-olivier' ] );
		$this->parent->add_render_attribute( 'timeline', 'data-visible_items', $settings['visible_items'] );
	}

	public function render_custom() {
		$id             = $this->parent->get_id();
		$settings       = $this->parent->get_settings_for_display();
		$timeline_items = $settings['timeline_items'];
		
		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'timeline' ); ?>>
			<div class="avt-timeline-wrapper">
				<div class="avt-timeline-items">					
					
					<?php foreach ( $timeline_items as $item ) : ?>							
						
						<div class="avt-timeline-item">
							<div class="avt-timeline-content">
								<?php $this->parent->render_item( '', '', $item ); ?>
							</div>
						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
 		<?php
	}

	public function render_post() {
		$settings = $this->parent->get_settings_for_display();

		$this->parent->add_render_attribute( 'timeline', 'class', [ 'avt-timeline', 'avt-timeline-skin-olivier' ] );
		$this->parent->add_render_attribute( 'timeline', 'data-visible_items', $settings['visible_items'] );
		
		$wp_query = $this->parent->render_query();

		if( $wp_query->have_posts() ) :
		
			?>
			<div <?php echo $this->parent->get_render_attribute_string( 'timeline' ); ?>>
				<div class="avt-timeline-wrapper">
					<div class="avt-timeline-items">

						<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>							
						
							<div class="avt-timeline-item">
								<div class="avt-timeline-content">
									<?php $this->parent->render_item( '', '', '' ); ?>
								</div>
							</div>

						<?php endwhile; wp_reset_postdata(); ?>

					</div>
				</div>
			</div>
 		<?php endif;

	}

	public function render() {

		$settings = $this->parent->get_settings_for_display();

		if ( 'post'  === $settings['timeline_source'] ) {
			$this->render_post();
		} else if ( 'custom'  === $settings['timeline_source'] ) {
			$this->render_custom();
		} else {
			return;
		}

		$this->render_script();

	}
}