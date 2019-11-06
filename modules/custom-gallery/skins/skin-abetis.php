<?php
namespace WidgetPack\Modules\CustomGallery\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Abetis extends Elementor_Skin_Base {

	public function get_id() {
		return 'avt-abetis';
	}

	public function get_title() {
		return __( 'Abetis', 'avator-widget-pack' );
	}

	public function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/avt-custom-gallery/section_design_layout/after_section_end', [ $this, 'register_abetis_overlay_animation_controls'   ] );

	}

	public function register_abetis_overlay_animation_controls( Widget_Base $widget ) {

		$this->parent = $widget;
		$this->start_controls_section(
			'section_style_abetis',
			[
				'label' => __( 'Abetis Style', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'desc_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery-skin-abetis-desc' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery-skin-abetis-desc *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'desc_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery-skin-abetis-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'desc_alignment',
			[
				'label'       => __( 'Alignment', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery-skin-abetis-desc' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render_overlay($content, $element_key) {
		$settings                    = $this->parent->get_settings();

        if ( ! $settings['show_lightbox'] ) {
            return;
        }

		$this->parent->add_render_attribute(
			[
				'overlay-settings' => [
					'class' => [
						'avt-overlay',
						'avt-overlay-default',
						'avt-position-cover',
						$settings['overlay_animation'] ? 'avt-transition-' . $settings['overlay_animation'] : ''
					],
				],
			], '', '', true
		);

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'overlay-settings' ); ?>>
			<div class="avt-custom-gallery-content">
				<div class="avt-custom-gallery-content-inner">
				
					<?php if ( 'yes' == $settings['show_lightbox'] )  :

						$image_url = wp_get_attachment_image_src( $content['gallery_image']['id'], 'full');
						
						$this->parent->add_render_attribute($element_key, 'class', ['avt-gallery-item-link', 'avt-gallery-lightbox-item'], true );						

						$icon = $settings['icon'] ? : 'plus';

						?>
						<div class="avt-flex-inline avt-gallery-item-link-wrapper">
							<a <?php echo $this->parent->get_render_attribute_string( $element_key ); ?>>
								<?php if ( 'icon' == $settings['link_type'] ) : ?>
									<span avt-icon="icon: <?php echo esc_attr($icon); ?>; ratio: 1.6"></span>
								<?php elseif ( 'text' == $settings['link_type'] ) : ?>
									<span class="avt-text"><?php esc_html_e( 'ZOOM', 'avator-widget-pack' ); ?></span>
								<?php endif;?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function render_title($title) {
		if ( ! $this->parent->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->parent->get_settings( 'title_tag' );
		?>
		<<?php echo esc_html($tag) ?> class="avt-gallery-item-title">
			<?php echo esc_html( $title['image_title'] ); ?>
		</<?php echo esc_html($tag) ?>>
		<?php
	}

	public function render_text($text) {
		if ( ! $this->parent->get_settings( 'show_text' ) ) {
			return;
		}

		?>
		<div class="avt-gallery-item-text"><?php echo wp_kses_post($text['image_text']); ?></div>
		<?php
	}

	public function render_desc($content) {
	    if ( ! $this->parent->get_settings( 'show_title' ) and ! $this->parent->get_settings( 'show_text' ) ) {
	        return;
        }
		?>
		<div class="avt-custom-gallery-skin-abetis-desc avt-padding-small">
			<?php
			$this->render_title($content); 
			$this->render_text($content);
			?>
			
		</div>
		<?php
	}

	public function render() {
		$settings = $this->parent->get_settings();

		$this->parent->render_header('abetis');

		$this->parent->add_render_attribute('custom-gallery-item', 'class', 'avt-gallery-item');
		$this->parent->add_render_attribute('custom-gallery-item', 'class', 'avt-width-1-'. $settings['columns_mobile']);
		$this->parent->add_render_attribute('custom-gallery-item', 'class', 'avt-width-1-'. $settings['columns_tablet'] .'@s');
		$this->parent->add_render_attribute('custom-gallery-item', 'class', 'avt-width-1-'. $settings['columns'] .'@m');

		$this->parent->add_render_attribute('custom-gallery-item-inner', 'class', 'avt-custom-gallery-item-inner');
		
		if ('yes' === $settings['tilt_show']) {
			$this->parent->add_render_attribute('custom-gallery-item-inner', 'data-tilt', '');
		}

		foreach ( $settings['gallery'] as $index => $item ) :

			?>
			<div <?php echo $this->parent->get_render_attribute_string( 'custom-gallery-item' ); ?>>
				<div <?php echo $this->parent->get_render_attribute_string( 'custom-gallery-item-inner' ); ?>>

					<?php $this->parent->rendar_link($item, 'gallery-item-' . $index); ?>
					
					<?php if ($settings['direct_link']) : ?>
						<?php 
							if ( $settings['external_link'] ) {
								$this->parent->add_render_attribute( 'gallery-item-' . $index, 'target', '_blank' );
							} 
						?>
						<a <?php echo $this->parent->get_render_attribute_string( 'gallery-item-' . $index ); ?>>
					<?php endif; ?>


					<div class="avt-custom-gallery-inner avt-transition-toggle avt-position-relative">
						<?php 
						$this->parent->render_thumbnail($item, 'gallery-item-' . $index);
						$this->render_overlay($item, 'gallery-item-' . $index );
						?>
					</div>

					<?php if ($settings['direct_link']) : ?>
						</a>
					<?php endif; ?>

					<?php $this->render_desc($item); ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php $this->parent->render_footer($item);
	}
}

