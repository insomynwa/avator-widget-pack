<?php
namespace WidgetPack\Modules\Lightbox\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Lightbox extends Widget_Base {
	public function get_name() {
		return 'lightbox';
	}

	public function get_title() {
		return AWP . esc_html__( 'Lightbox', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-lightbox';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'lightbox', 'modal', 'popup', 'fullscreen' ];
	}
	
	public function get_script_depends() {
		return [ 'imagesloaded', 'avt-uikit-icons' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/8PdL6ZcDy28';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_toggler',
			[
				'label' => __( 'Toggler', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'lightbox_toggler',
			[
				'label'       => esc_html__( 'Select Lightbox Toggler', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'poster',
				'label_block' => true,
				'options'     => [
					'poster' => esc_html__( 'Poster', 'avator-widget-pack' ),
					'button' => esc_html__( 'Button', 'avator-widget-pack' ),
					'icon'   => esc_html__( 'Icon', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'poster_image',
			[
				'label'   => __( 'Poster Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'lightbox_toggler' => 'poster',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'poster_image_size',
				'default'   => 'large',
				'separator' => 'none',
				'condition' => [
					'lightbox_toggler' => 'poster',
				],
			]
		);

		$this->add_responsive_control(
			'poster_height',
			[
				'label'   => __( 'Poster Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 1200,
						'step' => 5,
					]
				],
				'condition' => [
					'lightbox_toggler' => 'poster',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-toggler-poster' => 'min-height: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => __( 'Button Text', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Open Lightbox',
				'condition' => [
					'lightbox_toggler' => 'button',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'lightbox_toggler_icon',
			[
				'label'     => __( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'toggler_icon',
				'default' => [
					'value' => 'fas fa-play',
					'library' => 'fa-solid',
				],
				'condition' => [
					'lightbox_toggler' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
				'condition'    => [
					'lightbox_toggler!' => 'poster',
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'     => __( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition' => [
					'lightbox_toggler' => 'button',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => __( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Before', 'avator-widget-pack' ),
					'right' => __( 'After', 'avator-widget-pack' ),
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'lightbox_toggler',
							'value' => 'button',
						],
						[
							'name'     => 'button_icon[value]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'lightbox_toggler',
							'value' => 'button',
						],
						[
							'name'     => 'button_icon[value]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Lightbox Content', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'lightbox_content',
			[
				'label'       => esc_html__( 'Select Lightbox Content', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'image',
				'label_block' => true,
				'options'     => [
					'image'      => esc_html__( 'Image', 'avator-widget-pack' ),
					'video'      => esc_html__( 'Video', 'avator-widget-pack' ),
					'youtube'    => esc_html__( 'Youtube', 'avator-widget-pack' ),
					'vimeo'      => esc_html__( 'Vimeo', 'avator-widget-pack' ),
					'google-map' => esc_html__( 'Google Map', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'content_image',
			[
				'label'   => __( 'Image Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'lightbox_content' => 'image',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_video',
			[
				'label'         => __( 'Video Source', 'avator-widget-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'default'       => [
					'url' => '//clips.vorwaerts-gmbh.de/big_buck_bunny.mp4',
				],
				'placeholder'   => '//example.com/video.mp4',
				'label_block'   => true,
				'condition'     => [
					'lightbox_content' => 'video',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_youtube',
			[
				'label'         => __( 'YouTube Source', 'avator-widget-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'default'       => [
					'url' => 'https://www.youtube.com/watch?v=YE7VzlLtp-4',
				],
				'placeholder'   => 'https://youtube.com/watch?v=xyzxyz',
				'label_block'   => true,
				'condition'     => [
					'lightbox_content' => 'youtube',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_vimeo',
			[
				'label'         => __( 'Vimeo Source', 'avator-widget-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'default'       => [
					'url' => 'https://vimeo.com/1084537',
				],
				'placeholder'   => 'https://vimeo.com/123123',
				'label_block'   => true,
				'condition'     => [
					'lightbox_content' => 'vimeo',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_google_map',
			[
				'label'         => __( 'Goggle Map Embed URL', 'avator-widget-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'default'       => [
					'url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4740.819266853735!2d9.99008871708242!3d53.550454675412404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3f9d24afe84a0263!2sRathaus!5e0!3m2!1sde!2sde!4v1499675200938',
				],
				'placeholder'   => 'https://google.com/maps/embed?pb',
				'label_block'   => true,
				'condition'     => [
					'lightbox_content' => 'google-map',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'content_caption',
			[
				'label'   => __( 'Content Caption', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => 'This is a image',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Toggle Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'lightbox_toggler!' => 'poster',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lightbox_animation',
			[
				'label'   => esc_html__( 'Lightbox Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'avator-widget-pack' ),
					'fade'  => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale' => esc_html__( 'Scale', 'avator-widget-pack' ),
				],
			]
		);

		

		$this->add_control(
			'video_autoplay',
			[
				'label'   => esc_html__( 'Video Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-play';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
		
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['button_icon']['value'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>

				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
				else : ?>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>

			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo wp_kses( $settings['button_text'], widget_pack_allow_tags('title') ); ?></span>
		</span>
		<?php
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		// remove global lightbox
		$this->add_render_attribute( 'lightbox-content', 'data-elementor-open-lightbox', 'no' );
		
		if ( 'poster' != $settings['lightbox_toggler'] ) {
			$this->add_render_attribute( 'lightbox-content', 'class', 'elementor-button elementor-size-md' );

			if ( $settings['hover_animation'] ) {
				$this->add_render_attribute( 'lightbox-content', 'class', 'elementor-animation-' . $settings['hover_animation'] );
			}
		}

		if ( $settings['content_caption'] ) {
			$this->add_render_attribute( 'lightbox-content', 'data-caption', $settings['content_caption'] );
		}

		if ('image' == $settings['lightbox_content']) {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_image']['url'] );
		} elseif ('video' == $settings['lightbox_content'] and '' != $settings['content_video']) {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_video']['url'] );
		} elseif ('youtube' == $settings['lightbox_content'] and '' != $settings['content_youtube']) {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_youtube']['url'] );
		} elseif ('vimeo' == $settings['lightbox_content'] and '' != $settings['content_vimeo']) {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_vimeo']['url'] );
		} else {
			$this->add_render_attribute( 'lightbox-content', 'href', $settings['content_google_map']['url'] );
			$this->add_render_attribute( 'lightbox-content', 'data-type', 'iframe' );
		}

		//$this->add_render_attribute( 'lightbox', 'class', 'avt-lightbox' );
		$this->add_render_attribute( 'lightbox', 'avt-lightbox', '' );
		
		if ( $settings['lightbox_animation'] ) {
			$this->add_render_attribute( 'lightbox', 'avt-lightbox', 'animation: ' . $settings['lightbox_animation'] . ';' );
		}

		if ( $settings['video_autoplay'] ) {
			$this->add_render_attribute( 'lightbox', 'avt-lightbox', 'video-autoplay: true;' );
		}
		
		if ( 'poster' == $settings['lightbox_toggler'] ) {

			$poster_url = Group_Control_Image_Size::get_attachment_image_src($settings['poster_image']['id'], 'poster_image_size', $settings);

			if ( ! $poster_url ) {
				$poster_url = $settings['poster_image']['url'];
			}
		}

		if ( ! isset( $settings['toggler_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['toggler_icon'] = 'fas fa-play';
		}

		$migrated  = isset( $settings['__fa4_migrated']['lightbox_toggler_icon'] );
		$is_new    = empty( $settings['toggler_icon'] ) && Icons_Manager::is_migration_allowed();	

        ?>
        <div id="avt-lightbox-<?php echo esc_attr($id); ?>">              
			<div <?php echo $this->get_render_attribute_string( 'lightbox' ); ?>>			

			    <a <?php echo $this->get_render_attribute_string( 'lightbox-content' ); ?>>

			    	<?php if ( 'poster' == $settings['lightbox_toggler'] ) : ?>
						<div class="avt-toggler-poster avt-background-cover" style="background-image: url('<?php echo esc_url($poster_url); ?>');"></div>
					<?php endif; ?>

					<?php if ( 'icon' == $settings['lightbox_toggler'] ) : ?>
				    	<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>

							<?php if ( $is_new || $migrated ) :
								Icons_Manager::render_icon( $settings['lightbox_toggler_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
							else : ?>
								<i class="<?php echo esc_attr( $settings['toggler_icon'] ); ?>" aria-hidden="true"></i>
							<?php endif; ?>

						</span>
					<?php endif; ?>

					<?php if ( 'button' == $settings['lightbox_toggler'] ) : ?>
			    		<?php $this->render_text(); ?>
			    	<?php endif; ?>
		    	</a>

			</div>     
        </div>
        <?php
	}
}
