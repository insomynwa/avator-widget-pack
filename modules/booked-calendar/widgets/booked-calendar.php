<?php
namespace WidgetPack\Modules\BookedCalendar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BookedCalendar extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'avt-booked';
	}

	public function get_title() {
		return AWP . __( 'Booked Calendar', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-booked-calendar';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}
    
    public function get_keywords() {
		return [ 'booked', 'calendar', 'appointment', 'schedule' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'calendar_style',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''     => esc_html__('Default', 'avator-widget-pack') ,
					'list' => esc_html__('List', 'avator-widget-pack') ,
				],
			]
		);

		$this->add_control(
			'calendar_day',
			[
				'label'   => esc_html__( 'Day', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => date('d'),
				'options' => [
					'01'     => '01',
					'02'     => '02',
					'03'     => '03',
					'05'     => '05',
					'06'     => '06',
					'07'     => '07',
					'08'     => '08',
					'09'     => '09',
					'10'     => '10',
					'11'     => '11',
					'12'     => '12',
					'13'     => '13',
					'14'     => '14',
					'15'     => '15',
					'16'     => '16',
					'17'     => '17',
					'18'     => '18',
					'19'     => '19',
					'20'     => '20',
					'21'     => '21',
					'22'     => '22',
					'23'     => '23',
					'24'     => '24',
					'25'     => '25',
					'26'     => '26',
					'27'     => '27',
					'28'     => '28',
					'29'     => '29',
					'30'     => '30',
				],
			]
		);

		$this->add_control(
			'calendar_month',
			[
				'label'   => esc_html__( 'Month', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => date('m'),
				'options' => [
					'01' => esc_html__('January', 'avator-widget-pack'),
					'02' => esc_html__('February', 'avator-widget-pack'),
					'03' => esc_html__('March', 'avator-widget-pack'),
					'04' => esc_html__('April', 'avator-widget-pack'),
					'05' => esc_html__('May', 'avator-widget-pack'),
					'06' => esc_html__('June', 'avator-widget-pack'),
					'07' => esc_html__('July', 'avator-widget-pack'),
					'08' => esc_html__('August', 'avator-widget-pack'),
					'09' => esc_html__('September', 'avator-widget-pack'),
					'10' => esc_html__('October', 'avator-widget-pack'),
					'11' => esc_html__('November', 'avator-widget-pack'),
					'12' => esc_html__('December', 'avator-widget-pack'),
				],
			]
		);

		$this->add_control(
			'calendar_year',
			[
				'label'   => esc_html__( 'Year', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => date('Y'),
				'options' => [
					'2018'     => '2018',
					'2019'     => '2019',
					'2020'     => '2020',
					'2021'     => '2021',
					'2022'     => '2022',
					'2023'     => '2023',
					'2024'     => '2024',
					'2025'     => '2025',
					'2026'     => '2026',
					'2027'     => '2027',
					'2028'     => '2028',
					'2029'     => '2029',
					'2030'     => '2030',
				],
			]
		);

		$this->add_control(
			'calendar_size',
			[
				'label'   => esc_html__( 'Calendar Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''      => esc_html__('Default', 'avator-widget-pack') ,
					'small' => esc_html__('Small', 'avator-widget-pack') ,
				],
			]
		);

		$this->add_control(
			'calendar_members_only',
			[
				'label' => esc_html__( 'Members Only', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_header',
			[
				'label'     => __( 'Header', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'calendar_style!' => 'list',
				],
			]
		);

		$this->add_control(
			'header_background',
			[
				'label'     => __( 'Header Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar thead th' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar tr.days'  => 'background-color: transparent !important',
					'{{WRAPPER}} table.booked-calendar thead'    => 'background-color: transparent !important',
				],
			]
		);

		$this->add_control(
			'header_color',
			[
				'label'     => __( 'Header Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar thead th' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Border Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar thead th'                    => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar tr.days th'                  => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar td:first-child'              => 'border-left-color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar td'                          => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar'                             => 'border-bottom-color: {{VALUE}} !important;',
					'{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot' => 'border-color: {{VALUE}} ;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_date',
			[
				'label'     => __( 'Date', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'calendar_style!' => 'list',
				],
			]
		);

		$this->add_control(
			'date_background',
			[
				'label'     => __( 'Date Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td .date' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => __( 'Date Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'date_hover_background',
			[
				'label'     => __( 'Date Hover Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td:hover .date span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'date_hover_color',
			[
				'label'     => __( 'Date Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td:hover .date span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'current_date_color',
			[
				'label'     => __( 'Current Date Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td.today .date span' => 'color: {{VALUE}} !important;',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'current_date_border_color',
			[
				'label'     => __( 'Current Date Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td.today .date span' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'current_date_hover_background',
			[
				'label'     => __( 'Current Date Hover Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td.today:hover .date span' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'current_date_hover_color',
			[
				'label'     => __( 'Current Date Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td.today:hover .date span' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'prev_next_date_background',
			[
				'label'     => __( 'Prev Date/Next Month Date Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td.prev-month .date'           => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar td.next-month .date'           => 'background-color: {{VALUE}};',
					'{{WRAPPER}} table.booked-calendar td.prev-date:hover .date'      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} table.booked-calendar td.prev-date .date'            => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar td.prev-date:hover .date span' => 'background-color: {{VALUE}} !important;',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'prev_next_date_color',
			[
				'label'     => __( 'Prev/Next Date Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar td.prev-date .date'            => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar td.prev-month .date span'      => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar td.next-month .date span'      => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} table.booked-calendar td.prev-date:hover .date span' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_apointments',
			[
				'label'     => __( 'Appointments', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'calendar_style!' => 'list',
				],
			]
		);

		$this->add_control(
			'background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar .booked-appt-list'                 => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot:hover' => 'background-color: rgba(255, 255, 255, 0.3);',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .booked-calendar-wrap .booked-appt-list h2'                                     => 'color: {{VALUE}};',
					'{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot .timeslot-time'               => 'color: {{VALUE}};',
					'{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot .timeslot-time i.booked-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'active_date_background_color',
			[
				'label'     => __( 'Active Date Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.booked-calendar tr.week td.active .date'                      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} table.booked-calendar tr.week td.active:hover .date'                => 'background-color: {{VALUE}};',
					'{{WRAPPER}} table.booked-calendar tr.entryBlock'                                => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot .spots-available' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_heading',
			[
				'label'     => __( 'Heading', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'calendar_style' => 'list',
				],
			]
		);

		$this->add_control(
			'list_heading_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .booked-appt-list > h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .booked-appt-list > h2',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_time',
			[
				'label'     => __( 'Time', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'calendar_style' => 'list',
				],
			]
		);

		$this->add_control(
			'list_time_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeslot-range' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_time_icon_color',
			[
				'label'     => __( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeslot-range .booked-icon.booked-icon-clock' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .spots-available' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_time_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .timeslot-range',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation_button',
			[
				'label'     => __( 'Navigation Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'calendar_style' => 'list',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_navigation_button_style' );

		$this->start_controls_tab(
			'tab_navigation_button_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navigation_button_text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} [class*="booked-list-view-date-"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'navigation_button_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} [class*="booked-list-view-date-"]',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'navigation_button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} [class*="booked-list-view-date-"]',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'navigation_button_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} [class*="booked-list-view-date-"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'navigation_button_shadow',
				'selector' => '{{WRAPPER}} [class*="booked-list-view-date-"]',
			]
		);

		$this->add_control(
			'navigation_button_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} [class*="booked-list-view-date-"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'navigation_button_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} [class*="booked-list-view-date-"]',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_navigation_button_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navigation_button_hover_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} [class*="booked-list-view-date-"]:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'navigation_button_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} [class*="booked-list-view-date-"]:hover',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'navigation_button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'navigation_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} [class*="booked-list-view-date-"]:hover' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_appointment_button',
			[
				'label'     => __( 'Appointment Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'calendar_style' => 'list',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_appointment_button_style' );

		$this->start_controls_tab(
			'tab_appointment_button_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'appointment_button_text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .new-appt.button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'appointment_button_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .new-appt.button',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'appointment_button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .new-appt.button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'appointment_button_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .new-appt.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'appointment_button_shadow',
				'selector' => '{{WRAPPER}} .new-appt.button',
			]
		);

		$this->add_control(
			'appointment_button_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .new-appt.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'appointment_button_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .new-appt.button',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_appointment_button_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'appointment_button_hover_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .new-appt.button:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'appointment_button_hover_background',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .new-appt.button:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'appointment_button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'navigation_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .new-appt.button:hover' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_additional',
			[
				'label'     => __( 'Additional', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'calendar_style' => 'list',
				],
			]
		);

		$this->add_control(
			'calendar_icon_color',
			[
				'label'     => __( 'Calendar Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'calendar_icon_background',
			[
				'label'     => __( 'Calendar Icon Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'calendar_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'calendar_icon_radius',
			[
				'label'      => __( 'Calendar Icon Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'calendar_icon_shadow',
				'selector' => '{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger'
			]
		);

		$this->add_control(
			'calendar_icon_padding',
			[
				'label'      => __( 'Calendar Icon Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .booked-list-view a.booked_list_date_picker_trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'calendar_row_border_color',
			[
				'label'     => __( 'Row Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'calendar_row_border_width',
			[
				'label' => __( 'Row Border Width', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .booked-calendar-wrap .booked-appt-list .timeslot' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function get_shortcode() {
		$settings = $this->get_settings();

		$attributes = [
			'style'        => $settings['calendar_style'],
			'year'         => $settings['calendar_year'],
			'month'        => $settings['calendar_month'],
			'day'          => $settings['calendar_day'],
			'size'         => $settings['calendar_size'],
			'members-only' => ('yes' === $settings['calendar_members_only']) ? 'true' : '',
		];

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = [];
		$shortcode[] = sprintf( '[booked-calendar %s]', $this->get_render_attribute_string( 'shortcode' ) );

		return implode("", $shortcode);
	}

	public function render() {
		echo do_shortcode( $this->get_shortcode() );
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
