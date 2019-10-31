<?php
namespace WidgetPack\Modules\Bbpress\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Bbpress extends Widget_Base {

	public function get_name() {
		return 'avt-bbpress';
	}

	public function get_title() {
		return AWP . esc_html__( 'Bbpress', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-bbpress';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'bbpress', 'forum', 'community', 'discussion', 'support' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_bbpress_content',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'bbpress_layout',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'forum-index',
				'options' => [
					'forum-index'  => esc_html__('Forum Index', 'avator-widget-pack'),
					'forum-form'   => esc_html__('Forum Form', 'avator-widget-pack'),
					'single-forum' => esc_html__('Single Forum', 'avator-widget-pack'),
					'topic-index'  => esc_html__('Topic Index', 'avator-widget-pack'),
					'topic-form'   => esc_html__('Topic Form', 'avator-widget-pack'),
					'single-topic' => esc_html__('Single Topic', 'avator-widget-pack'),
					'reply-form'   => esc_html__('Single Topic', 'avator-widget-pack'),
					'single-reply' => esc_html__('Single Reply', 'avator-widget-pack'),
					'topic-tags'   => esc_html__('Topic Tags', 'avator-widget-pack'),
					'single-tag'   => esc_html__('Single Tag', 'avator-widget-pack'),
					'single-view'  => esc_html__('Single View', 'avator-widget-pack'),
					'stats'        => esc_html__('Stats', 'avator-widget-pack'),
				],
			]
		);

		$this->add_control(
			'bbpress_id',
			[
				'label'       => esc_html__( 'ID', 'avator-widget-pack' ),
				'description' => esc_html__( 'Enter your forum ID here, to get this id go to dashboard then go into the forum and open a specific post', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'bbpress_layout' => [ 'single-forum', 'topic-form', 'single-topic', 'single-reply', 'single-tag', 'single-view' ]
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_header_style',
			[
				'label' => esc_html__( 'Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);		

		$this->end_controls_section();
	}

	private function get_shortcode() {
		$settings   = $this->get_settings();
		$layout     = ['single-forum', 'single-topic', 'single-reply', 'single-tag', 'single-view' ];
		$attributes = [];

		if (in_array( $settings['bbpress_layout'], $layout ) and isset($settings['bbpress_id'])) {
			$attributes = [ ' id' => $settings['bbpress_id'] ];
		} elseif ('topic-form' == $settings['bbpress_layout'] and isset($settings['bbpress_id'])) {
			$attributes = [ ' forum_id' => $settings['bbpress_id'] ];
		}

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = [];
		$shortcode[] = sprintf( '[bbp-'.$settings['bbpress_layout'].'%s]', $this->get_render_attribute_string( 'shortcode' ) );

		return implode("", $shortcode);
	}

	public function render() {
		echo do_shortcode( $this->get_shortcode() );
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
