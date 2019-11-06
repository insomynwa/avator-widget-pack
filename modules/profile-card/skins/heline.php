<?php
namespace WidgetPack\Modules\ProfileCard\Skins;

use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Heline extends Elementor_Skin_Base {

	public function get_id() {
		return 'heline';
	}

	public function get_title() {
		return esc_html__( 'Heline', 'avator-widget-pack' );
    }

    public function render_social_icon() {
        $settings = $this->parent->get_settings_for_display();

        ?>

        <?php if ($settings['show_social_icon']) : ?>

        <div class="avt-width-expand@s avt-width-1-1 avt-profile-card-share-wrapper">
            <div class="avt-profile-card-share-link avt-margin-medium-top">
                <?php 
                foreach ( $settings['social_link_list'] as $link ) :
                    $tooltip = ( 'yes' == $settings['social_icon_tooltip'] ) ? ' title="'.esc_attr( $link['social_link_title'] ).'" avt-tooltip' : ''; ?>
                    
                    <a href="<?php echo esc_url( $link['social_link'] ); ?>" class="elementor-repeater-item-<?php echo esc_attr($link['_id']); ?>" target="_blank"<?php echo $tooltip; ?>>
                        <?php Icons_Manager::render_icon( $link['social_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php endif; 
    }
    
    public function render_instagram_card() {
		$settings = $this->parent->get_settings_for_display();
        $instagram = widget_pack_instagram_card();

        // print_r($instagram);

		?>

        <div class="avt-profile-card avt-profile-card-heline">
            <div class="avt-profile-card-item avt-flex avt-flex-center">

                <div class="avt-profile-card-header">
                    
                    <?php if ($settings['show_user_menu']) : ?>
                    <div class="avt-profile-card-settings">
                        <a href="#" avt-icon="more"></a>
                    </div>
                    
                    <?php $this->parent->user_dropdown_menu(); ?>

                    <?php endif; ?>

                    <?php if ($settings['show_image']) : ?>
                    <div class="avt-profile-image">
                        <img src="<?php echo esc_url( $instagram['profile_picture'] ); ?>" alt="<?php echo $instagram['full_name']; ?>" />
                    </div>
                    <?php endif; ?>
                    
                </div>

                <div class="avt-profile-card-inner">

                	<?php if ($settings['show_badge']) : ?>
                    <div class="avt-profile-card-pro avt-text-right">
                        <span><?php echo $settings['profile_badge_text']; ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="avt-profile-name-info">

						<?php if ($settings['show_name']) : ?>
                            <h3 class="avt-name">
                                <a class="" href="https://instagram.com/<?php echo esc_html($instagram['username']); ?>"><?php echo wp_kses_post($instagram['full_name']); ?></a>
                            </h3>
                        <?php endif; ?>

						<?php if ($settings['show_username']) : ?>
                            <span class="avt-username"><?php echo $instagram['username']; ?></span>
                        <?php endif; ?>

                    </div>

					<?php if ($settings['show_text']) : ?>
                    <div class="avt-profile-bio">
                        <?php echo wp_kses_post($instagram['bio']); ?>
                    </div>
                    <?php endif; ?>

					<?php if ($settings['show_status']) : ?>
                    <div class="avt-profile-status">
                        <ul>
                            <li>
                                <span class="avt-profile-stat">
                                    <?php echo esc_attr( $instagram['counts']['media'] ); ?>
								</span>
                                <span class="avt-profile-label">
									<?php echo esc_html($settings['instagram_posts']); ?>
								</span>
                            </li>
                            <li>
								<span class="avt-profile-stat">
									<?php echo esc_attr( $instagram['counts']['follows'] ); ?>
								</span>
                                <span class="avt-profile-label">
									<?php echo esc_html($settings['instagram_followers']); ?>
								</span>
                            </li>
                            <li>
                                <span class="avt-profile-stat">
									<?php echo esc_attr( $instagram['counts']['followed_by'] ); ?>
								</span>
                                <span class="avt-profile-label">
									<?php echo esc_html($settings['instagram_following']); ?>
								</span>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
					
					<div class="avt-grid">
						<?php if ($settings['show_button']) : ?>
	                    <div class="avt-width-auto@s avt-width-1-1 avt-profile-button avt-margin-medium-top">
                            <a class="avt-button avt-button-secondary" href="https://instagram.com/<?php echo esc_html($instagram['username']); ?>"><?php echo $settings['instagram_button_text']; ?></a>
	                    </div>
	                    <?php endif; ?>

						<?php $this->render_social_icon(); ?>

                	</div>
                </div>

            </div>
        </div>

		<?php
    }

	public function render_blog_card() {
		$settings = $this->parent->get_settings_for_display();

        ?>
        
        <div class="avt-profile-card avt-profile-card-heline">
            <div class="avt-profile-card-item avt-flex avt-flex-center">

                <div class="avt-profile-card-header">
                    
                    <?php if ($settings['show_user_menu']) : ?>
                    <div class="avt-profile-card-settings">
                        <a href="#" avt-icon="more"></a>
                    </div>
                    
                    <?php $this->parent->user_dropdown_menu(); ?>

                    <?php endif; ?>

                    <?php if ($settings['show_image']) : ?>
                    <div class="avt-profile-image">
                        <img src="<?php echo esc_url( get_avatar_url( $settings['blog_user_id'], [ 'size' => 128 ] ) ); ?>" alt="<?php echo get_the_author_meta('first_name', $settings['blog_user_id']); ?>" />
                    </div>
                    <?php endif; ?>
                    
                </div>

                <div class="avt-profile-card-inner">

                	<?php if ($settings['show_badge']) : ?>
                    <div class="avt-profile-card-pro avt-text-right">
                        <span><?php echo $settings['profile_badge_text']; ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="avt-profile-name-info">

						<?php if ($settings['show_name']) : ?>
                            <h3 class="avt-name"><?php echo get_the_author_meta('first_name', $settings['blog_user_id']); ?> <?php echo get_the_author_meta('last_name', $settings['blog_user_id']); ?></h3>
                        <?php endif; ?>

						<?php if ($settings['show_username']) : ?>
                            <span class="avt-username"><?php echo get_the_author_meta('user_nicename', $settings['blog_user_id']); ?></span>
                        <?php endif; ?>

                    </div>

					<?php if ($settings['show_text']) : ?>
                    <div class="avt-profile-bio">
                        <?php echo get_the_author_meta('description', $settings['blog_user_id']); ?>
                    </div>
                    <?php endif; ?>

					<?php if ($settings['show_status']) : ?>
                    <div class="avt-profile-status">
                        <ul>
                            <li>
                                <span class="avt-profile-stat">
                                    <?php echo count_user_posts( $settings['blog_user_id'] ); ?>
                                </span>
                                <span class="avt-profile-label">
                                    <?php echo esc_html($settings['blog_posts']); ?>
                                </span>
                            </li>
                            <li>
                                <span class="avt-profile-stat">
                                    <?php
                                    $comments_count = wp_count_comments();
                                    echo $comments_count->approved;
                                    ?>
                                </span>
                                <span class="avt-profile-label">
                                    <?php echo esc_html($settings['blog_post_comments']); ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
					
					<div class="avt-grid">
						<?php if ($settings['show_button']) : ?>
	                    <div class="avt-width-auto@s avt-width-1-1 avt-profile-button avt-margin-medium-top">
                            <a class="avt-button avt-button-secondary" href="<?php echo get_author_posts_url($settings['blog_user_id']); ?>"><?php echo $settings['blog_button_text']; ?></a>
	                    </div>
	                    <?php endif; ?>

						<?php $this->render_social_icon(); ?>

                	</div>
                </div>

            </div>
        </div>

		<?php
	}

	public function render_custom_card() {
		$settings = $this->parent->get_settings_for_display();
		
		?>

        <div class="avt-profile-card avt-profile-card-heline">
            <div class="avt-profile-card-item avt-flex avt-flex-center">

                <div class="avt-profile-card-header">
                    
                    <?php if ($settings['show_user_menu']) : ?>
                    <div class="avt-profile-card-settings">
                        <a href="#" avt-icon="more"></a>
                    </div>
                    
                    <?php $this->parent->user_dropdown_menu(); ?>

                    <?php endif; ?>

                    <?php if ($settings['show_image']) : ?>
                    <div class="avt-profile-image">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'profile_image' ); ?>
                    </div>
                    <?php endif; ?>
                    
                </div>

                <div class="avt-profile-card-inner">

                	<?php if ($settings['show_badge']) : ?>
                    <div class="avt-profile-card-pro avt-text-right">
                        <span><?php echo $settings['profile_badge_text']; ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="avt-profile-name-info">

						<?php if ($settings['show_name']) : ?>
                        <h3 class="avt-name"><?php echo $settings['profile_name']; ?></h3>
                        <?php endif; ?>

						<?php if ($settings['show_username']) : ?>
                        <span class="avt-username"><?php echo $settings['profile_username']; ?></span>
                        <?php endif; ?>

                    </div>

					<?php if ($settings['show_text']) : ?>
                    <div class="avt-profile-bio">
                        <?php echo $settings['profile_content']; ?>
                    </div>
                    <?php endif; ?>

					<?php if ($settings['show_status']) : ?>
                    <div class="avt-profile-status">
                        <ul>
                            <li>
                                <span class="avt-profile-stat"><?php echo $settings['profile_posts_number']; ?></span>
                                <span class="avt-profile-label"><?php echo $settings['profile_posts']; ?></span>
                            </li>
                            <li>
                                <span class="avt-profile-stat"><?php echo $settings['profile_followers_number']; ?></span>
                                <span class="avt-profile-label"><?php echo $settings['profile_followers']; ?></span>
                            </li>
                            <li>
                                <span class="avt-profile-stat"><?php echo $settings['profile_following_number']; ?></span>
                                <span class="avt-profile-label"><?php echo $settings['profile_following']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
					
					<div class="avt-grid">
						<?php if ($settings['show_button']) : ?>
	                    <div class="avt-width-auto@s avt-width-1-1 avt-profile-button avt-margin-medium-top">
	                        <a class="avt-button avt-button-secondary" href="#"><?php echo $settings['profile_button_text']; ?></a>
	                    </div>
	                    <?php endif; ?>

						<?php $this->render_social_icon(); ?>

                	</div>
                </div>

            </div>
        </div>

		<?php 
	}

	public function render() {
	    $settings = $this->parent->get_settings_for_display();

	    if ('blog' == $settings['profile']) {
		    $this->render_blog_card();
	   	} elseif ( 'instagram' == $settings['profile']) {
		    $this->render_instagram_card();
	   	} else {
		    $this->render_custom_card();
        }
	}
}

