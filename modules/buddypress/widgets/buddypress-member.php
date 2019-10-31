<?php
namespace WidgetPack\Modules\Buddypress\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Buddypress_Member extends Widget_Base {

	public function get_name() {
		return 'avt-buddypress-member';
	}

	public function get_title() {
		return AWP . esc_html__( 'BuddyPress Member', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-buddypress';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}
    
    public function get_keywords() {
		return [ 'buddypress', 'user', 'member', 'activity', 'streams', 'profiles' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label'     => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'members_type',
			[
				'label'   => esc_html__( 'Members Type', 'avator-widget-pack' ),
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
			'max_members',
			[
				'label'   => esc_html__( 'Max Members', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .avt-buddypress-members .avt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .avt-buddypress-members .avt-grid > *' => 'padding-left: {{SIZE}}px',
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
					'{{WRAPPER}} .avt-buddypress-members .avt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .avt-buddypress-members .avt-grid > *' => 'margin-top: {{SIZE}}px',
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

		$this->add_control(
			'avatar_size',
			[
				'label'     => __( 'Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min'  => 5,
						'max'  => 150,
						'step' => 5,
					],
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
				'selector'    => '{{WRAPPER}} .avt-bp-member-avatar img',
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
					'{{WRAPPER}} .avt-bp-member-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
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
					'{{WRAPPER}} .avt-bp-member-avatar img' => 'opacity: {{SIZE}};',
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
					'{{WRAPPER}} .avt-bp-member-avatar img'  => 'margin-bottom: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .avt-bp-member-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .avt-bp-member-title a',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$type     = $settings['members_type'];

		// Setup args for querying members.
		$members_args = array(
			'user_id'         => 0,
			'type'            => esc_attr($type),
			'per_page'        => esc_attr($settings['max_members']['size']),
			'max'             => esc_attr($settings['max_members']['size']),
			'populate_extras' => true,
			'search_terms'    => false,
		);

		$avatar = array(
			'type'   => 'full',
			'width'  => esc_attr($settings['avatar_size']['size']),
			'class'  => 'avatar',
		);

		// Query for members.
		if ( bp_has_members( $members_args ) ) : ?>

			<div class="avt-buddypress-members">			
				<div class="avt-grid avt-grid-small avt-text-<?php echo esc_attr($settings['align']); ?> avt-flex-<?php echo esc_attr($settings['align']); ?>" avt-grid>
					<?php while ( bp_members() ) : bp_the_member(); ?>

						<?php $this->add_render_attribute('bp-member', 'class', 'avt-bp-member');

						if ('auto' !== $settings['columns']) {
							$this->add_render_attribute('bp-member', 'class', 'avt-width-1-'. $settings['columns_mobile']);
							$this->add_render_attribute('bp-member', 'class', 'avt-width-1-'. $settings['columns_tablet'] .'@s');
							$this->add_render_attribute('bp-member', 'class', 'avt-width-1-'. $settings['columns'] .'@m');
						} else {
							$this->add_render_attribute('bp-member', 'class', 'avt-width-auto');
						}

						if ($settings['show_meta_as_tooltip']) : ?>
							<?php if ( 'active' === $type ) : ?>
								<?php $this->add_render_attribute('bp-member', 'avt-tooltip', 'title: ' . bp_get_member_last_active(), true); ?>
							<?php elseif ( 'newest' === $type ) : ?>
								<?php $this->add_render_attribute('bp-member', 'avt-tooltip', 'title: ' . bp_get_member_registered(), true); ?>
							<?php elseif ( bp_is_active( 'friends' ) and ( 'popular' === $type ) ) : ?>
								<?php $this->add_render_attribute('bp-member', 'avt-tooltip', 'title: ' . bp_get_member_total_friend_count(), true); ?>
							<?php endif; ?>
						<?php endif; ?>

						<div <?php echo $this->get_render_attribute_string('bp-member'); ?>>
							<?php if ($settings['show_avatar']) : ?>
								<div class="avt-bp-member-avatar">
									<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar($avatar); ?></a>
								</div>
							<?php endif; ?>

							<?php if ($settings['show_title']) : ?>
								<div class="avt-bp-member-title fn"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></div>
							<?php endif; ?>	
						</div>

					<?php endwhile; ?>
				</div>
			</div>

		<?php else: ?>
			<div class="avt-alert-warning" avt-alert>There were no members found, please try another filter.</div>
		<?php endif;
	}

}
