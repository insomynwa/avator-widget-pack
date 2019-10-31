<?php
/**
 * Plugin Name: Avator Widget Pack
 * Description: Elementor add-on plugin widget pack
 * Author: Mr.Lorem
 * Version: 3.2.8
 *
 * Text Domain: avator-widget-pack
 * Domain Path: /languages
 * Elementor requires at least: 2.6.0
 * Elementor tested up to: 2.7.3
 */

// Some pre define value for easy use
define( 'AWP_VER', '3.2.8' );
define( 'AWP__FILE__', __FILE__ );
define( 'AWP_PNAME', basename( dirname(AWP__FILE__)) );
define( 'AWP_PBNAME', plugin_basename(AWP__FILE__) );
define( 'AWP_PATH', plugin_dir_path( AWP__FILE__ ) );
define( 'AWP_MODULES_PATH', AWP_PATH . 'modules/' );
define( 'AWP_INC_PATH', AWP_PATH . 'includes/' );
define( 'AWP_URL', plugins_url( '/', AWP__FILE__ ) );
define( 'AWP_ASSETS_URL', AWP_URL . 'assets/' );
define( 'AWP_ASSETS_PATH', AWP_PATH . 'assets/' );
define( 'AWP_MODULES_URL', AWP_URL . 'modules/' );

// Helper function here
require(dirname(__FILE__).'/includes/helper.php');
require(dirname(__FILE__).'/includes/utils.php');

/**
 * Plugin load here correctly
 * Also loaded the language file from here
 */
function avator_widget_pack_load_plugin() {
    load_plugin_textdomain( 'avator-widget-pack', false, basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'avator_widget_pack_fail_load' );
		return;
	}

	// Admin settings controller
    require( AWP_PATH . 'includes/class-settings-api.php' );
    // widget pack admin settings here
    require( AWP_PATH . 'includes/admin-settings.php' );
	// Element pack widget and assets loader
    require( AWP_PATH . 'loader.php' );
    // Notice class
    require( AWP_PATH . '/includes/admin-notice.php' );
}
add_action( 'plugins_loaded', 'avator_widget_pack_load_plugin', 9 );


/**
 * Check Elementor installed and activated correctly
 */
function avator_widget_pack_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }
		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
		$admin_message = '<p>' . esc_html__( 'Ops! Widget Pack not working because you need to activate the Elementor plugin first.', 'avator-widget-pack' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'avator-widget-pack' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) { return; }
		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		$admin_message = '<p>' . esc_html__( 'Ops! Widget Pack not working because you need to install the Elementor plugin', 'avator-widget-pack' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'avator-widget-pack' ) ) . '</p>';
	}

	echo '<div class="error">' . $admin_message . '</div>';
}

/**
 * Check the elementor installed or not
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {

    function _is_elementor_installed() {
        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();

        return isset( $installed_plugins[ $file_path ] );
    }
}