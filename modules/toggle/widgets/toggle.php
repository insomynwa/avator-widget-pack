<?php
namespace WidgetPack\Modules\Toggle\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Toggle extends Widget_Base {

	public function get_name() {
		return 'avt-toggle';
	}

	public function get_title() {
		return AWP . esc_html__( 'Toggle', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-toggle';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'toggle', 'accordion', 'tab' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Toggle', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'toggle_title',
			[
				'label'       => esc_html__( 'Normal Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Show All' , 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'toggle_open_title',
			[
				'label'       => esc_html__( 'Opened Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Collapse' , 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'    => esc_html__( 'Custom', 'avator-widget-pack' ),
					"elementor" => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
					'anywhere'  => esc_html__( 'AE Template', 'avator-widget-pack' ),
				],				
			]
		);

		$this->add_control(
			'template_id',
			[
				'label'       => __( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_et_options(),
				'label_block' => 'true',
				'condition'   => ['source' => "elementor"],
			]
		);

		$this->add_control(
			'anywhere_id',
			[
				'label'       => esc_html__( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_ae_options(),
				'label_block' => 'true',
				'condition'   => ['source' => 'anywhere'],
			]
		);

		$this->add_control(
			'toggle_content',
			[
				'label'      => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'       => Controls_Manager::WYSIWYG,
				'dynamic'    => [ 'active' => true ],
				'default'    => esc_html__( 'Toggle Content', 'avator-widget-pack' ),
				'show_label' => false,
				'condition'  => ['source' => 'custom'],
			]
		);

		$this->add_control(
			'toggle_icon_show',
			[
				'label'   => esc_html__( 'Toggle Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title'   => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shadow_height',
			[
				'label' => esc_html__( 'Shadow Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-toggle-container .avt-accordion .avt-accordion-item .avt-accordion-title:before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_normal',
			[
				'label'       => esc_html__( 'Normal Icon', 'avator-widget-pack' ),
				'type'        		=> Controls_Manager::ICONS,
				'fa4compatibility'  => 'icon_normal',
				'default' 			=> [
					'value' 			=> 'fas fa-plus',
					'library' 			=> 'fa-solid',
				],
				'condition'   => [
					'toggle_icon_show!' => '',
				],
			]
		);

		$this->add_control(
			'toggle_icon_active',
			[
				'label'       => esc_html__( 'Active Icon', 'avator-widget-pack' ),
				'type'        		=> Controls_Manager::ICONS,
				'fa4compatibility'  => 'icon_active',
				'default' 			=> [
					'value' 			=> 'fas fa-minus',
					'library' 			=> 'fa-solid',
				],
				'condition'   => [
					'toggle_icon_show!' => '',
				],
			]
		);

		$this->add_control(
			'toggle_initially_open',
			[
				'label'     => esc_html__( 'Initially Opened', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_title',
			[
				'label' => esc_html__( 'Title', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-title svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'title_shadow',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-accordion-item .avt-accordion-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .avt-accordion .avt-accordion-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);


		$this->add_control(
			'shadow_color',
			[
				'label'     => esc_html__( 'Shadow Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-toggle-container .avt-accordion .avt-accordion-item .avt-accordion-title:before' => 'background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, {{VALUE}} 100%);',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_active',
			[
				'label' => esc_html__( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'active_title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-title svg' => 'fill: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_content_style',
			[
				'label' => esc_html__( 'Content', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-content' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'toggle_icon_show' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-title .avt-accordion-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-title .avt-accordion-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_active',
			[
				'label' => esc_html__( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-accordion .avt-accordion-item.avt-open .avt-accordion-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		$this->add_render_attribute(
			[
				'accordion-settings' => [
					'id'            => 'avt-accordion-' . esc_attr( $id ),
					'class'         => 'avt-accordion',
					'avt-accordion' => [
						wp_json_encode( array_filter( [
							"collapsible" => true,
							"transition"  => "ease-in-out"
						] ) )
					]
				]
			]
		);

		if ( ! isset( $settings['icon_normal'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon_normal'] = 'fas fa-plus';
		}

		if ( ! isset( $settings['icon_active'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon_active'] = 'fas fa-minus';
		}

		$migrated  = isset( $settings['__fa4_migrated']['toggle_icon_normal'] );
		$is_new    = empty( $settings['icon_normal'] ) && Icons_Manager::is_migration_allowed();

		$active_migrated  = isset( $settings['__fa4_migrated']['toggle_icon_active'] );
		$active_is_new    = empty( $settings['icon_active'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div class="avt-toggle-container">
			<div <?php echo $this->get_render_attribute_string('accordion-settings'); ?>>
				<?php 
					$this->add_render_attribute( 'tab_title', [ 'class' => [ 'avt-accordion-title' ], ] );
					$this->add_render_attribute( 'toggle_content', [ 'class' => [ 'avt-accordion-content' ], ] );
					$this->add_inline_editing_attributes( 'toggle_content', 'advanced' );
				?>

				<div class="avt-accordion-item<?php echo ('yes' == $settings['toggle_initially_open']) ? ' avt-open' : ''; ?> ">
					
					<div <?php echo $this->get_render_attribute_string( 'toggle_content' ); ?>>
						<?php 
			            	if ( 'custom' == $settings['source'] and !empty( $settings['toggle_content'] ) ) {
			            		echo $this->parse_text_editor( $settings['toggle_content'] );
			            	} elseif ("elementor" == $settings['source'] and !empty( $settings['template_id'] )) {
			            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['template_id'] );
			            		echo widget_pack_template_edit_link( $settings['template_id'] );
			            	} elseif ('anywhere' == $settings['source'] and !empty( $settings['anywhere_id'] )) {
			            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['anywhere_id'] );
			            		echo widget_pack_template_edit_link( $settings['anywhere_id'] );
			            	}
			            ?>
					</div>

					<a <?php echo $this->get_render_attribute_string( 'tab_title' ); ?> href="#">
						<span class="avt-toggle-open">
							<?php echo wp_kses( $settings['toggle_title'], widget_pack_allow_tags('title') ); ?>
						</span>
						<span class="avt-toggle-close">
							<?php echo wp_kses( $settings['toggle_open_title'], widget_pack_allow_tags('title') ); ?>
						</span> 
						
						<?php if ( 'yes' === $settings['toggle_icon_show'] ) : ?>
						<span class="avt-accordion-icon" aria-hidden="true">

						<span class="avt-accordion-icon-closed">
							<?php if ( $is_new || $migrated ) :
								Icons_Manager::render_icon( $settings['toggle_icon_normal'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
							else : ?>
								<i class="<?php echo esc_attr( $settings['icon_normal'] ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
						</span>
						
						<span class="avt-accordion-icon-opened">
							<?php if ( $active_is_new || $active_migrated ) :
								Icons_Manager::render_icon( $settings['toggle_icon_active'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
							else : ?>
								<i class="<?php echo esc_attr( $settings['icon_active'] ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
						</span>

						</span>
						<?php endif; ?>
						
					</a>
					
				</div>
			</div>
		</div>
		<?php
	}
}
