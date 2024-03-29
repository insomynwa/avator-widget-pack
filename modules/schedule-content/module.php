<?php
namespace WidgetPack\Modules\ScheduleContent;

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
		return 'avt-schedule-content';
	}

	public function register_controls_scheduled($section, $section_id, $args) {

		static $layout_sections = [ 'section_advanced'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }

		// Schedule content controls
		$section->start_controls_section(
			'section_scheduled_content_controls',
			[
				'label' => AWP_CP . __( 'Schedule Content', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);
		
		$section->add_control(
			'section_scheduled_content_on',
			[
				'label'        => __( 'Schedule Content?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => __( 'Switch on to schedule the contents of this column|section!.', 'avator-widget-pack' ),
			]
		);
		
		$section->add_control(
			'section_scheduled_content_start_date',
			[
				'label' => __( 'Start Date', 'avator-widget-pack' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2018-02-01 00:00:00',
				'condition' => [
					'section_scheduled_content_on' => 'yes',
				],
				'description' => __( 'Set start date for show this section.', 'avator-widget-pack' ),
			]
		);
		
		$section->add_control(
			'section_scheduled_content_end_date',
			[
				'label' => __( 'End Date', 'avator-widget-pack' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2018-02-28 00:00:00',
				'condition' => [
					'section_scheduled_content_on' => 'yes',
				],
				'description' => __( 'Set end date for hide the section.', 'avator-widget-pack' ),
			]
		);

		$section->end_controls_section();

	}


	public function schedule_before_render($section) {    		
		$settings = $section->get_settings();
		if( $section->get_settings( 'section_scheduled_content_on' ) == 'yes' ) {
			$star_date    = strtotime($settings['section_scheduled_content_start_date']);
			$end_date     = strtotime($settings['section_scheduled_content_end_date']);
			$current_date = strtotime(gmdate( 'Y-m-d H:i', ( time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ) ));

			if ( ($current_date >= $star_date) and ($current_date <= $end_date) ) {
				$section->add_render_attribute( '_wrapper', 'class', 'avt-scheduled' );
			} else {
				$section->add_render_attribute( '_wrapper', 'class', 'avt-hidden' );
			}
		}
	}

	protected function add_actions() {

		add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_scheduled' ], 10, 3 );
		add_action( 'elementor/frontend/section/before_render', [ $this, 'schedule_before_render' ], 10, 1 );

	}
}