<?php
namespace WidgetPack\Modules\ThumbGallery\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

use Elementor\Utils;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Custom extends Elementor_Skin_Base {
	public function get_id() {
		return 'avt-custom';
	}

	public function get_title() {
		return __( 'Custom', 'avator-widget-pack' );
	}

	public function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/avt-thumb-gallery/section_query/after_section_end', [ $this, 'register_thumb_gallery_custom_controls'   ] );
		add_action( 'elementor/element/avt-thumb-gallery/section_button/after_section_start', [ $this, 'register_thumb_gallery_custom_button_controls'   ] );

	}

	public function register_thumb_gallery_custom_controls() {
		$this->start_controls_section(
			'section_custom_content',
			[
				'label' => esc_html__( 'Custom Content', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'gallery',
			[
				'label'   => esc_html__( 'Gallery Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'image_title' => esc_html__( 'Image #1', 'avator-widget-pack' ),
						'image_text'  => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'image_title' => esc_html__( 'Image #2', 'avator-widget-pack' ),
						'image_text'  => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'image_title' => esc_html__( 'Image #3', 'avator-widget-pack' ),
						'image_text'  => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'image_title' => esc_html__( 'Image #4', 'avator-widget-pack' ),
						'image_text'  => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
				],
				'fields' => [
					[
						'name'    => 'image_title',
						'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'dynamic' => [ 'active' => true ],
						'default' => esc_html__( 'Slide Title' , 'avator-widget-pack' ),
					],
					[
						'name'    => 'gallery_image',
						'label'   => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'    => Controls_Manager::MEDIA,
						'dynamic' => [ 'active' => true ],
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'name'    => 'image_text',
						'label'   => esc_html__( 'Content', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXTAREA,
						'dynamic' => [ 'active' => true ],
						'default' => esc_html__( 'Slide Content', 'avator-widget-pack' ),
					],
				],
				'title_field' => '{{{ image_title }}}',
			]
		);

		$this->end_controls_section();
	}

	public function register_thumb_gallery_custom_button_controls( Widget_Base $widget ) {
		$this->parent = $widget;
		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'avator-widget-pack' ),
				'default'     => [
					'url' => '#',
				],
			]
		);
	}

	public function render_image($image, $size) {
		$image_url = wp_get_attachment_image_src( $image['gallery_image']['id'], $size );

		$image_url = ( '' != $image_url ) ? $image_url[0] : $image['gallery_image']['url'];

		return $image_url;
	}

	public function render_title($title) {
		if ( ! $this->parent->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->parent->get_settings( 'title_tag' );
		$classes = ['avt-thumb-gallery-title'];
		?>

		<<?php echo esc_attr($tag) ?> class="<?php echo implode(" ", $classes); ?>">
			<?php echo esc_attr($title['image_title']); ?>
		</<?php echo esc_attr($tag) ?>>
		<?php
	}

	public function render_text($text) {
		if ( ! $this->parent->get_settings( 'show_text' ) ) {
			return;
		}

		?>
		<div class="avt-thumb-gallery-text avt-text-small">
			<?php echo wp_kses_post($text['image_text']); ?>
		</div>
		<?php
	}

	public function render_button() {
		if ( ! $this->parent->get_settings( 'show_button' ) ) {
			return;
		}

		$settings = $this->parent->get_settings();
		$instance = $this->get_instance_value('link');

		$this->parent->add_render_attribute(
			[
				'thumb-gallery-button' => [
					'class' => [
						'avt-thumb-gallery-button',
						'avt-display-inline-block',
						$settings['button_hover_animation'] ? 'elementor-animation-'.$settings['button_hover_animation'] : '',
					],
					'href' => empty( $instance['url']) ? '#' : esc_url($instance['url']),
					'target' => $instance['is_external'] ? '_blank' : '_self'
				]
			], '', '', true
		);
		
		?>
			<div>
				<a <?php echo ( $this->parent->get_render_attribute_string( 'thumb-gallery-button' ) );?>>
					<?php echo esc_attr($settings['button_text']); ?>
				
					<?php if ($settings['icon']) : ?>
						<span class="avt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">
							<i class="<?php echo esc_attr($settings['icon']); ?>"></i>
						</span>
					<?php endif; ?>
				</a>
			</div>
		<?php
	}

	public function render_loop_items() {
		$settings             = $this->parent->get_settings();
		$gallery              = $this->get_instance_value('gallery');
		$content_transition   = $settings['content_transition'] ? ' avt-transition-' . $settings['content_transition'] : '';
		$slideshow_fullscreen = $settings['slideshow_fullscreen'] ? ' avt-height-viewport="offset-top: true"' : '';
		$kenburns_reverse     = $settings['kenburns_reverse'] ? ' avt-animation-reverse' : '';
		
		?>
		<ul class="avt-slideshow-items"<?php echo esc_attr($slideshow_fullscreen); ?>>
			<?php
			foreach ( $gallery as $item ) :

				$gallery_image = $this->render_image($item, 'full');
				?>
				<li>
					<?php if( $settings['kenburns_animation'] ) : ?>
						<div class="avt-position-cover avt-animation-kenburns<?php echo esc_attr( $kenburns_reverse ); ?> avt-transform-origin-center-left">
					<?php endif; ?>

						<img src="<?php echo esc_url($gallery_image); ?>" alt="<?php echo get_the_title(); ?>" avt-cover>

					<?php if( $settings['kenburns_animation'] ) : ?>
			            </div>
			        <?php endif; ?>
					<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['content_position']); ?> avt-position-large">

						<?php if ( $settings['show_title'] || $settings['show_text'] || $settings['show_button'] ) : ?>
							<div class="avt-text-<?php echo esc_attr($settings['content_align']); ?>">
								<div class="avt-thumb-gallery-content<?php echo esc_attr($content_transition); ?>">
						        	<?php $this->render_title($item); ?>
						        	<?php $this->render_text($item); ?>
						        	<?php $this->render_button(); ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</li>
				<?php
			endforeach;
			?>
    	</ul>
    	<?php
	}

	public function render() {
		$this->parent->render_header();
		$this->render_loop_items();
		$this->parent->render_navigation();
		$this->render_thumbnavs();
		$this->parent->render_footer();
	}

	public function render_thumbnavs() {
		$settings = $this->parent->get_settings();

		if ( 'arrows' == $settings['navigation'] || 'none' == $settings['navigation'] ) {
			return;
		}
		
		$thumbnavs_outside = '';
		$vertical_thumbnav = '';

		if  ( 'center-left' == $settings['thumbnavs_position'] || 'center-right' == $settings['thumbnavs_position'] ) {
			if ( $settings['thumbnavs_outside'] ) {
				$thumbnavs_outside = '-out';
			}
			$vertical_thumbnav = ' avt-thumbnav-vertical';
		}

		?>
		<div class="avt-thumbnav-wrapper avt-position-<?php echo esc_attr($settings['thumbnavs_position'] . $thumbnavs_outside); ?> avt-position-small">
        	<ul class="avt-thumbnav<?php echo esc_attr($vertical_thumbnav); ?>">

				<?php		
				$avt_counter = 0;
				$gallery_thumb = $this->get_instance_value( 'gallery' );
				      
				foreach ( $gallery_thumb as $item ) :

					$gallery_thumbnail = $this->render_image($item, 'thumbnail');
					echo '<li class="avt-thumb-gallery-thumbnav" avt-slideshow-item="' . $avt_counter . '"><a class="avt-overflow-hidden avt-background-cover" href="#" style="background-image: url(' . esc_url($gallery_thumbnail) . ')"></a></li>';
					$avt_counter++;

				endforeach; ?>
        	</ul>
		</div>
    	<?php
	}
}