<?php
namespace WidgetPack\Modules\PostBlock\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Trinity extends Elementor_Skin_Base {

	public function get_id() {
		return 'trinity';
	}

	public function get_title() {
		return __( 'Trinity', 'avator-widget-pack' );
	}

	public function render() {
		$settings = $this->parent->get_settings();
		$id       = uniqid('avtpbm_');

		$this->parent->query_posts($settings['posts_limit']);
		$wp_query = $this->parent->get_query();

		if( $wp_query->have_posts() ) :

			$this->parent->add_render_attribute(
				[
					'post-block' => [
						'id'    => esc_attr( $id ),
						'class' => [
							'avt-post-block',
							'avt-post-block-skin-trinity',
						]
					]
				]
			);
			
			?>
			<div <?php echo $this->parent->get_render_attribute_string( 'post-block' ); ?>>

		  		<div class="avt-post-block-items avt-child-width-1-<?php echo esc_attr($settings['featured_item']); ?>@m avt-grid-<?php echo esc_attr($settings['trinity_column_gap']); ?>" avt-grid>
					<?php
					while ( $wp_query->have_posts() ) : $wp_query->the_post();

						$placeholder_image_src = Utils::get_placeholder_image_src();
						$image_src             = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );

						if ( ! $image_src ) {
							$image_src = $placeholder_image_src;
						} else {
							$image_src = $image_src[0];
						}

						?>
			  			<div class="avt-post-block-item featured-part">
				  			<div class="avt-post-block-thumbnail-wrap avt-position-relative">
				  				<div class="avt-post-block-thumbnail">
				  					<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
					  					<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
					  				</a>
				  				</div>
				  				<div class="avt-overlay-primary avt-position-cover"></div>
						  		<div class="avt-post-block-desc avt-text-center avt-position-center avt-position-medium avt-position-z-index">
									<?php if ('yes' == $settings['featured_show_tag']) : ?>
										<div class="avt-post-block-tag-wrap">
					                		<?php
											$tags_list = get_the_tag_list( '<span class="avt-background-primary">', '</span> <span class="avt-background-primary">', '</span>');
						                		if ($tags_list) :
						                    		echo  wp_kses_post($tags_list);
						                		endif; ?>
					                	</div>
									<?php endif ?>

									<?php if ('yes' == $settings['featured_show_title']) : ?>
										<h4 class="avt-post-block-title avt-margin-small-top">
											<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-block-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
										</h4>
									<?php endif ?>

					            	<?php if ('yes' == $settings['featured_show_category'] or 'yes' == $settings['featured_show_date']) : ?>

										<div class="avt-post-block-meta avt-flex-center avt-subnav avt-flex-middle">
											<?php if ('yes' == $settings['featured_show_category']) : ?>
												<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
											<?php endif ?>

											<?php if ('yes' == $settings['featured_show_date']) : ?>
												<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
											<?php endif ?>
										</div>

									<?php endif ?>
						  		</div>
							</div>
						</div>

					<?php endwhile;
					wp_reset_postdata(); ?>
				</div>
			</div>
 		<?php endif;
	}
}

