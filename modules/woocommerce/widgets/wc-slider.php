<?php
namespace WidgetPack\Modules\Woocommerce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;
//use WidgetPack\Modules\Woocommerce\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Slider extends Widget_Base {
	private $_query = null;

	public function get_name() {
		return 'avt-wc-slider';
	}

	public function get_title() {
		return AWP . __( 'WC - Slider', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-woocommerce';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'slider', 'woocommerce' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'avt-uikit-icons' ];
	}

	// public function _register_skins() {
	// 	$this->add_skin( new Skins\Skin_Slade( $this ) );
	// }

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'services';
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

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'text_align',
			[
				'label'   => __( 'Text Align', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'left',
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
					'justify' => [
						'title' => __( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
			]
		);

		$this->add_control(
			'vertical_align',
			[
				'label'   => __( 'Vertical Align', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'middle',
				'options' => [
					'top' => [
						'title' => __( 'Top', 'avator-widget-pack' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'avator-widget-pack' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'avator-widget-pack' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'label'   => __( 'Image Size', 'avator-widget-pack' ),
				'exclude' => [ 'custom' ],
				'default' => 'full',
			]
		);

		$this->add_control(
			'content_reverse',
			[
				'label' => __( 'Content Reverse', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settings',
			[
				'label' => __( 'Slider Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'slider_animations',
			[
				'label'     => esc_html__( 'Slider Animations', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'default'   => 'slide',
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
			'autoplay',
			[
				'label'   => __( 'Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => __( 'Autoplay Interval(ms)', 'avator-widget-pack' ),
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
				'label'     => __( 'Pause on Hover', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'slider_size_ratio',
			[
				'label'       => esc_html__( 'Size Ratio', 'avator-widget-pack' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => 'Slider ratio to widht and height, such as 16:9',
			]
		);

		$this->add_control(
			'slider_min_height',
			[
				'label' => esc_html__( 'Minimum Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
			]
		);

		$this->add_control(
			'slider_fullscreen',
			[
				'label' => __( 'Slideshow Fullscreen', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => __( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_price',
			[
				'label'   => __( 'Price', 'avator-widget-pack' ),
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
			'show_rating',
			[
				'label'   => __( 'Rating', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_text',
			[
				'label' => __( 'Show Text', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_cart',
			[
				'label'   => __( 'Add to Cart', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
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
			'show_badge',
			[
				'label'   => __( 'Show Badge', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_thumbnav',
			[
				'label'   => __( 'Show Thumbnav', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_readmore',
			[
				'label'     => __('Read More', 'avator-widget-pack'),
				'condition' => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label'       => esc_html__( 'Read More Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'wc_slider_readmore_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'readmore_icon',
			]
		);

		$this->add_control(
			'readmore_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'wc_slider_readmore_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'readmore_icon_indent',
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
					'wc_slider_readmore_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
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
				'default'   => 'bottom-right',
				'options'   => widget_pack_navigation_position(),
				'condition' => [
					'navigation' => ['arrows'],
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => __( 'Button', 'avator-widget-pack' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Read More', 'avator-widget-pack' ),
				'placeholder' => __( 'Read More', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => __( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => __( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => __( 'Before', 'avator-widget-pack' ),
					'right' => __( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => __( 'Icon Spacing', 'avator-widget-pack' ),
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
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-button-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-button-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
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

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => __( 'Show All', 'avator-widget-pack' ),
					'by_name' => __( 'Manual Selection', 'avator-widget-pack' ),
				],
				'label_block' => true,
			]
		);


		$product_categories = get_terms( 'product_cat' );

		$options = [];
		foreach ( $product_categories as $category ) {
			$options[ $category->slug ] = $category->name;
		}

		$this->add_control(
			'product_categories',
			[
				'label'       => __( 'Categories', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $options,
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'exclude_products',
			[
				'label'       => esc_html__( 'Exclude Product(s)', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder'     => 'product_id',
				'label_block' => true,
				'description' => __( 'Write product id here, if you want to exclude multiple products so use comma as separator. Such as 1 , 2', '' ),
			]
		);

		$this->add_control(
			'posts',
			[
				'label'   => __( 'Product Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'show_product_type',
			[
				'label'   => esc_html__( 'Show Product', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all'      => esc_html__( 'All Products', 'avator-widget-pack' ),
					'onsale'   => esc_html__( 'On Sale', 'avator-widget-pack' ),
					'featured' => esc_html__( 'Featured', 'avator-widget-pack' ),
				],
			]
		);


		$this->add_control(
			'hide_free',
			[
				'label'   => esc_html__( 'Hide Free', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);


		$this->add_control(
			'hide_out_stock',
			[
				'label'   => esc_html__( 'Hide Out of Stock', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'  => esc_html__( 'Date', 'avator-widget-pack' ),
					'price' => esc_html__( 'Price', 'avator-widget-pack' ),
					'sales' => esc_html__( 'Sales', 'avator-widget-pack' ),
					'rand'  => esc_html__( 'Random', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'avator-widget-pack' ),
					'ASC'  => esc_html__( 'Ascending', 'avator-widget-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		

		$this->add_control(
			'content_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-slider-item-content' => 'background: {{VALUE}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __('Content Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => __( 'Item Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-item-inner' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label'     => __( 'Price', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'old_price_heading',
			[
				'label' => __( 'Old Price', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-slider-price del, .avt-wc-slider .avt-slider-skin-price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-slider-price del, .avt-wc-slider .avt-slider-skin-price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'old_price_typography',
				'label'    => __( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-slider .avt-wc-slider-price del, .avt-wc-slider .avt-slider-skin-price del',
			]
		);

		$this->add_control(
			'sale_price_heading',
			[
				'label'     => __( 'Sale Price', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-slider-price, .avt-wc-slider .avt-slider-skin-price, {{WRAPPER}} .avt-wc-slider .avt-wc-slider-price ins, .avt-wc-slider .avt-slider-skin-price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_price_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-slider-price, .avt-wc-slider .avt-slider-skin-price, {{WRAPPER}} .avt-wc-slider .avt-wc-slider-price ins, .avt-wc-slider .avt-slider-skin-price ins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_price_typography',
				'label'    => __( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-slider .avt-wc-slider-price, .avt-wc-slider .avt-slider-skin-price, {{WRAPPER}} .avt-wc-slider .avt-wc-slider-price ins, .avt-wc-slider .avt-slider-skin-price ins',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => __( 'Title', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => [ 'yes' ],
				],
			]
		);

		// $this->add_responsive_control(
		// 	'title_width',
		// 	[
		// 		'label'   => __( 'Width (px)', 'avator-widget-pack' ),
		// 		'type'    => Controls_Manager::SLIDER,
		// 		'range' => [
		// 			'px' => [
		// 				'min' => 50,
		// 				'max' => 550,
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .avt-wc-slider-slade-skin .avt-wc-slider-title' => 'max-width: {{SIZE}}{{UNIT}};',
		// 		],
		// 		'condition' => [
		// 			'_skin!' => '',
		// 		],
		// 	]
		// );

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => __( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => __( 'Spacing', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_rating',
			[
				'label'     => __( 'Rating', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .star-rating:before' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => __( 'Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .star-rating span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_spacing',
			[
				'label'      => __( 'Spacing', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-rating' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => __( 'Text', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// $this->add_responsive_control(
		// 	'text_width',
		// 	[
		// 		'label'   => __( 'Width (px)', 'avator-widget-pack' ),
		// 		'type'    => Controls_Manager::SLIDER,
		// 		'range' => [
		// 			'px' => [
		// 				'min' => 50,
		// 				'max' => 650,
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .avt-wc-slider-slade-skin .avt-wc-slider-text' => 'max-width: {{SIZE}}{{UNIT}};',
		// 		],
		// 		'condition' => [
		// 			'_skin!' => '',
		// 		],
		// 	]
		// );

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => __( 'Text Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-text, .avt-wc-slider .avt-slideshow-items .avt-wc-slider-text p',
			]
		);

		$this->add_responsive_control(
			'text_spacing',
			[
				'label'      => __( 'Spacing', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-slideshow-items .avt-wc-slider-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => __( 'Add to Cart Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_cart' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'add_to_cart_spacing',
			[
				'label'      => __( 'Spacing', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart-readmore' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => __( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_hover_background',
			[
				'label' => __( 'Background', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-add-to-cart a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
					'{{WRAPPER}} .avt-wc-slider-readmore' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-wc-slider-readmore svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider-readmore' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .avt-wc-slider-readmore',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_shadow',
				'selector' => '{{WRAPPER}} .avt-wc-slider-readmore',
			]
		);

		$this->add_responsive_control(
			'readmore_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_space_between',
			[
				'label'     => esc_html__( 'Space Between', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-slider-readmore' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'readmore_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-slider-readmore',
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
					'{{WRAPPER}} .avt-wc-slider-readmore:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-wc-slider-readmore:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider-readmore:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'readmore_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider-readmore:hover' => 'border-color: {{VALUE}};',
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
			'section_style_badge',
			[
				'label'     => __( 'Badge', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'badge_border',
				'label'       => __( 'Border Color', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wc-slider .avt-badge',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'badge_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-wc-slider-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-slider .avt-badge',
			]
		);

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
			'heading_arrows',
			[
				'label'     => __( 'Arrows', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 44,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev svg, {{WRAPPER}} .avt-wc-slider .avt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev svg, {{WRAPPER}} .avt-wc-slider .avt-navigation-next svg' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev:hover svg, {{WRAPPER}} .avt-wc-slider .avt-navigation-next:hover svg' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev svg, {{WRAPPER}} .avt-wc-slider .avt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev:hover svg, {{WRAPPER}} .avt-wc-slider .avt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-next svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'arrows_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wc-slider .avt-navigation-prev svg, {{WRAPPER}} .avt-wc-slider .avt-navigation-next svg',
				'condition'   => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev svg, {{WRAPPER}} .avt-wc-slider .avt-navigation-next svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
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
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'navigation',
							'value'    => 'both',
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

		$this->add_control(
			'heading_dots',
			[
				'label'     => __( 'Dots', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-dotnav li a' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_width',
			[
				'label' => __( 'Active Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-dotnav li.avt-active a' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_responsive_control(
			'active_dot_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-slider .avt-dotnav li.avt-active a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-dotnav li a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-dotnav li.avt-active a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'heading_position',
			[
				'label'     => __( 'Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'navigation!' => 'none',
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
			[
				'label'     => __( 'Arrows Horizontal Offset', 'avator-widget-pack' ),
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
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows'],
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

		$this->add_control(
			'arrows_ncy_position',
			[
				'label'   => __( 'Arrows Vertical Offset', 'avator-widget-pack' ),
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
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows'],
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

		$this->add_control(
			'arrows_acx_position',
			[
				'label'   => __( 'Arrows Horizontal Offset', 'avator-widget-pack' ),
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
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => ['arrows'],
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
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

		$this->add_control(
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
					'{{WRAPPER}} .avt-wc-slider .avt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
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

		$this->add_control(
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

		$this->add_control(
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
					'{{WRAPPER}} .avt-wc-slider .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
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

		$this->add_control(
			'both_cx_position',
			[
				'label'   => __( 'Arrows Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-wc-slider .avt-navigation-next' => 'right: {{SIZE}}px;',
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

		$this->add_control(
			'both_cy_position',
			[
				'label'   => __( 'Dots Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-slider .avt-dots-container' => 'transform: translateY({{SIZE}}px);',
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

	public function render_query() {
		$settings = $this->get_settings();

		$exclude_products = ($settings['exclude_products']) ? explode(',', $settings['exclude_products']) : [];

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $settings['posts'],
			'no_found_rows'       => true,
			'meta_query'          => [],
			'tax_query'           => [ 'relation' => 'AND' ],
			'order'               => $settings['order'],
			'post__not_in'        => $exclude_products,
		);

		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		if ( 'by_name' === $settings['source'] and !empty($settings['product_categories']) ) {			  
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $settings['product_categories'],
				'post__not_in'        => $exclude_products,
			);
		}

		if ( 'yes' == $settings['hide_free'] ) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		if ( 'yes' == $settings['hide_out_stock'] ) {
			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['outofstock'],
					'operator' => 'NOT IN',
				),
			); // WPCS: slow query ok.
		}

		switch ( $settings['show_product_type'] ) {
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'onsale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
		}

		switch ( $settings['orderby'] ) {
			case 'price':
				$query_args['meta_key'] = '_price'; // WPCS: slow query ok.
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand':
				$query_args['orderby'] = 'rand';
				break;
			case 'sales':
				$query_args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
				$query_args['orderby']  = 'meta_value_num';
				break;
			default:
				$query_args['orderby'] = 'date';
		}

		$wp_query = new \WP_Query($query_args);

		return $wp_query;
	}

	public function render_navigation() {
		$settings = $this->get_settings();

		?>
		<div class="avt-position-z-index avt-visible@m avt-position-<?php echo esc_attr($settings['arrows_position']); ?>">
			<div class="avt-arrows-container avt-slidenav-container">
				<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9" avt-slideshow-item="previous"></a>
				<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9" avt-slideshow-item="next"></a>
			</div>
		</div>
		<?php
	}

	public function render_dotnavs() {
		$settings = $this->get_settings();

		?>
		<div class="avt-position-z-index avt-visible@m avt-position-<?php echo esc_attr($settings['dots_position']); ?>">
			<div class="avt-dotnav-wrapper avt-dots-container">
				<ul class="avt-dotnav avt-flex-center">

				    <?php		
					$avt_counter = 0;

					$wp_query = $this->render_query();
					      
					while ( $wp_query->have_posts() ) : $wp_query->the_post();
						$active = (0 == $avt_counter) ? ' avt-active' : '';
						echo '<li class="avt-slideshow-dotnav'.$active.'" avt-slideshow-item=" ' . $avt_counter . ' "><a href="#"></a></li>';
						$avt_counter++;
					endwhile; wp_reset_postdata(); ?>

				</ul>
			</div>
		</div>
		<?php
	}

	public function render_both_navigation() {
		$settings = $this->get_settings();
		?>

		<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="avt-arrows-dots-container avt-slidenav-container ">
				
				<div class="avt-flex avt-flex-middle">
					<div>
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9" avt-slideshow-item="previous"></a>
						
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="avt-dotnav-wrapper avt-dots-container">
							<ul class="avt-dotnav">
							    <?php		
								$avt_counter = 0;
								      
								$wp_query = $this->render_query();

								while ( $wp_query->have_posts() ) : $wp_query->the_post();
									echo '<li class="avt-slideshow-dotnav" avt-slideshow-item="'.$avt_counter.'"><a href="#"></a></li>';
									$avt_counter++;
								endwhile; wp_reset_postdata(); ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<div>
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9" avt-slideshow-item="next"></a>
						
					</div>
					
				</div>
			</div>
		</div>
		
		<?php
	}

	public function render_item_image() {
		$settings = $this->get_settings();
		$image_src = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);

		if ($image_src) :
			echo '<img src="'.esc_url($image_src).'" alt="' . get_the_title() . '">';
		endif;

		return 0;
	}

	public function render_header($skin = 'default') {
		$settings        = $this->get_settings_for_display();
		$slides_settings = [];

		$ratio = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'].":".$settings['slider_size_ratio']['height'] : '1920:768';

		$slider_settings['avt-slideshow'] = wp_json_encode(array_filter([
			"animation"         => $settings["slider_animations"],
			"ratio"             => $ratio,
			"min-height"        => $settings["slider_min_height"]["size"],
			"autoplay"          => ($settings["autoplay"]) ? true : false,
			"autoplay-interval" => $settings["autoplay_interval"],
			"pause-on-hover"    => ("yes" === $settings["pause_on_hover"]) ? true : false,
	    ]));

    	$slider_settings['class'][] = 'avt-wc-slider';

	    if ('both' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'avt-arrows-dots-align-'. $settings['both_position'];
		} elseif ('arrows' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'avt-arrows-align-'. $settings['arrows_position'];
		} elseif ('dots' == $settings['navigation']) {
	    	$slider_settings['class'][] = 'avt-dots-align-'. $settings['dots_position'];
		}

	    $slider_fullscreen = ( $settings['slider_fullscreen'] ) ? ' avt-height-viewport="offset-top: true"' : '';

		?>
		<div <?php echo \widget_pack_helper::attrs($slider_settings); ?>>
			<div class="avt-position-relative avt-visible-toggle">
				<ul class="avt-slideshow-items avt-child-width-1-1"<?php echo esc_attr($slider_fullscreen); ?>>
		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

				?>
				</ul>
				<?php if ('both' == $settings['navigation']) : ?>
					<?php $this->render_both_navigation(); ?>

					<?php if ( 'center' === $settings['both_position'] ) : ?>
						<?php $this->render_dotnavs(); ?>
					<?php endif; ?>

				<?php elseif ('arrows' == $settings['navigation']) : ?>			
					<?php $this->render_navigation(); ?>
				<?php elseif ('dots' == $settings['navigation']) : ?>			
					<?php $this->render_dotnavs(); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public function render_readmore() {
		$settings = $this->get_settings_for_display();
		
		$animation = ($this->get_settings('readmore_hover_animation')) ? ' elementor-animation-'.$this->get_settings('readmore_hover_animation') : '';

		if ( ! isset( $settings['readmore_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['readmore_icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['wc_slider_readmore_icon'] );
		$is_new    = empty( $settings['readmore_icon'] ) && Icons_Manager::is_migration_allowed();

		?>

			<a href="<?php echo esc_url(get_permalink()) ?>" class="avt-wc-slider-readmore <?php echo esc_attr($animation); ?>">
				<?php echo esc_html($this->get_settings('readmore_text')); ?>
				
				<?php if ( $settings['wc_slider_readmore_icon']['value'] ) : ?>
					<span class="avt-button-icon-align-<?php echo esc_attr($this->get_settings('readmore_icon_align')); ?>">

						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $settings['wc_slider_readmore_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $settings['readmore_icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
				<?php endif; ?>

			</a>
			<?php
	}

	public function render_item_content() {
		$settings        = $this->get_settings_for_display();

		?>
        <div class="avt-slideshow-content-wrapper avt-padding avt-text-<?php echo esc_attr($settings['text_align']); ?>">

        	<?php if ($settings['show_price']) : ?>
       			<div class="avt-wc-slider-price">
					<span class="wae-product-price"><?php woocommerce_template_single_price(); ?></span>
				</div>
            <?php endif; ?>

			<?php if ( $settings['show_title'] ) : ?>
				<h2 class="avt-wc-slider-title"><?php the_title(); ?></h2>
			<?php endif; ?>

			<?php if ($settings['show_rating']) : ?>
	           	<div class="avt-wc-rating avt-flex avt-flex-<?php echo esc_attr($settings['text_align']); ?>">
	       			<?php woocommerce_template_loop_rating(); ?>
	   			</div>
	    	<?php endif; ?>

			<?php if ( $settings['show_text'] ): ?>
				<div class="avt-wc-slider-text"><?php the_excerpt(); ?></div>
			<?php endif; ?>

			<?php if ($settings['show_cart']) : ?>
            	<div class="avt-wc-add-to-cart-readmore avt-flex avt-flex-<?php echo esc_attr($settings['text_align']); ?> avt-flex-middle">
					<?php if ($settings['show_cart']) : ?>
                		<div class="avt-wc-add-to-cart">
							<?php woocommerce_template_loop_add_to_cart();?>
						</div>
					<?php endif; ?>

					<?php if ($settings['show_readmore']) : ?>
						<?php $this->render_readmore(); ?>
					<?php endif; ?>

			<?php endif; ?>
				</div>

		</div>
		<?php
	}

	public function render() {
		$settings  = $this->get_settings_for_display();

		$content_reverse = $settings['content_reverse'] ? ' avt-flex-first' : '';

		$this->render_header();

		$wp_query = $this->render_query();

		while ( $wp_query->have_posts() ) : $wp_query->the_post(); global $product; ?>
				    
	        <li class="avt-slideshow-item">
		        <div class="avt-slideshow-item-inner avt-grid avt-grid-collapse avt-height-1-1" avt-grid>
			        <div class="avt-width-1-2@m avt-flex avt-flex-<?php echo esc_attr( $settings['vertical_align'] ); ?> avt-slider-item-content">
			            <?php $this->render_item_content(); ?>
			        </div>

			        <div class="avt-width-1-2@m avt-flex avt-flex-<?php echo esc_attr( $settings['vertical_align'] ); ?> avt-mobile-order<?php echo esc_attr( $content_reverse ); ?>">
				        <div class="avt-position-relative avt-wc-slider-image">
				            
			            	<?php $this->render_item_image(); ?>       

				  			<?php if ( $settings['show_badge'] and $product->is_on_sale() ) : ?>
					  			<div class="avt-badge avt-position-top-left avt-position-small">
						  			<?php woocommerce_show_product_loop_sale_flash(); ?>
					  			</div>
				  			<?php endif; ?>

					    </div>
				    </div>

		        </div>
	        </li>

		<?php endwhile; wp_reset_postdata();

		$this->render_footer();
	}
}
