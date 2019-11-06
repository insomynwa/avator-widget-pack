<?php
namespace WidgetPack\Modules\BusinessHours\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Business_Hours extends Widget_Base {

	//protected $_has_template_content = false;

	public function get_name() {
		return 'avt-business-hours';
	}

	public function get_title() {
		return AWP . esc_html__( 'Business Hours', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-business-hours';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'business', 'hours', 'time', 'duty', 'schedule' ];
	}

	public function get_style_depends() {
		return [ 'wipa-business-hours' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/1QfZ-os75rQ';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_business_days_layout',
			[
				'label' => esc_html__( 'Business Days & Times', 'avator-widget-pack' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'enter_day',
			[
				'label'       => esc_html__( 'Enter Day', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Monday',
			]
		);

		$repeater->add_control(
			'enter_time',
			[
				'label'       => esc_html__( 'Enter Time', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '10:00 AM - 6:00 PM',
			]
		);

		$repeater->add_control(
			'current_styling_heading',
			[
				'label'     => esc_html__( 'Styling', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'highlight_this',
			[
				'label'        => esc_html__( 'Style This Day', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			]
		);

		$repeater->add_control(
			'single_business_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'default'   => '#db6159',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .avt-business-day-off' => 'color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'single_business_timing_color',
			[
				'label'     => esc_html__( 'Time Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'default'   => '#db6159',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .avt-business-time-off' => 'color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'single_business_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-business-hours-inner {{CURRENT_ITEM}}.border-divider' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'business_days_times',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => array_values( $repeater->get_controls() ),
				'default'     => [
					[
						'enter_day'  => esc_html__( 'Monday', 'avator-widget-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'avator-widget-pack' ),
					],
					[
						'enter_day'  => esc_html__( 'Tuesday', 'avator-widget-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'avator-widget-pack' ),
					],
					[
						'enter_day'  => esc_html__( 'Wednesday', 'avator-widget-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'avator-widget-pack' ),
					],
					[
						'enter_day'  => esc_html__( 'Thursday', 'avator-widget-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'avator-widget-pack' ),
					],
					[
						'enter_day'  => esc_html__( 'Friday', 'avator-widget-pack' ),
						'enter_time' => esc_html__( '10:00 AM - 6:00 PM', 'avator-widget-pack' ),
					],
					[
						'enter_day'      => esc_html__( 'Saturday', 'avator-widget-pack' ),
						'enter_time'     => esc_html__( '10:00 AM - 6:00 PM', 'avator-widget-pack' ),
					],
					[
						'enter_day'      => esc_html__( 'Sunday', 'avator-widget-pack' ),
						'enter_time'     => esc_html__( 'Closed', 'avator-widget-pack' ),
						'highlight_this' => esc_html__( 'yes', 'avator-widget-pack' ),
					],
				],
				'title_field' => '{{{ enter_day }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_bs_general',
			[
				'label' => esc_html__( 'General', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_bs_list_padding',
			[
				'label'      => esc_html__( 'Row Spacing', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => ['top' => 5, 'right' => 5, 'bottom' => 5, 'left' => 5],
				'selectors'  => [
					'{{WRAPPER}} div.avt-business-hours-inner div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_bs_divider',
			[
				'label' => esc_html__( 'Divider', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'day_divider',
			[
				'label'        => esc_html__( 'Divider', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'day_divider_style',
			[
				'label'     => esc_html__( 'Style', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'solid'  => esc_html__( 'Solid', 'avator-widget-pack' ),
					'dotted' => esc_html__( 'Dotted', 'avator-widget-pack' ),
					'dashed' => esc_html__( 'Dashed', 'avator-widget-pack' ),
				],
				'default'   => 'solid',
				'selectors' => [
					'{{WRAPPER}} .avt-business-hours div.avt-business-hours-inner div.border-divider:not(:first-child)' => 'border-top-style: {{VALUE}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'day_divider_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e8e8e8',
				'selectors' => [
					'{{WRAPPER}} .avt-business-hours div.avt-business-hours-inner div.border-divider:not(:first-child)' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'day_divider_weight',
			[
				'label'     => esc_html__( 'Weight', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-business-hours div.avt-business-hours-inner div.border-divider:not(:first-child)' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_business_day_style',
			[
				'label' => esc_html__( 'Day and Time', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bs_note_heading',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => sprintf( '<p style="font-size: 12px;font-style: italic;line-height: 1.4;color: #a4afb7;">%s</p>', esc_html__( 'Note: By default, the color & typography options will inherit from parent styling. If you wish you can override that styling from here.', 'avator-widget-pack' ) ),
			]
		);

		$this->add_responsive_control(
			'business_hours_day_align',
			[
				'label'     => esc_html__( 'Day Alignment', 'avator-widget-pack' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} div.avt-business-hours-inner .heading-date' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'business_hours_time_align',
			[
				'label'     => esc_html__( 'Time Alignment', 'avator-widget-pack' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} div.avt-business-hours-inner .heading-time' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'business_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-business-day' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-widget-container' => 'overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Day Typography', 'avator-widget-pack' ),
				'name'     => 'business_day_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .heading-date',
			]
		);

		$this->add_control(
			'business_timing_color',
			[
				'label'     => esc_html__( 'Time Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-business-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Time Typography', 'avator-widget-pack' ),
				'name'     => 'business_timings_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .heading-time',
			]
		);

		$this->add_control(
			'business_hours_striped',
			[
				'label'        => esc_html__( 'Striped Effect', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'business_hours_striped_odd_color',
			[
				'label'     => esc_html__( 'Striped Odd Rows Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eaeaea',
				'selectors' => [
					'{{WRAPPER}} .border-divider:nth-child(odd)' => 'background: {{VALUE}};',
				],
				'condition' => [
					'business_hours_striped' => 'yes',
				],
			]
		);

		$this->add_control(
			'striped_effect_even',
			[
				'label'     => esc_html__( 'Striped Even Rows Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .border-divider:nth-child(even)' => 'background: {{VALUE}};',
				],
				'condition' => [
					'business_hours_striped' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings();
		?>

		<div class="avt-business-hours">
			<?php
			if ( count( $settings['business_days_times'] ) ) {
			$count = 0;
			?>
				<div class="avt-business-hours-inner">
					<?php
					foreach ( $settings['business_days_times'] as $item ) {
						$day_settings = $this->get_repeater_setting_key( 'enter_day', 'business_days_times', $count );
						$this->add_inline_editing_attributes( $day_settings );
						
						$time_settings = $this->get_repeater_setting_key( 'enter_time', 'business_days_times', $count );
						$this->add_inline_editing_attributes( $time_settings );

						$this->add_render_attribute( 'avt-inner-element', 'class', 'avt-inner avt-grid avt-grid-small', true );
						$this->add_render_attribute( 'avt-inner-heading-time', 'class', 'inner-heading-time' );
						$this->add_render_attribute( 'avt-bs-background' . $item['_id'], 'class', 'elementor-repeater-item-' . $item['_id'] );
						$this->add_render_attribute( 'avt-bs-background' . $item['_id'], 'class', 'border-divider' );

						if ( 'yes' === $item['highlight_this'] ) {
							$this->add_render_attribute( 'avt-bs-background' . $item['_id'], 'class', 'avt-highlight-bg' );
						} elseif ( 'yes' === $settings['business_hours_striped'] ) {
							$this->add_render_attribute( 'avt-bs-background' . $item['_id'], 'class', 'stripes' );
						}
						
						$this->add_render_attribute( 'avt-highlight-day' . $item['_id'], 'class', 'heading-date avt-width-expand' );
						$this->add_render_attribute( 'avt-highlight-time' . $item['_id'], 'class', 'heading-time avt-width-auto' );

						if ( 'yes' === $item['highlight_this'] ) {
							$this->add_render_attribute( 'avt-highlight-day' . $item['_id'], 'class', 'avt-business-day-off' );
							$this->add_render_attribute( 'avt-highlight-time' . $item['_id'], 'class', 'avt-business-time-off' );
						} else {
							$this->add_render_attribute( 'avt-highlight-day' . $item['_id'], 'class', 'avt-business-day' );
							$this->add_render_attribute( 'avt-highlight-time' . $item['_id'], 'class', 'avt-business-time' );
						}
						?>
						<div <?php echo $this->get_render_attribute_string( 'avt-bs-background' . $item['_id'] ); ?>>
							<div <?php echo $this->get_render_attribute_string( 'avt-inner-element' ); ?>>
								<span <?php echo $this->get_render_attribute_string( 'avt-highlight-day' . $item['_id'] ); ?>>
									<span <?php echo $this->get_render_attribute_string( $day_settings ); ?>><?php echo esc_html($item['enter_day']); ?></span>
								</span>

								<?php if ( ! empty($item['enter_time']) ) : ?>
									<span <?php echo $this->get_render_attribute_string( 'avt-highlight-time' . $item['_id'] ); ?>>
										<span <?php echo $this->get_render_attribute_string( 'avt-inner-heading-time' ); ?>>
											<span <?php echo $this->get_render_attribute_string( $time_settings ); ?>><?php echo esc_html($item['enter_time']); ?></span>
										</span>
									</span>
								<?php endif; ?>
							</div>
						</div>
						<?php
						$count++;
					} ?>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	protected function _content_template() {
		?>
		<div class="avt-business-hours">
			<div class="avt-business-hours-inner">
			<#  if ( settings.business_days_times ) {

					var count = 0;

					_.each( settings.business_days_times, function( item ) {

						var avt_current_item_wrap = 'elementor-repeater-item-' + item._id;
						var avt_bs_background;
						if ( 'yes' == item.highlight_this ) {
							avt_bs_background = 'avt-highlight-bg';
						} else if ( 'yes' == settings.business_hours_striped ) {
							avt_bs_background = 'stripes';
						} else {
							avt_bs_background = 'bs-background';
						}
						var avt_highlight_day;
						var avt_highlight_time;
						if ( 'yes' == item.highlight_this ) {
							avt_highlight_day  = 'avt-business-day-off';
							avt_highlight_time = 'avt-business-time-off';
						} else {
							avt_highlight_day  = 'avt-business-day';
							avt_highlight_time = 'avt-business-time';
						}

					#>
					<div class="{{ avt_current_item_wrap }} {{ avt_bs_background }} border-divider">
						<div class="avt-inner avt-grid">
							<span class="{{ avt_highlight_day }} heading-date avt-width-expand">
								<span class="elementor-inline-editing" data-elementor-setting-key="business_days_times.{{ count }}.enter_day" data-elementor-inline-editing-toolbar="basic">{{ item.enter_day }}</span>
							</span>

							<# if ( item.enter_time ) { #>
								<span class="{{ avt_highlight_time }} heading-time avt-width-auto">
									<span class="inner-heading-time">								
										<span class="elementor-inline-editing" data-elementor-setting-key="business_days_times.{{ count }}.enter_time" data-elementor-inline-editing-toolbar="basic">{{ item.enter_time }}</span>
									</span>
								</span>
							<# } #>
						</div>
					</div>
					<#
					count++;
					});				}
				#>
			</div>
		</div>
		<?php
	}
}
