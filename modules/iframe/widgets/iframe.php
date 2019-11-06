<?php
namespace WidgetPack\Modules\Iframe\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Iframe extends Widget_Base {

	public function get_name() {
		return 'avt-iframe';
	}

	public function get_title() {
		return AWP . esc_html__( 'Iframe', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-iframe';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'iframe', 'embed' ];
	}

	public function get_script_depends() {
		return [ 'recliner', 'wipa-iframe' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/3ABRMLE_6-I';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'         => esc_html__( 'Content Source', 'avator-widget-pack' ),
				'type'          => Controls_Manager::URL,
				'dynamic'       => [ 'active' => true ],
				'default'       => [ 'url' => 'https://example.com' ],
				'placeholder'   => esc_html__( 'https://example.com', 'avator-widget-pack' ),
				'description'   => esc_html__( 'You can put here any website url, youtube, vimeo, document or image embed url', 'avator-widget-pack' ),
				'label_block'   => true,
				'show_external' => false,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Iframe Height', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'range'     => [
					'px' => [
						'min'   => 100,
						'max'   => 1500,
						'step' => 10,
					],
					'vw' => [
						'min'   => 1,
						'max'   => 100,
					],
					'%' => [
						'min'   => 1,
						'max'   => 100,
					],
				],
				'size_units' => [ 'px', 'vw', '%' ],
				'default' => [
					'size' => 640,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-iframe iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'auto_height!' => 'yes',
				],
			]
		);

