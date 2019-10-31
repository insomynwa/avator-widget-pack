<?php
namespace WidgetPack\Modules\Weather\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Weather extends Widget_Base {

	public $weather_data = [];

	public $weather_api_url = 'https://api.apixu.com/v1/forecast.json';

	public function get_name() {
		return 'avt-weather';
	}

	public function get_title() {
		return AWP . esc_html__( 'Weather', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-weather';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'weather', 'cloudy', 'sunny', 'morning', 'evening' ];
	}

	public function get_style_depends() {
		return ['weather'];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_weather',
			[
				'label' => esc_html__( 'Weather', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'view',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => [
					'simple'   => esc_html__( 'Simple', 'avator-widget-pack' ),
					'today'    => esc_html__( 'Today', 'avator-widget-pack' ),
					'tiny'     => esc_html__( 'Tiny', 'avator-widget-pack' ),
					'forecast' => esc_html__( 'Forecast', 'avator-widget-pack' ),
					'full'     => esc_html__( 'Full', 'avator-widget-pack' ),
				],
				'prefix_class' => 'avt-weather-layout-',
				'render_type' => 'template',
			]
		);

		// $this->add_control(
		// 	'location_type',
		// 	[
		// 		'label'   => esc_html__( 'Location Type', 'avator-widget-pack' ),
		// 		'type'    => Controls_Manager::SELECT,
		// 		'default' => 'darksky',
		// 		'options' => [
		// 			'lat_long'        => esc_html__( 'Latitude Longitude', 'avator-widget-pack' ),
		// 			'location' => esc_html__( 'Location Name', 'avator-widget-pack' ),
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'latitude',
		// 	[
		// 		'label'       => esc_html__( 'Latitude', 'avator-widget-pack' ),
		// 		'description' => __( '<a href="https://www.latlong.net/">Look here</a> for your latitude.', 'avator-widget-pack' ),
		// 		'type'        => Controls_Manager::TEXT,
		// 		'dynamic'     => [ 'active' => true ],
		// 		'default'     => 24.823402,
		// 		'condition'   => [
		// 			'api_type' => ['darksky']
		// 		]
		// 	]
		// );

		// $this->add_control(
		// 	'longitude',
		// 	[
		// 		'label'       => esc_html__( 'Longitude', 'avator-widget-pack' ),
		// 		'description' => __( '<a href="https://www.latlong.net/">Look here</a> for your longitude.', 'avator-widget-pack' ),
		// 		'type'        => Controls_Manager::TEXT,
		// 		'dynamic'     => [ 'active' => true ],
		// 		'default'     => 89.384077,
		// 		'condition'   => [
		// 			'api_type' => ['darksky']
		// 		]
		// 	]
		// );

		$this->add_control(
			'location',
			[
				'label'   => esc_html__( 'Location', 'avator-widget-pack' ),
				'description'   => esc_html__( 'City and Region required, for example: Boston, MA', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => 'Bogra, BD',
			]
		);

		$this->add_control(
			'country',
			[
				'label'   => esc_html__( 'Country (optional)', 'avator-widget-pack' ),
				'description'   => esc_html__( 'If you want to override country name, for example: USA', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'units',
			[
				'label'   => esc_html__( 'Units', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'metric',
				'options' => [
					'metric'   => esc_html__( 'Metric', 'avator-widget-pack' ),
					'imperial' => esc_html__( 'Imperial', 'avator-widget-pack' ),
				],
			]
		);

		// $this->add_control(
		// 	'timeformat',
		// 	[
		// 		'label'   => esc_html__( 'Time Format', 'avator-widget-pack' ),
		// 		'type'    => Controls_Manager::SELECT,
		// 		'default' => 12,
		// 		'options' => [
		// 			12 => esc_html__( '12', 'avator-widget-pack' ),
		// 			24 => esc_html__( '24', 'avator-widget-pack' ),
		// 		],
		// 		'condition' => [
		// 			'view!' => ['tiny']
		// 		]
		// 	]
		// );

		$this->add_control(
			'show_city',
			[
				'label'   => esc_html__( 'Show City Name', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				// 'condition' => [
				// 	'view!' => ['tiny', 'forecast']
				// ]
			]
		);

		$this->add_control(
			'show_country',
			[
				'label'   => esc_html__( 'Show Country Name', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'view!' => ['tiny']
				]
			]
		);

		$this->add_control(
			'show_temperature',
			[
				'label'   => esc_html__( 'Show Temperature', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				// 'condition' => [
				// 	'view!' => ['tiny']
				// ]
			]
		);

		$this->add_control(
			'show_weather_condition_name',
			[
				'label'   => esc_html__( 'Show Weather Condition Name', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				// 'condition' => [
				// 	'view!' => ['tiny']
				// ]
			]
		);

		$this->add_control(
			'show_weather_icon',
			[
				'label'   => esc_html__( 'Show Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'view!' => ['forecast']
				]
			]
		);

		$this->add_control(
			'show_weather_desc',
			[
				'label'   => esc_html__( 'Show Description', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'view' => ['tiny']
				]
			]
		);

		$this->add_control(
			'show_today_name',
			[
				'label'   => esc_html__( 'Show Today Name', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'view!' => ['tiny', 'simple']
				]
			]
		);

		$this->add_control(
			'weather_details',
			[
				'label'   => esc_html__( 'Weather Details', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'view!' => ['tiny', 'simple']
				]
			]
		);

		$this->add_control(
			'forecast',
			[
				'label' => esc_html__( 'Forecast', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'default' => [
					'size' => 5,
				],
				'condition' => [
					'view' => ['full', 'forecast']
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_weather',
			[
				'label' => esc_html__( 'Weather', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-weather' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-weather [class*="avtw-"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tiny_text_typography',
				'selector' => '{{WRAPPER}} .avt-weather',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		

		$this->add_control(
			'forecast_border',
			[
				'label' => __( 'Border', 'avator-widget-pack' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				// 'selectors' => [
				// 	'{{WRAPPER}} .avt-weather .avt-wf-divider>li:nth-child(n+2)' => 'border-style: solid',
				// ],
			]
		);

		$this->add_control(
			'forecast_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid'  => esc_html__( 'Solid', 'avator-widget-pack' ),
					'dotted' => esc_html__( 'Dotted', 'avator-widget-pack' ),
					'dashed' => esc_html__( 'Dashed', 'avator-widget-pack' ),
					'double' => esc_html__( 'Double', 'avator-widget-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .avt-weather .avt-wf-divider>li:nth-child(n+2)' => 'border-top-style: {{VALUE}}',
				],
				'condition' => [
					'forecast_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'forecast_border_color',
			[
				'label' => __( 'Border Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-weather .avt-wf-divider>li:nth-child(n+2)' => 'border-top-color: {{VALUE}}',
				],
				'condition' => [
					'forecast_border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'forecast_border_width',
			[
				'label' => __( 'List Space', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-weather .avt-wf-divider>li:nth-child(n+2)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'forecast_border' => 'yes',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_location',
			[
				'label'     => esc_html__( 'Tiny Style', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'view' => 'tiny'
				]
			]
		);


		$this->add_control(
			'tiny_location_color',
			[
				'label'     => esc_html__( 'Location Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-weather-layout-tiny .avt-weather .avt-weather-city-name' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'tiny_temp_color',
			[
				'label'     => esc_html__( 'Tempareture Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-weather-layout-tiny .avt-weather .avt-weather-today-temp' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'tiny_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-weather-layout-tiny .avt-weather .avt-weather-today-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tiny_weather_desc',
			[
				'label'     => esc_html__( 'Description Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-weather-layout-tiny .avt-weather .avt-weather-today-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings           = $this->get_settings_for_display();
		$this->weather_data = $this->weather_data();		

		$this->add_render_attribute( 'weather', 'class', 'avt-weather' );
		//$this->add_render_attribute( 'weather', 'class', 'avt-weather-layout-' . $settings['view'] );

		?>

		<div <?php echo $this->get_render_attribute_string('weather'); ?>>
			<div class="avt-weather-container">

				<?php if ( 'full' == $settings['view'] or 'simple' == $settings['view'] or 'today' == $settings['view'] ) : ?>
					<?php $this->render_weather_today(); ?>
				<?php elseif ( 'tiny' == $settings['view'] ) : ?>
					<?php $this->render_weather_tiny(); ?>
				<?php endif; ?>
				
				<?php if ( 'full' == $settings['view'] or 'forecast' == $settings['view'] ) : ?>
					<?php $this->render_weather_forecast(); ?>
				<?php endif; ?>

			</div>
		</div>

		<?php
	}


	public function render_weather_today() {
		$settings   = $this->get_settings_for_display();
		$data       = $this->weather_data;
		$speed_unit = ( 'metric' === $settings['units'] ) ? esc_html_x( 'km/h', 'Weather String', 'avator-widget-pack' ) : esc_html_x( 'm/h', 'Weather String', 'avator-widget-pack' );
		$speed      = ( 'metric' === $settings['units'] ) ? $data['today']['wind_speed']['kph'] : $data['today']['wind_speed']['mph'];

		?>

		<div class="avt-weather-today">
			<?php if ( 'yes' == $settings['show_city'] or 'yes' == $settings['show_country'] or 'yes' == $settings['show_temperature'] or 'yes' == $settings['show_today_name'] ) : ?>
			<div class="avt-grid avt-grid-collapse">
				
				<div class="avt-width-3-5">
						
					<?php $this->render_weather_title(); ?>
		
					<?php if ( 'yes' == $settings['show_temperature'] ) : ?>
						<div class="avt-weather-today-temp"><?php echo $this->weather_temperature( $data['today']['temp'] ); ?></div>
					<?php endif; ?>
					
					<?php if ( 'yes' == $settings['show_today_name'] ) : ?>
						<div class="avt-weather-today-name"><?php echo esc_html($data['today']['week_day']); ?></div>
					<?php endif; ?>
				</div>
				
				<?php if ( 'yes' == $settings['show_weather_icon'] ) : ?>
				<div class="avt-width-2-5 avt-flex avt-flex-middle avt-text-center">
					<div class="avt-width-1-1">
						<div class="avt-weather-today-icon"><?php echo $this->weather_icon( $data['today']['code'], $data['today']['is_day'] ); ?></div>
						
						<?php if ( 'yes' == $settings['show_weather_condition_name'] ) : ?>
							<div class="avt-weather-today-desc"><?php echo $this->weather_desc( $data['today']['code'], $data['today']['is_day'] ); ?></div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				
			</div>
			<?php else : ?>
				<div class="avt-text-center">
					<div class="avt-weather-today-icon"><?php echo $this->weather_icon( $data['today']['code'], $data['today']['is_day'] ); ?></div>
					<?php if ( 'yes' == $settings['show_weather_condition_name'] ) : ?>
						<div class="avt-weather-today-desc"><?php echo $this->weather_desc( $data['today']['code'], $data['today']['is_day'] ); ?></div>
					<?php endif; ?>
					
				</div>
			<?php endif; ?>

		</div>
		<?php if ( 'yes' === $settings['weather_details'] ) : ?>
			<div class="avt-weather-details avt-grid avt-grid-collapse">
				<div class="avt-width-1-3">
					<div class="avt-weather-today-sunrise">
						<span class="avtw-sunrise"></span>
						<?php echo esc_html($data['today']['sunrise']); ?>
					</div>
					<div class="avt-weather-today-sunset">
						<span class="avtw-sunset"></span>
						<?php echo esc_html($data['today']['sunset']); ?>
					</div>
				</div>
				<div class="avt-width-1-3">
					<div class="avt-weather-today-min-temp">
						<span class="avtw-min-tempareture"></span>
						<?php printf( '%1$s %2$s', esc_html__( 'Min:', 'avator-widget-pack' ), $this->weather_temperature( $data['today']['temp_min'] ) ); ?>
					</div>
					<div class="avt-weather-today-max-temp">
						<span class="avtw-max-tempareture"></span>
						<?php printf( '%1$s %2$s', esc_html__( 'Max:', 'avator-widget-pack' ), $this->weather_temperature( $data['today']['temp_max'] ) ); ?>
					</div>
				</div>
				<div class="avt-width-1-3">
					<div class="avt-weather-today-humidity">
						<span class="avtw-humidity"></span>
						<?php echo esc_html($data['today']['humidity']); ?>
					</div>
					<div class="avt-weather-today-pressure">
						<span class="avtw-pressure"></span>
						<?php echo $this->get_weather_pressure( $data['today']['pressure'] ); ?>
					</div>
					<div class="avt-weather-today-wind">
						<span class="avtw-<?php echo widget_pack_wind_code( $data['today']['wind_deg'] ); ?>"></span>
						<?php echo esc_html($speed) .' '. esc_html($speed_unit); ?>
					</div>
				</div>
			</div>
		<?php endif;
	}

	public function render_weather_tiny() {
		$settings = $this->get_settings_for_display();
		$data     = $this->weather_data;
		?>
		
		<?php if ( 'yes' == $settings['show_city'] ) : ?>
			<span class="avt-weather-city-name"><?php echo $this->weather_data['location']['city']; ?></span>
		<?php endif; ?>

		<?php if ( 'yes' == $settings['show_temperature'] ) : ?>
			<span class="avt-weather-today-temp"><?php echo $this->weather_temperature( $data['today']['temp'] ); ?></span>
		<?php endif; ?>

		<?php if ( 'yes' == $settings['show_weather_icon'] ) : ?>
			<span class="avt-weather-today-icon"><?php echo $this->weather_icon( $data['today']['code'], $data['today']['is_day'] ); ?></span>
		<?php endif; ?>
		<?php if ( 'yes' == $settings['show_weather_desc'] ) : ?>
			<span class="avt-weather-today-desc"><?php echo $this->weather_desc( $data['today']['code'], $data['today']['is_day'] ); ?></span>
		<?php endif; ?>

		<?php
	}

	public function render_weather_title() {
		$settings = $this->get_settings_for_display();
		$data     = $this->weather_data;
		?>
		<?php if ( 'yes' == $settings['show_city'] or 'yes' == $settings['show_country'] ) : ?>
			<div class="avt-weather-title">
				<?php if ( 'yes' == $settings['show_city'] ) : ?>
					<span class="avt-weather-city-name"><?php echo $this->weather_data['location']['city']; ?></span>
				<?php endif; ?>

				<?php if ( 'yes' == $settings['show_country'] ) : ?>
					<span class="avt-weather-country-name">
						
						<?php if ( $settings['country'] ) : ?>
							<?php echo esc_html($settings['country']); ?>
						<?php else : ?>
							<?php echo $this->weather_data['location']['country']; ?>
						<?php endif; ?>

					</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php
	}

	public function render_weather_forecast() {
		$settings = $this->get_settings_for_display();
		$data     = $this->weather_data;

		$forecast_data = $data['forecast'];

		if ( 'forecast' === $settings['view'] ) {
			array_unshift( $forecast_data, array(
				'code'     => $data['today']['code'],
				'temp_min' => $data['today']['temp_min'],
				'temp_max' => $data['today']['temp_max'],
				'week_day' => $data['today']['week_day'],
			));
		}

		$forecast_days = intval($settings['forecast']['size']);
		$forecast_days = ( $forecast_days <= 5 ) ? $forecast_days : 5;


		?>
		
		<?php if ( 'forecast' == $settings['view'] ) : ?>
			<?php $this->render_weather_title(); ?>
		<?php endif; ?>

		<ul class="avt-weather-forecast avt-list avt-wf-divider"><?php
			for ( $i = 0; $i < $forecast_days; $i ++ ) { ?>
				<li class="avt-weather-forecast-item">
					<div class="avt-grid avt-grid-collapse">
						<div class="avt-wf-day avt-width-1-4">
							<?php echo esc_html($forecast_data[ $i ]['week_day']); ?>
						</div>
						<div class="avt-wf-icon avt-width-1-4 avt-text-center" title="<?php echo esc_attr( $this->weather_desc( $forecast_data[ $i ]['code'] ) ); ?>">
							<?php echo $this->weather_icon( $forecast_data[ $i ]['code'], true ); ?>
						</div>
						<div class="avt-wf-max-temp avt-width-1-4 avt-text-center">
							<?php echo $this->weather_temperature( $forecast_data[ $i ]['temp_max'] ); ?>
						</div>
						<div class="avt-wf-min-temp avt-width-1-4 avt-text-right">
							<?php echo $this->weather_temperature( $forecast_data[ $i ]['temp_min'] ); ?>
						</div>
					</div>
				</li>
			<?php }
		?></ul>

		<?php
	}

	public function weather_data() {

		$ep_api_settings = get_option( 'widget_pack_api_settings' );
		$api_key = !empty($ep_api_settings['apixu_api_key']) ? $ep_api_settings['apixu_api_key'] : '';

		// return error message when api key not found
		if ( ! $api_key ) {
			
			$message = esc_html__( 'Ops! I think you forget to set API key in Widget Pack API settings.', 'avator-widget-pack' );

			$this->weather_error_notice($message);

			return false;
		}

		$settings = $this->get_settings_for_display();
		$location = $settings['location'];

		if ( empty( $location ) ) {
			return false;
		}

		$transient_key = sprintf( 'avt-weather-data-%s', md5( $location ) );

		$data = get_transient( $transient_key );

		if ( ! $data ) {
			// Prepare request data
			$location = esc_attr( $location );
			$api_key  = esc_attr( $api_key );

			$request_args = array(
				'key'  => urlencode( $api_key ),
				'q'    => urlencode( $location ),
				'days' => 6,
			);

			$request_url = add_query_arg(
				$request_args,
				$this->weather_api_url
			);

			$weather = $this->weather_remote_request( $request_url );

			if ( ! $weather ) {
				return false;
			}

			if ( isset( $weather['error'] ) ) {

				if ( isset( $weather['error']['message'] ) ) {
					$message = $weather['error']['message'];
				} else {
					$message = esc_html__( 'Weather data of this location not found.', 'avator-widget-pack' );
				}

				echo $this->weather_error_notice( $message );
				return false;
			}

			$data = $this->transient_weather( $weather );

			if ( empty( $data ) ) {
				return false;
			}

			set_transient( $transient_key, $data, apply_filters( 'widget-pack/weather/cached-time', HOUR_IN_SECONDS ) );
		}

		return $data;
	}

	public function weather_remote_request( $url ) {

		$response = wp_remote_get( $url, array( 'timeout' => 30 ) );

		if ( ! $response || is_wp_error( $response ) ) {
			return false;
		}

		$remote_data = wp_remote_retrieve_body( $response );

		if ( ! $remote_data || is_wp_error( $remote_data ) ) {
			return false;
		}

		$remote_data = json_decode( $remote_data, true );

		if ( empty( $remote_data ) ) {
			return false;
		}

		return $remote_data;
	}

	public function transient_weather( $weather = [] ) {

		$weather = $weather;

		$data = array(
			'location' => array(
				'city'    => $weather['location']['name'],
				'country' => $weather['location']['country'],
			),
			'today' => array(
				'code'   => $weather['current']['condition']['code'],
				'is_day' => $weather['current']['is_day'],
				'temp' => array(
					'c' => round( $weather['current']['temp_c'] ),
					'f' => round( $weather['current']['temp_f'] ),
				),
				'temp_min' => array(
					'c' => round( $weather['forecast']['forecastday'][0]['day']['mintemp_c'] ),
					'f' => round( $weather['forecast']['forecastday'][0]['day']['mintemp_f'] ),
				),
				'temp_max' => array(
					'c' => round( $weather['forecast']['forecastday'][0]['day']['maxtemp_c'] ),
					'f' => round( $weather['forecast']['forecastday'][0]['day']['maxtemp_f'] ),
				),
				'wind_speed' => array(
					'mph' => $weather['current']['wind_mph'],
					'kph' => $weather['current']['wind_kph'],
				),
				'wind_deg' => $weather['current']['wind_degree'],
				'humidity' => $weather['current']['humidity'] . '%',
				'pressure' => array(
					'mb' => $weather['current']['pressure_mb'],
					'in' => $weather['current']['pressure_in'],
				),
				'sunrise'  => $weather['forecast']['forecastday'][0]['astro']['sunrise'],
				'sunset'   => $weather['forecast']['forecastday'][0]['astro']['sunset'],
				'week_day' => date_i18n( 'l' ),
			),
			'forecast' => [],
		);

		for ( $i = 1; $i <= 5; $i ++ ) {
			$data['forecast'][] = array(
				'code'     => $weather['forecast']['forecastday'][ $i ]['day']['condition']['code'],
				'week_day' => $this->readable_week( 'Y-m-d', $weather['forecast']['forecastday'][ $i ]['date'] ),
				'temp_min' => array(
					'c' => round( $weather['forecast']['forecastday'][ $i ]['day']['mintemp_c'] ),
					'f' => round( $weather['forecast']['forecastday'][ $i ]['day']['mintemp_f'] ),
				),
				'temp_max' => array(
					'c' => round( $weather['forecast']['forecastday'][ $i ]['day']['maxtemp_c'] ),
					'f' => round( $weather['forecast']['forecastday'][ $i ]['day']['maxtemp_f'] ),
				),
			);
		}

		return $data;
	}

	public function readable_week( $format = '', $date = '' ) {
		$date = date_create_from_format( $format, $date );
		return date_i18n( 'l', date_timestamp_get( $date ) );
	}

	public function weather_desc( $code, $is_day = true ) {
		$desc = widget_pack_weather_code( $code, 'desc', $is_day );

		if ( empty( $desc ) ) { return ''; }

		return $desc;
	}

	public function weather_temperature( $temp ) {
		$units     = $this->get_settings_for_display( 'units' );
		$temp_unit = ( 'metric' === $units ) ? '&#176;C' : '&#176;F';

		if ( is_array( $temp ) ) {
			$temp = ( 'metric' === $units ) ? $temp['c'] : $temp['f'];
		}

		$temp_format = apply_filters( 'widget-pack/weather/temperature-format', '%1$s%2$s' );

		return sprintf( $temp_format, $temp, $temp_unit );
	}


	public function get_weather_pressure( $pressure ) {
		$units = $this->get_settings_for_display( 'units' );

		if ( is_array( $pressure ) ) {
			$pressure = ( 'metric' === $units ) ? $pressure['mb'] : $pressure['in'];
		}

		$format = apply_filters( 'widget-pack/weather/pressure-format', '%s' );

		return sprintf( $format, $pressure );
	}


	public function weather_icon( $icon, $is_day = true ) {

		$icon = widget_pack_weather_code( $icon, 'icon' );
		$time = ($is_day) ? 'd' : 'n';

		$icon_class   = [];
		$icon_class[] = sprintf( 'avtw-%s', esc_attr( $icon ) );

		return sprintf( '<span class="%1$s%2$s"></span>', implode(' ', $icon_class), $time );
	}

	public function weather_error_notice($message) {
		?>

		<div class="avt-alert-warning" avt-alert>
		    <a class="avt-alert-close" avt-close></a>
		    <p><?php echo esc_html($message); ?></p>
		</div>
		<?php
	}


}
