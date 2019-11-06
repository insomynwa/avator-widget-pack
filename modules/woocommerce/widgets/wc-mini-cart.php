<?php
namespace WidgetPack\Modules\Woocommerce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use WidgetPack\Widget_Pack_Loader;
use Elementor\Icons_Manager;
use WidgetPack\Modules\Woocommerce\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Mini cart widget
 * @since 4.0.0
 */
class WC_Mini_Cart extends Widget_Base {

	public function get_name() {
		return 'avt-wc-mini-cart';
	}

	public function get_title() {
		return AWP . esc_html__( 'WC - Mini Cart', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-woocommerce';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'mini cart', 'cart', 'wc', 'woocommerce' ];
	}

	public function get_script_depends() {
		return [ 'avt-uikit-icons', 'wipa-woocommerce' ];
	}

	public function get_style_depends() {
		return [ 'wipa-woocommerce' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_mini_cart',
			[
				'label' => esc_html__( 'Mini Cart', 'avator-widget-pack' ),
			]
		);


		$this->add_control(
			'show_price_amount',
			[
				'label'   => esc_html__( 'Show Price Amount', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'prefix_class' => 'wc-cart-price--',
			]
		);

		$this->add_control(
			'show_cart_icon',
			[
				'label'   => esc_html__( 'Show Cart Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'prefix_class' => 'wc-cart-icon--',
			]
		);
		
		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'avator-widget-pack' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'cart-light'    => __( 'Cart', 'avator-widget-pack' ) . ' ' . __( 'Light', 'avator-widget-pack' ),
					'cart-medium'   => __( 'Cart', 'avator-widget-pack' ) . ' ' . __( 'Medium', 'avator-widget-pack' ),
					'cart-solid'    => __( 'Cart', 'avator-widget-pack' ) . ' ' . __( 'Solid', 'avator-widget-pack' ),
					'basket-light'  => __( 'Basket', 'avator-widget-pack' ) . ' ' . __( 'Light', 'avator-widget-pack' ),
					'basket-medium' => __( 'Basket', 'avator-widget-pack' ) . ' ' . __( 'Medium', 'avator-widget-pack' ),
					'basket-solid'  => __( 'Basket', 'avator-widget-pack' ) . ' ' . __( 'Solid', 'avator-widget-pack' ),
					'bag-light'     => __( 'Bag', 'avator-widget-pack' ) . ' ' . __( 'Light', 'avator-widget-pack' ),
					'bag-medium'    => __( 'Bag', 'avator-widget-pack' ) . ' ' . __( 'Medium', 'avator-widget-pack' ),
					'bag-solid'     => __( 'Bag', 'avator-widget-pack' ) . ' ' . __( 'Solid', 'avator-widget-pack' ),
				],
				'default' => 'cart-medium',
				'prefix_class' => 'wc-cart-icon--',
				'condition' => [
					'show_cart_icon' => ['yes'],
				]
			]
		);

		$this->add_control(
			'show_cart_badge',
			[
				'label'   => esc_html__( 'Show Badge', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'prefix_class' => 'wc-cart-badge--',
			]
		);

		$this->add_responsive_control(
			'mini_cart_align',
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
				'prefix_class' => 'elementor%s-align-',
				'default'      => 'left',
			]
		);

		$this->add_control(
			'mini_cart_icon_indent',
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
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Offcanvas', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'custom_widget_cart_title',
			[
				'label'   => esc_html__( 'Cart Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Shopping Cart', 'avator-widget-pack' ),
				'separator' => 'after',
			]
		);

		$this->add_control(
			'custom_content_before_switcher',
			[
				'label' => esc_html__( 'Custom Content Before', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'custom_content_after_switcher',
			[
				'label' => esc_html__( 'Custom Content After', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'offcanvas_overlay',
			[
				'label'        => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'offcanvas_animations',
			[
				'label'     => esc_html__( 'Animations', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slide',
				'options'   => [
					'slide'  => esc_html__( 'Slide', 'avator-widget-pack' ),
					'push'   => esc_html__( 'Push', 'avator-widget-pack' ),
					'reveal' => esc_html__( 'Reveal', 'avator-widget-pack' ),
					'none'   => esc_html__( 'None', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'offcanvas_flip',
			[
				'label'        => esc_html__( 'Flip', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'right',
			]
		);

		$this->add_control(
			'offcanvas_close_button',
			[
				'label'   => esc_html__( 'Close Button', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'offcanvas_bg_close',
			[
				'label'   => esc_html__( 'Close on Click Background', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'offcanvas_esc_close',
			[
				'label'   => esc_html__( 'Close on Press ESC', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'offcanvas_width',
			[
				'label'      => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 240,
						'max' => 1200,
					],
					'vw' => [
						'min' => 10,
						'max' => 100,
					]
				],
				'selectors' => [
					'body:not(.avt-offcanvas-flip) #avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'width: {{SIZE}}{{UNIT}};left: -{{SIZE}}{{UNIT}};',
					'body:not(.avt-offcanvas-flip) #avt-offcanvas-{{ID}}.avt-offcanvas.avt-open>.avt-offcanvas-bar' => 'left: 0;',
					'.avt-offcanvas-flip #avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'width: {{SIZE}}{{UNIT}};right: -{{SIZE}}{{UNIT}};',
					'.avt-offcanvas-flip #avt-offcanvas-{{ID}}.avt-offcanvas.avt-open>.avt-offcanvas-bar' => 'right: 0;',
				],
				'condition' => [
					'offcanvas_animations!' => ['push', 'reveal'],
				]
			]
		);


		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_custom_before',
			[
				'label'     => esc_html__( 'Custom Content Before', 'avator-widget-pack' ),
				'condition' => [
					'custom_content_before_switcher' => 'yes',
				]
			]
		);

		$this->add_control(
			'custom_content_before',
			[
				'label'   => esc_html__( 'Custom Content Before', 'avator-widget-pack' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'This is your custom content for before of your offcanvas.', 'avator-widget-pack' ),
			]
		);
		
		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_custom_after',
			[
				'label'     => esc_html__( 'Custom Content After', 'avator-widget-pack' ),
				'condition' => [
					'custom_content_after_switcher' => 'yes',
				]
			]
		);


		$this->add_control(
			'custom_content_after',
			[
				'label'   => esc_html__( 'Custom Content After', 'avator-widget-pack' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'This is your custom content for after of your offcanvas.', 'avator-widget-pack' ),
			]
		);
		
		$this->end_controls_section();

		//Style

		$this->start_controls_section(
			'section_style_mini_cart_content',
			[
				'label' => esc_html__( 'Mini Cart', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mini_cart_price_amount_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-wrapper .avt-cart-button-text .avt-mini-cart-price-amount *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mini_cart_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'mini_cart_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button',
			]
		);

		$this->add_control(
			'mini_cart_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mini_cart_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_amount_typography',
				'selector' => '{{WRAPPER}} .avt-mini-cart-wrapper .avt-cart-button-text',
			]
		);

		$this->add_control(
			'mini_cart_icon_style',
			[
				'label' 	=> __( 'Cart Icon', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mini_cart_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button-icon .avt-cart-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'mini_cart_icon_typography',
				'selector' => '{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button-icon .avt-cart-icon i',
			]
		);
		
		$this->add_control(
			'mini_cart_badge_style',
			[
				'label' 	=> __( 'Cart Badge', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mini_cart_badge_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button-icon .avt-cart-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mini_cart_badge_background_color',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button-icon .avt-cart-badge' => 'background: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cart_badge_typography',
				'selector' => '{{WRAPPER}} .avt-mini-cart-wrapper .avt-mini-cart-button-icon .avt-cart-badge',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_content',
			[
				'label' => esc_html__( 'Offcanvas', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_style_offcanvas_content' );

		$this->start_controls_tab(
			'tab_style_product_cart',
			[
				'label' => esc_html__( 'Product List', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'product_cart_main_title_color',
			[
				'label'     => esc_html__( 'Cart Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas .avt-widget-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_cart_main_title_border_color',
			[
				'label'     => esc_html__( 'Cart Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas .avt-widget-title' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_cart_main_title_typography',
				'selector' => '{{WRAPPER}} .avt-offcanvas .avt-widget-title',
			]
		);

		$this->add_control(
			'product_cart_style',
			[
				'label' 	=> __( 'Product Cart', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_cart_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_cart_title_hover_color',
			[
				'label'     => esc_html__( 'Title Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-name a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_cart_title_typography',
				'selector' => '{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-name a',
			]
		);

		$this->add_control(
			'product_cart_item_border_color',
			[
				'label'     => esc_html__( 'Item Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item' => 'border-color: {{VALUE}};',
				],
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'product_cart_quantity_price_style',
			[
				'label' 	=> __( 'Price', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_cart_quantity_color',
			[
				'label'     => esc_html__( 'Quantity Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_cart_price_color',
			[
				'label'     => esc_html__( 'Amount Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .widget_shopping_cart_content .amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_cart_price_typography',
				'selector' => '{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-price',
			]
		);

		$this->add_control(
			'product_cart_image_style',
			[
				'label' 	=> __( 'Image', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'product_cart_image_border',
				'label'       => esc_html__( 'Image Border', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-thumbnail img',
			]
		);

		$this->add_responsive_control(
			'product_cart_image_radius',
			[
				'label'      => esc_html__( 'Image Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'product_cart_subtotal_style',
			[
				'label' 	=> __( 'Subtotal', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_cart_subtotal_color',
			[
				'label'     => esc_html__( 'Subtotal Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-subtotal' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_cart_subtotal_tax_color',
			[
				'label'     => esc_html__( 'Tax Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-subtotal small' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_cart_subtotal_typography',
				'selector' => '{{WRAPPER}} .avt-mini-cart-subtotal',
			]
		);

		$this->add_control(
			'product_cart_viewcart_button_style',
			[
				'label' 	=> __( 'View Cart Button', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pc_viewcart_text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart .avt-button-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_viewcart_button_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart:hover .avt-button-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_viewcart_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_viewcart_background_hover_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'pc_viewcart_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart',
			]
		);

		$this->add_control(
			'pc_viewcart_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'pc_viewcart_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_viewcart_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pc_viewcart_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pc_viewcart_shadow',
				'selector' => '{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'pc_viewcart_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector'  => '{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-view-cart .avt-button-text',
			]
		);

		$this->add_control(
			'product_cart_checkout_button_style',
			[
				'label' 	=> __( 'Checkout Button', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pc_checkout_text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout .avt-button-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_checkout_button_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout:hover .avt-button-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_checkout_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_checkout_background_hover_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'pc_checkout_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout',
			]
		);

		$this->add_control(
			'pc_checkout_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'pc_checkout_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_checkout_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pc_checkout_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pc_checkout_shadow',
				'selector' => '{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'pc_checkout_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector'  => '{{WRAPPER}} .avt-mini-cart-footer-buttons .avt-button-checkout .avt-button-text',
			]
		);

		$this->add_control(
			'product_cart_remove_button_style',
			[
				'label' 	=> __( 'Product Remove Button', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pc_remove_text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a svg *' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_remove_button_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a:hover svg *' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_remove_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_remove_background_hover_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'pc_remove_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a',
			]
		);

		$this->add_control(
			'pc_remove_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'pc_remove_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pc_remove_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pc_remove_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pc_remove_shadow',
				'selector' => '{{WRAPPER}} .avt-mini-cart-product-item .avt-mini-cart-product-remove a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_offcanvas_after_before',
			[ 
				'label' => esc_html__( 'Content', 'avator-widget-pack' ),
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name'     => 'custom_content_before_switcher',
							'value'    => 'yes',
						],
						[
							'name'  => 'custom_content_after_switcher',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'offcanvas_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-custom-content-before.widget, {{WRAPPER}} .avt-offcanvas-custom-content-after.widget' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-custom-content-before.widget, {{WRAPPER}} .avt-offcanvas-custom-content-after.widget'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-offcanvas-custom-content-before.widget *, {{WRAPPER}} .avt-offcanvas-custom-content-after.widget *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-offcanvas-custom-content-before.widget:hover, {{WRAPPER}} .avt-offcanvas-custom-content-after.widget:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'offcanvas_content_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector'  => '{{WRAPPER}} .avt-offcanvas-custom-content-before.widget, {{WRAPPER}} .avt-offcanvas-custom-content-after.widget',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_offcanvas_content',
			[
				'label' => esc_html__( 'Offcanvas', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'offcanvas_content_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'offcanvas_content_shadow',
				'selector'  => '#avt-offcanvas-{{ID}}.avt-offcanvas > div',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'offcanvas_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_close_button',
			[
				'label'     => esc_html__( 'Offcanvas Close Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'offcanvas_close_button' => 'yes'
				]
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
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_bg',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'close_button_shadow',
				'selector'  => '#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'close_button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'close_button_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'close_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close:hover' => 'background-color: {{VALUE}};',
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
					'#avt-offcanvas-{{ID}}.avt-offcanvas .avt-offcanvas-close:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render_button() {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-offcanvas-' . $this->get_id();

		if ( null === WC()->cart ) {
			return;
		}

		global $woocommerce;

		$this->add_render_attribute( 'button', 'class', ['avt-offcanvas-button', 'avt-mini-cart-button'] );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		$this->add_render_attribute( 'button', 'avt-toggle', 'target: #' . esc_attr($id) );
		$this->add_render_attribute( 'button', 'href', '#' );

		$product_count = WC()->cart->get_cart_contents_count();
		
		?> 

		<div class="avt-mini-cart-wrapper">
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?> >

				<span class="avt-mini-cart-inner">
					<span class="avt-cart-button-text">
						<span class="avt-mini-cart-price-amount">

	                        <?php echo WC()->cart->get_cart_subtotal(); ?>

						</span>

					</span>

					<span class="avt-mini-cart-button-icon">

	                    <?php if ( $product_count != 0 ) : ?>
	                    <span class="avt-cart-badge"><?php echo esc_html($product_count); ?></span>
	                    <?php endif; ?>

						<span class="avt-cart-icon">
							<i class="eicon" aria-hidden="true"></i>
						</span>

					</span>
				</span>

			</a>
		</div>

		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-offcanvas-' . $this->get_id();

		global $woocommerce;

		$this->add_render_attribute( 'offcanvas', 'class', 'avt-offcanvas' );
		$this->add_render_attribute( 'offcanvas', 'id', $id );
        $this->add_render_attribute(
        	[
        		'offcanvas' => [
        			'data-settings' => [
        				wp_json_encode(array_filter([
							'id'      =>  $id,
        		        ]))
        			]
        		]
        	]
        );

		$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'mode: ' . $settings['offcanvas_animations'] . ';' );

		if ( $settings['offcanvas_overlay'] ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'overlay: true;' );
		}

		if ( 'right' == $settings['offcanvas_flip'] ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'flip: true;' );
		}

		if ( 'yes' !== $settings['offcanvas_bg_close'] ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'bg-close: false;' );
		}

		if ( 'yes' !== $settings['offcanvas_esc_close'] ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas', 'esc-close: false;' );
		}

		?>

		<?php $this->render_button(); ?>

	    <div <?php echo $this->get_render_attribute_string( 'offcanvas' ); ?>>
	        <div class="avt-offcanvas-bar avt-text-left">
				
				<?php if ($settings['offcanvas_close_button']) : ?>
	        		<button class="avt-offcanvas-close" type="button" avt-close></button>
				<?php endif; ?>
				
					<div class="avt-widget-title">
						<?php echo wp_kses_post($settings['custom_widget_cart_title']); ?>
					</div>

	        	
		        	<?php if ($settings['custom_content_before_switcher'] === 'yes' and !empty($settings['custom_content_before'])) : ?>
		        	<div class="avt-offcanvas-custom-content-before widget">
		            	<?php echo wp_kses_post($settings['custom_content_before']); ?>		        		
		        	</div>
		        	<?php endif; ?>

					<?php the_widget( 'WC_Widget_Cart', '' ); ?>

	            	<?php if ($settings['custom_content_after_switcher'] === 'yes' and !empty($settings['custom_content_after'])) : ?>
	            	<div class="avt-offcanvas-custom-content-after widget">
	                	<?php echo wp_kses_post($settings['custom_content_after']); ?>		        		
	            	</div>
	            	<?php endif; ?>
	        </div>
	    </div>

		<?php
	}

	public function render_plain_content() {}
}
