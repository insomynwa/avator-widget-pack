<?php
namespace WidgetPack\Modules\ImageParallax;

use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use WidgetPack;
use WidgetPack\Plugin;
use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'avt-image-parallax';
	}

	public function get_style_depends() {
		return [ 'wipa-image-parallax' ];
	}

	public function register_controls_parallax($section, $section_id, $args) {

		static $style_sections = [ 'section_background'];

		if ( ! in_array( $section_id, $style_sections ) ) { return; }


		// parallax controls
		$section->start_controls_section(
			'section_parallax_content_controls',
			[
				'label' => AWP_CP . __( 'Parallax', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$section->start_controls_tabs( 'widget_pack_section_parallax_tabs' );

		$section->start_controls_tab(
			'widget_pack_section_image_parallax_tab',
			[
				'label' => __( 'Image', 'avator-widget-pack' ),
			]
		);
		
		$section->add_control(
			'section_parallax_elements',
			[
				'label'   => __( 'Parallax Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name'        => 'section_parallax_title',
						'label'       => __( 'Title', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => __( 'Parallax 1' , 'avator-widget-pack' ),
						'label_block' => true,
						'render_type' => 'ui',
					],
					[
						'name'      => 'section_parallax_image',
						'label'     => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'      => Controls_Manager::MEDIA,
						//'condition' => [ 'parallax_content' => 'parallax_image' ],
					],
					[
						'name'    => 'section_parallax_depth',
						'label'   => __( 'Depth', 'avator-widget-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'default' => 0.1,
						'min'     => 0,
						'max'     => 1,
						'step'    => 0.1,
					],
					[
						'name'    => 'section_parallax_bgp_x',
						'label'   => __( 'Image X Position', 'avator-widget-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					],
					[
						'name'    => 'section_parallax_bgp_y',
						'label'   => __( 'Image Y Position', 'avator-widget-pack' ),
						'type'    => Controls_Manager::NUMBER,
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					],
					[
						'name'    => 'section_parallax_bg_size',
						'label'   => __( 'Image Size', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'cover',
						'options' => [
							'auto'    => __( 'Auto', 'avator-widget-pack' ),
							'cover'   => __( 'Cover', 'avator-widget-pack' ),
							'contain' => __( 'Contain', 'avator-widget-pack' ),
						],
					],		
									
				],
				'title_field' => '{{{ section_parallax_title }}}',
			]
		);


		$section->add_control(
			'section_parallax_mode',
			[
				'label'   => esc_html__( 'Parallax Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''         => esc_html__( 'Relative', 'avator-widget-pack' ),
					'clip'     => esc_html__( 'Clip', 'avator-widget-pack' ),
					'hover'    => esc_html__( 'Hovar (Mobile also turn off)', 'avator-widget-pack' ),
				],
			]
		);



		$section->end_controls_tab();

		$section->start_controls_tab(
			'widget_pack_section_color_parallax_tab',
			[
				'label' => __( 'Color', 'avator-widget-pack' ),
			]
		);


		$section->add_control(
			'widget_pack_sbgc_parallax_show',
			[
				'label'        => __( 'Background Color', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
			]
		);

		$section->add_control(
			'widget_pack_sbgc_parallax_sc',
			[
				'label'     => esc_html__( 'Start Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'widget_pack_sbgc_parallax_show' => 'yes',
				],
			]
		);

		$section->add_control(
			'widget_pack_sbgc_parallax_ec',
			[
				'label'     => esc_html__( 'End Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'widget_pack_sbgc_parallax_show' => 'yes',
				],

			]
		);

		$section->add_control(
			'widget_pack_sbc_parallax_show',
			[
				'label'        => __( 'Border Color', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$section->add_control(
			'widget_pack_sbc_parallax_sc',
			[
				'label'     => esc_html__( 'Start Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'widget_pack_sbc_parallax_show' => 'yes',
				],
			]
		);

		$section->add_control(
			'widget_pack_sbc_parallax_ec',
			[
				'label'     => esc_html__( 'End Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'widget_pack_sbc_parallax_show' => 'yes',
				],
				
			]
		);


		$section->end_controls_tab();

		$section->end_controls_tabs();


		
		$section->end_controls_section();
		


	}


	public function section_parallax_before_render($section) {
		$parallax_elements = $section->get_settings('section_parallax_elements');
		$settings          = $section->get_settings();


		if ( 'yes' === $settings['widget_pack_sbgc_parallax_show']) {

			$color1 = ($settings['widget_pack_sbgc_parallax_sc']) ? $settings['widget_pack_sbgc_parallax_sc'] : '#fff';
			$color2 = ($settings['widget_pack_sbgc_parallax_ec']) ? $settings['widget_pack_sbgc_parallax_ec'] : '#fff';

			$section->add_render_attribute( '_wrapper', 'avt-parallax', 'background-color: '. $color1 . ',' . $color2 . ';' );
		}


		if ( 'yes' === $settings['widget_pack_sbc_parallax_show']) {

			$color1 = ($settings['widget_pack_sbc_parallax_sc']) ? $settings['widget_pack_sbc_parallax_sc'] : '#fff';
			$color2 = ($settings['widget_pack_sbc_parallax_ec']) ? $settings['widget_pack_sbc_parallax_ec'] : '#fff';

			$section->add_render_attribute( '_wrapper', 'avt-parallax', 'border-color: '. $color1 . ',' . $color2 . ';' );
		}


		if( !empty($parallax_elements) ) {


			wp_enqueue_script( 'parallax' );
			wp_enqueue_style( 'wipa-image-parallax' );

			$id = $section->get_id();
			$section->add_render_attribute( 'scene', 'class', 'parallax-scene' );
			$section->add_render_attribute( '_wrapper', 'class', 'has-avt-parallax' );

			if ( 'relative' === $settings['section_parallax_mode']) {
				$section->add_render_attribute( 'scene', 'data-relative-input', 'true' );
			} elseif ( 'clip' === $settings['section_parallax_mode']) {
				$section->add_render_attribute( 'scene', 'data-clip-relative-input', 'true' );
			} elseif ( 'hover' === $settings['section_parallax_mode']) {
				$section->add_render_attribute( 'scene', 'data-hover-only', 'true' );
			}

			?>
			<div data-parallax-id="avt_scene<?php echo esc_attr($id); ?>" id="avt_scene<?php echo esc_attr($id); ?>" <?php echo $section->get_render_attribute_string( 'scene' ); ?>>
				<?php foreach ( $parallax_elements as $index => $item ) : ?>
				
					<?php 

					$image_src = wp_get_attachment_image_src( $item['section_parallax_image']['id'], 'full' ); 

					if ($item['section_parallax_bgp_x']) {
						$section->add_render_attribute( 'item', 'style', 'background-position-x: ' . $item['section_parallax_bgp_x'] . '%;', true );
					}
					if ($item['section_parallax_bgp_y']) {
						$section->add_render_attribute( 'item', 'style', 'background-position-y: ' . $item['section_parallax_bgp_y'] . '%;' );
					}
					if ($item['section_parallax_bg_size']) {
						$section->add_render_attribute( 'item', 'style', 'background-size: ' . $item['section_parallax_bg_size'] . ';' );
					}

					if ($image_src[0]) {
						$section->add_render_attribute( 'item', 'style', 'background-image: url(' . esc_url($image_src[0]) .');' );
					}

					?>
					
					<div data-depth="<?php echo esc_attr($item['section_parallax_depth']); ?>" class="avt-scene-item" <?php echo $section->get_render_attribute_string( 'item' ); ?>></div>
					
				<?php endforeach; ?>
			</div>

			<?php
		}
	}

	protected function add_actions() {

		add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_parallax' ], 10, 3 );
		add_action( 'elementor/frontend/section/before_render', [ $this, 'section_parallax_before_render' ], 10, 1 );

	}
}