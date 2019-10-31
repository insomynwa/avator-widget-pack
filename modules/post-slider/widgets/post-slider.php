<?php
namespace WidgetPack\Modules\PostSlider\Widgets;

use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;
use WidgetPack\Modules\QueryControl\Module;

use WidgetPack\Modules\PostSlider\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Post Slider
 */
class Post_Slider extends Widget_Base {
	public $_query = null;

	public function get_name() {
		return 'avt-post-slider';
	}

	public function get_title() {
		return AWP . __( 'Post Slider', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-post-slider';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'post', 'slider', 'blog', 'recent', 'news' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'post';
		}

		return $element;
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
		return $element;
	}

	public function get_query() {
		return $this->_query;
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Vast( $this ) );
		$this->add_skin( new Skins\Skin_Hazel( $this ) );
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_limit',
			[
				'label' => esc_html__( 'Post Limit', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'condition' => [
					'_skin' => ['avt-hazel', 'avt-vast'],
				],
				'default' => [
					'size' => 4,
				],
			]
		);

		$this->add_control(
			'show_tag',
			[
				'label'   => __( 'Show Tag', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => __( 'Show Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => __( 'Title HTML Tag', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => widget_pack_title_tags(),
				'default'   => 'h1',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'   => __( 'Show Excerpt', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => __( 'Excerpt Length', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 35,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_button',
			[
				'label' => __( 'Read More Button', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label'   => __( 'Meta', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_pagination_thumb',
			[
				'label'     => __( 'Pagination Thumb', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'slider_size_ratio',
			[
				'label'       => esc_html__( 'Size Ratio', 'avator-widget-pack' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => 'Slider ratio to widht and height, such as 16:9',
				'condition'   => [
					'_skin!' => 'avt-vast',
				],
			]
		);

		$this->add_control(
			'slider_min_height',
			[
				'label'     => esc_html__( 'Slider Minimum Height', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'_skin!' => 'avt-vast',
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
			]
		);

		$this->add_control(
			'slider_max_height',
			[
				'label'     => esc_html__( 'Slider Max Height', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'_skin!' => 'avt-vast',
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
			]
		);

		$this->add_responsive_control(
			'slider_container_width',
			[
				'label' => esc_html__( 'Container Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-content-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-content'      => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-pagination'   => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label' => esc_html__( 'Content Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'   => esc_html__( 'Content Alignment', 'avator-widget-pack' ),
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
				'description'  => 'Use align to match position',
				'default'      => 'left',
				'prefix_class' => 'elementor-align-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'post_slider_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'post_slider_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'post_slider_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-post-slider .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => __( 'Query', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Posts::get_type(),
			[
				'name'  => 'posts',
				'label' => __( 'Posts', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order By', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date'  => __( 'Date', 'avator-widget-pack' ),
					'post_title' => __( 'Title', 'avator-widget-pack' ),
					'menu_order' => __( 'Menu Order', 'avator-widget-pack' ),
					'rand'       => __( 'Random', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => __( 'ASC', 'avator-widget-pack' ),
					'desc' => __( 'DESC', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label'     => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => [
					'posts_post_type!' => 'by_id',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_slider_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => esc_html__( 'Autoplay Interval', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 7000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__( 'Animation Speed', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			]
		);

		$this->add_control(
			'slider_animations',
			[
				'label'     => esc_html__( 'Slider Animations', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'slide' => esc_html__( 'Slide', 'avator-widget-pack' ),
					'fade'  => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale' => esc_html__( 'Scale', 'avator-widget-pack' ),
					'push'  => esc_html__( 'Push', 'avator-widget-pack' ),
					'pull'  => esc_html__( 'Pull', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'kenburns_animation',
			[
				'label'     => esc_html__( 'Kenburns Animation', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin' => ''
				]
			]
		);

		$this->add_control(
			'kenburns_reverse',
			[
				'label'     => esc_html__( 'Kenburn Reverse', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'kenburns_animation' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slider',
			[
				'label'     => esc_html__( 'Slider', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => ''
				]
			]
		);

		$this->add_control(
			'overlay',
			[
				'label'   => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'background',
				'options' => [
					'none'       => esc_html__( 'None', 'avator-widget-pack' ),
					'background' => esc_html__( 'Background', 'avator-widget-pack' ),
					'blend'      => esc_html__( 'Blend', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'condition' => [
					'overlay' => ['background', 'blend']
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-overlay-default' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label'   => esc_html__( 'Overlay Opacity', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.4,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.1,
						'step' => 0.01,
					],
				],
				'condition' => [
					'overlay' => ['background', 'blend']
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-overlay-default' => 'opacity: {{SIZE}};'
				]
			]
		);

		$this->add_control(
			'blend_type',
			[
				'label'     => esc_html__( 'Blend Type', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'multiply',
				'options'   => widget_pack_blend_options(),
				'condition' => [
					'overlay' => 'blend',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_bottom_part',
			[
				'label'     => esc_html__( 'Bottom Part', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-vast'
				]
			]
		);

		$this->add_control(
			'bottom_part_bg',
			[
				'label'       => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-vast .avt-post-slider-content' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_right_part',
			[
				'label'     => esc_html__( 'Right Part', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-hazel'
				]
			]
		);

		$this->add_control(
			'right_part_bg',
			[
				'label'       => esc_html__( 'Description Background', 'avator-widget-pack' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-thumbnail ~ div' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'right_part_nav_color',
			[
				'label'       => esc_html__( 'Navigation Color', 'avator-widget-pack' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
				'separator'   => 'before',
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-navigation-inner a' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'right_part_nav_hover_color',
			[
				'label'       => esc_html__( 'Navigation Hover Color', 'avator-widget-pack' ),
				'label_block' => true,
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-navigation-inner a:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'right_part_nav_bg',
			[
				'label'       => esc_html__( 'Navigation Background', 'avator-widget-pack' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
				'separator'   => 'before',
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-navigation-inner a' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'right_part_nav_hover_bg',
			[
				'label'       => esc_html__( 'Navigation Hover Background', 'avator-widget-pack' ),
				'label_block' => true,
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-navigation-inner a:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'right_part_nav_arrows_color',
			[
				'label'       => esc_html__( 'Arrows Color', 'avator-widget-pack' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
				'separator'   => 'before',
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-navigation-inner a svg polyline' => 'stroke: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'right_part_nav_hover_arrows_color',
			[
				'label'       => esc_html__( 'Arrows Hover Color', 'avator-widget-pack' ),
				'label_block' => true,
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-navigation-inner a:hover svg polyline' => 'stroke: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'right_part_line_color',
			[
				'label'       => esc_html__( 'Line Color', 'avator-widget-pack' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
				'separator'   => 'before',
				'selectors'   => [
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-navigation-inner a:first-child:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-slider-skin-hazel .avt-post-slider-navigation-inner'                     => 'border-top-color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tag',
			[
				'label'     => esc_html__( 'Tag', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_tag' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'tag_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-tag-wrap span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-tag-wrap span a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'tag_border',
				'label'    => __( 'Border', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-slider .avt-post-slider-tag-wrap span',
			]
		);

		$this->add_control(
			'tag_border_radius',
			[
				'label' => __( 'Border Radius', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-tag-wrap span' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tag_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-slider .avt-post-slider-tag-wrap span',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-slider .avt-post-slider-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
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
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => esc_html__( 'Text', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-slider .avt-post-slider-text',
			]
		);

		$this->add_responsive_control(
			'text_spacing',
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
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_meta',
			[
				'label' => esc_html__( 'Meta', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-slider .avt-post-slider-meta',
			]
		);

		$this->add_responsive_control(
			'meta_spacing',
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
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-post-slider .avt-post-slider-button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_spacing',
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
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-slider .avt-post-slider-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[
				'label'     => esc_html__( 'Pagination', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'pagination_text_color',
			[
				'label'     => esc_html__( 'Pagination Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-pagination h6'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-pagination span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'thumb_background_color',
			[
				'label'     => esc_html__( 'Thumb Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-thumb-wrap' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_pagination_thumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'thumb_opacity',
			[
				'label' => esc_html__( 'Thumb Opacity', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.1,
						'step' => 0.01,
					],
				],
				'condition' => [
					'show_pagination_thumb' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-thumb-wrap img' => 'opacity: {{SIZE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'thumb_border',
				'label'     => __( 'Border', 'avator-widget-pack' ),
				'selector'  => '{{WRAPPER}} .avt-post-slider .avt-post-slider-thumb-wrap',
				'condition' => [
					'show_pagination_thumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'thumb_border_radius',
			[
				'label' => __( 'Thumb Border Radius', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'condition' => [
					'show_pagination_thumb' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-thumb-wrap' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'pagination_border_color',
			[
				'label'     => esc_html__( 'Upper Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-pagination .avt-thumbnav' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_active_border_color',
			[
				'label'     => esc_html__( 'Active Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-slider .avt-post-slider-pagination .avt-active .avt-post-slider-pagination-item' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_title_typography',
				'label'    => esc_html__( 'Title Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-slider .avt-post-slider-pagination .avt-thumbnav .avt-post-slider-pagination-item h6',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_date_typography',
				'label'    => esc_html__( 'Date Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-slider .avt-post-slider-pagination .avt-thumbnav .avt-post-slider-pagination-item .avt-post-slider-date',
			]
		);

		$this->end_controls_section();

	}

	public function query_posts() {
		$settings = $this->get_settings();
		$query_args = Module::get_query_args( 'posts', $settings );

		$post_limit = ('avt-hazel' == $settings['_skin'] or 'avt-vast' == $settings['_skin']) ? $settings['item_limit']['size'] : 4;

		$query_args['posts_per_page'] = $post_limit;

		$this->_query = new \WP_Query( $query_args );
	}

	public function render() {
		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->render_header();

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post();
		}

		$this->render_footer();

		wp_reset_postdata();
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {
		if ( ! $this->get_settings( 'show_text' ) ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="avt-post-slider-text avt-visible@m" avt-slideshow-parallax="x: 500,-500">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_title() {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->get_settings( 'title_tag' );

		?>
		<div class="avt-post-slider-title-wrap">
			<a href="<?php echo esc_url(get_permalink()); ?>">
				<<?php echo esc_attr($tag) ?> class="avt-post-slider-title avt-margin-remove-bottom" avt-slideshow-parallax="x: 200,-200">
					<?php the_title() ?>
				</<?php echo esc_attr($tag) ?>>
			</a>
		</div>
		<?php
	}

	public function render_read_more_button() {
		$settings        = $this->get_settings_for_display();

		if ( ! $this->get_settings( 'show_button' ) ) {
			return;
		}
		$settings  = $this->get_settings();
		$animation = ($settings['button_hover_animation']) ? ' elementor-animation-'.$settings['button_hover_animation'] : '';

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['post_slider_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div class="avt-post-slider-button-wrap" avt-slideshow-parallax="y: 200,-200">
			<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-slider-button avt-display-inline-block<?php echo esc_attr($animation); ?>">
				<?php echo esc_attr($this->get_settings( 'button_text' )); ?>

				<?php if ($settings['post_slider_icon']['value']) : ?>
					<span class="avt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">

						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $settings['post_slider_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
				<?php endif; ?>
			</a>
		</div>
		<?php
	}

	public function render_header() {
		$settings = $this->get_settings();
		$id       = 'avt-post-slider-' . $this->get_id();

		$ratio = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'].":".$settings['slider_size_ratio']['height'] : '';

	    $this->add_render_attribute(
			[
				'slider-settings' => [
					'id'    => esc_attr($id),
					'class' => [
						'avt-post-slider',
						'avt-post-slider-skin-default'
					],
					'avt-slideshow' => [
						wp_json_encode(array_filter([
							"animation"         => $settings["slider_animations"],
							"min-height"        => $settings["slider_min_height"]["size"],
							"max-height"        => $settings["slider_max_height"]["size"],
							"ratio"             => $ratio,
							"autoplay"          => $settings["autoplay"],
							"autoplay-interval" => $settings["autoplay_interval"],
							"pause-on-hover"    => $settings["pause_on_hover"]
						]))
					]
				]
			]
		);
	    
		?>
		<div <?php echo $this->get_render_attribute_string( 'slider-settings' ); ?>>
			<div class="avt-slideshow-items">
		<?php
	}

	public function render_footer() {
		?>
			</div>
			<?php $this->render_loop_pagination(); ?>
		</div>
		
		<?php
	}

	public function render_loop_item() {
		$settings         = $this->get_settings();		

		$placeholder_image_src = Utils::get_placeholder_image_src();

		$slider_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

		if ( ! $slider_thumbnail ) {
			$slider_thumbnail = $placeholder_image_src;
		} else {
			$slider_thumbnail = $slider_thumbnail[0];
		}

		$this->add_render_attribute(
			[
				'post-slider-item' => [
					'class' => [
						'avt-slideshow-item',
						'avt-post-slider-item'
					]
				]
			], '', '', true
		);

		$kenburns_reverse = $settings['kenburns_reverse'] ? ' avt-animation-reverse' : '';

		?>
		<div <?php echo $this->get_render_attribute_string( 'post-slider-item' ); ?>>
			<?php if( $settings['kenburns_animation'] ) : ?>
				<div class="avt-position-cover avt-animation-kenburns<?php echo esc_attr( $kenburns_reverse ); ?> avt-transform-origin-center">
			<?php endif; ?>
				<img src="<?php echo esc_url($slider_thumbnail); ?>" alt="<?php echo get_the_title(); ?>" avt-cover>
			<?php if( $settings['kenburns_animation'] ) : ?>
	            </div>
	        <?php endif; ?>
			<div class="avt-post-slider-content-wrap avt-position-center avt-position-z-index">
				<div class="avt-post-slider-content">

	                <?php if ($settings['show_tag']) : ?>
	                	<div class="avt-post-slider-tag-wrap" avt-slideshow-parallax="y: -200,200">
	                		<?php
							$tags_list = get_the_tag_list( '<span class="avt-background-primary">', '</span> <span class="avt-background-primary">', '</span>');
		                		if ($tags_list) :
		                    		echo  wp_kses_post($tags_list);
		                		endif; ?>
	                	</div>
	            	<?php endif;

					$this->render_title();
					$this->render_excerpt();

					if ($settings['show_meta']) : ?>
						<div class="avt-post-slider-meta avt-flex-inline avt-flex-middile" avt-slideshow-parallax="x: 250,-250">
							<div class="avt-post-slider-author avt-margin-small-right avt-border-circle avt-overflow-hidden avt-visible@m">
								<?php echo get_avatar( get_the_author_meta( 'ID' ) , 28 ); ?>
							</div>
							<span class="avt-author avt-text-capitalize"><?php echo esc_attr(get_the_author()); ?> </span>
							<span><?php esc_html_e('On', 'avator-widget-pack'); ?> <?php echo get_the_date(); ?></span>
						</div>
					<?php endif; ?>
					
					<?php $this->render_read_more_button(); ?>

				</div>
			</div>

			<?php if( 'none' !== $settings['overlay'] ) :
				$blend_type = ( 'blend' == $settings['overlay']) ? ' avt-blend-'.$settings['blend_type'] : ''; ?>
				<div class="avt-overlay-default avt-position-cover<?php echo esc_attr($blend_type); ?>"></div>
	        <?php endif; ?>
		</div>
		<?php
		
	}

	public function render_loop_pagination() {
		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$settings = $this->get_settings();
		$id       = $this->get_id();
		$ps_count = 0;

		?>
		<div id="<?php echo esc_attr($id); ?>_nav"  class="avt-post-slider-pagination avt-position-bottom-center">
		     <ul class="avt-thumbnav avt-grid avt-grid-small avt-child-width-auto avt-child-width-1-4@m avt-flex-center" avt-grid> 

		<?php		      
		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			?>
			<li avt-slideshow-item="<?php echo esc_attr($ps_count); ?>">
				<div class="avt-post-slider-pagination-item">
					<a href="#">
						<div class="avt-flex avt-flex-middle avt-text-left">
							<?php if ($settings['show_pagination_thumb']) :	

								$placeholder_image_src = Utils::get_placeholder_image_src();
								$slider_thumbnail      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );

								if ( ! $slider_thumbnail ) {
									$slider_thumbnail = $placeholder_image_src;
								} else {
									$slider_thumbnail = $slider_thumbnail[0];
								}

								?>
								<div class="avt-width-auto avt-post-slider-thumb-wrap">
									<img src="<?php echo esc_url($slider_thumbnail); ?>">
								</div>
		        			<?php endif; ?>
							<div class="avt-margin-small-left avt-visible@m">
								<h6 class="avt-margin-remove-bottom"><?php echo esc_attr(get_the_title()); ?></h6>
								<span class="avt-post-slider-date"><?php echo get_the_date(); ?><span>
							</div>
						</div>
					</a>
				</div>
			</li>

			<?php
			$ps_count++;
		} ?>
		    
	        </ul>
		</div>
		<?php
	}

	public function render_post() {
		$this->render_loop_item();
	}
}
