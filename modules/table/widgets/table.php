<?php
namespace WidgetPack\Modules\Table\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Table extends Widget_Base {
	public function get_name() {
		return 'avt-table';
	}

	public function get_title() {
		return AWP . __( 'Table', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-table';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'table', 'row', 'column' ];
	}

	public function get_script_depends() {
		return [ 'datatables' ];
	}

	public function get_style_depends() {
		return [ 'datatables' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_table',
			[
				'label' => __( 'Table', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => __( 'Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'   => __( 'Custom', 'avator-widget-pack' ),
					'csv_file' => __( 'CSV File', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => __( 'Content', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __( '<table><thead><tr><th>Name</th><th>Age</th><th>Phone</th></tr></thead><tbody><tr><td>Tom</td><td>5</td><td>010281065</td></tr><tr><td>Jerry</td><td>4</td><td>012540515</td></tr><tr><td>Halum</td><td>12</td><td>011511441</td></tr></tbody></table>', 'avator-widget-pack' ),
				'placeholder' => __( 'Table Data', 'avator-widget-pack' ),
				'rows'        => 10,
				'condition'   => [
					'source' => 'custom',
				],
			]
		);

		$this->add_control(
			'file',
			[
				'label'         => __( 'Enter a CSV File URL', 'avator-widget-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'label_block'   => true,
				'default'       => [
					'url' => AWP_ASSETS_URL . 'others/table.csv',
				],
				'condition'     => [
					'source' => 'csv_file',
				],
			]
		);

		$this->add_control(
			'header_align',
			[
				'label'   => __( 'Header Alignment', 'avator-widget-pack' ),
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
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .avt-table th' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'body_align',
			[
				'label'   => __( 'Body Alignment', 'avator-widget-pack' ),
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .avt-table table' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'use_data_table',
			[
				'label'   => esc_html__( 'Datatable', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'table_responsive_control',
			[
				'label'   => __( 'Responsive', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'table_responsive_2',
				'options' => [
					'table_responsive_no'     => esc_html__('No Responsive', 'avator-widget-pack'),
					'table_responsive_1' 	  => esc_html__('Responsive 1', 'avator-widget-pack'),
					'table_responsive_2' 	  => esc_html__('Responsive 2', 'avator-widget-pack'),
				],
				'separator' => 'before',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_data_table',
			[
				'label'     => __( 'Data Table Settings', 'avator-widget-pack' ),
				'condition' => [
					'use_data_table' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_searching',
			[
				'label'   => esc_html__( 'Search', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_ordering',
			[
				'label'   => esc_html__( 'Ordering', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'   => esc_html__( 'Pagination', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_info',
			[
				'label'   => esc_html__( 'Info', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_table',
			[
				'label' => __( 'Table', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'stripe_style',
			[
				'label' => __( 'Stripe Style', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'table_border_style',
			[
				'label'   => __( 'Border Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'avator-widget-pack' ),
					'solid'  => __( 'Solid', 'avator-widget-pack' ),
					'double' => __( 'Double', 'avator-widget-pack' ),
					'dotted' => __( 'Dotted', 'avator-widget-pack' ),
					'dashed' => __( 'Dashed', 'avator-widget-pack' ),
					'groove' => __( 'Groove', 'avator-widget-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table table' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_border_width',
			[
				'label'   => __( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 4,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table table' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .avt-table table' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_header',
			[
				'label' => __( 'Header', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'header_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7ebef',
				'selectors' => [
					'{{WRAPPER}} .avt-table th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333',
				'selectors' => [
					'{{WRAPPER}} .avt-table th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_border_style',
			[
				'label'   => __( 'Border Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'avator-widget-pack' ),
					'solid'  => __( 'Solid', 'avator-widget-pack' ),
					'double' => __( 'Double', 'avator-widget-pack' ),
					'dotted' => __( 'Dotted', 'avator-widget-pack' ),
					'dashed' => __( 'Dashed', 'avator-widget-pack' ),
					'groove' => __( 'Groove', 'avator-widget-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table th' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_border_width',
			[
				'label'   => __( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table th' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'header_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .avt-table th' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 1,
					'bottom' => 1,
					'left'   => 1,
					'right'  => 1,
					'unit'   => 'em'
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_body',
			[
				'label' => __( 'Body', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cell_border_style',
			[
				'label'   => __( 'Border Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'avator-widget-pack' ),
					'solid'  => __( 'Solid', 'avator-widget-pack' ),
					'double' => __( 'Double', 'avator-widget-pack' ),
					'dotted' => __( 'Dotted', 'avator-widget-pack' ),
					'dashed' => __( 'Dashed', 'avator-widget-pack' ),
					'groove' => __( 'Groove', 'avator-widget-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table td' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border_width',
			[
				'label'   => __( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table td' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cell_padding',
			[
				'label'      => __( 'Cell Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 0.5,
					'bottom' => 0.5,
					'left'   => 1,
					'right'  => 1,
					'unit'   => 'em'
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs('tabs_body_style');

		$this->start_controls_tab(
			'tab_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'normal_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .avt-table td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .avt-table td' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'row_hover_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-avt-table .avt-table table tr:hover td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'row_hover_text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-avt-table .avt-table table tr:hover td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_stripe',
			[
				'label'     => __( 'Stripe', 'avator-widget-pack' ),
				'condition' => [
					'stripe_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'stripe_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table .even td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'stripe_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table .even td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_filter_style',
			[
				'label'      => esc_html__( 'Filter', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('filter_style');
		
		$this->start_controls_tab(
			'filter_header_style',
			[
				'label'     => __( 'Header', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'datatable_header_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table .dataTables_length label, {{WRAPPER}} .avt-table .dataTables_filter label' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);


		$this->add_control(
			'datatable_header_input_color',
			[
				'label'     => esc_html__( 'Input Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table .dataTables_filter input, {{WRAPPER}} .avt-table .dataTables_length select' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'datatable_header_input_background',
			[
				'label'     => esc_html__( 'Input Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table .dataTables_filter input, {{WRAPPER}} .avt-table .dataTables_length select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'datatable_header_input_padding',
			[
				'label'      => esc_html__( 'Input Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-table .dataTables_filter input, {{WRAPPER}} .avt-table .dataTables_length select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'datatable_header_input_border',
				'label'       => esc_html__( 'Input Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-table .dataTables_filter input, {{WRAPPER}} .avt-table .dataTables_length select',
			]
		);

		$this->add_responsive_control(
			'datatable_header_input_radius',
			[
				'label'      => esc_html__( 'Input Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-table .dataTables_filter input, {{WRAPPER}} .avt-table .dataTables_length select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'datatable_header_input_box_shadow',
				'selector' => '{{WRAPPER}} .avt-table .dataTables_filter input, {{WRAPPER}} .avt-table .dataTables_length select',
			]
		);

		$this->add_control(
			'datatable_header_space',
			[
				'label'   => __( 'Space', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 40,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table .dataTables_filter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'filter_footer_style',
			[
				'label'     => __( 'Footer', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'datatable_footer_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table .dataTables_info, {{WRAPPER}} .avt-table .dataTables_paginate' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'datatable_footer_pagination_color',
			[
				'label'     => esc_html__( 'Pagination Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table .dataTables_paginate a' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'datatable_footer_pagination_active_color',
			[
				'label'     => esc_html__( 'Pagination Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-table .dataTables_paginate a.current' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'datatable_footer_space',
			[
				'label'   => __( 'Space', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 40,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-table table' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		$id       = 'avt-table-' . $this->get_id();

		if ( empty($settings['content']) or empty($settings['file']['url']) ) {
					
			widget_pack_alert( esc_html__('Opps!! You didn\'t enter any table data or CSV file', 'avator-widget-pack') );	

		}

		if ('table_responsive_no' == $settings['table_responsive_control']) {
			$this->add_render_attribute('table-wrapper', 'class', ['avt-table']);
		}

		if ('table_responsive_1' == $settings['table_responsive_control']) {
			$this->add_render_attribute('table-wrapper', 'class', ['avt-table', 'avt-table-responsive']);
		}
		
		if ('table_responsive_2' == $settings['table_responsive_control']) {
			$this->add_render_attribute('table-wrapper', 'class', ['avt-table', 'avt-table-default-responsive']);
		}
		
		$this->add_render_attribute( 'table-wrapper', 'class', $settings['stripe_style'] ? 'avt-stripe' : '' );
		$this->add_render_attribute( 'table-wrapper', 'id', $id );

		if ( 'yes' == $settings['use_data_table'] ) :
			
			$this->add_render_attribute( 'table-wrapper', 'class', 'avt-data-table' );

			$this->add_render_attribute(
				[
					'table-wrapper' => [
						'data-settings' => [
							wp_json_encode([
								'paging'    => ( 'yes' == $settings['show_pagination'] ) ? true : false,
					    		'info'      => ( 'yes' == $settings['show_info'] ) ? true : false,
					    		'searching' => ( 'yes' == $settings['show_searching'] ) ? true : false,
					    		'ordering'  => ( 'yes' == $settings['show_ordering'] ) ? true : false,
					        ])
						]
					]
				]
			);
		
		endif;

		?>
		<div <?php echo $this->get_render_attribute_string( 'table-wrapper' ); ?>>

			
			<?php 

				if ( 'custom' == $settings['source'] ) {
				
					echo do_shortcode($settings['content']);

				} elseif ( 'csv_file' == $settings['source'] and !empty($settings['file']['url']) ) {
					echo widget_pack_parse_csv(esc_url($settings['file']['url']));
				}

			?>
				
			
		</div>
		<?php
	}
}
