<?php
namespace WidgetPack\Modules\TestimonialCarousel\Skins;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Vyxo extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-vyxo';
	}

	public function get_title() {
		return __( 'Vyxo', 'avator-widget-pack' );
	}

	public function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/avt-testimonial-carousel/section_style_text/after_section_start', [ $this, 'register_vyxo_style_controls'   ] );
	}

	public function register_vyxo_style_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'text_background_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-testimonial-carousel .avt-testimonial-carousel-text-wrap',
				'separator' => 'after',
			]
		);
	}

	public function render() {
		$settings = $this->parent->get_settings();

		$wp_query = $this->parent->render_query();

		if( $wp_query->have_posts() ) : ?>

			<?php $this->parent->render_header('vyxo'); ?>

				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			  		<div class="swiper-slide avt-testimonial-carousel-item avt-text-center">
				  		<div class="avt-testimonial-carousel-text-wrap avt-padding avt-background-primary">
			            	<?php $this->parent->render_excerpt(); ?>
				  		</div>
				  		<div class="avt-testimonial-carousel-item-wrapper">
					  		<div class="testimonial-item-header avt-position-top-center">
					  			<?php $this->parent->render_image( get_the_ID() ); ?>
				            </div>

			            	<?php
			            	$this->parent->render_title( get_the_ID() );
							$this->parent->render_address( get_the_ID() );

	                        if ( $settings['show_rating'] && $settings['show_text'] ) : ?>
		                    	<div class="avt-testimonial-carousel-rating avt-display-inline-block">
								    <?php $this->parent->render_rating( get_the_ID() ); ?>
				                </div>
	                        <?php endif; ?>

		                </div>
	                </div>
				<?php endwhile;	wp_reset_postdata(); ?>

			<?php $this->parent->render_footer();
		 	
		endif;
	}
}

