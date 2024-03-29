<?php
namespace WidgetPack\Modules\EventCalendar\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Annal extends Elementor_Skin_Base {

	public function get_id() {
		return 'annal';
	}

	public function get_title() {
		return __( 'Annal', 'avator-widget-pack' );
	}


	public function render_header() {
		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

		$desktop_cols = $settings['columns'];
		$tablet_cols = $settings['columns_tablet'];
		$mobile_cols = $settings['columns_mobile'];


		?> 
		<div id="avt-event-<?php echo esc_attr($id); ?>" class="avt-event-grid-skin-annal avt-event-calendar">
	  		<div class="avt-grid avt-grid-<?php echo esc_attr($settings['column_gap']); ?> avt-child-width-1-<?php echo esc_attr($mobile_cols); ?> avt-child-width-1-<?php echo esc_attr($tablet_cols); ?>@s avt-child-width-1-<?php echo esc_attr($desktop_cols); ?>@l" avt-grid>

		<?php
	}

	public function render_image() {
		$settings = $this->parent->get_settings_for_display();

		if ( ! $this->parent->get_settings( 'show_image' ) ) {
			return;
		}

		$settings['image'] = [
			'id' => get_post_thumbnail_id(),
		];

		$image_html        = Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' );
		$placeholder_image_src = Utils::get_placeholder_image_src();

		if ( ! $image_html ) {
			$image_html = '<img src="' . esc_url( $placeholder_image_src ) . '" alt="' . get_the_title() . '">';
		}

		?>

		<div class="avt-event-image avt-background-cover">

			<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
				<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>" alt="<?php echo get_the_title(); ?>">
			</a>

		</div>
		<?php
	}

	public function render_date() {
		if ( ! $this->parent->get_settings( 'show_date' ) ) {
			return;
		}

		$start_datetime = tribe_get_start_date();
		$end_datetime = tribe_get_end_date();

		$event_date = tribe_get_start_date( null, false );

		?>
		<span class="avt-event-date">
			<a href="#" title="<?php esc_html_e('Start Date:', 'avator-widget-pack'); echo esc_html($start_datetime); ?>  - <?php esc_html_e('End Date:', 'avator-widget-pack'); echo esc_html($end_datetime); ?>"> 
				<span class="avt-event-day">
					<?php echo esc_html($event_date); ?>
				</span>
			</a>
		</span> 
		<?php
	}

	public function render_meta() {
		$settings = $this->parent->get_settings_for_display();
		if ( ! $this->parent->get_settings( 'show_meta' ) ) {
			return;
		}

		$cost         = ($settings['show_meta_cost']) ? tribe_get_formatted_cost() : '';	
		$more_icon    = ( 'yes' == ( $settings['show_meta_more_btn']) ) ;	

		?>

		<?php if ( !empty($cost) or $more_icon )  : ?>
		<div class="avt-event-meta avt-grid">

			<?php if (!empty($cost)) : ?>
			    <div class="avt-width-auto avt-padding-remove">
				    <div class="avt-event-price">
				    	<a href="#"><?php esc_html_e('Cost:', 'avator-widget-pack'); ?></a>
				    	<a href="#"><?php echo esc_html($cost); ?></a>
				    </div>
			    </div>
			<?php endif; ?>

			<?php if (!empty($more_icon)) : ?>
		    <div class="avt-width-expand avt-text-right">
				<div class="avt-more-icon">
					<a href="#" avt-tooltip="<?php echo esc_html( 'Find out more', 'avator-widget-pack' ); ?>" class="wipa-arrow-right-4" aria-hidden="true"></a>
				</div>
			</div>
			<?php endif; ?>

		</div>
		<?php endif; ?>

		<?php
	}

	public function render_website_address() {
		$settings = $this->parent->get_settings_for_display();

		$address = ($settings['show_meta_location']) ? tribe_address_exists() : '';
		$website = ($settings['show_meta_website']) ? tribe_get_event_website_url() : '';

		?>

		<?php if ( !empty($website) or $address ) : ?>
			<div class="avt-address-website-icon">
				
				<?php if (!empty($website)) : ?>
					<a href="<?php echo esc_url($website); ?>" target="_blank" class="wipa-earth" aria-hidden="true"></a>
				<?php endif; ?>

				<?php if ( $address ) : ?>
					<a href="#" avt-tooltip="<?php echo esc_html( tribe_get_full_address() ); ?>" class="wipa-location" aria-hidden="true"></a>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<?php

	}

	public function render_loop_item( $post ) {
		$settings = $this->parent->get_settings_for_display();	

		?> 
		<div class="avt-event-item">

			<div class="avt-event-item-inner">
			
				<?php $this->render_website_address(); ?>

				<?php $this->render_image(); ?>

			    <div class="avt-event-content">

			        <?php $this->render_date(); ?>

			        <?php $this->parent->render_title(); ?>

		            <?php $this->parent->render_excerpt( $post ); ?>

					<?php $this->render_meta(); ?>

			    </div>

			</div>
			
		</div>
		<?php
	}

	public function render() {

		$settings = $this->parent->get_settings_for_display();

		global $post;

		$start_date = ( 'custom' == $settings['start_date'] ) ? $settings['custom_start_date'] : $settings['start_date'];
		$end_date   = ( 'custom' == $settings['end_date'] ) ? $settings['custom_end_date'] : $settings['end_date'];

		$query_args = array_filter( [
			'start_date'     => $start_date,
			'end_date'       => $end_date,
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'eventDisplay' 	 => ( 'custom' == $settings['start_date'] or 'custom' == $settings['end_date'] ) ? 'custom' : 'all',
			'posts_per_page' => $settings['limit'],
		] );


		if ( 'by_name' === $settings['source'] and !empty($settings['event_categories']) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'tribe_events_cat',
				'field'    => 'slug',
				'terms'    => $settings['event_categories'],
			];
		}

		$query_args = tribe_get_events( $query_args );

		$this->render_header();

		foreach ( $query_args as $post ) {
			
			$this->render_loop_item( $post );

		}

		$this->parent->render_footer();

		wp_reset_postdata();
	}
}