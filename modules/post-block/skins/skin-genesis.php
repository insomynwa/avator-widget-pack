<?php
namespace WidgetPack\Modules\PostBlock\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Genesis extends Elementor_Skin_Base {

	public function get_id() {
		return 'genesis';
	}

	public function get_title() {
		return __( 'Genesis', 'avator-widget-pack' );
	}

	public function render() {
		$settings = $this->parent->get_settings();
		$id       = uniqid('avtpbm_');

		$animation        = ($settings['read_more_hover_animation']) ? ' elementor-animation-'.$settings['read_more_hover_animation'] : '';
		$avt_list_divider = ( $settings['show_list_divider'] ) ? ' avt-has-divider' : '';

		$this->parent->query_posts($settings['posts_limit']);
		$wp_query = $this->parent->get_query();

		if( $wp_query->have_posts() ) :

			$this->parent->add_render_attribute(
				[
					'post-block' => [
						'id'    => esc_attr( $id ),
						'class' => [
							'avt-post-block',
							'avt-grid',
							'avt-grid-match',
							'avt-post-block-skin-genesis',
						],
						'avt-grid' => ''
					]
				]
			);

			if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
				// add old default
				$settings['icon'] = 'fas fa-arrow-right';
			}

			$migrated  = isset( $settings['__fa4_migrated']['post_block_icon'] );
			$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			?> 
			<div <?php echo $this->parent->get_render_attribute_string( 'post-block' ); ?>>

				<?php $avt_count = 0;
			
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					$avt_count++;

					$placeholder_image_src = Utils::get_placeholder_image_src();
					$image_src             = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );

					if ( ! $image_src ) {
						$image_src = $placeholder_image_src;
					} else {
						$image_src = $image_src[0];
					}

					if( $avt_count <= $settings['featured_item']) : ?>

				  		<div class="avt-width-1-<?php echo esc_attr($settings['featured_item']); ?>@m">
				  			<div class="avt-post-block-item featured-part">
								<div class="avt-post-block-img-wrapper avt-margin-bottom">
									<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
					  					<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
					  				</a>
								</div>
						  		
						  		<div class="avt-post-block-desc">

									<?php if ($settings['featured_show_title']) : ?>
										<h4 class="avt-post-block-title">
											<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-block-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
										</h4>
									<?php endif ?>

	            	            	<?php if ($settings['featured_show_category'] or $settings['featured_show_date']) : ?>

	            						<div class="avt-post-block-meta avt-subnav avt-flex-middle">
	            							<?php if ($settings['featured_show_date']) : ?>
	            								<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
	            							<?php endif ?>

	            							<?php if ($settings['featured_show_category']) : ?>
	            								<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
	            							<?php endif ?>
	            							
	            						</div>

	            					<?php endif ?>

									<?php $this->parent->render_excerpt(); ?>

									<?php if ($settings['featured_show_read_more']) : ?>
										<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-block-read-more avt-link-reset<?php echo esc_attr($animation); ?>"><?php echo esc_html($settings['read_more_text']); ?>
											
											<?php if ($settings['post_block_icon']['value']) : ?>
												<span class="avt-post-block-read-more-icon-<?php echo esc_attr($settings['icon_align']); ?>">

													<?php if ( $is_new || $migrated ) :
														Icons_Manager::render_icon( $settings['post_block_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
													else : ?>
														<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
													<?php endif; ?>

												</span>
											<?php endif; ?>

										</a>
									<?php endif ?>

						  		</div>

							</div>
							
						</div>
					
					<?php if ($avt_count == $settings['featured_item']) : ?>

			  		<div class="avt-post-block-item list-part avt-width-1-1@m avt-margin-medium-top">
			  			<ul class="avt-child-width-1-<?php echo esc_attr($settings['featured_item']); ?>@m<?php echo esc_attr($avt_list_divider); ?>" avt-grid avt-scrollspy="cls: avt-animation-fade; target: > .avt-post-block-item; delay: 300;">
			  		<?php endif; ?>

					<?php else : ?>
						<?php $post_thumbnail  = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' ); ?>
					  			<li>
						  			<div class="avt-flex">
						  				<div class="avt-post-block-thumbnail avt-width-auto">
						  					<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
							  					<img src="<?php echo esc_url($post_thumbnail[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
							  				</a>
						  				</div>
								  		<div class="avt-post-block-desc avt-width-expand avt-margin-small-left">
											<?php if ($settings['list_show_title']) : ?>
												<h4 class="avt-post-block-title">
													<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-block-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
												</h4>
											<?php endif ?>

							            	<?php if ($settings['list_show_category'] or $settings['list_show_date']) : ?>

												<div class="avt-post-block-meta avt-subnav avt-flex-middle">
													<?php if ($settings['list_show_date']) : ?>
														<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
													<?php endif ?>

													<?php if ($settings['list_show_category']) : ?>
														<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
													<?php endif ?>
													
												</div>

											<?php endif ?>
								  		</div>
									</div>
								</li>
							<?php endif; endwhile; ?>
						</ul>
					</div>
				</div>
		
		 	<?php 
			wp_reset_postdata(); 
		endif;
	}
}

