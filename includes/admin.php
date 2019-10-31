<?php
namespace WidgetPack;

use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'after_setup_theme', [$this, 'whitelabel'] );
	}

	/**
	 * You can easily add white label branding for extended license or multi site license. Don't try for regular license otherwise your license will be invalid.
	 * @return [type] [description]
	 * Define AWP_WL for execute white label branding
	 */
	public function whitelabel() {
		if (defined('AWP_WL')) {

			add_filter( 'gettext', [$this, 'widget_pack_name_change'], 20, 3 );

			if ( defined('AWP_HIDE') ) {
				add_action( 'pre_current_active_plugins', [$this, 'hide_widget_pack'] );
			}

		} else {
			// add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 2 );
		}
	}

	public function enqueue_styles() {

		$suffix = is_rtl() ? '.rtl' : '';

		wp_register_style( 'avator-widget-pack-admin', AWP_ASSETS_URL . 'css/admin' . $suffix . '.css', AWP_VER );

		wp_enqueue_style( 'avator-widget-pack-admin' );
	}


	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		if ( AWP_PBNAME === $plugin_file ) {
			$row_meta = [
				'docs' => '<a href="https://widgetpack.pro/contact/" aria-label="' . esc_attr( __( 'Go for Get Support', 'avator-widget-pack' ) ) . '" target="_blank">' . __( 'Get Support', 'avator-widget-pack' ) . '</a>',
				'video' => '<a href="https://www.youtube.com/playlist?list=PLP0S85GEw7DOJf_cbgUIL20qqwqb5x8KA" aria-label="' . esc_attr( __( 'View Widget Pack Video Tutorials', 'avator-widget-pack' ) ) . '" target="_blank">' . __( 'Video Tutorials', 'avator-widget-pack' ) . '</a>',
			];

			$plugin_meta = array_merge( $plugin_meta, $row_meta );
		}

		return $plugin_meta;
	}

	//Change Widget Pack Name
	public function widget_pack_name_change( $translated_text, $text, $domain ) {
		switch ( $translated_text ) {
		    case 'Widget Pack' :
		        $translated_text = AWP_TITLE;
		        break;
		}
		return $translated_text;
	}

	//hiding plugins //still in testing purpose 
	public function hide_widget_pack() {
	  global $wp_list_table;
	  $hide_plg_array = array('avator-widget-pack/avator-widget-pack.php');
	  $all_plugins = $wp_list_table->items;
	  
	  foreach ($all_plugins as $key => $val) {
	    if (in_array($key,$hide_plg_array)) {
	      unset($wp_list_table->items[$key]);
	    }
	  }	
	}
}
