<?php
namespace WidgetPack\Modules\SocialShare\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use WidgetPack\Modules\SocialShare\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Social_Share extends Widget_Base {

	protected $_has_template_content = false;

	private static $medias_class = [
		'email'      => 'ep-envelope',
		'vkontakte'  => 'ep-vk',
	];

	private static function get_social_media_class( $media_name ) {
		if ( isset( self::$medias_class[ $media_name ] ) ) {
			return self::$medias_class[ $media_name ];
		}

		return 'ep-' . $media_name;
	}


	public function get_name() {
		return 'avt-social-share';
	}

	public function get_title() {
		return AWP . esc_html__( 'Social Share', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-social-share';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'social', 'link', 'share' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font', 'avt-social-share' ];
	}
	
	public function get_script_depends() {
		return [ 'goodshare' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_buttons_content',
			[
				'label' => esc_html__( 'Share Buttons', 'avator-widget-pack' ),
			]
		);

		$repeater = new Repeater();

		$medias = Module::get_social_media();

		$medias_names = array_keys( $medias );

		$repeater->add_control(
			'button',
			[
				'label' => esc_html__( 'Social Media', 'avator-widget-pack' ),
				'type' => Controls_Manager::SELECT,
				'options' => array_reduce( $medias_names, function( $options, $media_name ) use ( $medias ) {
					$options[ $media_name ] = $medias[ $media_name ]['title'];

					return $options;
				}, [] ),
				'default' => 'facebook',
			]
		);

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Custom Label', 'avator-widget-pack' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'share_buttons',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => [
					[ 'button' => 'facebook' ],
					[ 'button' => 'linkedin' ],
					[ 'button' => 'twitter' ],
					[ 'button' => 'pinterest' ],
				],
				'title_field' => '{{{ button }}}',
			]
		);

		$this->add_control(
			'view',
			[
				'label'       => esc_html__( 'View', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'icon-text' => 'Icon & Text',
					'icon'      => 'Icon',
					'text'      => 'Text',
				],
				'default'      => 'icon-text',
				'separator'    => 'before',
				'prefix_class' => 'avt-ss-btns-view-',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'show_label',
			[
				'label'     => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'view' => 'icon-text',
				],
			]
		);

		$this->add_control(
			'show_counter',
			[
				'label'     => esc_html__( 'Count', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'view!' => 'icon',
				],
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'flat'     => esc_html__( 'Flat', 'avator-widget-pack' ),
					'framed'   => esc_html__( 'Framed', 'avator-widget-pack' ),
					'gradient' => esc_html__( 'Gradient', 'avator-widget-pack' ),
					'minimal'  => esc_html__( 'Minimal', 'avator-widget-pack' ),
					'boxed'    => esc_html__( 'Boxed Icon', 'avator-widget-pack' ),
				],
				'default'      => 'flat',
				'prefix_class' => 'avt-ss-btns-style-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label'   => esc_html__( 'Shape', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'square'  => esc_html__( 'Square', 'avator-widget-pack' ),
					'rounded' => esc_html__( 'Rounded', 'avator-widget-pack' ),
					'circle'  => esc_html__( 'Circle', 'avator-widget-pack' ),
				],
				'default'      => 'square',
				'prefix_class' => 'avt-ss-btns-shape-',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => [
					'0' => 'Auto',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'avt-wp-grid%s-',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
					'justify' => [
						'title' => esc_html__( 'Justify', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'prefix_class' => 'avt-ss-btns-align-',
				'condition'    => [
					'columns' => '0',
				],
			]
		);

		$this->add_control(
			'share_url_type',
			[
				'label'   => esc_html__( 'Target URL', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'current_page' => esc_html__( 'Current Page', 'avator-widget-pack' ),
					'custom'       => esc_html__( 'Custom', 'avator-widget-pack' ),
				],
				'default'   => 'current_page',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'share_url',
			[
				'label'         => esc_html__( 'URL', 'avator-widget-pack' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'placeholder'   => 'http://your-link.com',
				'condition'     => [
					'share_url_type' => 'custom',
				],
				'show_label'         => false,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_buttons_style',
			[
				'label' => esc_html__( 'Share Buttons', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Columns Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-ss-btn' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
					'{{WRAPPER}} .avt-wp-grid'             => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2);',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Rows Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-ss-btn' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_size',
			[
				'label' => esc_html__( 'Button Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.5,
						'max'  => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-ss-btn' => 'font-size: calc({{SIZE}}{{UNIT}} * 10);',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'em' => [
						'min'  => 0.5,
						'max'  => 4,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'em',
				],
				'tablet_default' => [
					'unit' => 'em',
				],
				'mobile_default' => [
					'unit' => 'em',
				],
				'size_units' => [ 'em', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-ss-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'text',
				],
			]
		);

		$this->add_responsive_control(
			'button_height',
			[
				'label' => esc_html__( 'Button Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'em' => [
						'min'  => 1,
						'max'  => 7,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'em',
				],
				'tablet_default' => [
					'unit' => 'em',
				],
				'mobile_default' => [
					'unit' => 'em',
				],
				'size_units' => [ 'em', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-ss-btn' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_size',
			[
				'label'      => esc_html__( 'Border Size', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'size' => 2,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
					'em' => [
						'max'  => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-ss-btn' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style' => [ 'framed', 'boxed' ],
				],
			]
		);

		$this->add_control(
			'color_source',
			[
				'label'       => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'original' => 'Original Color',
					'custom'   => 'Custom Color',
				],
				'default'      => 'original',
				'prefix_class' => 'avt-ss-btns-color-',
				'separator'    => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'     => esc_html__( 'Normal', 'avator-widget-pack' ),
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label'     => esc_html__( 'Primary Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-ss-btns-style-flat .avt-ss-btn,
					 {{WRAPPER}}.avt-ss-btns-style-gradient .avt-ss-btn,
					 {{WRAPPER}}.avt-ss-btns-style-boxed .avt-ss-btn .avt-ss-icon,
					 {{WRAPPER}}.avt-ss-btns-style-minimal .avt-ss-btn .avt-ss-icon' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.avt-ss-btns-style-framed .avt-ss-btn,
					 {{WRAPPER}}.avt-ss-btns-style-minimal .avt-ss-btn,
					 {{WRAPPER}}.avt-ss-btns-style-boxed .avt-ss-btn' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label'     => esc_html__( 'Secondary Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-ss-btns-style-flat .avt-ss-icon, 
					 {{WRAPPER}}.avt-ss-btns-style-flat .avt-social-share-text, 
					 {{WRAPPER}}.avt-ss-btns-style-gradient .avt-ss-icon,
					 {{WRAPPER}}.avt-ss-btns-style-gradient .avt-social-share-text,
					 {{WRAPPER}}.avt-ss-btns-style-boxed .avt-ss-icon,
					 {{WRAPPER}}.avt-ss-btns-style-minimal .avt-ss-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'color_source' => 'custom',
				],
				'separator' => 'after',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => esc_html__( 'Hover', 'avator-widget-pack' ),
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'primary_color_hover',
			[
				'label'     => esc_html__( 'Primary Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-ss-btns-style-flat .avt-ss-btn:hover,
					 {{WRAPPER}}.avt-ss-btns-style-gradient .avt-ss-btn:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.avt-ss-btns-style-framed .avt-ss-btn:hover,
					 {{WRAPPER}}.avt-ss-btns-style-minimal .avt-ss-btn:hover,
					 {{WRAPPER}}.avt-ss-btns-style-boxed .avt-ss-btn:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
					'{{WRAPPER}}.avt-ss-btns-style-boxed .avt-ss-btn:hover .avt-ss-icon, 
					 {{WRAPPER}}.avt-ss-btns-style-minimal .avt-ss-btn:hover .avt-ss-icon' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'secondary_color_hover',
			[
				'label'     => esc_html__( 'Secondary Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.avt-ss-btns-style-flat .avt-ss-btn:hover .avt-ss-icon, 
					 {{WRAPPER}}.avt-ss-btns-style-flat .avt-ss-btn:hover .avt-social-share-text, 
					 {{WRAPPER}}.avt-ss-btns-style-gradient .avt-ss-btn:hover .avt-ss-icon,
					 {{WRAPPER}}.avt-ss-btns-style-gradient .avt-ss-btn:hover .avt-social-share-text,
					 {{WRAPPER}}.avt-ss-btns-style-boxed .avt-ss-btn:hover .avt-ss-icon,
					 {{WRAPPER}}.avt-ss-btns-style-minimal .avt-ss-btn:hover .avt-ss-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'color_source' => 'custom',
				],
				'separator' => 'after',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-social-share-title, {{WRAPPER}} .avt-ss-counter',
				'exclude'  => [ 'line_height' ],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Text Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'view' => 'text',
				],
			]
		);

		$this->end_controls_section();
	}

	private function has_counter( $media_name ) {
		$settings = $this->get_active_settings();

		return 'icon' !== $settings['view'] && 'yes' === $settings['show_counter'] && ! empty( Module::get_social_media( $media_name )['has_counter'] );
	}
	
	public function render() {

		$settings  = $this->get_active_settings();

		if ( empty( $settings['share_buttons'] ) ) {
			return;
		}

		$show_text = 'text' === $settings['view'] ||  $settings['show_label'];
		?>
		<div class="avt-social-share avt-wp-grid">
			<?php
			foreach ( $settings['share_buttons'] as $button ) {
				$social_name = $button['button'];
				$has_counter = $this->has_counter( $social_name );

				if ( 'custom' === $settings['share_url_type'] ) {
					$this->add_render_attribute( 'social-attrs', 'data-url', esc_url( $settings['share_url']['url'] ), true );
				}

				$this->add_render_attribute(
					[
						'social-attrs' => [
							'class' => [
								'avt-ss-btn',
								'avt-ss-' . $social_name
							],
							'data-social' => $social_name,
						]
					], '', '', true
				);

				?>
				<div class="avt-social-share-item avt-wp-grid-item">
					<div <?php echo $this->get_render_attribute_string( 'social-attrs' ); ?>>
						<?php if ( 'icon' === $settings['view'] || 'icon-text' === $settings['view'] ) : ?>
							<span class="avt-ss-icon">
								<i class="<?php echo self::get_social_media_class( $social_name ); ?>"></i>
							</span>
						<?php endif; ?>
						<?php if ( $show_text || $has_counter ) : ?>
							<div class="avt-social-share-text avt-inline">
								<?php if ( 'yes' === $settings['show_label'] || 'text' === $settings['view'] ) : ?>
									<span class="avt-social-share-title">
										<?php echo $button['text'] ? esc_html($button['text']) : Module::get_social_media( $social_name )['title']; ?>
									</span>
								<?php endif; ?>
								<?php if ( $has_counter ) : ?>
									<span class="avt-social-share-counter" data-counter="<?php echo esc_attr($social_name); ?>"></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php
			}
			?>
		</div>

		
		<?php

		
	}

	
}
