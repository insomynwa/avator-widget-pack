<?php
namespace WidgetPack\Modules\Woocommerce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

use WidgetPack\Modules\Woocommerce\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Products extends Widget_Base {

	public function get_name() {
		return 'avt-wc-products';
	}

	public function get_title() {
		return AWP . esc_html__( 'WC - Products', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-woocommerce';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'product', 'woocommerce', 'table' ];
	}

	public function get_script_depends() {
		return [ 'datatables', 'wipa-woocommerce' ];
	}

	public function get_style_depends() {
		return [ 'wipa-woocommerce', 'datatables', 'widget-pack-font' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/3VkvEpVaNAM';
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Table( $this ) );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_woocommerce_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-products-wrapper.avt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .avt-wc-products .avt-wc-products-wrapper.avt-grid > *' => 'padding-left: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-products-wrapper.avt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .avt-wc-products .avt-wc-products-wrapper.avt-grid > *' => 'margin-top: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .star-rating' => 'text-align: {{VALUE}}; display: inline-block !important',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'table_header_alignment',
			[
				'label'   => esc_html__( 'Header Alignment', 'avator-widget-pack' ),
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
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products table th' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'table_data_alignment',
			[
				'label'   => esc_html__( 'Data Alignment', 'avator-widget-pack' ),
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
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products table td' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'label'     => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'exclude'   => [ 'custom' ],
				'default'   => 'medium',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_filter_bar',
			[
				'label' => esc_html__( 'Show Filter', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'condition'    => [
					'_skin'      => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'masonry',
			[
				'label'       => esc_html__( 'Masonry', 'avator-widget-pack' ),
				'description' => esc_html__( 'Masonry will not work if you not set filter.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => [
					'columns!' => '1',
					'_skin'		=> '',
				],
			]
		);

		$this->add_control(
			'show_info',
			[
				'label'   => esc_html__( 'Footer Info', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition'    => [
					'_skin'           => 'avt-table',
					'show_pagination' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => esc_html__( 'Query', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__( 'Show All', 'avator-widget-pack' ),
					'by_name' => esc_html__( 'Manual Selection', 'avator-widget-pack' ),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'product_categories',
			[
				'label'       => esc_html__( 'Categories', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => widget_pack_get_category( 'product_cat' ),
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
			'posts_per_page',
			[
				'label'   => esc_html__( 'Product Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label' => esc_html__( 'Pagination', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
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
			'section_woocommerce_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'     => esc_html__( 'Show Badge', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_thumb',
			[
				'label'   => esc_html__( 'Show Thumbnail', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'open_thumb_in_lightbox',
			[
				'label'      => esc_html__( 'Open Thumb in Lightbox', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SWITCHER,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'show_thumb',
							'value'    => 'yes',
						],
						[
							'name'  => '_skin',
							'value' => 'avt-table',
						],
					],
				],
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
			'show_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'excerpt_limit',
			[
				'label'      => esc_html__( 'Excerpt Limit', 'avator-widget-pack' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 10,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes',
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'   => esc_html__( 'Rating', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'show_price',
			[
				'label'   => esc_html__( 'Price', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_categories',
			[
				'label'     => esc_html__( 'Categories', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin' => 'avt-table',
				],
			]
		);


		$this->add_control(
			'show_tags',
			[
				'label'     => esc_html__( 'Tags', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin' => 'avt-table',
				],
			]
		);

		$this->add_control(
			'show_cart',
			[
				'label'   => esc_html__( 'Add to Cart', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_searching',
			[
				'label'   => esc_html__( 'Search', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_ordering',
			[
				'label'   => esc_html__( 'Ordering', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

	

		$this->add_control(
			'thumb_hide_on_mobile',
			[
				'label'        => esc_html__( 'Thumb Hide on mobile ?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-thumb-hide-on-mobile-',
				'condition'    => [
					'show_thumb' => 'yes',
					'_skin'      => 'avt-table',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_hide_on_mobile',
			[
				'label'        => esc_html__( 'Title Hide on mobile ?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-title-hide-on-mobile-',
				'condition'    => [
					'show_title' => 'yes',
					'_skin'      => 'avt-table',
				]
			]
		);

		$this->add_control(
			'excerpt_hide_on_mobile',
			[
				'label'        => esc_html__( 'Description Hide on mobile ?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-excerpt-hide-on-mobile-',
				'condition'    => [
					'show_excerpt' => 'yes',
					'_skin'        => 'avt-table',
				]
			]
		);

		$this->add_control(
			'price_hide_on_mobile',
			[
				'label'        => esc_html__( 'Price Hide on mobile ?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-price-hide-on-mobile-',
				'condition'    => [
					'show_price' => 'yes',
					'_skin'      => 'avt-table',
				]
			]
		);

		$this->add_control(
			'categories_hide_on_mobile',
			[
				'label'        => esc_html__( 'Categories Hide on mobile ?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-categories-hide-on-mobile-',
				'condition'    => [
					'show_categories' => 'yes',
					'_skin'           => 'avt-table',
				]
			]
		);

		$this->add_control(
			'tags_hide_on_mobile',
			[
				'label'        => esc_html__( 'Tags Hide on mobile ?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-tags-hide-on-mobile-',
				'condition'    => [
					'show_tags' => 'yes',
					'_skin'     => 'avt-table',
				]
			]
		);

		$this->add_control(
			'rating_hide_on_mobile',
			[
				'label'        => esc_html__( 'Rating Hide on mobile ?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-rating-hide-on-mobile-',
				'condition'    => [
					'show_rating' => 'yes',
					'_skin'       => 'avt-table',
				]
			]
		);

		$this->add_control(
			'cart_hide_on_mobile',
			[
				'label'        => esc_html__( 'Cart Hide on mobile ?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-cart-hide-on-mobile-',
				'condition'    => [
					'show_cart' => 'yes',
					'_skin'     => 'avt-table',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_item',
			[
				'label'     => esc_html__( 'Item', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => false,
						],
					],
					'color' => [
						'default' => '#eee',
					],
				],
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Item Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'desc_padding',
			[
				'label'      => esc_html__( 'Description Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-inner:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_table',
			[
				'label'     => esc_html__( 'Table', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_table_style' );

		$this->start_controls_tab(
			'tab_table_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'table_header_typography',
				'label'    => esc_html__( 'Header Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-products table th',
			]
		);

		$this->add_control(
			'table_heading_background',
			[
				'label'     => esc_html__( 'Heading Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products table th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_heading_color',
			[
				'label'     => esc_html__( 'Heading Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products table th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products table td'                  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .avt-wc-products table th'                  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .avt-wc-products table.dataTable.no-footer' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'cell_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_odd_row_background',
			[
				'label'     => esc_html__( 'Odd Row Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products table.dataTable.stripe tbody tr.odd' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'stripe' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_even_row_background',
			[
				'label'     => esc_html__( 'Even Row Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products table.dataTable.stripe tbody tr.even' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'stripe' => 'yes',
				],
			]
		);

		$this->add_control(
			'cell_border',
				[
				'label'     => esc_html__( 'Cell Border', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'stripe',
				[
				'label'     => esc_html__( 'stripe', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'hover_effect',
				[
				'label'     => esc_html__( 'Hover Effect', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'table_cell_padding',
			[
				'label'      => esc_html__( 'Cell Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products table.avt-wc-product td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_table_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'table_odd_row_hover_background',
			[
				'label'     => esc_html__( 'Odd Row Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products table.dataTable.stripe tbody tr:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'stripe' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_field_style',
			[
				'label' => esc_html__( 'Search Field', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_searching' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_search_field_style' );

		$this->start_controls_tab(
			'tab_search_field_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'search_field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'search_field_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wc-products input[type*="search"], {{WRAPPER}} .avt-wc-products select',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'search_field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_field_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'search_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .dataTables_filter label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .dataTables_filter' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'search_text_typography',
				'label'     => esc_html__( 'Text Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-wc-products .dataTables_filter label',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_search_field_focus',
			[
				'label' => esc_html__( 'Focus', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'search_field_focus_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_focus_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_focus_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_field_focus_border_width',
			[
				'label'   => __( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]:focus' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'search_field_focus_border_radius',
			[
				'label'   => __( 'Border Radius', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products input[type*="search"]:focus' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_select_field_style',
			[
				'label'     => esc_html__( 'Select Field', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_select_field_style' );

		$this->start_controls_tab(
			'tab_select_field_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'select_field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products select'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'select_field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'select_field_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wc-products select',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'select_field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'select_field_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'select_text_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'select_field_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .dataTables_length label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'select_text_typography',
				'label'     => esc_html__( 'Text Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-wc-products .dataTables_length label',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_select_field_focus',
			[
				'label' => esc_html__( 'Focus', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'select_field_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'select_field_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products select:focus'   => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'label'    => esc_html__( 'Image Border', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product-image',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'image_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product-image',
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
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_title_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product-title',
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
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product-excerpt',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_rating',
			[
				'label'     => esc_html__( 'Rating', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .star-rating:before' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => esc_html__( 'Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .star-rating span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .star-rating span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label'     => esc_html__( 'Price', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-price .amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'old_price_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product-price del',
			]
		);

		$this->add_control(
			'sale_price_heading',
			[
				'label'     => esc_html__( 'Sale Price', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-price, {{WRAPPER}} .avt-wc-products .avt-wc-product .avt-wc-product-price ins .amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_price_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product-price, {{WRAPPER}} .avt-wc-products .avt-wc-product-price ins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_price_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product-price, {{WRAPPER}} .avt-wc-products .avt-wc-product-price ins',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
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
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_fullwidth',
			[
				'label'     => esc_html__( 'Fullwidth Button', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a' => 'width: 100%;',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a',
				'separator' => 'before',
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
					'{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-add-to-cart a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'badge_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'badge_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-badge',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'badge_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'badge_shadow',
				'selector' => '{{WRAPPER}} .avt-wc-products .avt-wc-product .avt-badge',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_pagination',
			[
				'label'     => esc_html__( 'Footer', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_datatable_footer_style' );

		$this->start_controls_tab(
			'tab_datatable_info',
			[
				'label' => __( 'Page Info', 'avator-widget-pack' )
			]
		);

		$this->add_responsive_control(
			'info_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .dataTables_info' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'info_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dataTables_info' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'info_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .dataTables_info',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_datatable_pagination',
			[
				'label' => esc_html__( 'Pagination', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination'    => 'margin-top: {{SIZE}}px;',
					'{{WRAPPER}} .dataTables_paginate' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a'    => 'color: {{VALUE}};',
					'{{WRAPPER}} ul.avt-pagination li span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .paginate_button'          => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'active_pagination_color',
			[
				'label'     => esc_html__( 'Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li.avt-active a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .paginate_button.current'          => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_margin',
			[
				'label'     => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a'    => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} ul.avt-pagination li span' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .paginate_button'          => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_arrow_size',
			[
				'label'     => esc_html__( 'Arrow Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a svg' => 'height: {{SIZE}}px; width: auto;',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ul.avt-pagination li a, {{WRAPPER}} ul.avt-pagination li span, {{WRAPPER}} .dataTables_paginate',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_categories',
			[
				'label'      => esc_html__( 'Categories', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => '_skin',
							'value' => 'avt-table',
						],
						[
							'name'  => 'show_categories',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'categories_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-product-categories a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-wc-product-categories'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'categories_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-product-categories, {{WRAPPER}} .avt-wc-product-categories a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tags',
			[
				'label'      => esc_html__( 'Tags', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => '_skin',
							'value' => 'avt-table',
						],
						[
							'name'  => 'show_tags',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'tags_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wc-product-tags'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-wc-product-tags a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tags_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-wc-product-tags, {{WRAPPER}} .avt-wc-product-tags a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_filter',
			[
				'label'     => esc_html__( 'Filter Bar', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter_bar' => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
				],
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters-wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_filter',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li',
			]
		);

		$this->add_control(
			'filter_spacing',
			[
				'label'     => esc_html__( 'Bottom Space', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_style_desktop' );

		$this->start_controls_tab(
			'filter_tab_desktop',
			[
				'label' => __( 'Desktop', 'avator-widget-pack' )
			]
		);

		$this->add_control(
			'desktop_filter_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_filter_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_filter_padding',
			[
				'label'      => __('Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'desktop_filter_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wipa-grid-filters li'
			]
		);

		$this->add_control(
			'desktop_filter_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_filter_shadow',
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li'
			]
		);

		$this->add_control(
			'filter_item_spacing',
			[
				'label'     => esc_html__( 'Space Between', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters > li.avt-wipa-grid-filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .avt-wipa-grid-filters > li.avt-wipa-grid-filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_control(
			'desktop_filter_active',
			[
				'label' => esc_html__( 'Active', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter_active',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_active_filter_shadow',
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li.avt-active'
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'filter_tab_mobile',
			[
				'label' => __( 'Mobile', 'avator-widget-pack' )
			]
		);

		$this->add_control(
			'filter_mbtn_width',
			[
				'label' => __('Button Width(%)', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 100
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'width: {{SIZE}}%;'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_color',
			[
				'label'     => __( 'Button Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_background',
			[
				'label'     => __( 'Button Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropdown-nav li' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_background',
			[
				'label'     => __( 'Dropdown Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropdown' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filter_mbtn_dropdown_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-dropdown-nav li',
			]
		);

		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_image() {
		$settings = $this->get_settings();
		?>
		<div class="avt-wc-product-image avt-position-relative avt-background-cover">
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>">
			</a>

        	<?php if ('yes' == $settings['show_cart']) : ?>
            	<div class="avt-wc-add-to-cart">
					<?php woocommerce_template_loop_add_to_cart();?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	public function render_header() {

		$settings = $this->get_settings();

		$this->add_render_attribute('wc-products', 'class', ['avt-wc-products', 'avt-wc-products-skin-default']);

		if ( $settings['show_filter_bar'] ) {
			$this->add_render_attribute( 'wc-products', 'avt-filter', 'target: #avt-wc-product-' . $this->get_id() );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wc-products' ); ?>>

		<?php if ( $settings['show_filter_bar'] ) {
			$this->render_filter_menu();
		}
	}

	public function render_footer() {
		?>
		</div>
		<?php
	}

	public function render_query() {
		$settings = $this->get_settings();

		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } 
		elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } 
		else { $paged = 1; }

		$exclude_products = ($settings['exclude_products']) ? explode(',', $settings['exclude_products']) : [];

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'posts_per_page'      => $settings['posts_per_page'],
			'ignore_sticky_posts' => 1,
			'meta_query'          => [],
			'tax_query'           => [ 'relation' => 'AND' ],
			'paged'               => $paged,
			'order'               => $settings['order'],
			'post__not_in'        => $exclude_products,
		);

		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		
		if ( 'by_name' === $settings['source'] and !empty($settings['product_categories']) ) {			  
			$query_args['tax_query'][] = [
				'taxonomy'           => 'product_cat',
				'field'              => 'slug',
				'terms'              => $settings['product_categories'],
				'post__not_in'       => $exclude_products,
			];
		}

		if ( 'yes' == $settings['hide_free'] ) {
			$query_args['meta_query'][] = [
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			];
		}

		if ( 'yes' == $settings['hide_out_stock'] ) {
			$query_args['tax_query'][] = [
				[
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['outofstock'],
					'operator' => 'NOT IN',
				],
			]; // WPCS: slow query ok.
		}


		switch ( $settings['show_product_type'] ) {
			case 'featured':
				$query_args['tax_query'][] = [
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				];
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

	public function render_filter_menu() {
		$settings           = $this->get_settings();
		$product_categories = [];

		$wp_query = $this->render_query();

		if ( 'by_name' === $settings['source'] and !empty($settings['product_categories'] ) ) {
			$product_categories = $settings['product_categories'];
		} else {

			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$terms = get_the_terms( get_the_ID(), 'product_cat' );
    			foreach ($terms as $term) {
    				$product_categories[] = esc_attr($term->slug);
    			};
			endwhile;

            wp_reset_postdata();

			$product_categories = array_unique($product_categories);

		}
		
		?>

		<div class="avt-wipa-grid-filters-wrapper">
			
			<button class="avt-button avt-button-default avt-hidden@m" type="button"><?php esc_html_e( 'Filter', 'avator-widget-pack' ); ?></button>
			<div avt-dropdown="mode: click;" class="avt-dropdown avt-margin-remove-top avt-margin-remove-bottom">
			    <ul class="avt-nav avt-dropdown-nav">

					<li class="avt-wipa-grid-filter avt-active" avt-filter-control><?php esc_html_e( 'All Products', 'avator-widget-pack' ); ?></li>
					
					<?php foreach($product_categories as $product_category => $value) : ?>
						<?php $filter_name = get_term_by('slug', $value, 'product_cat'); ?>
						<li class="avt-wipa-grid-filter" avt-filter-control="[data-filter*='avtf-<?php echo esc_attr(trim($value)); ?>']">
							<?php echo esc_html($filter_name->name); ?>
						</li>				
					<?php endforeach; ?>
			    
			    </ul>
			</div>


			<ul class="avt-wipa-grid-filters avt-visible@m" avt-margin>
				<li class="avt-wipa-grid-filter avt-active" avt-filter-control><?php esc_html_e( 'All Products', 'avator-widget-pack' ); ?></li>
		
				<?php foreach($product_categories as $product_category => $value) : ?>
					<?php $filter_name = get_term_by('slug', $value, 'product_cat'); ?>
					<li class="avt-wipa-grid-filter" avt-filter-control="[data-filter*='avtf-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo esc_html($filter_name->name); ?>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
		<?php		
	}

	public function render_loop_item() {
		$settings = $this->get_settings();
		$id       = 'avt-wc-product-' . $this->get_id();

		$wp_query = $this->render_query();

		if($wp_query->have_posts()) {

			$this->add_render_attribute('wc-products-wrapper', 'avt-grid', '');

			if ( $settings['masonry'] ) {
				$this->add_render_attribute('wc-products-wrapper', 'avt-grid', 'masonry: true');
			}

			$this->add_render_attribute(
				[
					'wc-products-wrapper' => [
						'class' => [
							'avt-wc-products-wrapper',
							'avt-grid',
							'avt-grid-medium',
							'avt-child-width-1-'. $settings['columns_mobile'],
							'avt-child-width-1-'. $settings['columns_tablet'] .'@s',
							'avt-child-width-1-'. $settings['columns'] .'@m',
						],
						'id' => esc_attr( $id ),
					],
				]
			);

			?>
			<div <?php echo $this->get_render_attribute_string( 'wc-products-wrapper' ); ?>>
			<?php			

			$this->add_render_attribute( 'wc-product', 'class', 'avt-wc-product' );

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); global $post, $product; ?>
				
				<?php if( $settings['show_filter_bar'] ) {
			 		$terms = get_the_terms( get_the_ID(), 'product_cat' );
			 		$product_filter_cat = [];
	    			foreach ($terms as $term) {
	    				$product_filter_cat[] = 'avtf-' . esc_attr($term->slug);
	    			};
	    			$this->add_render_attribute( 'wc-product', 'data-filter', implode(' ', $product_filter_cat), true );
    			} ?>

		  		<div <?php echo $this->get_render_attribute_string( 'wc-product' ); ?>>
		  			<div class="avt-wc-product-inner">
		  				<?php if ( $settings['show_badge'] and $product->is_on_sale() ) : ?>
				  			<div class="avt-badge avt-position-top-left avt-position-small">
					  			<?php //woocommerce_show_product_loop_sale_flash(); ?>
					  			<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="avt-onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
				  			</div>
			  			<?php endif; ?>

		               <?php $this->render_image(); ?>

	           			<div class="avt-wc-product-desc">
		               		<?php if ( 'yes' == $settings['show_title']) : ?>
			           			<h2 class="avt-wc-product-title">
			           				<a href="<?php the_permalink(); ?>" class="avt-link-reset">
						               <?php the_title(); ?>
						           </a>
				               </h2>
				            <?php endif; ?>

		           			<?php if (('yes' == $settings['show_price']) or ('yes' == $settings['show_rating'])) : ?>
			               		<?php if ( 'yes' == $settings['show_price']) : ?>
				           			<span class="avt-wc-product-price">
										<?php woocommerce_template_single_price(); ?>
									</span>
					            <?php endif; ?>
						               
				               <?php if ('yes' == $settings['show_rating']) : ?>
					               	<div class="avt-wc-rating">
					           			<?php woocommerce_template_loop_rating(); ?>
				           			</div>
			                	<?php endif; ?>
		                	<?php endif; ?>
						</div>

					</div>
				</div>
			<?php endwhile;	?>
			</div>
			<?php

			if ($settings['show_pagination']) {
				widget_pack_post_pagination($wp_query);
			}

			wp_reset_postdata();
			
		} else {
			echo '<div class="avt-alert-warning" avt-alert>' . esc_html__( 'Ops! There is no product.', 'avator-widget-pack' ) .'<div>';
		}
	}

	public function render() {
		$this->render_header();
		$this->render_loop_item();
		$this->render_footer();
	}
		
}
