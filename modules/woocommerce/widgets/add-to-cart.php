<?php
namespace WidgetPack\Modules\Woocommerce\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Button;
use WidgetPack\Modules\QueryControl\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Add_To_Cart extends Widget_Button {

	public function get_name() {
		return 'wc-add-to-cart';
	}

	public function get_title() {
		return AWP . esc_html__( 'WC - Add To Cart', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-woocommerce';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'add', 'to', 'cart', 'woocommerce' ];
	}

	public function on_export( $element ) {
		unset( $element['settings']['product_id'] );

		return $element;
	}

	public function unescape_html( $safe_text, $text ) {
		return $text;
	}

	public function get_style_depends() {
		return [ 'widget-pack-font' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_product',
			[
				'label' => esc_html__( 'Product', 'avator-widget-pack' ),
			]
		);

		$post_list = get_posts(['numberposts' => 50, 'post_type' => 'product',]);

		$post_list_options = ['0' => esc_html__( 'Select Post', 'avator-widget-pack' ) ];

		foreach ( $post_list as $list ) :
			$post_list_options[ $list->ID ] = $list->post_title;
		endforeach;

		$this->add_control(
			'product_id',
			[
				'label' => esc_html__( 'Product', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $post_list_options,
				'default'     => ['0'],
			]
		);

		$this->add_control(
			'show_quantity',
			[
				'label'     => esc_html__( 'Show Quantity', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'avator-widget-pack' ),
				'label_on'  => esc_html__( 'Show', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'quantity',
			[
				'label'     => esc_html__( 'Quantity', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'condition' => [
					'show_quantity' => '',
				],
			]
		);

		$this->end_controls_section();

		parent::_register_controls();

		$this->update_control(
			'link',
			[
				'type'    => Controls_Manager::HIDDEN,
				'default' => [
					'url' => '',
				],
			]
		);

		$this->update_control(
			'text',
			[
				'default'     => esc_html__( 'Add to Cart', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Add to Cart', 'avator-widget-pack' ),
			]
		);

		$this->update_control(
			'icon',
			[
				'default' => 'ep-cart',
			]
		);

		$this->update_control(
			'background_color',
			[
				'default' => '#61ce70',
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( ! empty( $settings['product_id'] ) ) {
			$product_id = $settings['product_id'];
		} elseif ( \Elementor\Utils::is_ajax() ) {
			$product_id = esc_attr($_POST['post_id']);
		} else {
			$product_id = get_queried_object_id();
		}

		global $product;
		$product = wc_get_product( $product_id );

		if ( 'yes' === $settings['show_quantity']  ) {
			$this->render_form_button( $product );
		} else {
			$this->render_ajax_button( $product );
		}
	}

	/**
	 * @param \WC_Product $product
	 */
	private function render_ajax_button( $product ) {
		$settings    = $this->get_settings_for_display();
		
		if ( $product ) {
			if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
				$product_type = $product->get_type();
			} else {
				$product_type = $product->product_type;
			}

			$class = implode( ' ', array_filter( [
				'product_type_' . $product_type,
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			] ) );

			$this->add_render_attribute( 'button', [
					'rel'             => 'nofollow',
					'href'            => $product->add_to_cart_url(),
					'data-quantity'   => ( isset( $settings['quantity'] ) ? $settings['quantity'] : 1 ),
					'data-product_id' => $product->get_id(),
					'class'           => $class,
				]
			);

		} elseif ( current_user_can( 'manage_options' ) ) {
			$settings['text'] = esc_html__( 'Please set a valid product', 'avator-widget-pack' );
			$this->set_settings( $settings );
		}

		parent::render();
	}

	private function render_form_button( $product ) {
		if ( ! $product && current_user_can( 'manage_options' ) ) {
			echo  esc_html__( 'Please set a valid product', 'avator-widget-pack' );
			return;
		}

		$text_callback = function () {
			ob_start();
			$this->render_text();
			$output = ob_get_clean();
			return $output;
		};

		add_filter( 'woocommerce_get_stock_html', '__return_empty_string' );
		add_filter( 'woocommerce_product_single_add_to_cart_text', $text_callback );
		add_filter( 'esc_html', [ $this, 'unescape_html' ], 10 ,2 );

		ob_start();
		woocommerce_template_single_add_to_cart();
		$form = ob_get_clean();
		$form = str_replace( 'single_add_to_cart_button', 'single_add_to_cart_button elementor-button', $form );
		echo esc_attr($form);

		remove_filter( 'woocommerce_product_single_add_to_cart_text', $text_callback );
		remove_filter( 'woocommerce_get_stock_html', '__return_empty_string' );
		remove_filter( 'esc_html', [ $this, 'unescape_html' ] );
	}

	// Force remote render
	protected function _content_template() {}
}
