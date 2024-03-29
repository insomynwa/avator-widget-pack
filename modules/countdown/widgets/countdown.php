<?php
namespace WidgetPack\Modules\Countdown\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Utils;

use Elementor\Scheme_Color;

use WidgetPack\Modules\Countdown\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Countdown extends Widget_Base {

	public function get_name() {
		return 'avt-countdown';
	}

	public function get_title() {
		return AWP . esc_html__( 'Countdown', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-countdown';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'countdown', 'timer', 'schedule' ];
	}

	public function get_style_depends() {
		return [ 'wipa-countdown' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/HtsshsQxqEA';
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Event_Countdown( $this ) );
	}


	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'due_date',
			[
				'label'       => esc_html__( 'Due Date', 'avator-widget-pack' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => date( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				'description' => sprintf( __( 'Date set according to your timezone: %s.', 'avator-widget-pack' ), Utils::get_timezone_string() ),
				'condition'   => [
					'_skin' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_count',
			[
				'label' => esc_html__( 'Count Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'count_gap',
			[
				'label'   => esc_html__( 'Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''         => esc_html__( 'Default', 'avator-widget-pack' ),
					'small'    => esc_html__( 'Small', 'avator-widget-pack' ),
					'medium'   => esc_html__( 'Medium', 'avator-widget-pack' ),
					'large'    => esc_html__( 'Large', 'avator-widget-pack' ),
					'collapse' => esc_html__( 'Collapse', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'number_label_gap',
			[
				'label'   => esc_html__( 'Number & Label Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}}.avt-countdown--label-block .avt-countdown-number'  => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.avt-countdown--label-inline .avt-countdown-number' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_labels!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'        => __( 'Text Alignment', 'avator-widget-pack' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'default'      => 'center',
			]
		);

		$this->add_responsive_control(
			'container_width',
			[
				'label'   => esc_html__( 'Container Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
					'size' => 70,
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-countdown-wrapper' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
				],
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'       => __( 'Content Align', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left' => [
						'title' => __( 'Top', 'avator-widget-pack' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Bottom', 'avator-widget-pack' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-countdown-wrapper' => 'margin-{{VALUE}}: 0;',
				],
			]
		);

		$this->add_responsive_control(
			'count_column',
			[
				'label'          => esc_html__( 'Count Column', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '2',
				'options'        => [
					''  => esc_html__( 'Default', 'avator-widget-pack' ),
					'1' => esc_html__( '1 Columns', 'avator-widget-pack' ),
					'2' => esc_html__( '2 Columns', 'avator-widget-pack' ),
					'3' => esc_html__( '3 Column', 'avator-widget-pack' ),
					'4' => esc_html__( '4 Columns', 'avator-widget-pack' ),
				],
				'condition' => [
					'_skin' => '',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => esc_html__( 'Additional Options', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'label_display',
			[
				'label'   => esc_html__( 'View', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'block'  => esc_html__( 'Block', 'avator-widget-pack' ),
					'inline' => esc_html__( 'Inline', 'avator-widget-pack' ),
				],
				'default'      => 'block',
				'prefix_class' => 'avt-countdown--label-',
			]
		);

		$this->add_control(
			'show_days',
			[
				'label'   => esc_html__( 'Days', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label'   => esc_html__( 'Hours', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_minutes',
			[
				'label'   => esc_html__( 'Minutes', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				]
		);

		$this->add_control(
			'show_seconds',
			[
				'label'   => esc_html__( 'Seconds', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label'   => esc_html__( 'Show Label', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'custom_labels',
			[
				'label'        => esc_html__( 'Custom Label', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition'    => [
					'show_labels!' => '',
				],
			]
		);

		$this->add_control(
			'label_days',
			[
				'label'       => esc_html__( 'Days', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Days', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Days', 'avator-widget-pack' ),
				'condition'   => [
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_days'      => 'yes',
				],
			]
		);

		$this->add_control(
			'label_hours',
			[
				'label'       => esc_html__( 'Hours', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Hours', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Hours', 'avator-widget-pack' ),
				'condition'   => [
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_hours'     => 'yes',
				],
			]
		);

		$this->add_control(
			'label_minutes',
			[
				'label'       => esc_html__( 'Minutes', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Minutes', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Minutes', 'avator-widget-pack' ),
				'condition'   => [
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_minutes'   => 'yes',
				],
			]
		);

		$this->add_control(
			'label_seconds',
			[
				'label'       => esc_html__( 'Seconds', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Seconds', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Seconds', 'avator-widget-pack' ),
				'condition'   => [
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_seconds'   => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_count_style',
			[
				'label' => esc_html__( 'Count Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'count_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-countdown-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'count_border',
				'label'    => esc_html__( 'Border', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-countdown-item',
			]
		);

		$this->add_control(
			'count_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'count_shadow',
				'selector' => '{{WRAPPER}} .avt-countdown-item',
			]
		);

		$this->add_responsive_control(
			'count_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_number_style',
			[
				'label' => esc_html__( 'Number', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-countdown-number' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'  => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-countdown-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'number_box_shadow',
				'selector' => '{{WRAPPER}} .avt-countdown-number',
			]
		);

		$this->add_responsive_control(
			'number_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-countdown-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'number_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-countdown-number',
			]
		);

		$this->add_responsive_control(
			'number_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-countdown-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .avt-countdown-number',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_style',
			[
				'label'     => esc_html__( 'Label', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'label_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-countdown-label' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-countdown-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'label_box_shadow',
				'selector' => '{{WRAPPER}} .avt-countdown-label',
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-countdown-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'label_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-countdown-label',
			]
		);

		$this->add_responsive_control(
			'label_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-countdown-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .avt-countdown-label',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
	}

	public function get_strftime( $settings ) {
		$string = '';
		if ( $settings['show_days'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_days', 'avt-countdown-days' );
		}
		if ( $settings['show_hours'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_hours', 'avt-countdown-hours' );
		}
		if ( $settings['show_minutes'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_minutes', 'avt-countdown-minutes' );
		}
		if ( $settings['show_seconds'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_seconds', 'avt-countdown-seconds' );
		}

		return $string;
	}

	private $_default_countdown_labels;

	private function _init_default_countdown_labels() {
		$this->_default_countdown_labels = [
			'label_months'  => esc_html__( 'Months', 'avator-widget-pack' ),
			'label_weeks'   => esc_html__( 'Weeks', 'avator-widget-pack' ),
			'label_days'    => esc_html__( 'Days', 'avator-widget-pack' ),
			'label_hours'   => esc_html__( 'Hours', 'avator-widget-pack' ),
			'label_minutes' => esc_html__( 'Minutes', 'avator-widget-pack' ),
			'label_seconds' => esc_html__( 'Seconds', 'avator-widget-pack' ),
		];
	}

	public function get_default_countdown_labels() {
		if ( ! $this->_default_countdown_labels ) {
			$this->_init_default_countdown_labels();
		}

		return $this->_default_countdown_labels;
	}

	private function render_countdown_item( $settings, $label, $part_class ) {
		$string  = '<div class="avt-countdown-item-wrapper">';
			$string .= '<div class="avt-countdown-item">';
				$string .= '<span class="avt-countdown-number ' . $part_class . ' avt-text-'.esc_attr($this->get_settings('alignment')).'"></span>';

				if ( $settings['show_labels'] ) {
					$default_labels = $this->get_default_countdown_labels();
					$label          = ( $settings['custom_labels'] ) ? $settings[ $label ] : $default_labels[ $label ];
					$string        .= ' <span class="avt-countdown-label avt-text-'.esc_attr($this->get_settings('alignment')).'">' . $label . '</span>';
				}
			$string .= '</div>';
		$string .= '</div>';

		return $string;
	}

	protected function render() {
		$settings      = $this->get_settings();
		$due_date      = $settings['due_date'];
		$string        = $this->get_strftime( $settings );
		
		$with_gmt_time = date( 'Y-m-d H:i', strtotime( $due_date ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );		
		$datetime      = new \DateTime($with_gmt_time);
		$final_time    = $datetime->format('c');

		$this->add_render_attribute(
			[
				'countdown' => [
					'class' => [
						'avt-grid',
						$settings['count_gap'] ? 'avt-grid-' . $settings['count_gap'] : '',
						'avt-child-width-1-' . $settings['count_column_mobile'],
						'avt-child-width-1-' . $settings['count_column_tablet'] . '@s',
						'avt-child-width-1-' . $settings['count_column'] . '@m'
					],
					'avt-countdown' => [
						'date: ' . $final_time,
					],
					'avt-grid' => '',
				],
			]
		);

		?>
		<div class="avt-countdown-wrapper avt-countdown-skin-default">
			<div <?php echo $this->get_render_attribute_string( 'countdown' ); ?>>
				<?php echo wp_kses_post($string); ?>
			</div>
		</div>
		<?php
	}
}
