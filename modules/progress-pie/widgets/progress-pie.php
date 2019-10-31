<?php
namespace WidgetPack\Modules\ProgressPie\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Progress_Pie extends Widget_Base {

	protected $_has_template_content = true;

	public function get_name() {
		return 'avt-progress-pie';
	}

	public function get_title() {
		return AWP . esc_html__( 'Progress Pie', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-progress-pie';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'progress', 'pie', 'circle' ];
	}

	public function get_script_depends() {
		return [ 'aspieprogress' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'percent',
			[
				'label'   => esc_html__( 'Percent', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 75,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'duration',
			[
				'label'   => esc_html__( 'Duration(s)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
			]
		);

		/*$this->add_control(
			'delay',
			[
				'label'   => esc_html__( 'Delay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
			]
		);*/

		/*$this->add_control(
			'step',
			[
				'label'   => esc_html__( 'Steps', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
			]
		);*/

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Progress Pie Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Your title text here', 'avator-widget-pack' ),
				'default'     => esc_html__( 'Progress Pie Title', 'avator-widget-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'hide_title_divider',
			[
				'label'        => esc_html__( 'Hide Title Divider', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => ' avt-no-divider',
				'condition'    => [
					'title!' => '',
				]
			]
		);

		$this->add_control(
			'before',
			[
				'label'       => esc_html__( 'Before Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Your before text here', 'avator-widget-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => esc_html__( 'Middle Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Your middle text here', 'avator-widget-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'after',
			[
				'label'       => esc_html__( 'After Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Your after text here', 'avator-widget-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_layout',
			[
				'label' => esc_html__( 'Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'progress_pie',
			[
				'label'     => esc_html__( 'Progress Pie', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'progress_background',
			[
				'label'     => esc_html__( 'Pie Fill Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-progress-pie-wrapper .avt-progress-pie svg ellipse' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'progress_color',
			[
				'label'     => esc_html__( 'Pie Bar Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-progress-pie-wrapper .avt-progress-pie svg path' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'before_text_color',
			[
				'label'     => esc_html__( 'Before Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-progress-pie-before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'before!' => '',
				],
			]
		);

		$this->add_control(
			'middle_text_color',
			[
				'label'     => esc_html__( 'Middle Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-progress-pie-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'text!' => '',
				],

			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Percentage Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-progress-pie-number' => 'color: {{VALUE}};',
				],
				'condition' => [
					'text' => '',
				],

			]
		);

		$this->add_control(
			'after_text_color',
			[
				'label'     => esc_html__( 'After Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-progress-pie-after' => 'color: {{VALUE}};',
				],
				'condition' => [
					'after!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'progress_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-progress-pie-wrapper .avt-progress-pie' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'line_width',
			[
				'label'   => esc_html__( 'Line Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
			]
		);


		$this->add_control(
			'line_cap',
			[
				'label'     => esc_html__( 'Line Cap', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'round',
				'options'   => [
					'round' => esc_html__( 'Rounded', 'avator-widget-pack' ),
					'square'  => esc_html__( 'Square', 'avator-widget-pack' ),
					'butt'    => esc_html__( 'Butt', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'progress_title',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-progress-pie-wrapper .avt-progress-pie-title' => 'background-color: {{VALUE}};  border-top: none;',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-progress-pie-wrapper .avt-progress-pie-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-progress-pie-wrapper .avt-progress-pie-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'selector'  => '{{WRAPPER}} .avt-progress-pie-wrapper .avt-progress-pie-title',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		$id       = $this->get_id();
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			[
				'pp-settings' => [
					'id'          => esc_attr( $id ),
					'class'       => [
						'avt-progress-pie',
						'avt-pp-lc-'.$settings['line_cap'],
						$settings['text'] ? '' : 'avt-pp-percent'
					],
					'role'          => 'progressbar',
					'data-goal'     => intval($settings['percent']),
					'aria-valuemin' => '0',
					/*'data-step'     => $settings['step'],
					'data-delay'    => $settings['delay']*1000,*/
					'data-speed'    => $settings['duration']*15,
					'data-barsize'  => intval($settings['line_width']),
					'aria-valuemax' => '100'
				]
			]
		);

		?>
		<div id="<?php echo esc_attr($id); ?>_container" class="avt-progress-pie-wrapper">
			<div <?php echo ( $this->get_render_attribute_string( 'pp-settings' ) ); ?>>
		    	<div class="avt-progress-pie-label">
			       <?php if ($settings['before'] !== '') : ?>
					    <div class="avt-progress-pie-before"><?php echo esc_html($settings['before']); ?></div>
					<?php endif; ?>

			       <?php if ($settings['text'] !== '') : ?>
			       		    <div class="avt-progress-pie-text"><?php echo esc_html($settings['text']); ?></div>
	       		   <?php else : ?>
			            <div class="avt-progress-pie-number"></div>
		        	<?php endif; ?>
			        <?php if ($settings['after'] !== '') : ?>
	        		    <div class="avt-progress-pie-after"><?php echo esc_html($settings['after']); ?></div>
	        		<?php endif; ?>
			    </div>
			</div>
				<?php if ($settings['title'] !== '') : ?>
				    <h4 class="avt-progress-pie-title<?php echo esc_attr($settings['hide_title_divider']); ?>"><?php echo esc_html($settings['title']); ?></h4>
				<?php endif; ?>
					
		</div>

		<?php
	}
}
