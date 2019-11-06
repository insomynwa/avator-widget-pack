<?php

namespace WidgetPack;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

final class Manager {
	private $_modules = [];

	private function is_module_active( $module_id ) {

		$module_data = $this->get_module_data( $module_id );
		$options     = get_option( 'widget_pack_active_modules', [] );

		if ( ! isset( $options[ $module_id ] ) ) {
			return $module_data['default_activation'];
		} else {
			if ( $options[ $module_id ] == "on" ) {
				return true;
			} else {
				return false;
			}
		}
	}

	private function has_module_style( $module_id ) {

		$module_data = $this->get_module_data( $module_id );

		if ( isset( $module_data['has_style'] ) ) {
			return $module_data['has_style'];
		} else {
			return false;
		}

	}

	private function has_module_script( $module_id ) {

		$module_data = $this->get_module_data( $module_id );

		if ( isset( $module_data['has_script'] ) ) {
			return $module_data['has_script'];
		} else {
			return false;
		}

	}

	private function get_module_data( $module_id ) {
		return isset( $this->_modules[ $module_id ] ) ? $this->_modules[ $module_id ] : false;
	}

	public function __construct() {
		$modules = [
			'query-control',
			//all widgets here
			'audio-player',
			'accordion',
			'business-hours',
			'advanced-button',
			'animated-heading',
			'advanced-heading',
			'advanced-icon-box',
			'advanced-gmap',
			'advanced-image-gallery',
			'chart',
			'call-out',
			'carousel',
			'circle-menu',
			'countdown',
			'contact-form',
			'cookie-consent',
			'comment',
			'crypto-currency',
			'custom-gallery',
			'custom-carousel',
			'dual-button',
			'device-slider',
			'document-viewer',
			'dropbar',
			'flip-box',
			'helpdesk',
			'image-compare',
			'image-magnifier',
			'instagram',
			'iconnav',
			'iframe',
			'marker',
			'member',
			'mailchimp',
			'modal',
			'navbar',
			'news-ticker',
			'lightbox',
			'offcanvas',
			'open-street-map',
			'panel-slider',
			'post-card',
			'post-block',
			'single-post',
			'post-grid',
			'post-grid-tab',
			'post-block-modern',
			'post-gallery',
			'post-slider',
			'price-list',
			'price-table',
			'progress-pie',
			'post-list',
			'protected-content',
			'profile-card',
			'qrcode',
			'scrollnav',
			'search',
			'slider',
			'slideshow',
			'social-share',
			'scroll-image',
			'scroll-button',
			'switcher',
			'tabs',
			'timeline',
			'table',
			'table-of-content',
			'toggle',
			'trailer-box',
			'thumb-gallery',
			'threesixty-product-viewer',
			'user-login',
			'user-register',
			'video-player',
			'elementor',
			'twitter-slider',
			'twitter-carousel',
			'video-gallery',
			'weather',
		];

		$faq               = widget_pack_option( 'faq', 'widget_pack_third_party_widget', 'on' );
		$cf_seven          = widget_pack_option( 'contact-form-seven', 'widget_pack_third_party_widget', 'on' );
		$event_calendar    = widget_pack_option( 'event-calendar', 'widget_pack_third_party_widget', 'on' );
		$rev_slider        = widget_pack_option( 'revolution-slider', 'widget_pack_third_party_widget', 'on' );
		$instagram_feed    = widget_pack_option( 'instagram-feed', 'widget_pack_third_party_widget', 'on' );
		$wp_forms          = widget_pack_option( 'wp-forms', 'widget_pack_third_party_widget', 'on' );
		$mailchimp_for_wp  = widget_pack_option( 'mailchimp-for-wp', 'widget_pack_third_party_widget', 'on' );
		$tm_grid           = widget_pack_option( 'testimonial-grid', 'widget_pack_third_party_widget', 'on' );
		$tm_carousel       = widget_pack_option( 'testimonial-carousel', 'widget_pack_third_party_widget', 'on' );
		$tm_slider         = widget_pack_option( 'testimonial-slider', 'widget_pack_third_party_widget', 'on' );
		$woocommerce       = widget_pack_option( 'woocommerce', 'widget_pack_third_party_widget', 'on' );
		$booked_calendar   = widget_pack_option( 'booked-calendar', 'widget_pack_third_party_widget', 'on' );
		$bbpress           = widget_pack_option( 'bbpress', 'widget_pack_third_party_widget', 'on' );
		$layerslider       = widget_pack_option( 'layerslider', 'widget_pack_third_party_widget', 'on' );
		$downloadmonitor   = widget_pack_option( 'download-monitor', 'widget_pack_third_party_widget', 'on' );
		$quform            = widget_pack_option( 'quform', 'widget_pack_third_party_widget', 'on' );
		$ninja_forms       = widget_pack_option( 'ninja-forms', 'widget_pack_third_party_widget', 'on' );
		$caldera_forms     = widget_pack_option( 'caldera-forms', 'widget_pack_third_party_widget', 'on' );
		$gravity_forms     = widget_pack_option( 'gravity-forms', 'widget_pack_third_party_widget', 'on' );
		$buddypress        = widget_pack_option( 'buddypress', 'widget_pack_third_party_widget', 'on' );
		$ed_downloads      = widget_pack_option( 'easy-digital-downloads', 'widget_pack_third_party_widget', 'on' );
		$tablepress        = widget_pack_option( 'tablepress', 'widget_pack_third_party_widget', 'on' );
		$portfolio_gallery = widget_pack_option( 'portfolio-gallery', 'widget_pack_third_party_widget', 'off' );

		// elementor extend
		$widget_parallax     = widget_pack_option( 'widget_parallax_show', 'widget_pack_elementor_extend', 'on' );
		$background_parallax = widget_pack_option( 'section_parallax_show', 'widget_pack_elementor_extend', 'on' );
		$section_sticky      = widget_pack_option( 'section_sticky_show', 'widget_pack_elementor_extend', 'on' );
		$section_particles   = widget_pack_option( 'section_particles_show', 'widget_pack_elementor_extend', 'on' );
		$section_schedule    = widget_pack_option( 'section_schedule_show', 'widget_pack_elementor_extend', 'on' );
		$image_parallax      = widget_pack_option( 'section_parallax_content_show', 'widget_pack_elementor_extend', 'on' );
		$widget_tooltip      = widget_pack_option( 'widget_tooltip_show', 'widget_pack_elementor_extend', 'on' );
		$transform_effects   = widget_pack_option( 'widget_motion_show', 'widget_pack_elementor_extend', 'on' );

		if ( 'on' === $transform_effects ) {
			$modules[] = 'transform-effects';
		}

		if ( 'on' === $widget_tooltip ) {
			$modules[] = 'tooltip';
		}

		if ( 'on' === $image_parallax ) {
			$modules[] = 'image-parallax';
		}
		if ( 'on' === $section_schedule ) {
			$modules[] = 'schedule-content';
		}

		if ( 'on' === $section_particles ) {
			$modules[] = 'particles';
		}

		if ( 'on' === $section_sticky ) {
			$modules[] = 'section-sticky';
		}

		if ( 'on' === $background_parallax ) {
			$modules[] = 'background-parallax';
		}

		if ( 'on' === $widget_parallax ) {
			$modules[] = 'parallax-effects';
		}

		if ( is_plugin_active( 'booked/booked.php' ) and 'on' === $booked_calendar ) {
			$modules[] = 'booked-calendar';
		}

		if ( is_plugin_active( 'avator-portfolio/avator-portfolio.php' ) and 'on' === $portfolio_gallery ) {
			$modules[] = 'portfolio-gallery';
		}

		if ( is_plugin_active( 'bbpress/bbpress.php' ) and 'on' === $bbpress ) {
			$modules[] = 'bbpress';
		}

		if ( is_plugin_active( 'buddypress/bp-loader.php' ) and 'on' === $buddypress ) {
			$modules[] = 'buddypress';
		}

		if ( is_plugin_active( 'caldera-forms/caldera-core.php' ) and 'on' === $caldera_forms ) {
			$modules[] = 'caldera-forms';
		}

		if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) and 'on' === $cf_seven ) {
			$modules[] = 'contact-form-seven';
		}

		if ( is_plugin_active( 'download-monitor/download-monitor.php' ) and 'on' === $downloadmonitor ) {
			$modules[] = 'download-monitor';
		}

		if ( is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) and 'on' === $ed_downloads ) {
			$modules[] = 'easy-digital-downloads';
		}

		if ( is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) and 'on' === $event_calendar ) {
			$modules[] = 'event-calendar';
		}

		if ( is_plugin_active( 'avator-faq/avator-faq.php' ) and 'on' === $faq ) {
			$modules[] = 'faq';
		}

		if ( is_plugin_active( 'gravityforms/gravityforms.php' ) and 'on' === $gravity_forms ) {
			$modules[] = 'gravity-forms';
		}

		if ( is_plugin_active( 'instagram-feed/instagram-feed.php' ) and 'on' === $instagram_feed ) {
			$modules[] = 'instagram-feed';
		}

		if ( is_plugin_active( 'LayerSlider/layerslider.php' ) and 'on' === $layerslider ) {
			$modules[] = 'layer-slider';
		}

		if ( is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) and 'on' === $mailchimp_for_wp ) {
			$modules[] = 'mailchimp-for-wp';
		}

		if ( is_plugin_active( 'ninja-forms/ninja-forms.php' ) and 'on' === $ninja_forms ) {
			$modules[] = 'ninja-forms';
		}

		if ( is_plugin_active( 'revslider/revslider.php' ) and 'on' === $rev_slider ) {
			$modules[] = 'revolution-slider';
		}

		if ( is_plugin_active( 'quform/quform.php' ) and 'on' === $quform ) {
			$modules[] = 'quform';
		}

		if ( is_plugin_active( 'tablepress/tablepress.php' ) and 'on' === $tablepress ) {
			$modules[] = 'tablepress';
		}

		if ( is_plugin_active( 'avator-testimonials/avator-testimonials.php' ) and 'on' === $tm_carousel ) {
			$modules[] = 'testimonial-carousel';
		}
		if ( is_plugin_active( 'avator-testimonials/avator-testimonials.php' ) and 'on' === $tm_grid ) {
			$modules[] = 'testimonial-grid';
		}
		if ( is_plugin_active( 'avator-testimonials/avator-testimonials.php' ) and 'on' === $tm_slider ) {
			$modules[] = 'testimonial-slider';
		}

		if ( ( is_plugin_active( 'wpforms-lite/wpforms.php' ) or is_plugin_active( 'wpforms/wpforms.php' ) ) and 'on' === $wp_forms ) {
			$modules[] = 'wp-forms';
		}

		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) and 'on' === $woocommerce ) {
			$modules[] = 'woocommerce';
		}

		// Fetch all modules data
		foreach ( $modules as $module ) {
			$this->_modules[ $module ] = require AWP_MODULES_PATH . $module . '/module.info.php';
		}

		$direction_suffix = is_rtl() ? '.rtl' : '';
		$suffix           = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		foreach ( $this->_modules as $module_id => $module_data ) {

			if ( ! $this->is_module_active( $module_id ) ) {
				continue;
			}

			$class_name = str_replace( '-', ' ', $module_id );
			$class_name = str_replace( ' ', '', ucwords( $class_name ) );
			$class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

			// register widget css
			if ( $this->has_module_style( $module_id ) ) {
				wp_register_style( 'wipa-' . $module_id, AWP_URL . 'assets/css/wipa-' . $module_id . $direction_suffix . '.css', [], AWP_VER );
			}

			// register widget javascript
			if ( $this->has_module_script( $module_id ) ) {
				wp_register_script( 'wipa-' . $module_id, AWP_URL . 'assets/js/widgets/wipa-' . $module_id . $suffix . '.js', [
					'jquery',
					'avt-uikit',
					'elementor-frontend',
					'widget-pack-site'
				], AWP_VER, true );

			}


			$class_name::instance();

			// error_log( $class_name );
			// error_log( wipa_memory_usage_check() );
		}
	}

}
