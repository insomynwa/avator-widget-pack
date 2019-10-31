<?php
namespace WidgetPack\Modules\PostGrid\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Trosia extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-trosia';
	}

	public function get_title() {
		return __( 'Trosia', 'avator-widget-pack' );
	}

	public function render() {

		$settings = $this->parent->get_settings();
		$id       = $this->parent->get_id();
		
		$this->parent->add_render_attribute('post-grid-item', 'class', 'avt-width-1-'. $settings['columns_mobile']);
		$this->parent->add_render_attribute('post-grid-item', 'class', 'avt-width-1-'. $settings['columns_tablet'] .'@s');
		$this->parent->add_render_attribute('post-grid-item', 'class', 'avt-width-1-'. $settings['columns'] .'@m');

		$this->parent->query_posts($settings['trosia_item_limit']['size']);
		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		?> 
		<div id="avt-post-grid-<?php echo esc_attr($id); ?>" class="avt-post-grid avt-post-grid-skin-trosia">
	  		<div class="avt-grid avt-grid-<?php echo esc_attr($settings['column_gap']); ?>" avt-grid>

				<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>		

		            <div <?php echo $this->parent->get_render_attribute_string( 'post-grid-item' ); ?>>
		                <div class="avt-post-grid-item avt-transition-toggle avt-position-relative">
								
							<?php $this->parent->render_image(get_post_thumbnail_id( get_the_ID() ), $settings['thumbnail_size'] ); ?>

							<div class="avt-custom-overlay avt-position-cover"></div>
					  		
					  		<div class="avt-post-grid-desc avt-position-bottom">
						  		<div class="avt-position-medium ">

									<?php $this->parent->render_title(); ?>

					            	<?php if (('yes' == $settings['show_author']) or ('yes' == $settings['show_date'])) : ?>
										<div class="avt-post-grid-meta avt-subnav avt-flex-middle avt-margin-small-top">
											<?php $this->parent->render_author(); ?>
											<?php $this->parent->render_date(); ?>
										</div>
									<?php endif; ?>
									
							  		<div class="avt-transition-slide-bottom">
										<?php $this->parent->render_excerpt( $settings['excerpt_length'] ); ?>
									</div>
								</div>
							</div>

							<?php $this->parent->render_category(); ?>

						</div>
		            </div>

				<?php endwhile; ?>
			</div>
		</div>
	
 		<?php
 		
 		if ($settings['show_pagination']) {
 			widget_pack_post_pagination($wp_query);
 		}
		wp_reset_postdata();
	}
}

