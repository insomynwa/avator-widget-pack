<?php
namespace WidgetPack\Modules\OpenStreetMap\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;

use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Open_Street_Map extends Widget_Base {

	public function get_name() {
		return 'avt-open-street-map';
	}

	public function get_title() {
		return AWP . esc_html__( ' Open Street Map', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-open-street-map';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'open', 'street', 'map', 'location' ];
	}

	public function get_style_depends() {
		return [ 'wipa-open-street-map' ];
	}

	public function get_script_depends() {
		return [ 'leaflet', 'wipa-open-street-map' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/DCQ5g7yleyk';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_osmap',
			[
				'label' => esc_html__( 'Open Street Map', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'zoom_control',
			[
				'label'   => esc_html__( 'Zoom Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'zoom',
			[
				'label' => esc_html__( 'Zoom', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
			]
		);

		$this->add_responsive_control(
			'open_street_map_height',
			[
				'label' => esc_html__( 'Map Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-open-street-map'  => 'min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'search_align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-osmap-search-wrapper' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'osmap_geocode' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'search_spacing',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-osmap-search-wrapper'  => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'osmap_geocode' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_marker',
			[
				'label' => esc_html__( 'Marker', 'avator-widget-pack' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'marker_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Marker #1',
			]
		);

		$repeater->add_control(
			'marker_lat',
			[
				'label' => esc_html__( 'Latitude', 'avator-widget-pack' ),
				'type'  => Controls_Manager::TEXT,
				'default' => '24.82391',
			]
		);

		$repeater->add_control(
			'marker_lng',
			[
				'label'   => esc_html__( 'Longitude', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '89.38414',
			]
		);

		$repeater->add_control(
			'marker_content',
			[
				'label'   => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Your Business Address Here', 'avator-widget-pack'),
			]
		);

		$repeater->add_control(
			'custom_marker',
			[
				'label'       => esc_html__( 'Custom marker', 'avator-widget-pack' ),
				'description' => esc_html__('Use max 32x32 px size icon for better result.', 'avator-widget-pack'),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => AWP_ASSETS_URL . 'images/location.svg',
				]
			]
		);

		$this->add_control(
			'markers',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => [
					[
						'marker_lat'     => '24.82391',
						'marker_lng'     => '89.38414',
						'marker_title'   => esc_html__( 'Marker #1', 'avator-widget-pack' ),
						'marker_content' => esc_html__( '<strong>Avator Limited</strong>,<br>Latifpur, Bogra - 5800,<br>Bangladesh', 'avator-widget-pack'),
					],
				],
				'title_field' => '{{{ marker_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tooltip',
			[
				'label' => esc_html__( 'Tooltip', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'marker_tooltip_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .leaflet-popup-content-wrapper' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'marker_tooltip_button_color',
			[
				'label'     => esc_html__( 'Close Button Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .leaflet-popup-close-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'marker_tooltip_button_hover_color',
			[
				'label'     => esc_html__( 'Close Button Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .leaflet-popup-close-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'marker_tooltip_background',
				'selector' => '{{WRAPPER}} .leaflet-popup-content-wrapper, {{WRAPPER}} .leaflet-popup-tip',
			]
		);

		$this->add_responsive_control(
			'marker_tooltip_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .leaflet-popup-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'marker_tooltip_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .leaflet-popup-content-wrapper',
			]
		);

		$this->add_responsive_control(
			'marker_tooltip_border_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .leaflet-popup-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'marker_tooltip_shadow',
				'selector' => '{{WRAPPER}} .leaflet-popup-content-wrapper',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'marker_tooltip_typography',
				'selector' => '{{WRAPPER}} .leaflet-popup-content-wrapper',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_zoom_control',
			[
				'label'     => esc_html__( 'Zoom Control', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'zoom_control' => 'yes'
				]
			]
		);

		$this->add_control(
			'zoom_control_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .leaflet-touch .leaflet-bar a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'zoom_control_background',
				'selector' => '{{WRAPPER}} .leaflet-touch .leaflet-bar a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'zoom_control_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .leaflet-touch .leaflet-bar a',
			]
		);

		$this->add_responsive_control(
			'zoom_control_border_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .leaflet-touch .leaflet-bar a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'zoom_control_bar_color',
			[
				'label'     => esc_html__( 'Bar Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .leaflet-touch .leaflet-bar' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'zoom_control_bar_width',
			[
				'label'     => __('Bar Width', 'avator-widget-pack'),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .leaflet-touch .leaflet-bar' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings           = $this->get_settings();
		$ep_api_settings    = get_option( 'widget_pack_api_settings' );

		$marker_settings    = [];
		$avt_counter        = 0;

		if ( ( '' != $ep_api_settings['open_street_map_access_token'] ) ) {
			$map_settings['osmAccessToken'] = $ep_api_settings['open_street_map_access_token'];

			foreach ( $settings['markers'] as $marker_item ) :		

				$marker_settings['lat']        = ( $marker_item['marker_lat'] ) ? $marker_item['marker_lat'] : '';
				$marker_settings['lng']        = ( $marker_item['marker_lng'] ) ? $marker_item['marker_lng'] : '';
				$marker_settings['title']      = ( $marker_item['marker_title'] ) ? $marker_item['marker_title'] : '';
				$marker_settings['iconUrl']    = ( $marker_item['custom_marker']['url'] ) ? $marker_item['custom_marker']['url'] : '#';			
				$marker_settings['infoWindow'] = ( $marker_item['marker_content'] ) ? $marker_item['marker_content'] : '';

				$all_markers[] = $marker_settings;

				$avt_counter++;

				if ( 1 === $avt_counter ) {
					$map_settings['lat'] = ( $marker_item['marker_lat'] ) ? $marker_item['marker_lat'] : '';
					$map_settings['lng'] = ( $marker_item['marker_lng'] ) ? $marker_item['marker_lng'] : '';
				}
				
				$map_settings['zoomControl'] = ( $settings['zoom_control'] ) ? true : false;
				$map_settings['zoom'] = $settings['zoom']['size'];

			endforeach;

			$this->add_render_attribute( 'open-street-map', 'data-settings', wp_json_encode($map_settings) );
			$this->add_render_attribute( 'open-street-map', 'data-map_markers', wp_json_encode($all_markers) );
			

			?>
			<div class="avt-open-street-map" style="width: auto; height: 400px;" <?php echo $this->get_render_attribute_string( 'open-street-map' ); ?>></div>
			<?php
		} else {
			?>
			<div class="avt-alert-warning" avt-alert>
			    <a class="avt-alert-close" avt-close></a>
			    <?php $ep_setting_url = esc_url( admin_url('admin.php?page=widget_pack_options#widget_pack_api_settings')); ?>
			    <p><?php printf(__( 'Please set your open street map accesss token in <a href="%s">widget pack settings</a> to show your map correctly.', 'avator-widget-pack' ), $ep_setting_url); ?></p>
			</div>
			<?php
		}		
	}
}
