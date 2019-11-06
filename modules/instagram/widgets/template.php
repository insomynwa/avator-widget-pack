
<?php

	if ( $_REQUEST['show_lightbox'] ) {
		$link_url =  esc_url( $insta_feeds[$i]['image']['large'] );
	} else {
		$link_url = esc_url( $insta_feeds[ $i ]['link'] );
	}

	?>

	<div class="avt-instagram-item-wrapper feed-type-<?php echo esc_attr( $insta_feeds[ $i ]['post_type'] ); ?>">
		<div class="avt-instagram-item avt-transition-toggle avt-position-relative avt-scrollspy-inview avt-animation-fade">
			<div class="avt-instagram-thumbnail">
				<img src="<?php echo esc_url($insta_feeds[$i]['image']['medium']); ?>" alt="<?php esc_html_e( 'Image by:', 'avator-widget-pack' ); ?> <?php echo esc_html($insta_feeds[ $i ]['user']['full_name']); ?> " avt-img>
				
			</div>

			<?php if ( $_REQUEST['show_lightbox'] or $_REQUEST['show_link'] ) : ?>
			<a href="<?php echo $link_url; ?>" data-elementor-open-lightbox="no">

				<div class='avt-transition-fade avt-inline-clip avt-position-cover avt-overlay avt-overlay-default '>
					<span class='avt-position-center' avt-overlay-icon></span>


					<div class='avt-instagram-like-comment avt-flex-center avt-child-width-auto avt-grid'>
						<?php if ( $_REQUEST['show_like'] ) : ?>
							<span><span class='wipa-heart-empty'></span> <b><?php echo esc_attr( $insta_feeds[ $i ]['like'] ); ?></b></span>
						<?php endif; ?>							
						<?php if ( $_REQUEST['show_comment'] ) : ?>
							<span><span class='wipa-bubble'></span> <b><?php echo esc_attr( $insta_feeds[ $i ]['comment']['count'] ); ?></b></span>
						<?php endif; ?>							
					</div>

				</div>
				            			
			
			</a>
			<?php endif; ?>

		</div>

		
	</div>
						