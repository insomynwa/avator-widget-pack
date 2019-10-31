<?php
namespace WidgetPack\Modules\AdvancedGmap\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Gmap extends Widget_Base {

	public function get_name() {
		return 'avt-advanced-gmap';
	}

	public function get_title() {
		return AWP . esc_html__( 'Advanced Google Map', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-advanced-google-map';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'advanced', 'gmap', 'location' ];
	}

	public function get_script_depends() {
		return [ 'gmap-api','gmap' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_gmap',
			[
				'label' => esc_html__( 'Google Map', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'avd_google_map_zoom_control',
			[
				'label'   => esc_html__( 'Zoom Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'avd_google_map_default_zoom',
			[
				'label' => esc_html__( 'Default Zoom', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 24,
					],
				],
				'condition' => ['avd_google_map_zoom_control' => 'yes']
			]
		);

		$this->add_control(
			'avd_google_map_street_view',
			[
				'label'   => esc_html__( 'Street View Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'avd_google_map_type_control',
			[
				'label'   => esc_html__( 'Map Type Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'avd_google_map_height',
			[
				'label' => esc_html__( 'Map Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-gmap'  => 'min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'gmap_geocode',
			[
				'label' => esc_html__( 'Search Address', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',
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
					'{{WRAPPER}} .avt-gmap-search-wrapper' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'gmap_geocode' => 'yes',
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
					'{{WRAPPER}} .avt-gmap-search-wrapper'  => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'gmap_geocode' => 'yes',
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

		$repeater->start_controls_tabs( 'tabs_content_marker' );

		$repeater->start_controls_tab(
			'tab_content_content',
			[
				'label' => esc_html__( 'Content', 'avator-widget-pack' ),
			]
		);

		$repeater->add_control(
			'marker_lat',
			[
				'label'   => esc_html__( 'Latitude', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => '24.8238746',
			]
		);

		$repeater->add_control(
			'marker_lng',
			[
				'label'   => esc_html__( 'Longitude', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => '89.3816299',
			]
		);

		$repeater->add_control(
			'marker_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => 'Another Place',
			]
		);

		$repeater->add_control(
			'marker_content',
			[
				'label'   => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Your Business Address Here', 'avator-widget-pack'),
			]
		);
		
		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_content_marker',
			[
				'label' => esc_html__( 'Marker', 'avator-widget-pack' ),
			]
		);

		$repeater->add_control(
			'custom_marker',
			[
				'label'       => esc_html__( 'Custom marker', 'avator-widget-pack' ),
				'description' => esc_html__('Use max 32x32 px size icon for better result.', 'avator-widget-pack'),
				'type'        => Controls_Manager::MEDIA,
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'marker',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => [
					[
						'marker_lat'     => '24.8248746',
						'marker_lng'     => '89.3826299',
						'marker_title'   => esc_html__( 'Avator', 'avator-widget-pack' ),
						'marker_content' => esc_html__( '<strong>Avator Limited</strong>,<br>Latifpur, Bogra - 5800,<br>Bangladesh', 'avator-widget-pack'),
					],
				],
				'title_field' => '{{{ marker_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_gmap',
			[
				'label' => esc_html__( 'GMap Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'avd_google_map_style',
			[
				'label'   => esc_html__( 'Style Json Code', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '',
		        'description' => esc_html__( 'Go to this link: <a href="https://snazzymaps.com/" target="_blank">snazzymaps.com</a> and pick a style, copy the json code from first with \'[\' to last with \']\' then come back and paste here', 'avator-widget-pack' ),
			]
		);

		$this->end_controls_section();
	
		$this->start_controls_section(
			'section_style_search',
			[
				'label'     => esc_html__( 'Search', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'gmap_geocode' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search.avt-search-default .avt-search-input' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search.avt-search-default .avt-search-input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-search.avt-search-default .avt-search-input::placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-search.avt-search-default span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'search_shadow',
				'selector' => '{{WRAPPER}} .avt-search.avt-search-default .avt-search-input',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'search_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-search.avt-search-default .avt-search-input',
			]
		);

		$this->add_responsive_control(
			'search_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search.avt-search-default .avt-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'search_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search.avt-search-default .avt-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-search.avt-search-default .avt-search-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings           = $this->get_settings();
		$id                 = 'avt-advanced-gmap-'.$this->get_id();
		$ep_api_settings    = get_option( 'widget_pack_api_settings' );
		
		$map_settings       = [];
		$map_settings['el'] = '#'.$id;
		
		$marker_settings    = [];
		$marker_content     = [];
		$avt_counter        = 0;
		$all_markers        = [];

		foreach ( $settings['marker'] as $marker_item ) {
			$marker_settings['lat']    = (double)(( $marker_item['marker_lat'] ) ? $marker_item['marker_lat'] : '');
			$marker_settings['lng']    = (double)(( $marker_item['marker_lng'] ) ? $marker_item['marker_lng'] : '');
			$marker_settings['title']  = ( $marker_item['marker_title'] ) ? $marker_item['marker_title'] : '';
			$marker_settings['icon']   = ( $marker_item['custom_marker']['url'] ) ? $marker_item['custom_marker']['url'] : '';
			
			$marker_settings['infoWindow']['content'] = ( $marker_item['marker_content'] ) ? $marker_item['marker_content'] : '';

			$all_markers[] = $marker_settings;

			$avt_counter++;
			if ( 1 === $avt_counter ) {
				$map_settings['lat'] = ( $marker_item['marker_lat'] ) ? $marker_item['marker_lat'] : '';
				$map_settings['lng'] = ( $marker_item['marker_lng'] ) ? $marker_item['marker_lng'] : '';
			}
		};


		$map_settings['zoomControl']       = ( $settings['avd_google_map_zoom_control'] ) ? true : false;
		$map_settings['zoom']              =  $settings['avd_google_map_default_zoom']['size'];
		
		$map_settings['streetViewControl'] = ( $settings['avd_google_map_street_view'] ) ? true : false;
		$map_settings['mapTypeControl']    = ( $settings['avd_google_map_type_control'] ) ? true : false;

		?>

		<?php if(empty($ep_api_settings['google_map_key'])) : ?>
			<div class="avt-alert-warning" avt-alert>
			    <a class="avt-alert-close" avt-close></a>
			    <?php $ep_setting_url = esc_url( admin_url('admin.php?page=widget_pack_options#widget_pack_api_settings')); ?>
			    <p><?php printf(__( 'Please set your google map api key in <a href="%s">widget pack settings</a> to show your map correctly.', 'avator-widget-pack' ), $ep_setting_url); ?></p>
			</div>
		<?php endif; ?>
	
		<?php if($settings['gmap_geocode']) : ?>

			<div class="avt-gmap-search-wrapper avt-margin">
			    <form method="post" id="<?php echo esc_attr($id); ?>form" class="avt-search avt-search-default">
			        <span avt-search-icon></span>
			        <input id="<?php echo esc_attr($id); ?>address" name="address" class="avt-search-input" type="search" placeholder="Search...">
			    </form>
			</div>

		<?php endif;

		$this->add_render_attribute( 'advanced-gmap', 'id', $id );
		$this->add_render_attribute( 'advanced-gmap', 'class', 'avt-advanced-gmap' );
		
		$this->add_render_attribute( 'advanced-gmap', 'data-map_markers', wp_json_encode($all_markers) );

		if( '' != $settings['avd_google_map_style'] ) {
			$this->add_render_attribute( 'advanced-gmap', 'data-map_style', trim(preg_replace('/\s+/', ' ', $settings['avd_google_map_style'])) );
		}

		$this->add_render_attribute( 'advanced-gmap', 'data-map_settings', wp_json_encode($map_settings) );
		$this->add_render_attribute( 'advanced-gmap', 'data-map_geocode', ('yes' == $settings['gmap_geocode']) ? 'true' : 'false' );
		
		?>

		<div <?php echo $this->get_render_attribute_string( 'advanced-gmap' ); ?>></div>
		
		<?php
	}
}
