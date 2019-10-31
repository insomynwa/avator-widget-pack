<?php
namespace WidgetPack\Modules\Carousel\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;
use WidgetPack\Modules\QueryControl\Module;

use WidgetPack\Modules\Carousel\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Carousel extends Widget_Base {

	private $_query = null;

	public function get_name() {
		return 'avt-carousel';
	}

	public function get_title() {
		return AWP . __( 'Carousel', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-carousel';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'carousel', 'navigation' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'avt-uikit-icons' ];
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
		$this->add_skin( new Skins\Skin_Vertical( $this ) );
		$this->add_skin( new Skins\Skin_Alice( $this ) );
	}

	protected function _register_controls() {
		$this->register_query_section_controls();
	}

	private function register_query_section_controls() {
		$this->start_controls_section(
			'section_carousel_layout',
			[
				'label' => __( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => __( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'options'        => [
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Limit', 'avator-widget-pack' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'item_gap',
			[
				'label'   => __( 'Item Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_image',
			[
				'label' => __( 'Image', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'thumbnail_show',
			[
				'label'        => __( 'Thumbnail Show', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'thumbnail_size',
				'label'        => __( 'Thumbnail Size', 'avator-widget-pack' ),
				'exclude'      => [ 'custom' ],
				'default'      => 'medium',
				'prefix_class' => 'avt-carousel-thumbnail-size-',
				'condition' => [
					'thumbnail_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => __( 'Image Width', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail' => 'width: {{SIZE}}{{UNIT}};margin-left: auto;margin-right: auto;',
				],
				'condition' => [
					'thumbnail_show' => 'yes',
					'_skin'          => '',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_layout_image_width',
			[
				'label' => __( 'Image Width', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-grid .avt-width-1-2' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'thumbnail_show' => 'yes',
					'_skin'          => 'avt-vertical',
				],
			]
		);

		$this->add_responsive_control(
			'image_ratio',
			[
				'label'   => __( 'Image Ratio', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.1,
						'max'  => 2,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail'       => 'padding-bottom: calc( {{SIZE}} * 100% ); top: 0; left: 0; right: 0; bottom: 0;',
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail:after' => 'content: "{{SIZE}}"; position: absolute; color: transparent;',
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail img'   => 'height: 100%; width: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); font-size: {{SIZE}};',
				],
				'condition' => [
					'thumbnail_show' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_layout_title',
			[
				'label' => __( 'Title', 'avator-widget-pack' ),
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
				'default'   => 'h4',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_layout_meta',
			[
				'label'     => __( 'Meta', 'avator-widget-pack' ),
				
			]
		);

		$this->add_control(
			'show_alice_category',
			[
				'label'     => __( 'Category', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => 'avt-alice'
				],
			]
		);

		$this->add_control(
			'meta_data',
			[
				'label'       => __( 'Meta Data', 'avator-widget-pack' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'default'     => [ 'date', 'comments' ],
				'multiple'    => true,
				'options'     => [
					'author'   => __( 'Author', 'avator-widget-pack' ),
					'category' => __( 'Category', 'avator-widget-pack' ),
					'date'     => __( 'Date', 'avator-widget-pack' ),
					'time'     => __( 'Time', 'avator-widget-pack' ),
					'comments' => __( 'Comments', 'avator-widget-pack' ),
				],
				'condition' => [
					'_skin!' => 'avt-alice'
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_layout_excerpt',
			[
				'label'     => __( 'Excerpt', 'avator-widget-pack' ),
				'condition' => [
					'_skin!' => 'avt-alice'
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'   => __( 'Excerpt', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => __( 'Excerpt Length', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 15,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_layout_button',
			[
				'label'     => __( 'Readmore Button', 'avator-widget-pack' ),
				'condition' => [
					'_skin!' => 'avt-alice'
				],
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label'   => __( 'Read More', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'       => __( 'Read More Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Read More', 'avator-widget-pack' ),
				'placeholder' => __( 'Read More', 'avator-widget-pack' ),
				'condition'   => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => __( 'Button Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => [
					'xs' => __( 'Extra Small', 'avator-widget-pack' ),
					'sm' => __( 'Small', 'avator-widget-pack' ),
					'md' => __( 'Medium', 'avator-widget-pack' ),
					'lg' => __( 'Large', 'avator-widget-pack' ),
					'xl' => __( 'Extra Large', 'avator-widget-pack' ),
				],
				'condition' => [
					'read_more_text!' => '',
					'show_read_more!' => '',
				],
			]
		);

		$this->add_control(
			'carousel_icon',
			[
				'label'       => esc_html__( 'Button Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition'   => [
					'read_more_text!' => '',
					'show_read_more!' => '',
				],
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
					'carousel_icon[value]!' => '',
				],
			]
		);

		$this->add_responsive_control(
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
					'carousel_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-flex-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-carousel .avt-flex-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
			'section_content_navigation',
			[
				'label' => __( 'Navigation', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'avator-widget-pack' ),
					'arrows' => __( 'Arrows', 'avator-widget-pack' ),
					'dots'   => __( 'Dots', 'avator-widget-pack' ),
					'none'   => __( 'None', 'avator-widget-pack' ),
				],
				'prefix_class' => 'avt-navigation-type-',
				'render_type' => 'template',				
			]
		);
		
		$this->add_control(
			'both_position',
			[
				'label'     => __( 'Arrows and Dots Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => widget_pack_navigation_position(),
				'condition' => [
					'navigation' => 'both',
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => __( 'Arrows Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => widget_pack_navigation_position(),
				'condition' => [
					'navigation' => 'arrows',
				],				
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'     => __( 'Dots Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => widget_pack_pagination_position(),
				'condition' => [
					'navigation' => 'dots',
				],				
			]
		);

		$this->add_control(
			'hide_arrow_on_mobile',
			[
				'label'     => __( 'Hide Arrow on Mobile ?', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],				
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_settings',
			[
				'label' => __( 'Carousel Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'match_height',
			[
				'label' => __( 'Item Match Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => __( 'Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pauseonhover',
			[
				'label' => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'slides_to_scroll',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides to Scroll', 'avator-widget-pack' ),
				'options'   => [
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				],
				'default'   => '1',
			]
		);

		$this->add_control(
			'center_slide',
			[
				'label'   => __( 'Center Slide', 'avator-widget-pack' ),
				'description'   => __( 'Use even items from Layout > Columns settings for better preview.', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => __( 'Loop', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				
			]
		);


		$this->add_control(
			'speed',
			[
				'label'   => __( 'Animation Speed (ms)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 500,
				],
				'range' => [
					'min'  => 100,
					'max'  => 5000,
					'step' => 50,
				],
			]
		);

		$this->add_control(
			'observer',
			[
				'label'       => __( 'Observer', 'avator-widget-pack' ),
				'description' => __( 'When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,				
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_skin',
			[
				'label'     => __( 'Items', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-alice'
				],
			]
		);

		$this->add_control(
			'skin_shadow_mode',
			[
				'label'        => esc_html__( 'Shadow Mode', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-wp-shadow-mode-',
			]
		);

		$this->add_control(
			'skin_shadow_color',
			[
				'label'     => esc_html__( 'Shadow Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'shadow_mode' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container:before' => 'background: linear-gradient(to right, {{VALUE}} 5%,rgba(255,255,255,0) 100%);',
					'{{WRAPPER}} .elementor-widget-container:after'  => 'background: linear-gradient(to right, rgba(255,255,255,0) 0%, {{VALUE}} 95%);',
				],
			]
		);

		$this->add_control(
			'skin_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-custom-overlay' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_layout',
			[
				'label'     => __( 'Items', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => 'avt-alice'
				],
			]
		);

		$this->start_controls_tabs('tabs_item_style');

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .avt-carousel .avt-carousel-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-carousel .avt-carousel-item',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'shadow_mode',
			[
				'label'        => esc_html__( 'Shadow Mode', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-wp-shadow-mode-',
			]
		);

		$this->add_control(
			'shadow_color',
			[
				'label'     => esc_html__( 'Shadow Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'shadow_mode' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container:before' => 'background: linear-gradient(to right, {{VALUE}} 5%,rgba(255,255,255,0) 100%);',
					'{{WRAPPER}} .elementor-widget-container:after'  => 'background: linear-gradient(to right, rgba(255,255,255,0) 0%, {{VALUE}} 95%);',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-item:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-carousel .avt-carousel-item:hover',
			]
		);

		$this->add_responsive_control(
			'item_shadow_padding',
			[
				'label'       => __( 'Match Padding', 'avator-widget-pack' ),
				'description' => __( 'You have to add padding for matching overlaping hover shadow', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					]
				],
				'default' => [
					'size' => 10
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container' => 'padding: {{SIZE}}{{UNIT}}; margin: 0 -{{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => __( 'Image', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'thumbnail_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'image_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'image_opacity',
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
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'image_hover_opacity',
			[
				'label'   => __( 'Hover Opacity (%)', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'size' => 20,
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_categories',
			[
				'label'     => __( 'Categories', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-alice',
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-categories a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-categories a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'category_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-carousel .avt-carousel-categories a',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'category_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-categories a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'category_shadow',
				'selector' => '{{WRAPPER}} .avt-carousel .avt-carousel-categories a',
			]
		);

		$this->add_responsive_control(
			'category_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'category_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-categories a' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-carousel .avt-carousel-categories a',
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
					'{{WRAPPER}} .avt-carousel .avt-carousel-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => __( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-title'   => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-carousel .avt-carousel-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_date',
			[
				'label'     => __( 'Date', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-alice',
				],
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'date_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-date' => 'margin-top: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'date_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-carousel .avt-carousel-date',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_meta',
			[
				'label'      => __( 'Meta', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'meta_data',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'avt-alice',
						],
					],
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-meta span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_hover_color',
			[
				'label'     => __( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-meta span:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-meta'   => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-carousel .avt-carousel-meta span',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label'     => __( 'Excerpt', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes',
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'avt-alice',
						],
					],
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-excerpt'   => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-carousel .avt-carousel-excerpt',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'      => __( 'Button', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_read_more',
							'value' => 'yes',
						],
						[
							'name'     => 'read_more_text',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'avt-alice',
						],
					],
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
					'{{WRAPPER}} .avt-carousel-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .avt-carousel-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-carousel-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-carousel-button',
			]
		);

		$this->add_control(
			'carousel_button_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-button .avt-carousel-button-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-carousel .avt-carousel-button .avt-carousel-button-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'carousel_icon[value]!' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'carousel_icon_size',
			[
				'label' => __( 'Icon Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 10,
						'max'  => 100,
					],
				],				
				'selectors' => [ 
					'{{WRAPPER}} .avt-carousel .avt-carousel-button .avt-carousel-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'carousel_icon[value]!' => '',
				],
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
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-carousel-button:hover',
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel-button:hover' => 'border-color: {{VALUE}};',
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

		$this->add_control(
			'carousel_button_hover_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-carousel-button:hover .avt-carousel-button-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-carousel .avt-carousel-button:hover .avt-carousel-button-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'carousel_icon[value]!' => '',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev svg, {{WRAPPER}} .avt-carousel .avt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev, {{WRAPPER}} .avt-carousel .avt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev:hover, {{WRAPPER}} .avt-carousel .avt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev svg, {{WRAPPER}} .avt-carousel .avt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Arrows Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev:hover svg, {{WRAPPER}} .avt-carousel .avt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_space',
			[
				'label' => __( 'Space', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .avt-carousel .avt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label' => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev, {{WRAPPER}} .avt-carousel .avt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev, {{WRAPPER}} .avt-carousel .avt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Dots Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_ncx_position',
			[
				'label'     => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'tablet_default' => [
					'size' => 20,
				],
				'mobile_default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .avt-carousel .avt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
					'(tablet){{WRAPPER}} .avt-carousel .avt-arrows-container' => 'transform: translate({{arrows_ncx_position_tablet.size}}px, {{SIZE}}px);',
					'(mobile){{WRAPPER}} .avt-carousel .avt-arrows-container' => 'transform: translate({{arrows_ncx_position_mobile.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_acx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-carousel .avt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'dots_nnx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'dots_nny_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .avt-carousel .avt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
					'(tablet){{WRAPPER}} .avt-carousel .avt-dots-container' => 'transform: translate({{dots_nnx_position_tablet.size}}px, {{SIZE}}px);',
					'(mobile){{WRAPPER}} .avt-carousel .avt-dots-container' => 'transform: translate({{dots_nnx_position_mobile.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'both_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'both_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .avt-carousel .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
					'(tablet){{WRAPPER}} .avt-carousel .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position_tablet.size}}px, {{SIZE}}px);',
					'(mobile){{WRAPPER}} .avt-carousel .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position_mobile.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'both_cx_position',
			[
				'label'   => __( 'Arrows Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-carousel .avt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'both_cy_position',
			[
				'label'   => __( 'Dots Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-carousel .avt-dots-container' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	public function get_taxonomies() {
		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

		$options = [ '' => '' ];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

	public function get_posts_tags() {
		$taxonomy = $this->get_settings( 'taxonomy' );

		foreach ( $this->_query->posts as $post ) {
			if ( ! $taxonomy ) {
				$post->tags = [];

				continue;
			}

			$tags = wp_get_post_terms( $post->ID, $taxonomy );

			$tags_slugs = [];

			foreach ( $tags as $tag ) {
				$tags_slugs[ $tag->term_id ] = $tag;
			}

			$post->tags = $tags_slugs;
		}
	}

	public function query_posts() {
		$query_args = Module::get_query_args( 'posts', $this->get_settings() );

		$query_args['posts_per_page'] = $this->get_settings( 'posts_per_page' );

		$this->_query = new \WP_Query( $query_args );
	}

	public function render() {
		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->get_posts_tags();

		$this->render_header();

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post();
		}

		$this->render_footer();

		wp_reset_postdata();
	}

	public function render_thumbnail() {
		$settings = $this->get_settings();

		if ( 'yes' !== $settings['thumbnail_show'] ) {
			return;
		}

		$settings['thumbnail_size'] = [
			'id' => get_post_thumbnail_id(),
		];

		$thumbnail_html        = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail_size' );
		$placeholder_image_src = Utils::get_placeholder_image_src();

		if ( ! $thumbnail_html ) {
			$thumbnail_html = '<img src="' . esc_url( $placeholder_image_src ) . '" alt="' . get_the_title() . '">';
		}

		?>
		<div class="avt-carousel-thumbnail">
			<a href="<?php echo get_permalink() ?>" title="<?php echo get_the_title(); ?>">
				<?php echo wp_kses_post($thumbnail_html) ?>
			</a>
		</div>
		<?php
	}

	public function render_meta_data() {
		$settings = $this->get_settings( 'meta_data' );
		if ( empty( $settings ) ) {
			return;
		}
		?>
		<div class="avt-carousel-meta avt-subnav avt-flex-middle avt-margin-small-top" avt-margin>
			<?php
			if ( in_array( 'author', $settings ) ) {
				$this->render_author();
			}

			if ( in_array( 'category', $settings ) ) {
				$this->render_category();
			}

			if ( in_array( 'date', $settings ) ) {
				$this->render_date();
			}

			if ( in_array( 'time', $settings ) ) {
				$this->render_time();
			}

			if ( in_array( 'comments', $settings ) ) {
				$this->render_comments();
			}
			?>
		</div>
		<?php
	}

	public function render_author() {
		?>
		<span class="pc-author">
			<span><?php the_author(); ?></span>
		</span>
		<?php
	}

	public function render_category() {
		?>
		<span class="pc-category">
			<span><?php echo get_the_category_list(', '); ?></span>
		</span>
		<?php 
	}

	public function render_date() {
		?>
		<span class="pc-date">
			<span><?php echo apply_filters( 'the_date', get_the_date('M j, Y'), get_option( 'date_format' ), '', '' ); ?></span>
		</span>
		<?php
	}

	public function render_time() {
		?>
		<span class="pc-time">
			<span><?php the_time(); ?></span>
		</span>
		<?php
	}

	public function render_comments() {
		?>
		<span class="pc-avatar">
			<span><?php comments_number(); ?></span>
		</span>
		<?php
	}

	public function render_title() {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->get_settings( 'title_tag' );
		$classes = ['avt-carousel-title avt-margin-small-bottom', 'avt-margin-remove-top']
		?>

		<<?php echo esc_html($tag) ?> class="<?php echo implode(" ", $classes); ?>">
		<a href="<?php echo get_permalink() ?>">
			<?php the_title() ?>
		</a>
		</<?php echo esc_html($tag) ?>>
		<?php
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {
		if ( ! $this->get_settings( 'show_excerpt' ) ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="avt-carousel-excerpt">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_readmore() {
		if ( ! $this->get_settings( 'show_read_more' ) ) {
			return;
		}

		$settings    = $this->get_settings();
		$animation   = ($settings['button_hover_animation']) ? ' elementor-animation-'.$settings['button_hover_animation'] : '';

		if ( 'left' == $settings['icon_align'] or 'right' == $settings['icon_align'] ) {
			$this->add_render_attribute( 'carousel-button', 'class', 'avt-flex avt-flex-middle', 'true' );
		}

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['carousel_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<a class="avt-carousel-button elementor-button elementor-size-<?php echo esc_attr($settings['button_size'] . $animation); ?>" href="<?php echo get_permalink(); ?>"> 
			<span <?php echo $this->get_render_attribute_string( 'carousel-button' ); ?>>
				<?php echo esc_html( $settings['read_more_text'] ); ?> 

				<?php if ($settings['carousel_icon']['value']) : ?>
					<span class="avt-carousel-button-icon avt-flex-align-<?php echo esc_attr($settings['icon_align']); ?>">

						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $settings['carousel_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
				<?php endif; ?>
			</span>

		</a>
		<?php
	}

	public function render_loop_header() {
		global $post;

		$tags_classes = array_map( function( $tag ) {
			return 'avt-carousel-filter-' . $tag->term_id;
		}, $post->tags );

		$classes = [
			'avt-carousel-item',
			'swiper-slide',
			implode( ' ', $tags_classes ),
		];

		?>
		<div <?php post_class( $classes ); ?>>
		<?php
	}

	public function render_post_footer() {
		?>
		</div>
		<?php
	}

	public function render_overlay_header() {
		$classes = ['avt-carousel-desc'];
		if ($this->get_settings('item_padding') == '') :
			$classes[] = 'avt-margin-top';
		endif; ?>
		<div class="<?php echo implode(" ", $classes);?>">
		<?php
	}

	public function render_overlay_footer() {
		?>
		</div>
		<?php
	}

	public function render_header($skin="default") {
		$id              = 'avt-carousel-' . $this->get_id();
		$settings        = $this->get_settings();
		$elementor_vp_lg = get_option( 'elementor_viewport_lg' );
		$elementor_vp_md = get_option( 'elementor_viewport_md' );
		$viewport_lg     = !empty($elementor_vp_lg) ? $elementor_vp_lg - 1 : 1023;
		$viewport_md     = !empty($elementor_vp_md) ? $elementor_vp_md - 1 : 767;
		
		$this->add_render_attribute( 'carousel', 'id', $id );
		$this->add_render_attribute( 'carousel', 'class', ['avt-carousel', 'avt-carousel-skin-' . $skin] );

		if ('arrows' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-arrows-align-'. $settings['arrows_position'] );
			
		}
		if ('dots' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-dots-align-'. $settings['dots_position'] );
		}
		if ('both' == $settings['navigation']) {
			$this->add_render_attribute( 'carousel', 'class', 'avt-arrows-dots-align-'. $settings['both_position'] );
		}

		if ( 'yes' == $settings['match_height'] ) {
			$this->add_render_attribute( 'carousel', 'avt-height-match', 'target: > div > div > .avt-carousel-item' );
		}

		$this->add_render_attribute(
			[
				'carousel' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"autoplay"       => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"           => ($settings["loop"] == "yes") ? true : false,
							"speed"          => $settings["speed"]["size"],
							"pauseOnHover"   => ("yes" == $settings["pauseonhover"]) ? true : false,
							"slidesPerView"  => (int) $settings["columns"],
							"slidesPerGroup" => ($settings["slides_to_scroll"] > 1) ? $settings["slides_to_scroll"] : false ,
							"spaceBetween"   => $settings["item_gap"]["size"],
							"observer"       => ($settings["observer"]) ? true : false,
							"observeParents" => ($settings["observer"]) ? true : false,
							"breakpoints"    => [
								(int) $viewport_lg => [
									"slidesPerView" => (int) $settings["columns_tablet"],
									"spaceBetween"       => $settings["item_gap"]["size"],
								],
								(int) $viewport_md => [
									"slidesPerView" => (int) $settings["columns_mobile"],
									"spaceBetween"       => $settings["item_gap"]["size"],
								]
					      	],
			      	        "navigation" => [
			      				"nextEl" => "#" . $id . " .avt-navigation-next",
			      				"prevEl" => "#" . $id . " .avt-navigation-prev",
			      			],
			      			"pagination" => [
			      			  "el"         => "#" . $id . " .swiper-pagination",
			      			  "type"       => "bullets",
			      			  "clickable"  => true,
			      			],
				        ]))
					]
				]
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'carousel' ); ?>>
			<div class="swiper-container">
				<div class="swiper-wrapper">
		<?php
	}

	public function render_both_navigation() {
		$settings             = $this->get_settings();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'avt-visible@m' : '';

		?>
		<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="avt-arrows-dots-container avt-slidenav-container ">
				
				<div class="avt-flex avt-flex-middle">
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>	
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>	
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	public function render_navigation() {
		$settings             = $this->get_settings();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? ' avt-visible@m' : '';
		?>

		<?php if ( 'arrows' == $settings['navigation'] ) : ?>
				<div class="avt-position-z-index avt-position-<?php echo esc_attr( $settings['arrows_position'] . $hide_arrow_on_mobile ); ?>">
					<div class="avt-arrows-container avt-slidenav-container">
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>
					</div>
				</div>
		<?php endif; ?>
		
		<?php
	}

	public function render_pagination() {
		$settings = $this->get_settings();
		?>

		<?php if ( 'dots' == $settings['navigation'] ) : ?>
			<?php if ( 'arrows' !== $settings['navigation'] ) : ?>
				<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['dots_position']); ?>">
					<div class="avt-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				</div>
			<?php endif; ?>
			
		<?php endif; ?>
		
		<?php
	}

	public function render_footer() {
		$id       = 'avt-carousel-' . $this->get_id();
		$settings = $this->get_settings();
		
		?>
				</div>
			</div>
			
			<?php if ('both' == $settings['navigation']) : ?>
				<?php $this->render_both_navigation(); ?>
				<?php if ('center' === $settings['both_position']) : ?>
					<div class="avt-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				<?php endif; ?>
			<?php else : ?>			
				<?php $this->render_pagination(); ?>
				<?php $this->render_navigation(); ?>
			<?php endif; ?>
			
		</div>

		<?php
	}

	public function render_post() {
		$this->render_loop_header();
		$this->render_thumbnail();
		$this->render_overlay_header();
		$this->render_title();
		$this->render_meta_data();
		$this->render_excerpt();
		$this->render_readmore();
		$this->render_overlay_footer();
		$this->render_post_footer();
	}
}
