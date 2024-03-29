<?php
namespace WidgetPack\Modules\PostGridTab\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\QueryControl\Module;
use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Post_Grid_Tab extends Widget_Base {
	private $_query = null;

	public function get_name() {
		return 'avt-post-grid-tab';
	}

	public function get_title() {
		return AWP . esc_html__( 'Post Grid Tab', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-post-grid-tab';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'post', 'grid', 'tab', 'blog', 'recent', 'news' ];
	}

	public function get_style_depends() {
		return ['wipa-post-grid-tab', 'widget-pack-font'];
	}

	public function get_script_depends() {
		return [ 'avt-uikit-icons', 'gridtab', 'recliner', 'wipa-post-grid-tab' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/kFEL4AGnIv4';
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

	public function _register_controls() {
		$this->register_query_section_controls();
	}

	private function register_query_section_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 4,
				'tablet_default' => 3,
				'mobile_default' => 2,
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
				'label'   => esc_html__( 'Posts Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
			]
		);

		$this->add_control(
			'item_ratio',
			[
				'label' => esc_html__( 'Item Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab-thumbnail img' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'grid_tab_item',
			[
				'label'   => esc_html__( 'Grid Tab Item', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image' => esc_html__( 'Image', 'avator-widget-pack' ),
					'title' => esc_html__( 'Title', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'exclude'   => ['custom'],
				'condition' => ['grid_tab_item' => 'image'],
				'default'   => 'medium',
			]
		);

		$this->add_control(
			'content_reverse',
			[
				'label'   => esc_html__( 'Content Reverse', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Posts::get_type(),
			[
				'name'  => 'posts',
				'label' => esc_html__( 'Posts', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date'  => esc_html__( 'Date', 'avator-widget-pack' ),
					'post_title' => esc_html__( 'Title', 'avator-widget-pack' ),
					'menu_order' => esc_html__( 'Menu Order', 'avator-widget-pack' ),
					'rand'       => esc_html__( 'Random', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'ASC', 'avator-widget-pack' ),
					'desc' => esc_html__( 'DESC', 'avator-widget-pack' ),
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
			'section_content_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => widget_pack_title_tags(),
				'default'   => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'   => esc_html__( 'Author', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label'   => esc_html__( 'Comments', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'     => esc_html__( 'Category', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'after'
			]
		);

		$this->add_control(
			'content_image',
			[
				'label'   => esc_html__('Post Image', 'avator-widget-pack'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'content_thumbnail',
				'exclude'   => ['custom'],
				'condition' => ['grid_tab_item' => 'image'],
				'default'   => 'full',
				'condition' => [
					'content_image' => 'yes'
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'   => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 45,
				'condition' => [
					'show_excerpt' => 'yes',
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'show_readmore',
			[
				'label'   => esc_html__( 'Read More', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label'       => esc_html__( 'Read More Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
				'condition'   => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->add_control(
			'post_grid_tab_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition'   => [
					'show_readmore' => 'yes',
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
					'icon!' => '',
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
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-post-grid-tab .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'show_close',
			[
				'label'   => esc_html__( 'Close Button', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_arrows',
			[
				'label' => esc_html__( 'Arrows', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_padding',
			[
				'label'   => esc_html__( 'Item Padding', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => '0',
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 2,
					],
				],
			]
		);

		$this->add_responsive_control(
			'tab_text_align',
			[
				'label'   => __( 'Item Text Align', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
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
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab > dt' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'grid_tab_item' => 'title',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'tab_text_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-grid-tab .gridtab > dt',
				'condition' => [
					'grid_tab_item' => 'title',
				],
			]
		);

		$this->add_control(
			'item_border_width',
			[
				'label'   => esc_html__( 'Item Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 2,
					],
				],
			]
		);

		$this->add_control(
			'tab_border_color',
			[
				'label'     => esc_html__( 'Item Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab > dt, {{WRAPPER}} .avt-post-grid-tab .gridtab > dd' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'active_tab_no',
			[
				'label'     => esc_html__( 'Active Tab Number', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
			]
		);

		$this->add_control(
			'active_tab_background',
			[
				'label'     => esc_html__( 'Active Item Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab > dt.is-active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'active_tab_text_color',
			[
				'label'     => esc_html__( 'Active Item Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab > dt.is-active' => 'color: {{VALUE}};',
				],
				'condition' => [
					'grid_tab_item' => 'title',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Content Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-desc-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => esc_html__( 'Content Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab > dd' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-item-title'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-item-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_meta',
			[
				'label'     => esc_html__( 'Meta', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#adb5bd',
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-meta *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-meta *',
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#adb5bd',
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-subnav span:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-excerpt',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[
				'label'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_readmore' => 'yes',
 				],
			]
		);

		$this->start_controls_tabs( 'tabs_readmore_style' );

		$this->start_controls_tab(
			'tab_readmore_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'readmore_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'readmore_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_shadow',
				'selector' => '{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore',
			]
		);

		$this->add_responsive_control(
			'readmore_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'readmore_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_readmore_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'readmore_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .avt-post-grid-tab-readmore:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_close_button',
			[
				'label'     => esc_html__( 'Close Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_close' => 'yes',
 				],
			]
		);

		$this->start_controls_tabs( 'tabs_close_button_style' );

		$this->start_controls_tab(
			'tab_close_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'close_button_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__close:before, {{WRAPPER}} .avt-post-grid-tab .gridtab__close:after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__close' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'close_button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-post-grid-tab .gridtab__close',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'close_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'close_button_shadow',
				'selector' => '{{WRAPPER}} .avt-post-grid-tab .gridtab__close',
			]
		);

		$this->add_responsive_control(
			'close_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_close_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'close_button_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__close:hover::before, {{WRAPPER}} .avt-post-grid-tab .gridtab__close:hover::after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__close:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'close_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__close:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_arrows' => 'yes',
 				],
			]
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow:before, {{WRAPPER}} .avt-post-grid-tab .gridtab__arrow:after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'arrows_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'arrows_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'arrows_shadow',
				'selector' => '{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow',
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow:hover::before, {{WRAPPER}} .avt-post-grid-tab .gridtab__arrow:hover::after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'arrows_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid-tab .gridtab__arrow:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
		$settings = $this->get_settings();
		$id       = 'avt-post-grid-tab-' . $this->get_id();

		$this->query_posts();
		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->get_posts_tags();

		$this->render_header();

			?>
			<dl id="<?php echo esc_attr($id); ?>" class="gridtab">
			    <?php
			    
			    while ( $wp_query->have_posts() ) {
					$wp_query->the_post();
					$this->render_post();
				} ?>

			</dl>
		</div>
		<?php		
		wp_reset_postdata();
	}

	public function render_content_image($image_id, $size) {
		
		$loading_img = AWP_ASSETS_URL . 'images/loading.svg';

		$placeholder_image_src = Utils::get_placeholder_image_src();
		$image_src             = wp_get_attachment_image_src( $image_id, $size );

		if ( ! $image_src ) {
			$image_src = $placeholder_image_src;
		} else {
			$image_src = $image_src[0];
		}
		?>
		<div class="avt-post-grid-tab-image">
			<div class="avt-post-grid-tab-image-inner avt-gt-mh avt-cover-container">
				<img class="<?php echo esc_attr($size); ?>" src="<?php echo esc_url($image_src); ?>" alt="<?php echo get_the_title(); ?>" >
			</div>
		</div>
		<?php
	}

	public function render_tab_image($image_id) {
		$settings              = $this->get_settings();
		
		$placeholder_image_src = Utils::get_placeholder_image_src();
		$image_src             = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'thumbnail', $settings );

		if ( ! $image_src ) {
			$image_src = $placeholder_image_src;
		}
		?>
		<div class="avt-post-grid-tab-thumbnail" title="<?php echo get_the_title(); ?>">
			<img class="" src="<?php echo esc_url($image_src); ?>" alt="<?php echo get_the_title(); ?>">
		</div>
		<?php
	}

	public function render_title() {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->get_settings( 'title_tag' );

		?>
		<a href="<?php echo get_the_permalink(); ?>">
			<<?php echo esc_attr($tag) ?> class="avt-post-grid-tab-item-title avt-margin-remove">
				<?php the_title() ?>
			</<?php echo esc_attr($tag) ?>>
		</a>
		<?php
	}

	public function render_tab_title() {
		echo '<div class="avt-post-grid-tab-title">';
		the_title();
		echo '</div>';
	}

	public function render_author() {

		if ( ! $this->get_settings('show_author') ) {
			return;
		}
		
		echo 
			'<span class="avt-post-grid-tab-author avt-text-capitalize">'.get_the_author().'</span>';		
	}

	public function render_date() {

		if ( ! $this->get_settings('show_date') ) {
			return;
		}
		
		echo 
			'<span class="avt-post-grid-tab-date">'.get_the_date().'</span>';		
	}

	public function render_comments() {

		if ( ! $this->get_settings('show_comments') ) {
			return;
		}
		
		echo 
			'<span><i class="wipa-bubble avt-display-inline-block" aria-hidden="true"></i> '.get_comments_number().'</span>';
	}

	public function render_category() {

		if ( ! $this->get_settings( 'show_category' ) or ! get_the_category_list() ) { return; }
		?>
		<span class="avt-post-grid-tab-category">
			<?php echo get_the_category_list(' '); ?>
		</span>
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
		<div class="avt-post-grid-tab-excerpt">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_readmore() {
		$settings        = $this->get_settings_for_display();

		if ( ! $this->get_settings('show_readmore') ) {
			return;
		}
		
		$animation = ($this->get_settings('readmore_hover_animation')) ? ' elementor-animation-'.$this->get_settings('readmore_hover_animation') : '';

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['post_grid_tab_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>

		<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-grid-tab-readmore avt-display-inline-block <?php echo esc_attr($animation); ?>">
			<?php echo esc_html($this->get_settings('readmore_text')); ?>
			
			<span class="avt-button-icon-align-<?php echo esc_attr($this->get_settings('icon_align')); ?>">

				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['post_grid_tab_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
				else : ?>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>

			</span>
		</a>
		<?php
	}

	public function render_header($skin = 'default') {
		$settings = $this->get_settings();
		$this->add_render_attribute('post-grid-tab', 'class', ['avt-post-grid-tab', 'avt-post-grid-tab-skin-' . $skin]);

		$this->add_render_attribute(
			[
				'post-grid-tab' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"grid"           => $settings["columns"],
							"tabPadding"     => $settings["tab_padding"]["size"],
							"borderWidth"    => $settings["item_border_width"]["size"],
							"config"         => [
								"layout"     => ( "title" === $settings["grid_tab_item"] ) ? "tab" : "grid",
								"activeTab"  => $settings["active_tab_no"]["size"],
								"showClose"  => ( $settings["show_close"] ) ? true : false,
								"showArrows" => ( $settings["show_arrows"] ) ? true : false,
							],
					      	"responsive"=> [
					      		[
						          	"breakpoint" => 767,
						          	"settings"   => [
						              	"grid"   => $settings["columns_tablet"],
						          	]
						      	],
						      	[
						          	"breakpoint" => 480,
						          	"settings"   => [
						              	"grid"   => $settings["columns_mobile"],
						          	]
						      	]
						    ]
				        ]))
					]
				]
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'post-grid-tab' ); ?>>
		<?php
	}

	public function render_post_grid_tab_item( $post_id, $image_size = 'full' ) {
		$settings = $this->get_settings();
		global $post;

		$this->add_render_attribute( 'post-grid-tab-item', 'avt-grid' );


		if ( $settings['content_image'] and ( $settings['show_title'] or $settings['show_author'] or $settings['show_date'] or $settings['show_comments'] or $settings['show_category'] or $settings['show_excerpt'] or $settings['show_readmore'] ) )  {
			$this->add_render_attribute( 'post-grid-tab-item', 'class', [ 'avt-post-grid-tab-item', 'avt-grid', 'avt-grid-collapse', 'avt-child-width-1-2@m' ] );
			if ('yes' == $settings['content_reverse']) {
				$this->add_render_attribute( 'post-grid-tab-item', 'class', 'avt-flex-row-reverse' );
			}
		} else {			
			$this->add_render_attribute( 'post-grid-tab-item', 'class', [ 'avt-post-grid-tab-item', 'avt-grid', 'avt-child-width-1-1' ] );
		}
		

		?>
		<div <?php echo $this->get_render_attribute_string( 'post-grid-tab-item' ) ?>>
			<?php if ( $settings['content_image'] ) : ?>								
				<?php $this->render_content_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>
			<?php endif; ?> 		
	  		<div class="avt-post-grid-tab-desc">
	  			<div class="avt-post-grid-desc-inner avt-gt-mh">
					<?php $this->render_title(); ?>

	            	<?php if ($settings['show_author'] or $settings['show_date'] or $settings['show_category'] or $settings['show_comments']) : ?>
						<div class="avt-post-grid-tab-meta avt-subnav avt-flex-middle avt-margin-small-top">
							<?php $this->render_author(); ?>
							<?php $this->render_date(); ?>
							<?php $this->render_category(); ?>
							<?php $this->render_comments(); ?>
						</div>
					<?php endif; ?>

					<?php $this->render_excerpt(); ?>
					<?php $this->render_readmore(); ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function render_post() {
		global $post;
		$settings = $this->get_settings();

		?>
		<dt>
			<?php
			if ('title' === $settings['grid_tab_item']) {
				$this->render_tab_title();
			} else {
				$this->render_tab_image(get_post_thumbnail_id( $post->ID ), $settings['thumbnail_size'] );
			}			
			?>
		</dt>
		<dd><?php $this->render_post_grid_tab_item( $post->ID, $settings['content_thumbnail_size'] ); ?></dd>
		<?php
	}
}