		$this->add_control(
			'auto_height',
			[
				'label'   => esc_html__( 'Auto Height', 'avator-widget-pack' ),
				'description'   => esc_html__( 'Auto height only works when cross domain or allow origin all in header.'  , 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_iframe_settings',
			[
				'label' => esc_html__( 'Lazyload Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'lazyload',
			[
				'label'   => esc_html__( 'Lazyload', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'throttle',
			[
				'label'       => esc_html__('Throttle', 'avator-widget-pack'),
				'description' => esc_html__('millisecond interval at which to process events', 'avator-widget-pack'),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 300,
				'condition'   => [
					'lazyload' => 'yes',
				],
			]
		);

		$this->add_control(
			'threshold',
			[
				'label'       => esc_html__('Threshold', 'avator-widget-pack'),
				'description' => esc_html__('scroll distance from element before its loaded', 'avator-widget-pack'),
				'type'        => Controls_Manager::NUMBER,
				'separator'   => 'before',
				'default'     => 100,
				'condition'   => [
					'lazyload' => 'yes',
				],
			]
		);

		$this->add_control(
			'live',
			[
				'label'       => esc_html__( 'Live', 'avator-widget-pack' ),
				'description' => esc_html__('auto bind lazy loading to ajax loaded elements', 'avator-widget-pack'),
				'type'        => Controls_Manager::SWITCHER,
				'separator'   => 'before',
				'default'     => 'yes',
				'condition'   => [
					'lazyload' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => esc_html__( 'Additional Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'allowfullscreen',
			[
				'label'       => esc_html__( 'Allow Fullscreen', 'avator-widget-pack' ),
				'description' => esc_html__('Maybe you need this when you use youtube or video embed link.', 'avator-widget-pack'),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes'
			]
		);

		$this->add_control(
			'scrolling',
			[
				'label'       => esc_html__( 'Show Scroll Bar', 'avator-widget-pack' ),
				'description' => esc_html__('Specifies whether or not to display scrollbars', 'avator-widget-pack'),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sandbox',
			[
				'label'       => esc_html__( 'Sandbox', 'avator-widget-pack' ),
				'description' => esc_html__('Enables an extra set of restrictions for the content', 'avator-widget-pack'),
				'type'        => Controls_Manager::SWITCHER,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'sandbox_allowed_attributes',
			[
				'label'       => esc_html__('Sandbox Allowed Attributes', 'avator-widget-pack'),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options'     => [
					'allow-forms'            => esc_html__('Forms', 'avator-widget-pack'),
					'allow-pointer-lock'     => esc_html__('Pointer Lock', 'avator-widget-pack'),
					'allow-orientation-lock' => esc_html__('Orientation Lock', 'avator-widget-pack'),
					'allow-popups'           => esc_html__('Popups', 'avator-widget-pack'),
					'allow-same-origin'      => esc_html__('Same Origin', 'avator-widget-pack'),
					'allow-scripts'          => esc_html__('Scripts', 'avator-widget-pack'),
					'allow-top-navigation'   => esc_html__('Top Navigation', 'avator-widget-pack')
				],
				'condition' => [
					'sandbox' => 'yes'
				]
			]
		);

		$this->add_control(
			'custom_attributes',
			[
				'label' => __( 'Custom Attributes', 'avator-widget-pack' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'key|value', 'avator-widget-pack' ),
				'description' => sprintf( __( 'Set custom attributes for the iframe tag. Each attribute in a separate line. Separate attribute key from the value using %s character.', 'avator-widget-pack' ), '<code>|</code>' ),
				'classes' => 'elementor-control-direction-ltr',
			]
		);

		//allowvr="yes" allow="vr; xr; accelerometer; magnetometer; gyroscope; autoplay

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'iframe-container', 'class', 'avt-iframe' );
		if ('yes' == $settings['lazyload']) {
			$this->add_render_attribute( 'iframe', 'class', 'avt-lazyload' );
			$this->add_render_attribute( 'iframe', 'data-throttle', esc_attr($settings['throttle']) );
			$this->add_render_attribute( 'iframe', 'data-threshold', esc_attr($settings['threshold']) );
			$this->add_render_attribute( 'iframe', 'data-live', $settings['live'] ? 'true' : 'false' );
			$this->add_render_attribute( 'iframe', 'data-src', esc_url( do_shortcode( $settings['source']['url']) ) );
		} else {
			$this->add_render_attribute( 'iframe', 'src', esc_url( do_shortcode( $settings['source']['url'] ) ) );
		}

		if (! $settings['scrolling']) {
			$this->add_render_attribute( 'iframe', 'scrolling', 'no' );
		}

		$this->add_render_attribute( 'iframe', 'data-auto_height', ($settings['auto_height']) ? 'true' : 'false' );

		
		if ('yes' == $settings['allowfullscreen']) {
			$this->add_render_attribute( 'iframe', 'allowfullscreen' );
		} else {
			$this->add_render_attribute( 'iframe', 'donotallowfullscreen' );
		}

		if ($settings['sandbox']) {
			$this->add_render_attribute( 'iframe', 'sandbox' );

			if ($settings['sandbox_allowed_attributes']) {
				$this->add_render_attribute( 'iframe', 'sandbox', $settings['sandbox_allowed_attributes'] );
			}
		}

		if ( ! empty( $settings['custom_attributes'] ) ) {
			$attributes = explode( "\n", $settings['custom_attributes'] );

			$reserved_attr = [ 'class', 'onload', 'onclick', 'onfocus', 'onblur', 'onchange', 'onresize', 'onmouseover', 'onmouseout', 'onkeydown', 'onkeyup', 'onerror', 'sandbox', 'allowfullscreen', 'donotallowfullscreen', 'scrolling', 'data-throttle', 'data-threshold', 'data-live', 'data-src' ];

			foreach ( $attributes as $attribute ) {
				if ( ! empty( $attribute ) ) {
					$attr = explode( '|', $attribute, 2 );
					if ( ! isset( $attr[1] ) ) {
						$attr[1] = '';
					}

					if ( ! in_array( strtolower( $attr[0] ), $reserved_attr ) ) {
						$this->add_render_attribute( 'iframe', trim( $attr[0] ), trim( $attr[1] ) );
					}
				}
			}
		}

		?>
        <div <?php echo $this->get_render_attribute_string('iframe-container'); ?>>
        	<iframe <?php echo $this->get_render_attribute_string('iframe'); ?>></iframe>
        </div>
		<?php
	}
}
