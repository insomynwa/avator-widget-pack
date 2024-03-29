<?php
namespace WidgetPack\Modules\Tablepress\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tablepress extends Widget_Base {

	public function get_name() {
		return 'avt-tablepress';
	}

	public function get_title() {
		return AWP . esc_html__( 'TablePress', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-tablepress';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'tablepress' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/TGnc0ap-cWs';
	}

	protected function tablepress_table_list() {
		$table_ids          = \TablePress::$model_table->load_all( false );
		$table_options['0'] = esc_html__( 'Select Table', 'avator-widget-pack' );

		foreach ( $table_ids as $table_id ) {
			// Load table, without table data, options, and visibility settings.
			$table = \TablePress::$model_table->load( $table_id, false, false );

			if ( '' === trim( $table['name'] ) ) {
				$table['name'] = __( '(no name)', 'tablepress' );
			}
			
			$table_options[$table['id']] = $table['name'];
		}

		return $table_options;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'table_id',
			[
				'label'   => esc_html__( 'Select Table', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $this->tablepress_table_list(),
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
					'{{WRAPPER}} .avt-tablepress .tablepress th' => 'text-align: {{VALUE}};',
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress table.tablepress tr td' => 'text-align: {{VALUE}};',
				],
			]
		);

		if (class_exists('TablePress_Responsive_Tables')) {
			$this->add_control(
				'table_responsive',
				[
					'label'   => __( 'Responsive', 'avator-widget-pack' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '0',
					'options' => [
						'0'        => __( 'None', 'avator-widget-pack' ),
						'flip'     => __( 'Flip', 'avator-widget-pack' ),
						'scroll'   => __( 'Scroll', 'avator-widget-pack' ),
						'collapse' => __( 'Collapse', 'avator-widget-pack' ),
					],
				]
			);
		}

		$this->add_control(
			'navigation_hide',
			[
				'label'     => esc_html__( 'Navigation Hide', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_length' => 'display: none;',
				],
			]
		);

		$this->add_control(
			'search_hide',
			[
				'label'     => esc_html__( 'Search Hide', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_filter' => 'display: none;',
				],
			]
		);

		$this->add_control(
			'footer_info_hide',
			[
				'label'     => esc_html__( 'Footer Info Hide', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_info' => 'display: none;',
				],
			]
		);

		$this->add_control(
			'pagination_hide',
			[
				'label'     => esc_html__( 'Pagination Hide', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_paginate' => 'display: none;',
				],
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
			'table_text_color',
			[
				'label'     => esc_html__( 'Global Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_length, {{WRAPPER}} .avt-tablepress .dataTables_filter, {{WRAPPER}} .avt-tablepress .dataTables_info, {{WRAPPER}} .avt-tablepress .paginate_button' => 'color: {{VALUE}};',
				],
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
					'{{WRAPPER}} .avt-tablepress table.tablepress' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_border_width',
			[
				'label'   => __( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress table.tablepress' => 'border-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-tablepress table.tablepress' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'table_header_tools_gap',
			[
				'label' => __( 'Pagination/Search Gap', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_length, {{WRAPPER}} .avt-tablepress .dataTables_filter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_footer_tools_gap',
			[
				'label' => __( 'Footer Text/Navigation Gap', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_info, {{WRAPPER}} .avt-tablepress .dataTables_paginate' => 'margin-top: {{SIZE}}{{UNIT}};',
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
				'default'   => '#dfe3e6',
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_active_background',
			[
				'label'     => __( 'Hover/Active Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccd3d8',
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress .sorting:hover, {{WRAPPER}} .avt-tablepress .tablepress .sorting_asc, {{WRAPPER}} .avt-tablepress .tablepress .sorting_desc' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-tablepress .tablepress th' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-tablepress .tablepress th' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_border_width',
			[
				'label'   => __( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress th' => 'border-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-tablepress .tablepress th' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-tablepress .tablepress th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-tablepress .tablepress td' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border_width',
			[
				'label'   => __( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'min'  => 0,
					'max'  => 20,
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress td' => 'border-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-tablepress .tablepress td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-tablepress .tablepress .odd td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress .odd td' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-tablepress .tablepress .odd td' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_stripe',
			[
				'label' => __( 'Stripe', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'stripe_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f7f7f7',
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress .even td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'stripe_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress .even td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'stripe_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress .even td' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'body_hover_background',
			[
				'label'     => __( 'Hover Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .tablepress .row-hover tr:hover td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_layout_style',
			[
				'label'      => esc_html__( 'Navigation/Search', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
				        [
							'name'  => 'navigation_hide',
							'value' => '',
				        ],
				        [	
							'name'  => 'search_hide',
							'value' => '',
				        ],
				    ],
				],
			]
		);

		$this->add_control(
			'search_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_filter input, {{WRAPPER}} .avt-tablepress .dataTables_length select' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tablepress .dataTables_filter input, {{WRAPPER}} .avt-tablepress .dataTables_length select' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-tablepress .dataTables_filter input, {{WRAPPER}} .avt-tablepress .dataTables_length select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'search_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-tablepress .dataTables_filter input, {{WRAPPER}} .avt-tablepress .dataTables_length select',
			]
		);

		$this->add_responsive_control(
			'search_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-tablepress .dataTables_filter input, {{WRAPPER}} .avt-tablepress .dataTables_length select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'search_box_shadow',
				'selector' => '{{WRAPPER}} .avt-tablepress .dataTables_filter input, {{WRAPPER}} .avt-tablepress .dataTables_length select',
			]
		);

		$this->end_controls_section();
	}


	private function get_shortcode() {
		$settings = $this->get_settings();

		if (!$settings['table_id']) {
			return '<div class="avt-alert avt-alert-warning">'.__('Please select a table from setting!', 'avator-widget-pack').'</div>';
		}
		
		if ( Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			// Load the frontend controller
			\TablePress::load_controller( 'frontend' );
			// class methods aren't static so we need an instance to call them
			$controller = new \TablePress_Frontend_Controller();
			// Register the shortcode
			$controller->init_shortcodes();

		}

		$attributes = [
			'id'         => $settings['table_id'],
			'responsive' => (class_exists('TablePress_Responsive_Tables')) ? $settings['table_responsive'] : '',
		];

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = ['<div class="avt-tablepress">'];
		$shortcode[] = sprintf( '[table %s]', $this->get_render_attribute_string( 'shortcode' ) );
		$shortcode[] = '</div>';

		$output = implode("", $shortcode);

		return $output;
	}

	public function render() {
		$settings = $this->get_settings();
		echo do_shortcode( $this->get_shortcode() );

		if ( Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			?>
			<script type="text/javascript" src="<?php echo plugins_url(); ?>/tablepress/js/jquery.datatables.min.js"></script>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('#tablepress-<?php echo esc_attr($settings['table_id']); ?>').dataTable({"order":[],"orderClasses":false,"stripeClasses":["even","odd"],"pagingType":"simple"});
				});
			</script>
			<?php
		}
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
