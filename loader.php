<?php
namespace WidgetPack;

use Elementor\Plugin;
use WidgetPack\Includes\Widget_Pack_WPML;
use WidgetPack\Includes\Widget_Pack_Template_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main class for widget pack
 */
class Widget_Pack_Loader {

	/**
	 * @var Widget_Pack_Loader
	 */
	private static $_instance;

	/**
	 * @var Manager
	 */
	private $_modules_manager;

	private $classes_aliases = [
		'WidgetPack\Modules\PanelPostsControl\Module' => 'WidgetPack\Modules\QueryControl\Module',
		'WidgetPack\Modules\PanelPostsControl\Controls\Group_Control_Posts' => 'WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts',
		'WidgetPack\Modules\PanelPostsControl\Controls\Query' => 'WidgetPack\Modules\QueryControl\Controls\Query',
	];

	public $elements_data = [
		'sections' => [],
		'columns'  => [],
		'widgets'  => [],
	];

	/**
	 * @deprecated
	 *
	 * @return string
	 */
	public function get_version() {
		return AWP_VER;
	}

	/**
	 * return active theme
	 */
	public function get_theme() {
		return wp_get_theme();
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'avator-widget-pack' ), '1.6.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'avator-widget-pack' ), '1.6.0' );
	}

	/**
	 * @return \Elementor\Widget_Pack_Loader
	 */

	public static function elementor() {
		return Plugin::$instance;
	}

	/**
	 * @return Widget_Pack_Loader
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	

	/**
	 * we loaded module manager + admin php from here
	 * @return [type] [description]
	 */
	private function _includes() {

		require AWP_INC_PATH . 'modules-manager.php';
		require AWP_INC_PATH . 'class-elements-wpml-compatibility.php';
		require AWP_INC_PATH . 'class-template-manager.php';

		// Rooten theme header footer compatibility 
		if ('Rooten' === $this->get_theme()->name or 'Rooten' === $this->get_theme()->parent_theme) {
			if (!class_exists('RootenCustomTemplate')) {
				require AWP_INC_PATH . 'class-rooten-theme-compatibility.php';
			}
		}

		if ( is_admin() ) {
			if(!defined('AWP_CH')) {
				require AWP_INC_PATH . 'admin.php';
				// Load admin class for admin related content process
				new Admin();
			}
		}

	}

	/**
	 * Autoloader function for all classes files
	 * @param  [type] $class [description]
	 * @return [type]        [description]
	 */
	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$has_class_alias = isset( $this->classes_aliases[ $class ] );

		// Backward Compatibility: Save old class name for set an alias after the new class is loaded
		if ( $has_class_alias ) {
			$class_alias_name = $this->classes_aliases[ $class ];
			$class_to_load    = $class_alias_name;
		} else {
			$class_to_load    = $class;
		}

		if ( ! class_exists( $class_to_load ) ) {
			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);
			$filename = AWP_PATH . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include( $filename );
			}
		}

		if ( $has_class_alias ) {
			class_alias( $class_alias_name, $class );
		}
	}

	/**
	 * Register all script that need for any specific widget on call basis.
	 * @return [type] [description]
	 */
	public function register_site_scripts() {

		$suffix   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$settings = get_option( 'widget_pack_api_settings' );

		wp_register_script( 'avt-uikit-icons', AWP_ASSETS_URL . 'js/avt-uikit-icons' . $suffix . '.js', ['jquery', 'avt-uikit'], '3.0.3', true );
		wp_register_script( 'goodshare', AWP_ASSETS_URL . 'vendor/js/goodshare' . $suffix . '.js', ['jquery'], '4.1.2', true );
		wp_register_script( 'twentytwenty', AWP_ASSETS_URL . 'vendor/js/jquery.twentytwenty' . $suffix . '.js', ['jquery'], '0.1.0', true );
		wp_register_script( 'eventmove', AWP_ASSETS_URL . 'vendor/js/jquery.event.move' . $suffix . '.js', ['jquery'], '2.0.0', true );
		wp_register_script( 'aspieprogress', AWP_ASSETS_URL . 'vendor/js/jquery-asPieProgress' . $suffix . '.js', ['jquery'], '0.4.7', true );
		wp_register_script( 'morphext', AWP_ASSETS_URL . 'vendor/js/morphext' . $suffix . '.js', ['jquery'], '2.4.7', true );
		wp_register_script( 'qrcode', AWP_ASSETS_URL . 'vendor/js/jquery-qrcode' . $suffix . '.js', ['jquery'], '0.14.0', true );
		wp_register_script( 'jplayer', AWP_ASSETS_URL . 'vendor/js/jquery.jplayer' . $suffix . '.js', ['jquery'], '2.9.2', true );
		wp_register_script( 'circle-menu', AWP_ASSETS_URL . 'vendor/js/jQuery.circleMenu' . $suffix . '.js', ['jquery'], '0.1.1', true );
		wp_register_script( 'cookieconsent', AWP_ASSETS_URL . 'vendor/js/cookieconsent' . $suffix . '.js', ['jquery'], '3.1.0', true );
		wp_register_script( 'gridtab', AWP_ASSETS_URL . 'vendor/js/gridtab' . $suffix . '.js', ['jquery'], '2.1.1', true );
		
		if (!empty($settings['google_map_key'])) {
			wp_register_script( 'gmap-api', '//maps.googleapis.com/maps/api/js?key='.$settings['google_map_key'], ['jquery'], null, true );
		} else {
			wp_register_script( 'gmap-api', '//maps.google.com/maps/api/js?sensor=true', ['jquery'], null, true );
		}
		
		wp_register_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js', ['jquery'], null, true );

		wp_register_script( 'chart', AWP_ASSETS_URL . 'vendor/js/chart' . $suffix . '.js', ['jquery'], '2.7.3', true );
		wp_register_script( 'gmap', AWP_ASSETS_URL . 'vendor/js/gmap' . $suffix . '.js', ['jquery', 'gmap-api'], null, true );
		wp_register_script( 'leaflet', AWP_ASSETS_URL . 'vendor/js/leaflet' . $suffix . '.js', ['jquery'], '', true );
		wp_register_script( 'parallax', AWP_ASSETS_URL . 'vendor/js/parallax' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'table-of-content', AWP_ASSETS_URL . 'vendor/js/table-of-content' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'instagram-feed', AWP_ASSETS_URL . 'vendor/js/jquery.instagramFeed' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'imagezoom', AWP_ASSETS_URL . 'vendor/js/jquery.imagezoom' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'datatables', AWP_ASSETS_URL . 'vendor/js/datatables' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'typed', AWP_ASSETS_URL . 'vendor/js/typed' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'timeline', AWP_ASSETS_URL . 'vendor/js/timeline' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'popper', AWP_ASSETS_URL . 'vendor/js/popper' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'tippyjs', AWP_ASSETS_URL . 'vendor/js/tippy.all' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'tilt', AWP_ASSETS_URL . 'vendor/js/tilt.jquery' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'rvslider', AWP_ASSETS_URL . 'vendor/js/rvslider' . $suffix . '.js', ['jquery'], null, true );
		wp_register_script( 'spritespin', AWP_ASSETS_URL . 'vendor/js/spritespin' . $suffix . '.js', ['jquery'], '4.0.5', true );

		wp_register_script( 'particles', AWP_ASSETS_URL . 'vendor/js/particles' . $suffix . '.js', ['jquery'], '2.0.0', true );
		wp_register_script( 'recliner', AWP_ASSETS_URL . 'vendor/js/recliner' . $suffix . '.js', ['jquery'], '0.2.2', true );
		wp_register_script( 'wipa-justified-gallery', AWP_ASSETS_URL . 'vendor/js/jquery.justifiedGallery' . $suffix . '.js', ['jquery'], '1.0.0', true );


		if (!empty($settings['disqus_user_name'])) {
			wp_register_script( 'disqus', '//'.$settings['disqus_user_name'].'.disqus.com/count.js', ['jquery'], null, true );
		}
	}

	public function register_site_styles() {
		$direction_suffix = is_rtl() ? '.rtl' : '';

        // third party widget css
        wp_register_style( 'twentytwenty', AWP_ASSETS_URL . 'css/twentytwenty.css', [], AWP_VER );
        wp_register_style( 'datatables', AWP_ASSETS_URL . 'css/datatables' . $direction_suffix . '.css', [], AWP_VER );
        wp_register_style( 'imagezoom', AWP_ASSETS_URL . 'css/imagezoom' . $direction_suffix . '.css', [], AWP_VER );
        wp_register_style( 'cookie-consent', AWP_ASSETS_URL . 'css/cookie-consent' . $direction_suffix . '.css', [], AWP_VER );

        wp_register_style( 'widget-pack-font', AWP_ASSETS_URL . 'css/widget-pack-font' . $direction_suffix . '.css', [], AWP_VER );

	}

	/**
	 * Loading site related style from here.
	 * @return [type] [description]
	 */
	public function enqueue_site_styles() {

		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_enqueue_style( 'avt-uikit', AWP_ASSETS_URL . 'css/avt-uikit' . $direction_suffix . '.css', [], '3.2' );
		wp_enqueue_style( 'widget-pack-site', AWP_ASSETS_URL . 'css/widget-pack-site' . $direction_suffix . '.css', [], AWP_VER );		
	}


	/**
	 * Loading site related script that needs all time such as uikit.
	 * @return [type] [description]
	 */
	public function enqueue_site_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'avt-uikit', AWP_ASSETS_URL . 'js/avt-uikit' . $suffix . '.js', ['jquery'], AWP_VER );
		wp_enqueue_script( 'widget-pack-site', AWP_ASSETS_URL . 'js/widget-pack-site' . $suffix . '.js', ['jquery', 'elementor-frontend'], AWP_VER );

		$script_config = [ 
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'nonce'         => wp_create_nonce( 'widget-pack-site' ),
			'data_table' => [
				'language'    => [
			        'lengthMenu' => sprintf(esc_html_x('Show %1s Entries', 'DataTable String', 'avator-widget-pack'), '_MENU_' ),
			        'info'       => sprintf(esc_html_x('Showing %1s to %2s of %3s entries', 'DataTable String', 'avator-widget-pack'), '_START_', '_END_', '_TOTAL_' ),
			        'search'     => esc_html_x('Search :', 'DataTable String', 'avator-widget-pack'),
			        'paginate'   => [
			            'previous' => esc_html_x('Previous', 'DataTable String', 'avator-widget-pack'),
			            'next'     => esc_html_x('Next', 'DataTable String', 'avator-widget-pack'),
			        ],
				],
			],
			'contact_form' => [
				'sending_msg' => esc_html_x('Sending message please wait...', 'Contact Form String', 'avator-widget-pack'),
				'captcha_nd'  => esc_html_x('Invisible captcha not defined!', 'Contact Form String', 'avator-widget-pack'),
				'captcha_nr'  => esc_html_x('Could not get invisible captcha response!', 'Contact Form String', 'avator-widget-pack'),

			],
			'mailchimp' => [
				'subscribing' => esc_html_x( 'Subscribing you please wait...', 'Mailchimp String', 'avator-widget-pack'),
			],
			'elements_data' => $this->elements_data,
		];


		// localize for user login widget ajax login script
	    wp_localize_script( 'avt-uikit', 'widget_pack_ajax_login_config', array( 
			'ajaxurl'        => admin_url( 'admin-ajax.php' ),
			'loadingmessage' => esc_html__('Sending user info, please wait...', 'avator-widget-pack'),
	    ));

	    $script_config = apply_filters( 'widget_pack/frontend/localize_settings', $script_config );

	    // TODO for editor script
		wp_localize_script( 'avt-uikit', 'WidgetPackConfig', $script_config );

	}

	public function enqueue_editor_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'widget-pack', AWP_ASSETS_URL . 'js/widget-pack-editor' . $suffix . '.js', ['backbone-marionette', 'elementor-common-modules', 'elementor-editor-modules',], AWP_VER, true );

		// $locale_settings = [
		// 	'i18n' => [],
		// 	'urls' => [
		// 		'modules' => AWP_MODULES_URL,
		// 	],
		// ];

		// $locale_settings = apply_filters( 'widget_pack/editor/localize_settings', $locale_settings );

		// wp_localize_script(
		// 	'widget-pack',
		// 	'WidgetPackConfig',
		// 	$locale_settings
		// );
	}

	public function enqueue_admin_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'widget-pack-admin', AWP_ASSETS_URL . 'js/widget-pack-admin' . $suffix . '.js', ['jquery'], AWP_VER, true );
	}

	/**
	 * Load editor editor related style from here
	 * @return [type] [description]
	 */
	public function enqueue_preview_styles() {
		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_enqueue_style('widget-pack-preview', AWP_ASSETS_URL . 'css/widget-pack-preview' . $direction_suffix . '.css', '', AWP_VER );
	}


	public function enqueue_editor_styles() {
		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_register_style('widget-pack-editor', AWP_ASSETS_URL . 'css/widget-pack-editor' . $direction_suffix . '.css', '', AWP_VER );
		wp_enqueue_style('widget-pack-editor');
	}


	/**
	 * Callback to shortcode.
	 * @param array $atts attributes for shortcode.
	 */
	public function shortcode_template( $atts ) {

		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'rooten_custom_template'
		);

		$id = ! empty( $atts['id'] ) ? intval( $atts['id'] ) : '';

		if ( empty( $id ) ) {
			return '';
		}

		return self::$elementor_instance->frontend->get_builder_content_for_display( $id );

	}


	/**
	 * Add widget_pack_ajax_login() function with wp_ajax_nopriv_ function 
	 * @return [type] [description]
	 */
	public function widget_pack_ajax_login_init() {
	    // Enable the user with no privileges to run widget_pack_ajax_login() in AJAX
	    add_action( 'wp_ajax_nopriv_widget_pack_ajax_login', [ $this, "widget_pack_ajax_login"] );

	}

	/**
	 * For ajax login
	 * @return [type] [description]
	 */
	public function widget_pack_ajax_login(){
	    // First check the nonce, if it fails the function will break
	    check_ajax_referer( 'ajax-login-nonce', 'avt-user-login-sc' );

	    // Nonce is checked, get the POST data and sign user on
		$access_info                  = [];
		$access_info['user_login']    = !empty($_POST['user_login'])?$_POST['user_login'] : "";
		$access_info['user_password'] = !empty($_POST['user_password'])?$_POST['user_password'] : "";
		$access_info['remember']      = !empty($_POST['rememberme'])? true : false;
		$user_signon                  = wp_signon( $access_info, false );

	    if ( !is_wp_error($user_signon) ){
	        echo wp_json_encode( ['loggedin' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'avator-widget-pack')] );
	    } else {
	        echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Ops! Wrong username or password!', 'avator-widget-pack')] );
	    }

	    die();
	}


	public function widget_pack_ajax_search() {
	    global $wp_query;

	    $result = array('results' => array());
	    $query  = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';

	    if (strlen($query) >= 3) {

			$wp_query->query_vars['posts_per_page'] = 5;
			$wp_query->query_vars['post_status']    = 'publish';
			$wp_query->query_vars['s']              = $query;
			$wp_query->is_search                    = true;

	        foreach ($wp_query->get_posts() as $post) {

	            $content = !empty($post->post_excerpt) ? strip_tags(strip_shortcodes($post->post_excerpt)) : strip_tags(strip_shortcodes($post->post_content));

	            if (strlen($content) > 180) {
	                $content = substr($content, 0, 179).'...';
	            }

	            $result['results'][] = array(
	                'title' => $post->post_title,
	                'text'  => $content,
	                'url'   => get_permalink($post->ID)
	            );
	        }
	    }

	    die(json_encode($result));
	}

	// Load WPML compatibility instance
	public function wpml_compatiblity() {
		return Widget_Pack_WPML::get_instance();
	}


	/**
	 * initialize the category
	 * @return [type] [description]
	 */
	public function widget_pack_init() {
		$this->_modules_manager = new Manager();

		$elementor = Plugin::$instance;

		// Add element category in panel
		$elementor->elements_manager->add_category( AWP_SLUG, [ 'title' => AWP_TITLE, 'icon'  => 'font' ] );
		
		do_action( 'avator_widget_pack/init' );
	}

	public function widget_pack_template_library() {

		return Widget_Pack_Template_Manager::get_instance();

	}

	private function setup_hooks() {
		add_action( 'elementor/init', [ $this, 'widget_pack_init' ] );
		
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );

		add_action( 'elementor/frontend/before_register_styles', [ $this, 'register_site_styles' ] );
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_site_scripts' ] );

		add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_preview_styles' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );

		add_action( 'elementor/frontend/after_register_styles', [ $this, 'enqueue_site_styles' ] );
		add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_site_scripts' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

		// TODO AJAX SEARCH
		add_action('wp_ajax_widget_pack_search', [ $this, 'widget_pack_ajax_search' ] );
		add_action('wp_ajax_nopriv_widget_pack_search', [ $this, 'widget_pack_ajax_search' ] );

		add_shortcode( 'rooten_custom_template', [ $this, 'shortcode_template' ] );


		// When user not login add this action
		if (!is_user_logged_in()) {
			add_action('elementor/init', [ $this, 'widget_pack_ajax_login_init'] );
		}
	}

	/**
	 * Widget_Pack_Loader constructor.
	 */
	private function __construct() {
		// Register class automatically
		spl_autoload_register( [ $this, 'autoload' ] );
		// Include some backend files
		$this->_includes();

		// Finally hooked up all things here
		$this->setup_hooks();

		$this->wpml_compatiblity()->init();

		$this->widget_pack_template_library()->init();

	}
}

if ( ! defined( 'AWP_TESTS' ) ) {
	// In tests we run the instance manually.
	Widget_Pack_Loader::instance();
}

// handy fundtion for push data
function widget_pack_config() {
	return Widget_Pack_Loader::instance();
}