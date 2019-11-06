<?php
namespace WidgetPack\Modules\Buddypress\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Buddypress_Group extends Widget_Base {

	public function get_name() {
		return 'avt-buddypress-group';
	}

	public function get_title() {
		return AWP . esc_html__( 'BuddyPress Group', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-buddypress';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'buddypress', 'user', 'group', 'activity', 'streams', 'profiles' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/CccODcBw_9w';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label'     => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'groups_type',
			[
				'label'   => esc_html__( 'Groups Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'newest',
				'options' => [
					'newest'  => esc_html__('Newest', 'avator-widget-pack'),
					'popular' => esc_html__('Popular', 'avator-widget-pack'),
					'active'  => esc_html__('Active', 'avator-widget-pack'),
				],
			]
		);

		$this->add_responsive_control(
			'max_groups',
			[
				'label'   => esc_html__( 'Max Groups', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					],
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '6',
				'tablet_default' => '4',
				'mobile_default' => '2',
				'options'        => [
					'1'    => '1',
					'2'    => '2',
					'3'    => '3',
					'4'    => '4',
					'5'    => '5',
					'6'    => '6',
					'auto' => 'Auto',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-buddypress-groups .avt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .avt-buddypress-groups .avt-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-buddypress-groups .avt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .avt-buddypress-groups .avt-grid > *' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
			]
		);

		$this->add_control(
			'show_avatar',
			[
				'label'   => esc_html__( 'Show Avatar', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Show Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_meta_as_tooltip',
			[
				'label'   => esc_html__( 'Show Meta as Tooltip', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_avatar',
			[
				'label'     => esc_html__( 'Avatar', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'avatar_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-bp-group-avatar img',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'avatar_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-bp-group-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'avatar_opacity',
			[
				'label'   => __( 'Opacity (%)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-bp-group-avatar img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'avatar_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-bp-group-avatar img'  => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => __( 'Title', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-bp-group-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .avt-bp-group-title a',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();
	}

	public function render() {

		$settings = $this->get_settings_for_display();
		$type     = $settings['groups_type'];

		$groups_args = array(
			'user_id'  => 0,
			'type'     => esc_attr($type),
			'per_page' => esc_attr($settings['max_groups']['size']),
			'max'      => esc_attr($settings['max_groups']['size']),
		);

		if ( bp_is_active( 'groups' ) and bp_has_groups( $groups_args ) ) : ?>

			<div class="avt-buddypress-groups">			
				<div class="avt-grid avt-grid-small avt-text-<?php echo esc_attr($settings['align']); ?> avt-flex-<?php echo esc_attr($settings['align']); ?>" avt-grid>


			<?php while ( bp_groups() ) : bp_the_group(); ?>

				<?php
				$this->add_render_attribute('bp-group', 'class', 'avt-bp-group');

				if ('auto' !== $settings['columns']) {
					$this->add_render_attribute('bp-group', 'class', 'avt-width-1-'. $settings['columns_mobile']);
					$this->add_render_attribute('bp-group', 'class', 'avt-width-1-'. $settings['columns_tablet'] .'@s');
					$this->add_render_attribute('bp-group', 'class', 'avt-width-1-'. $settings['columns'] .'@m');
				} else {
					$this->add_render_attribute('bp-group', 'class', 'avt-width-auto');
				}
				?>

				<?php if ($settings['show_meta_as_tooltip']) : ?>
					<?php if ( 'active' === $type ) : ?>
						<?php $this->add_render_attribute('bp-group', 'avt-tooltip', 'title: ' . bp_get_group_last_active(), true); ?>
					<?php elseif ( 'newest' === $type ) : ?>
						<?php $this->add_render_attribute('bp-group', 'avt-tooltip', 'title: ' . bp_get_group_date_created(), true); ?>
					<?php elseif ( 'popular' === $type ) : ?>
						<?php $this->add_render_attribute('bp-group', 'avt-tooltip', 'title: ' . bp_get_group_member_count(), true); ?>
					<?php endif; ?>
				<?php endif; ?>

				<div <?php echo $this->get_render_attribute_string('bp-group'); ?>>
					<?php if ($settings['show_avatar']) : ?>
						<div class="avt-bp-group-avatar">
							<a href="<?php bp_group_permalink() ?>"><?php bp_group_avatar_thumb() ?></a>
						</div>
					<?php endif; ?>

					<?php if ($settings['show_title']) : ?>
						<div class="avt-bp-group-title"><?php bp_group_link(); ?></div>
					<?php endif; ?>								
				</div>
			<?php endwhile; ?>
			</div>
		</div>

		<?php else: ?>
			<div class="avt-alert-warning" avt-alert>No groups matched the current filter or group not active. </div>
		<?php endif;

	}

}
