<?php
namespace WidgetPack\Modules\Woocommerce;

use Elementor\Core\Documents_Manager;
use WidgetPack\Base\Widget_Pack_Module_Base;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	const TEMPLATE_MINI_CART = 'cart/mini-cart.php';
	const OPTION_NAME_USE_MINI_CART = 'use_mini_cart_template';

	public static function is_active() {
		return class_exists( 'woocommerce' );
	}

	public function get_name() {
		return 'avt-woocommerce';
	}

	public function get_widgets() {

		$products       = widget_pack_option('wc_products', 'widget_pack_third_party_widget', 'on' );
		$wc_add_to_cart = widget_pack_option('wc_add_to_cart', 'widget_pack_third_party_widget', 'on' );
		$wc_elements    = widget_pack_option('wc_elements', 'widget_pack_third_party_widget', 'on' );
		$wc_categories  = widget_pack_option('wc_categories', 'widget_pack_third_party_widget', 'on' );
		$wc_carousel    = widget_pack_option('wc_carousel', 'widget_pack_third_party_widget', 'on' );
		$wc_slider      = widget_pack_option('wc_slider', 'widget_pack_third_party_widget', 'on' );
		$wc_mini_cart   = widget_pack_option('wc_mini_cart', 'widget_pack_third_party_widget', 'off' );
		

		$widgets = [];

		if ( 'on' === $products ) {
			$widgets[] = 'Products';
		}
		if ( 'on' === $wc_add_to_cart ) {
			$widgets[] = 'Add_To_Cart';
		}
		if ( 'on' === $wc_elements ) {
			$widgets[] = 'Elements';
		} 
		if ( 'on' === $wc_categories ) {
			$widgets[] = 'Categories';
		}
		if ( 'on' === $wc_carousel ) {
			$widgets[] = 'WC_Carousel';
		}
		if ( 'on' === $wc_slider ) {
			$widgets[] = 'WC_Slider';
		}
		if ( 'on' === $wc_mini_cart ) {
			$widgets[] = 'WC_Mini_Cart';
		}

		return $widgets;
	}

	public function woocommerce_locate_template( $template, $template_name, $template_path ) {

		if ( self::TEMPLATE_MINI_CART !== $template_name ) {
			return $template;
		}

		$plugin_path = AWP_MODULES_PATH . 'woocommerce/wc-templates/';

		if ( file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}

		return $template;
	}

	public function widget_pack_mini_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();

		?>
			<span class="avt-mini-cart-inner">
				<span class="avt-cart-button-text">
					<span class="avt-mini-cart-price-amount">
	                    <?php echo WC()->cart->get_cart_subtotal(); ?>
					</span>
				</span>
				<span class="avt-mini-cart-button-icon">
					<span class="avt-cart-badge">
						<?php echo WC()->cart->get_cart_contents_count(); ?>
					</span>
					<span class="avt-cart-icon">
						<i class="eicon" aria-hidden="true"></i>
					</span>
				</span>
			</span>

		<?php
		$fragments['a.avt-mini-cart-button .avt-mini-cart-inner'] = ob_get_clean();
		return $fragments;
	}

	public function add_product_post_class( $classes ) {
		$classes[] = 'product';

		return $classes;
	}

	public function add_products_post_class_filter() {
		add_filter( 'post_class', [ $this, 'add_product_post_class' ] );
	}

	public function remove_products_post_class_filter() {
		remove_filter( 'post_class', [ $this, 'add_product_post_class' ] );
	}

	public function register_wc_hooks() {
		wc()->frontend_includes();
	}

	public function maybe_init_cart() {
		$has_cart = is_a( WC()->cart, 'WC_Cart' );

		if ( ! $has_cart ) {
			$session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
			WC()->session = new $session_class();
			WC()->session->init();
			WC()->cart = new \WC_Cart();
			WC()->customer = new \WC_Customer( get_current_user_id(), true );
		}
	}


	public function __construct() {
		
		parent::__construct();

		if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
			add_action( 'init', [ $this, 'register_wc_hooks' ], 5 );
		}

		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'maybe_init_cart' ] );

		$wc_mini_cart   = widget_pack_option('wc_mini_cart', 'widget_pack_third_party_widget', 'off' );

		if ( 'on' === $wc_mini_cart ) {
			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'widget_pack_mini_cart_fragment' ] );
			add_filter( 'woocommerce_locate_template', [ $this, 'woocommerce_locate_template' ], 12, 3 );
		}

	}
}
