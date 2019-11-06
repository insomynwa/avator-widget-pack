<?php
namespace WidgetPack\Modules\Chart\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use WidgetPack\Modules\Chart\Module;
use ParseCsv\Csv;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require AWP_INC_PATH . 'parsecsv/parsecsv.lib.php';

class Chart extends Widget_Base {

	public function get_name() {
		return 'avt-chart';
	}

	public function get_title() {
		return AWP . __( 'Chart', 'avator-widget-pack' );
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'chart', 'statistics', 'history' ];
	}

	public function get_icon() {
		return 'avt-wi-chart';
	}

	public function get_script_depends() {
		return [ 'chart', 'wipa-chart' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/-1WVTzTyti0';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_chart',
			[
				'label' => __( 'Chart', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'type',
			[
				'label'   => __( 'Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bar',
				'options' => [
					'bar'           => __( 'Bar (Vertical)', 'avator-widget-pack' ),
					'horizontalBar' => __( 'Bar (Horozontal)', 'avator-widget-pack' ),
					'line'          => __( 'Line', 'avator-widget-pack' ),
					'radar'         => __( 'Radar', 'avator-widget-pack' ),
					'doughnut'      => __( 'Doughnut', 'avator-widget-pack' ),
					'pie'           => __( 'Pie', 'avator-widget-pack' ),
					'polarArea'     => __( 'Polar Area', 'avator-widget-pack' ),
					'bubble'        => __( 'Bubble', 'avator-widget-pack' ),
				],
			]
		);

		// $this->add_control(
		// 	'data_source',
		// 	[
		// 		'label'   => __( 'Data Source', 'avator-widget-pack' ),
		// 		'type'    => Controls_Manager::SELECT,
		// 		'default' => 'custom',
		// 		'options' => [
		// 			'custom' => __( 'Custom', 'avator-widget-pack' ),
		// 			'csv'      => __( 'CSV File', 'avator-widget-pack' ),
		// 		],
		// 	]
		// );

		$this->add_control(
			'labels',
			[
				'label'       => __( 'Label Values', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'January; February; March; April; May', 'avator-widget-pack' ),
				'description' => __( 'Write multiple label by semicolon separated(;). Example: January; February; March etc', 'avator-widget-pack' ),
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_datasets',
			[
				'label'     => __( 'Datasets', 'avator-widget-pack' ),
				'condition' => [
					'type!' => [ 'bubble', 'pie', 'doughnut', 'polarArea' ]
				]
			]
		);

		$this->add_control(
			'datasets',
			[
				'label'   => __( 'Datasets', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'label'     => __( 'Dataset Label #1', 'avator-widget-pack' ),
						'data'      => __( '2; 4; 8; 16; 32', 'avator-widget-pack' ),
						'bg_color'  => 'rgba(255, 99, 132, 0.2)',
						'bg_colors' => 'rgba(255, 99, 132, 0.2); rgba(54, 162, 235, 0.2); rgba(255, 206, 86, 0.2); rgba(75, 192, 192, 0.2); rgba(153, 102, 255, 0.2)',
					],
					[
						'label'     => __( 'Dataset Label #2', 'avator-widget-pack' ),
						'data'      => __( '8; 25; 6; 8; 10', 'avator-widget-pack' ),
						'bg_color'  => 'rgba(54, 162, 235, 0.2)',
						'bg_colors' => 'rgba(153, 102, 255, 0.2); rgba(75, 192, 192, 0.2); rgba(255, 206, 86, 0.2); rgba(54, 162, 235, 0.2); rgba(255, 99, 132, 0.2)',
					],
					[
						'label'     => __( 'Dataset Label #3', 'avator-widget-pack' ),
						'data'      => __( '9; 4; 30; 8; 32', 'avator-widget-pack' ),
						'bg_color'  => 'rgba(75, 192, 192, 0.2)',
						'bg_colors' => 'rgba(255, 99, 132, 0.2); rgba(54, 162, 235, 0.2); rgba(255, 206, 86, 0.2); rgba(75, 192, 192, 0.2); rgba(153, 102, 255, 0.2)',
					],
					[
						'label'     => __( 'Dataset Label #4', 'avator-widget-pack' ),
						'data'      => __( '10; 15; 16; 28; 15', 'avator-widget-pack' ),
						'bg_color'  => 'rgba(255, 206, 86, 0.2)',
						'bg_colors' => 'rgba(153, 102, 255, 0.2); rgba(75, 192, 192, 0.2); rgba(255, 206, 86, 0.2); rgba(54, 162, 235, 0.2); rgba(255, 99, 132, 0.2)',
					],
					[
						'label'     => __( 'Dataset Label #5', 'avator-widget-pack' ),
						'data'      => __( '32; 15; 8; 4; 2', 'avator-widget-pack' ),
						'bg_color'  => 'rgba(153, 102, 255, 0.2)',
						'bg_colors' => 'rgba(255, 99, 132, 0.2); rgba(54, 162, 235, 0.2); rgba(255, 206, 86, 0.2); rgba(75, 192, 192, 0.2); rgba(153, 102, 255, 0.2)',
					],
				],
				'fields' => [
					[
						'name'        => 'label',
						'label'       => __( 'Label', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => __( 'Dataset Label', 'avator-widget-pack' ),
						'label_block' => true,
					],
					[
						'name'        => 'data',
						'label'       => __( 'Data', 'avator-widget-pack' ),
						'label_block' => true,
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => __( '2; 4; 8; 16; 32', 'avator-widget-pack' ),
						'description' => __( 'Enter data values by semicolon separated(;). Example: 2; 4; 8; 16; 32 etc', 'avator-widget-pack' ),
					],
					[
						'name'    => 'advanced_bg_color',
						'label'   => __( 'Advanced Background Color', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SWITCHER,
						'default' => 'no'
					],
					[
						'name'        => 'bg_color',
						'label'       => __( 'Background Color', 'avator-widget-pack' ),
						'label_block' => true,
						'default'     => 'rgba(255, 99, 132, 0.2)',
						'type'        => Controls_Manager::COLOR,
						'condition'   => [
							'advanced_bg_color!' => 'yes'
						]
					],
					[
						'name'        => 'bg_colors',
						'type'        => Controls_Manager::TEXT,
						'label'       => __( 'Background Colors', 'avator-widget-pack' ),
						'label_block' => true,
						'description' => __( 'Write multiple color values by semicolon separated(;). Example: #dddddd; #ff8844; #232323 etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'avator-widget-pack' ),
						'condition'   => [
							'advanced_bg_color' => 'yes'
						]
					],
					[
						'name'      => 'advanced_border_color',
						'label'     => __( 'Advanced Color', 'avator-widget-pack' ),
						'separator' => 'before',
						'type'      => Controls_Manager::SWITCHER,
						'default'   => 'no'
					],
					[
						'name'        => 'border_color',
						'label'       => __( 'Border Color', 'avator-widget-pack' ),
						'label_block' => true,
						'type'        => Controls_Manager::COLOR,
						'condition'   => [
							'advanced_border_color!' => 'yes'
						]
					],
					[
						'name'        => 'border_colors',
						'type'        => Controls_Manager::TEXT,
						'label'       => __( 'Border Colors', 'avator-widget-pack' ),
						'label_block' => true,
						'description' => __( 'Write multiple color values by semicolon separated(;). Example: #dddddd; #ff8844; #232323 etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'avator-widget-pack' ),
						'condition'   => [
							'advanced_border_color' => 'yes'
						]
					],
				],
				'title_field' => '{{{ label }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_single_datasets',
			[
				'label'     => __( 'Datasets', 'avator-widget-pack' ),
				'condition' => [
					'type' => ['polarArea', 'pie', 'doughnut']
				]
			]
		);

		$this->add_control(
			'single_label',
			[
				'label'       => __( 'Label', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'Polar Dataset Label', 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'single_datasets',
			[
				'label'       => __( 'Data', 'avator-widget-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
				'type'        => Controls_Manager::TEXT,
				'default'     => '10; 20; 30; 40; 50',
				'description' => __( 'Enter data values by semicolon separated(;). Example: 10; 20; 30; 40; 50 etc', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'single_bg_colors',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Background Colors', 'avator-widget-pack' ),
				'label_block' => true,
				'default'     => 'rgba(255, 99, 132, 0.2); rgba(54, 162, 235, 0.2); rgba(255, 206, 86, 0.2); rgba(75, 192, 192, 0.2); rgba(153, 102, 255, 0.2)',
				'description' => __( 'Write multiple color values by semicolon separated(;). Example: #dddddd; #ff8844; #232323 etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'single_border_colors',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Border Colors', 'avator-widget-pack' ),
				'label_block' => true,
				'description' => __( 'Write multiple color values by semicolon separated(;). Example: #dddddd; #ff8844; #232323 etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'avator-widget-pack' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_bubble_datasets',
			[
				'label'     => __( 'Datasets', 'avator-widget-pack' ),
				'condition' => [
					'type' => 'bubble'
				]
			]
		);


		$this->add_control(
			'bubble_datasets',
			[
				'label'   => __( 'Bubble Datasets', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'label'     => __( 'Bubble Dataset Label #1', 'avator-widget-pack' ),
						'data'      => __( '[20;30;15][40;10;10]', 'avator-widget-pack' ),
						'bg_color'  => 'rgba(255, 99, 132, 0.2)',
						'bg_colors' => 'rgba(255, 99, 132, 0.2); rgba(54, 162, 235, 0.2); rgba(255, 206, 86, 0.2);',
					],
					[
						'label'     => __( 'Bubble Dataset Label #2', 'avator-widget-pack' ),
						'data'      => __( '[15;25;5][50;60;8]', 'avator-widget-pack' ),
						'bg_color'  => 'rgba(54, 162, 235, 0.2)',
						'bg_colors' => 'rgba(153, 102, 255, 0.2); rgba(75, 192, 192, 0.2); rgba(255, 206, 86, 0.2);',
					],
					[
						'label'     => __( 'Bubble Dataset Label #3', 'avator-widget-pack' ),
						'data'      => __( '[60;5;20][100;50;15]', 'avator-widget-pack' ),
						'bg_color'  => 'rgba(75, 192, 192, 0.2)',
						'bg_colors' => 'rgba(255, 99, 132, 0.2); rgba(54, 162, 235, 0.2); rgba(255, 206, 86, 0.2);',
					],
				],
				'fields' => [
					[
						'name'        => 'label',
						'label'       => __( 'Label', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => __( 'Bubble Dataset Label', 'avator-widget-pack' ),
						'label_block' => true,
					],
					[
						'name'        => 'data',
						'label'       => __( 'Data', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => __( '[20;30;15][40;10;10]', 'avator-widget-pack' ),
						'label_block' => true,
					],
					[
						'name'    => 'advanced_bg_color',
						'label'   => __( 'Advanced Background Color', 'avator-widget-pack' ),
						'default' => 'no',
						'type'    => Controls_Manager::SWITCHER,
					],
					[
						'name'        => 'bg_color',
						'label'       => __( 'Background Color', 'avator-widget-pack' ),
						'label_block' => true,
						'default'     => 'rgba(255, 99, 132, 0.2)',
						'type'        => Controls_Manager::COLOR,
						'condition'   => [
							'advanced_bg_color!' => 'yes'
						]
					],
					[
						'name'        => 'bg_colors',
						'type'        => Controls_Manager::TEXT,
						'label'       => __( 'Background Colors', 'avator-widget-pack' ),
						'label_block' => true,
						'description' => __( 'Write multiple color values by semicolon separated(,). Example: #dddddd, #ff8844, #232323 etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'avator-widget-pack' ),
						'condition'   => [
							'advanced_bg_color' => 'yes'
						]
					],
					[
						'name'      => 'advanced_border_color',
						'label'     => __( 'Advanced Border Color', 'avator-widget-pack' ),
						'separator' => 'before',
						'type'      => Controls_Manager::SWITCHER,
						'default'   => 'no'
					],
					[
						'name'        => 'border_color',
						'label'       => __( 'Border Color', 'avator-widget-pack' ),
						'label_block' => true,
						'type'        => Controls_Manager::COLOR,
						'condition'   => [
							'advanced_border_color!' => 'yes'
						]
					],
					[
						'name'        => 'border_colors',
						'type'        => Controls_Manager::TEXT,
						'label'       => __( 'Border Colors', 'avator-widget-pack' ),
						'label_block' => true,
						'description' => __( 'Write multiple color values by semicolon separated(;). Example: #dddddd; #ff8844; #232323 etc<br><strong>N.B: it will not work for line, radar charts</strong>', 'avator-widget-pack' ),
						'condition'   => [
							'advanced_border_color' => 'yes'
						]
					],
				],
				'title_field' => '{{{ label }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label'     => __( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_grid_lines',
			[
				'label'   => __( 'Grid Lines', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label'   => esc_html__( 'Labels', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_legend',
			[
				'label'   => esc_html__( 'Legends', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'legend_align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-long-arrow-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'avator-widget-pack' ),
						'icon'  => 'fas fa-long-arrow-up',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'avator-widget-pack' ),
						'icon'  => 'fas fa-long-arrow-down',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-long-arrow-right',
					],
				],
				'condition' => [
					'show_legend' => 'yes',
				]
			]
		);

		$this->add_control(
			'show_tooltip',
			[
				'label'   => esc_html__( 'Tooltip', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		

		$this->add_control(
			'aspect_ratio',
			[
				'label'   => esc_html__( 'Squire Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'maintain_aspect_ratio',
			[
				'label'   => esc_html__( 'Maintain Aspect Ratio', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_chart',
			[
				'label' => esc_html__( 'Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'border_width',
			[
				'label'   => esc_html__( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1
				],
			]
		);

		$this->add_control(
			'grid_color',
			[
				'label'   => esc_html__( 'Grid Color', 'avator-widget-pack' ),
				'type'    => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.05)',
			]
		);

		$this->add_control(
			'tooltip_background',
			[
				'label'   => esc_html__( 'Tooltip Background Color', 'avator-widget-pack' ),
				'type'    => Controls_Manager::COLOR,
				'separator' => 'after',
			]
		);

		$this->end_controls_section();

	}

	public function bubble_values( $cdata ) {
		$cdata = trim( $cdata );
		$splitData = preg_match_all( '#\[([^\]]+)\]#U', $cdata, $matches );
		if ( !$splitData ) {
			return []; // if not get any data
		} else {
			$values = $matches[1];
			$output = [];
			foreach ( $values as $value ) {
				$value = trim( $value, '][ ' );
				$value = explode( ';', $value );
				
				if ( 3 != count( $value ) ) continue; // if not valid bubble data
				
				$point    = new \stdClass();
				$point->x = floatval( trim( $value[0] ) );
				$point->y = floatval( trim( $value[1] ) );
				$point->r = floatval( trim( $value[2] ) );
				$output[] = $point;
			}
			return $output;
		}
	}

	protected function render() {
		$settings       = $this->get_settings_for_display();
		$id             = 'avt-chart-' . $this->get_id();
		$datasets       = [];
		$all_datasets   = [];
		$chart_datasets = [];
		$options        = [];

		$settings['data_source'] = false;

		if ('csv' == $settings['data_source']) { // TODO
			
			// $csv = new Csv();

			// $csv->auto(AWP_ASSETS_PATH . 'others/_books.csv');

			// print_r($csv->titles);

			// print_r($csv->data);



		} else {
			if ( 'pie' == $settings['type'] or 'doughnut' == $settings['type'] or 'polarArea' == $settings['type'] ) {

				$single_data    = array_map('floatval', explode(';', $settings['single_datasets']));
				$all_datasets[] = [ 'data' => $single_data, 'backgroundColor' => explode('; ', $settings['single_bg_colors']) ];

				if ( $settings['single_border_colors'] ) {
					$all_datasets[] = [ 'borderColor' => $settings['single_border_colors'] ];
				}

			} else {

				$chart_datasets = ( 'bubble' == $settings['type'] ) ?  $settings['bubble_datasets'] : $settings['datasets'];

				foreach ( $chart_datasets as $dataset ) {

					$datasets['label'] = $dataset['label'];

					if ('bubble' == $settings['type']) {
						$datasets['data'] = $this->bubble_values($dataset['data']);
					} else {
						$datasets['data']  =  array_map('floatval', explode(';', $dataset['data']));				
					}

					if ( 'yes' == $dataset['advanced_bg_color'] and '' != $dataset['bg_colors'] ) {
						$datasets['backgroundColor'] = explode('; ', $dataset['bg_colors']);
					} else {
						$datasets['backgroundColor'] = $dataset['bg_color'];
					}

					if ( 'yes' == $dataset['advanced_border_color'] and '' != $dataset['border_colors'] ) {
						$datasets['borderColor'] = explode(';', $dataset['border_colors']);
					} else {
						$datasets['borderColor'] = $dataset['border_color'];
					}
					
					$all_datasets[] = $datasets;
				}
			}
			
			if ($settings['show_tooltip']) {
				if ($settings['tooltip_background']) {
					$options['tooltips'] = [ 
						'backgroundColor' => $settings['tooltip_background'],
					];
				}
			} else {
				$options['tooltips'] = [ 'enabled' => false ];
			}

			if ($settings['show_legend']) {
				if ($settings['legend_align']) {
					$options['legend'] = [ 'position' => $settings['legend_align'] ];
				}
			} else {
				$options['legend'] = [ 'display' => false ];
			}

			if ( 'pie' == $settings['type'] ) {
				$options['cutoutPercentage'] = 0;
			} else if ( 'doughnut' == $settings['type'] ) {
				$options['cutoutPercentage'] = 50;
			} else {
				if ($settings['show_grid_lines']) {
					$options['scales'] = [
						'yAxes' => [[
							'ticks' => [
								'display' => ( $settings['show_labels'] ) ? true : false,
							],
							'gridLines' => [
								'drawBorder' => false,
								'color'      => $settings['grid_color'],
							]
						]],
						'xAxes' => [[
							'ticks' => [
								'display' => ( $settings['show_labels'] ) ? true : false,
							],
							'gridLines' => [
								'drawBorder' => false,
								'color'      => $settings['grid_color'],
							]
						]]
					];
				} else {
					$options['scales'] = [
						'yAxes' => [[
							'ticks' => [
								'display' => ( $settings['show_labels'] ) ? true : false,
							],
							'gridLines' => [
								'display'    => false,
							]
						]],
						'xAxes' => [[
							'ticks' => [
								'display' => ( $settings['show_labels'] ) ? true : false,
							],
							'gridLines' => [
								'display'    => false,
							]
						]]
					];
				}
			}
		}


		if ($settings['aspect_ratio']) {
			$options['aspectRatio'] = 1;
		}

		if (!$settings['maintain_aspect_ratio']) {
			$options['maintainAspectRatio'] = false;
		}

		$this->add_render_attribute(
			[
				'chart' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"type"        => $settings["type"],
							"borderWidth" => $settings["border_width"]["size"],
							"data"        => [
								"labels" => explode(";", $settings["labels"]),
								"datasets" => $all_datasets,
							],
							"options" => $options,
							//"aspectRatio" => 1,
						]))							
					]
				]
			]
		);

		
		?>
		<div class="avt-chart" <?php echo $this->get_render_attribute_string( 'chart' ); ?>>
			<canvas id="<?php echo esc_attr( $id ); ?>"></canvas>
		</div>		
		<?php
	}
}
