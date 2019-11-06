<?php
namespace WidgetPack\Modules\ProfileCard\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;

use WidgetPack\Modules\ProfileCard\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Profile_Card extends Widget_Base {
	public function get_name() {
		return 'avt-profile-card';
	}

	public function get_title() {
		return AWP . esc_html__( 'Profile Card', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-profile-card';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'profile card', 'social card', 'social', 'card' ];
	}

	public function get_style_depends() {
		return ['wipa-profile-card'];
	}

	// public function get_script_depends() {
	// 	return [ 'popper', 'tippyjs' ];
	// }

	public function _register_skins() {
		$this->add_skin( new Skins\Heline( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_profile_card_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'profile',
			[
				'label'       => esc_html__( 'Select Profile', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'custom',
				'options'     => [
					'instagram' => esc_html__( 'Instagram', 'avator-widget-pack' ),
					'blog' 		=> esc_html__( 'My Blog', 'avator-widget-pack' ),
					'custom'   	=> esc_html__( 'Custom', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'blog_user_id',
			[
				'label'       => esc_html__( 'User ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( '1' , 'avator-widget-pack' ),
				'condition'   => [
					'profile' => 'blog',
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'profile_badge_text',
			[
				'label'       => esc_html__( 'Badge', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Pro' , 'avator-widget-pack' ),
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'   => __( 'Show Badge', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_user_menu',
			[
				'label'   => __( 'Show User Menu', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'   => __( 'Show Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_name',
			[
				'label'   => __( 'Show Name', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_username',
			[
				'label'   => __( 'Show Username', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'   => __( 'Show Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_status',
			[
				'label'   => __( 'Show Status', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'   => __( 'Show Follow Button', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_social_icon',
			[
				'label'   => __( 'Show Social Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_custom_profile',
			[
				'label' => esc_html__( 'Custom Profile', 'avator-widget-pack' ),
				'condition' => [
					'profile' => 'custom',
				],
			]
		);

		$this->add_control(
			'profile_image',
			[
				'label'   => __( 'Choose Photo', 'avator-widget-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => AWP_ASSETS_URL.'images/member.svg',
				],
			]
		);

		$this->add_control(
			'profile_name',
			[
				'label'       => esc_html__( 'Name', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Adam Smith' , 'avator-widget-pack' ),
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'profile_username',
			[
				'label'       => esc_html__( 'User Name', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( '@adamsmith' , 'avator-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'profile_content',
			[
				'label'      => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'       => Controls_Manager::WYSIWYG,
				'dynamic'    => [ 'active' => true ],
				'default'    => esc_html__( 'Hello, My name is Adam Smith ! I am Web Developer at Avator LTD.', 'avator-widget-pack' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'profile_posts',
			[
				'label'       => esc_html__( 'Posts', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Posts' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'profile_posts_number',
			[
				'label'       => esc_html__( 'Posts Number', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '213' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'profile_followers',
			[
				'label'       => esc_html__( 'Followers', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Followers' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'profile_followers_number',
			[
				'label'       => esc_html__( 'Followers Number', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '423' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'profile_following',
			[
				'label'       => esc_html__( 'Following', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Following' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'profile_following_number',
			[
				'label'       => esc_html__( 'Following Number', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '213' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'profile_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Follow' , 'avator-widget-pack' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_instagram_profile',
			[
				'label' => esc_html__( 'Instagram Profile', 'avator-widget-pack' ),
				'condition' => [
					'profile' => 'instagram',
				],
			]
		);

		$this->add_control(
			'instagram_posts',
			[
				'label'       => esc_html__( 'Posts', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Posts' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'instagram_followers',
			[
				'label'       => esc_html__( 'Followers', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Followers' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'instagram_following',
			[
				'label'       => esc_html__( 'Following', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Following' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'instagram_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Follow' , 'avator-widget-pack' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_blog_profile',
			[
				'label' => esc_html__( 'Blog Profile', 'avator-widget-pack' ),
				'condition' => [
					'profile' => 'blog',
				],
			]
		);

		$this->add_control(
			'blog_posts',
			[
				'label'       => esc_html__( 'Posts', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Posts' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'blog_post_comments',
			[
				'label'       => esc_html__( 'Comments', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Comments' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'blog_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Follow' , 'avator-widget-pack' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_social_link',
			[
				'label' => __( 'Social Icon', 'avator-widget-pack' ),
				'condition' => [
                    'show_social_icon' => 'yes',
                ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_link_title',
			[
				'label'   => __( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Facebook',
			]
		);

		$repeater->add_control(
			'social_link',
			[
				'label'   => __( 'Link', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'http://www.facebook.com/avator/', 'avator-widget-pack' ),
			]
		);

		$repeater->add_control(
			'social_icon',
			[
				'label'   => __( 'Choose Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-facebook-f',
					'library' => 'fa-brands',
				],
			]
		);

		$repeater->add_control(
			'icon_color',
			[
				'label'     => __( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'icon_background',
			[
				'label'     => __( 'Icon Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'social_link_list',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => [
					[
						'social_link'       => __( 'http://www.facebook.com/avator/', 'avator-widget-pack' ),
						'social_icon' 		=> [
													'value' => 'fab fa-facebook-f',
													'library' => 'fa-brands',
												],
						'social_link_title' => 'Facebook',
					],
					[
						'social_link'       => __( 'http://www.twitter.com/avator/', 'avator-widget-pack' ),
						'social_icon'		=> [
													'value' => 'fab fa-twitter',
													'library' => 'fa-brands',
												],
						'social_link_title' => 'Twitter',
					],
					[
						'social_link'       => __( 'http://www.instagram.com/avator/', 'avator-widget-pack' ),
						'social_icon'		=> [
													'value' => 'fab fa-instagram',
													'library' => 'fa-brands',
												],
						'social_link_title' => 'Instagram',
					],
				],
				'title_field' => '{{{ social_link_title }}}',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_custom_nav',
			[
				'label' => esc_html__( 'User Menu', 'avator-widget-pack' ),
				'condition' => [
					'show_user_menu' => 'yes',
				],
			]
		);

		$this->add_control(
			'custom_navs',
			[
				'label'   => esc_html__( 'Menus', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'custom_nav_title' => esc_html__( 'Billing', 'avator-widget-pack' ),
						'icon'          => ['value' => 'fas fa-dollar-sign', 'library' => 'fa-solid'],
						'custom_nav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						] 
					],
					[
						'custom_nav_title' => esc_html__( 'Settings', 'avator-widget-pack' ),
						'icon'          => ['value' => 'fas fa-cog', 'library' => 'fa-solid'],
						'custom_nav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						]
					],
					[
						'custom_nav_title' => esc_html__( 'Support', 'avator-widget-pack' ),
						'icon'          => ['value' => 'fas fa-life-ring', 'library' => 'fa-solid'],
						'custom_nav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						]
					],
				],
				'fields' => [
					[
						'name'    => 'custom_nav_title',
						'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'default' => esc_html__( 'Title' , 'avator-widget-pack' ),
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'    => 'icon',
						'label'   => esc_html__( 'Icon', 'avator-widget-pack' ),
						'type'        => Controls_Manager::ICONS,
						'default' => [
							'value' => 'fas fa-home',
							'library' => ['fa-solid'],
						],
					],
					[
						'name'        => 'custom_nav_link',
						'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::URL,
						'default'     => [ 'url' => '#' ],
						'dynamic'     => [ 'active' => true ],
					],
				],
				'title_field' => '{{{ custom_nav_title }}}',
			]
		);

		// $this->add_control(
		// 	'show_edit_profile',
		// 	[
		// 		'label'   => __('Edit Profile', 'avator-widget-pack'),
		// 		'type'    => Controls_Manager::SWITCHER,
		// 		'default' => 'yes'
		// 	]
		// );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_settings',
			[
				'label' => esc_html__( 'Additional Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'dropdown_width',
			[
				'label' => esc_html__( 'Dropdown Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 450,
					],
				],
				'condition' => [
					'show_user_menu' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-dropdown' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_offset',
			[
				'label' => esc_html__( 'Dropdown Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				//'separator' => 'before',
				'condition' => [
					'show_user_menu' => 'yes',
				],
			]
		);

		$this->add_control(
			'dropdown_position',
			[
				'label'   => esc_html__( 'Dropdown Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-right',
				'options' => widget_pack_drop_position(),
				'condition' => [
					'show_user_menu' => 'yes',
				],
			]
		);

		$this->add_control(
			'dropdown_mode',
			[
				'label'   => esc_html__( 'Dropdown Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover' => esc_html__('Hover', 'avator-widget-pack'),
					'click' => esc_html__('Clicked', 'avator-widget-pack'),
				],
				'condition' => [
					'show_user_menu' => 'yes',
				],
			]
		);


		$this->end_controls_section();



		//Style

		$this->start_controls_section(
			'section_profile_card_header_style',
			[
				'label' => __( 'Header Area', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_profile_card_header_style' );

		$this->start_controls_tab(
			'tab_profile_card_header_inner',
			[
				'label' => esc_html__( 'Inner Style', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'profile_card_header_background',
				'label' => __( 'Background', 'avator-widget-pack' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-card-header',
			]
		);

		$this->add_control(
			'profile_card_header_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'profile_card_header_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 250,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-header' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'profile_card_skin_header_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 130,
						'max' => 350,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-header' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => 'heline',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_profile_card_header_badge',
			[
				'label' => esc_html__( 'Badge', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'profile_badge_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card-pro span' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'profile_badge_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-profile-card-pro span',
			]
		);

		$this->add_control(
			'profile_badge_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card-pro span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'profile_badge_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card-pro span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'profile_badge_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-profile-card-pro span',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_profile_card_header_user_menu',
			[
				'label' => esc_html__( 'User Menu', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'settings_menu_size',
			[
				'label' => __( 'Dot Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card-settings svg' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'settings_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card-settings svg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'settings_dropdown_style',
			[
				'label' 	=> __( 'Dropdown Menu', 'avator-widget-pack' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'settings_dropdown_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-dropdown-nav>li>a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'settings_dropdown_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-dropdown-nav>li>a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'settings_dropdown_background_color',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-dropdown' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'dropdown_typography',
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-dropdown',
			]
		);


		$this->add_responsive_control(
			'profile_card_user_menu_left_spacing',
			[
				'label'       => __( 'Left Spacing', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 250,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card.avt-profile-card-heline .avt-profile-card-settings' => 'left: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'profile_card_user_menu_top_spacing',
			[
				'label'       => __( 'Top Spacing', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 250,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card.avt-profile-card-heline .avt-profile-card-settings' => 'top: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_profile_card_item_inner_style',
			[
				'label' => __( 'Content Area', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'profile_card_inner_background',
				'label' => __( 'Background', 'avator-widget-pack' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-card-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'profile_card_inner_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-profile-card .avt-profile-card-inner',
			]
		);


		$this->add_control(
			'profile_card_inner_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'profile_card_inner_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'profile_card_inner_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_profile_card_image_style',
			[
				'label' => __( 'Image', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'show_image' => 'yes',
                ],
			]
		);

		$this->add_responsive_control(
			'profile_card_image_width',
			[
				'label' => __( 'Size', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; margin-left: auto;margin-right: auto;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-profile-card .avt-profile-image img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'profile_card_image_spacing',
			[
				'label'       => __( 'Match Spacing', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 250,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-image img' => 'margin-top: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-profile-card.avt-profile-card-heline .avt-profile-image' => 'left: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_profile_card_name_style',
			[
				'label' => __( 'Full Name', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'profile_card_name_color',
			[
				'label' => __( 'Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-name-info .avt-name, {{WRAPPER}} .avt-profile-card .avt-profile-name-info .avt-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-name-info .avt-name',
			]
		);


		$this->add_responsive_control(
            'profile_card_name_spacing',
            [
                'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .avt-profile-card .avt-profile-name-info .avt-name' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_profile_card_username_style',
			[
				'label' => __( 'User Name', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'profile_card_username_color',
			[
				'label' => __( 'Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-name-info .avt-username' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'username_typography',
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-name-info .avt-username',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_profile_card_text_style',
			[
				'label' => __( 'Bio', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'profile_card_text_color',
			[
				'label' => __( 'Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-bio',
			]
		);


		$this->add_responsive_control(
            'profile_card_text_spacing',
            [
                'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .avt-profile-card .avt-profile-bio' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_profile_card_statas_style',
			[
				'label' => __( 'Status', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'profile_card_stat_color',
			[
				'label' => __( 'Number Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-status .avt-profile-stat' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'stat_typography',
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-status .avt-profile-stat',
			]
		);

		$this->add_control(
		'profile_card_label_color',
			[
				'label' => __( 'Label Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-status .avt-profile-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-status .avt-profile-label',
			]
		);


		$this->add_responsive_control(
            'profile_card_label_spacing',
            [
                'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .avt-profile-card .avt-profile-status' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'      => __( 'Follow Button', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'show_button' => 'yes',
                ],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_color',
				'label' => __( 'Background', 'avator-widget-pack' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button',
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover_color',
				'label' => __( 'Background', 'avator-widget-pack' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button:hover',
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-button .avt-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_social_icon',
			[
				'label' => __( 'Social Icon', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'show_social_icon' => 'yes',
                ],
			]
		);


		$this->start_controls_tabs( 'tabs_social_icon_style' );

		$this->start_controls_tab(
			'tab_social_icon_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'social_icon_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a',
			]
		);

		$this->add_control(
			'social_icon_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_size',
			[
				'label'     => __( 'Icon Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a i'        => 'min-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a i:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a + a' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_tooltip',
			[
				'label'   => __( 'Tooltip', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'social_line_color',
			[
				'label'     => __( 'Line Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link:before, {{WRAPPER}} .avt-profile-card .avt-profile-card-share-link:after' => 'background: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_social_icon_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_hover_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'social_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-profile-card .avt-profile-card-share-link a:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		
	}

	public function render_loop_custom_nav_list() {
		$settings = $this->get_settings_for_display();

		foreach ($settings['custom_navs'] as $key => $nav) {
			$this->add_render_attribute( 'custom-nav-item', 'title', $nav["custom_nav_title"], true );
			$this->add_render_attribute( 'custom-nav-item', 'href', $nav['custom_nav_link']['url'], true );
			
			if ( $nav['custom_nav_link']['is_external'] ) {
				$this->add_render_attribute( 'custom-nav-item', 'target', '_blank', true );
			}

			if ( $nav['custom_nav_link']['nofollow'] ) {
				$this->add_render_attribute( 'custom-nav-item', 'rel', 'nofollow', true );
			}
			
			?>
		    <li class="avt-profile-card-custom-item">
				<a <?php echo $this->get_render_attribute_string( 'custom-nav-item' ); ?>>
					<?php if ($nav['icon']) : ?>
						<span class="avt-ul-custom-nav-icon">
							<?php Icons_Manager::render_icon( $nav['icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
						</span>
					<?php endif; ?>

					<?php echo $nav["custom_nav_title"]; ?>
				</a>
			</li>
			<?php
		}

	}

	public function user_dropdown_menu() {
		$settings = $this->get_settings_for_display();
		$dropdown_offset = $settings['dropdown_offset'];

		$this->add_render_attribute(
			[
				'dropdown-settings' => [
					'avt-dropdown' => [
						wp_json_encode(array_filter([
							"mode"   => $settings["dropdown_mode"],
							"pos"    => $settings["dropdown_position"],
							"offset" => $dropdown_offset["size"]
						]))
					]
				]
			]
		);

		$this->add_render_attribute( 'dropdown-settings', 'class', 'avt-dropdown avt-text-left avt-overflow-hidden' );

		?>

		<div <?php echo $this->get_render_attribute_string('dropdown-settings'); ?>>
		    <ul class="avt-nav avt-dropdown-nav">

		        <?php $this->render_loop_custom_nav_list(); ?>
		        
		    </ul>
		</div>

		<?php
	}

	public function render_instagram_card() {
		$settings = $this->get_settings_for_display();
        $instagram = widget_pack_instagram_card();

		?>

        <div class="avt-profile-card">
            <div class="avt-profile-card-item">

                <div class="avt-profile-card-header avt-flex avt-flex-between">

                    <div class="avt-profile-card-pro">
						<?php if ($settings['show_badge']) : ?>
                            <span><?php echo $settings['profile_badge_text']; ?></span>
						<?php endif; ?>
                    </div>

					<?php if ($settings['show_user_menu']) : ?>
                        <div class="avt-profile-card-settings">
                            <a href="#" avt-icon="more"></a>
                        </div>

						<?php $this->user_dropdown_menu(); ?>

					<?php endif; ?>

                </div>

                <div class="avt-profile-card-inner avt-text-<?php echo esc_attr($settings['alignment']); ?>">

					<?php if ($settings['show_image']) : ?>
                        <div class="avt-profile-image">
                            <img src="<?php echo esc_url( $instagram['profile_picture'] ); ?>" alt="<?php echo $instagram['full_name']; ?>" />
                        </div>
					<?php endif; ?>

                    <div class="avt-profile-name-info">

						<?php if ($settings['show_name']) : ?>
                            <h3 class="avt-name">
                                <a class="" href="https://instagram.com/<?php echo esc_html($instagram['username']); ?>"><?php echo wp_kses_post($instagram['full_name']); ?></a>
							</h3>
						<?php endif; ?>

						<?php if ($settings['show_username']) : ?>
                            <span class="avt-username"><?php echo esc_html($instagram['username']); ?></span>
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

					<?php if ($settings['show_button']) : ?>
                        <div class="avt-profile-button avt-margin-medium-top avt-margin-medium-bottom">
                            <a class="avt-button avt-button-secondary" href="https://instagram.com/<?php echo esc_html($instagram['username']); ?>"><?php echo $settings['instagram_button_text']; ?></a>
                        </div>
					<?php endif; ?>

					<?php $this->render_social_icon(); ?>

                </div>

            </div>
        </div>

		<?php
    }

	public function render_blog_card() {
		$settings = $this->get_settings_for_display();

		?>

        <div class="avt-profile-card">
            <div class="avt-profile-card-item">

                <div class="avt-profile-card-header avt-flex avt-flex-between">

                    <div class="avt-profile-card-pro">
						<?php if ($settings['show_badge']) : ?>
                            <span><?php echo $settings['profile_badge_text']; ?></span>
						<?php endif; ?>
                    </div>

					<?php if ($settings['show_user_menu']) : ?>
                        <div class="avt-profile-card-settings">
                            <a href="#" avt-icon="more"></a>
                        </div>

						<?php $this->user_dropdown_menu(); ?>

					<?php endif; ?>

                </div>

                <div class="avt-profile-card-inner avt-text-<?php echo esc_attr($settings['alignment']); ?>">

					<?php if ($settings['show_image']) : ?>
                        <div class="avt-profile-image">
                            <img src="<?php echo esc_url( get_avatar_url( $settings['blog_user_id'], [ 'size' => 128 ] ) ); ?>" alt="<?php echo get_the_author_meta('first_name', $settings['blog_user_id']); ?>" />
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

					<?php if ($settings['show_button']) : ?>
                        <div class="avt-profile-button avt-margin-medium-top avt-margin-medium-bottom">
                            <a class="avt-button avt-button-secondary" href="<?php echo get_author_posts_url($settings['blog_user_id']); ?>"><?php echo $settings['blog_button_text']; ?></a>

                        </div>
					<?php endif; ?>

					<?php $this->render_social_icon(); ?>

                </div>

            </div>
        </div>

		<?php

	}

	public function render_custom_card() {
		$settings = $this->get_settings_for_display();
		
		?>

		<div class="avt-profile-card">
            <div class="avt-profile-card-item">

                <div class="avt-profile-card-header avt-flex avt-flex-between">

                    <div class="avt-profile-card-pro">
                	<?php if ($settings['show_badge']) : ?>
                        <span><?php echo $settings['profile_badge_text']; ?></span>
                    <?php endif; ?>
                    </div>
					
					<?php if ($settings['show_user_menu']) : ?>
                    <div class="avt-profile-card-settings">
                        <a href="#" avt-icon="more"></a>
                    </div>
					
					<?php $this->user_dropdown_menu(); ?>

                    <?php endif; ?>

                </div>

                <div class="avt-profile-card-inner avt-text-<?php echo esc_attr($settings['alignment']); ?>">
					
					<?php if ($settings['show_image']) : ?>
                    <div class="avt-profile-image">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'profile_image' ); ?>
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
                                <span class="avt-profile-stat">
									<?php echo $settings['profile_posts_number']; ?>
								</span>
                                <span class="avt-profile-label">
									<?php echo esc_html($settings['profile_posts']); ?>
								</span>
                            </li>
                            <li>
                                <span class="avt-profile-stat">
									<?php echo $settings['profile_followers_number']; ?>
								</span>
                                <span class="avt-profile-label">
									<?php echo esc_html($settings['profile_followers']); ?>
								</span>
                            </li>
                            <li>
                                <span class="avt-profile-stat">
									<?php echo $settings['profile_following_number']; ?>
								</span>
                                <span class="avt-profile-label">
									<?php echo esc_html($settings['profile_following']); ?>
								</span>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
					
					<?php if ($settings['show_button']) : ?>
                    <div class="avt-profile-button avt-margin-medium-top avt-margin-medium-bottom">
                        <a class="avt-button avt-button-secondary" href="#"><?php echo $settings['profile_button_text']; ?></a>
                    </div>
                    <?php endif; ?>

					<?php $this->render_social_icon(); ?>

                </div>

            </div>
        </div>

		<?php 
	}

	public function render_social_icon() {
		$settings = $this->get_settings_for_display();

		?>

		<?php if ($settings['show_social_icon']) : ?>

		<div class="avt-profile-card-share-wrapper">
			<div class="avt-profile-card-share-link">
				<?php 
				foreach ( $settings['social_link_list'] as $link ) :
					$tooltip = ( 'yes' == $settings['social_icon_tooltip'] ) ? ' title="'.esc_attr( $link['social_link_title'] ).'" avt-tooltip' : ''; ?>
					
					<a href="<?php echo esc_url( $link['social_link'] ); ?>" target="_blank"<?php echo $tooltip; ?> class="elementor-repeater-item-<?php echo esc_attr($link['_id']); ?>">
						<?php Icons_Manager::render_icon( $link['social_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>

		<?php endif; 
	}

	public function render() {
	    $settings = $this->get_settings_for_display();

	    if ('blog' == $settings['profile']) {
		    $this->render_blog_card();
	   	} elseif ( 'instagram' == $settings['profile']) {
		    $this->render_instagram_card();
	   	} else {
		    $this->render_custom_card();
        }
	}
}
