<?php
namespace WidgetPack\Modules\PortfolioGallery\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;

use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;

use WidgetPack\Modules\PortfolioGallery\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Portfolio_Gallery extends Widget_Base {
	private $_query = null;

	public function get_name() {
		return 'avt-portfolio-gallery';
	}

	public function get_title() {
		return AWP . esc_html__( 'Portfolio Gallery', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-portfolio-gallery';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'portfolio', 'gallery', 'blog', 'recent', 'news', 'works' ];
	}

	public function get_style_depends() {
		return ['wipa-portfolio-gallery'];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'tilt', 'avt-uikit-icons' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Abetis( $this ) );
		$this->add_skin( new Skins\Skin_Fedara( $this ) );
		$this->add_skin( new Skins\Skin_Trosia( $this ) );
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'post';
		}

		return $element;
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
		return $element;
	}

	public function get_query() {
		return $this->_query;
	}

	public function _register_controls() {
		$this->register_section_controls();
	}

	private function register_section_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label' => esc_html__( 'Pagination', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'thumbnail_size',
				'label'        => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'exclude'      => [ 'custom' ],
				'default'      => 'medium',
				'prefix_class' => 'avt-portfolio--thumbnail-size-',
			]
		);

		$this->add_control(
			'masonry',
			[
				'label'       => esc_html__( 'Masonry', 'avator-widget-pack' ),
				'description' => esc_html__( 'Masonry will not work if you not set filter.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => [
					'columns!' => '1',
				],
			]
		);

		$this->add_control(
			'item_ratio',
			[
				'label'   => esc_html__( 'Item Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 250,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-gallery-thumbnail img' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'masonry!' => 'yes',

				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__( 'Show All', 'avator-widget-pack' ),
					'by_name' => esc_html__( 'Manual Selection', 'avator-widget-pack' ),
				],
				'label_block' => true,
			]
		);



		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => widget_pack_get_category('portfolio_filter'),
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 9,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => esc_html__( 'Date', 'avator-widget-pack' ),
					'title'    => esc_html__( 'Title', 'avator-widget-pack' ),
					'category' => esc_html__( 'Category', 'avator-widget-pack' ),
					'rand'     => esc_html__( 'Random', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'avator-widget-pack' ),
					'ASC'  => esc_html__( 'Ascending', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label'     => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => [
					'posts_post_type!' => 'by_id',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'filter_bar',
			[
				'label' => esc_html__( 'Filter Bar', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_filter_bar',
			[
				'label' => esc_html__( 'Show', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'taxonomy',
			[
				'label'       => esc_html__( 'Taxonomy', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => $this->get_taxonomies(),
				'condition'   => [
					'show_filter_bar'  => 'yes',
					'posts_post_type!' => 'by_id',
				],
				'default' => 'category',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => widget_pack_title_tags(),
				'default'   => 'h4',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'excerpt_limit',
			[
				'label'     => esc_html__( 'Excerpt Limit', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 10,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__( 'Show Category', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_category_on_hover',
			[
				'label' => esc_html__( 'Category On Hover Show', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'condition' => [
					'show_category' => 'yes',
					'_skin!'		=> 'avt-trosia',
				],
			]
		);

		$this->add_control(
			'show_link',
			[
				'label'   => esc_html__( 'Show Link', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'post'     => esc_html__('Details Link', 'avator-widget-pack'),
					'lightbox' => esc_html__('Lightbox Link', 'avator-widget-pack'),
					'both'     => esc_html__('Both', 'avator-widget-pack'),
					'none'     => esc_html__('None', 'avator-widget-pack'),
				],
			]
		);

		$this->add_control(
			'external_link',
			[
				'label'   => esc_html__( 'Show in new Tab (Details Link/Title)', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
                'conditions' => [
                	'relation' => 'or',
                	'terms'    => [
                		[
                			'name'     => 'show_title',
                			'operator' => '==',
                			'value'    => 'yes'
                		],
                		[
                			'name'     => 'show_link',
                			'operator' => '==',
                			'values'    => ['post', 'both']
                		],
                	]
                ],
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => esc_html__('Icon', 'avator-widget-pack'),
					'text' => esc_html__('Text', 'avator-widget-pack'),
				],
				'condition' => [
					'show_link!' => 'none',
				]
			]
		);

		$this->add_control(
			'tilt_show',
			[
				'label' => esc_html__( 'Tilt Effect', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'tilt_scale',
			[
				'label'     => esc_html__( 'Zoom on Hover', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'tilt_show' => 'yes',
				]
			]
		);

		$this->add_control(
			'lightbox_animation',
			[
				'label'   => esc_html__( 'Lightbox Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'avator-widget-pack' ),
					'fade'  => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale' => esc_html__( 'Scale', 'avator-widget-pack' ),
				],
				'condition' => [
					'show_link' => ['both', 'lightbox'],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lightbox_autoplay',
			[
				'label'   => __( 'Lightbox Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_link' => ['both', 'lightbox'],
				]
			]
		);

		$this->add_control(
			'lightbox_pause',
			[
				'label'   => __( 'Lightbox Pause on Hover', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_link' => ['both', 'lightbox'],
					'lightbox_autoplay' => 'yes'
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => esc_html__( 'Items', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery.avt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .avt-portfolio-gallery.avt-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery.avt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .avt-portfolio-gallery.avt-grid > *' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'overlay_style_headline',
			[
				'label'     => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'_skin' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_primary_background',
			[
				'label'     => esc_html__( 'Primary Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery.avt-portfolio-gallery-skin-default .avt-portfolio-content-inner:before' => 'background: {{VALUE}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'overlay_secondary_background',
			[
				'label'     => esc_html__( 'Secondary Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery.avt-portfolio-gallery-skin-default .avt-portfolio-content-inner:after' => 'background: {{VALUE}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'portfolio_content_style_headline',
			[
				'label'     => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'portfolio_content_alignment',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'      => 'center',
				'prefix_class' => 'avt-custom-gallery-skin-fedara-style-',
				'selectors'    => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-desc, {{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-skin-fedara-desc' => 'text-align: {{VALUE}}',
				],
				// 'condition' => [
				// 	'_skin!' => 'avt-trosia',
				// ],
			]
		);


		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item .avt-gallery-item-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'desc_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-desc, {{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-skin-fedara-desc' => 'background: {{VALUE}};',
				],
				'condition' => [
					'_skin!' => 'avt-abetis',
				],
			]
		);

		$this->add_control(
			'desc__padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-desc, {{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-skin-fedara-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .avt-gallery-item .avt-gallery-item-title',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_margin',
			[
				'label'     => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-excerpt' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-portfolio-gallery .avt-portfolio-excerpt',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_link!' => 'none',
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
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link, {{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link svg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'border_radius_advanced_show!' => 'yes',
				],
			]
		);

		$this->add_control(
			'border_radius_advanced_show',
			[
				'label' => __( 'Advanced Radius', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'border_radius_advanced',
			[
				'label'       => esc_html__('Radius', 'avator-widget-pack'),
				'description' => sprintf(__('For example: <b>%1s</b> or Go <a href="%2s" target="_blank">this link</a> and copy and paste the radius value.', 'avator-widget-pack'), '30% 70% 82% 18% / 46% 62% 38% 54%', 'https://9elements.github.io/fancy-border-radius/'),
				'type'        => Controls_Manager::TEXT,
				'size_units'  => [ 'px', '%' ],
				'separator'   => 'after',
				'default'     => '30% 70% 82% 18% / 46% 62% 38% 54%',
				'selectors'   => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link'     => 'border-radius: {{VALUE}}; overflow: hidden;',
				],
				'condition' => [
					'border_radius_advanced_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link',
				'condition' => [
					'link_type' => 'text',
				],
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
			'hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link:hover svg'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link:hover span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-link.avt-link-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_filter',
			[
				'label'     => esc_html__( 'Filter Bar', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter_bar' => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_alignment',
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
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters-wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_filter',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li',
			]
		);

		$this->add_control(
			'filter_spacing',
			[
				'label'     => esc_html__( 'Bottom Space', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_style_desktop' );

		$this->start_controls_tab(
			'filter_tab_desktop',
			[
				'label' => __( 'Desktop', 'avator-widget-pack' )
			]
		);

		$this->add_control(
			'desktop_filter_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_filter_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_filter_padding',
			[
				'label'      => __('Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'desktop_filter_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-wipa-grid-filters li'
			]
		);

		$this->add_control(
			'desktop_filter_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_filter_shadow',
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li'
			]
		);

		$this->add_control(
			'filter_item_spacing',
			[
				'label'     => esc_html__( 'Space Between', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters > li.avt-wipa-grid-filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .avt-wipa-grid-filters > li.avt-wipa-grid-filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_control(
			'desktop_filter_active',
			[
				'label' => esc_html__( 'Active', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter_active',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-wipa-grid-filters li.avt-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_active_filter_shadow',
				'selector' => '{{WRAPPER}} .avt-wipa-grid-filters li.avt-active'
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'filter_tab_mobile',
			[
				'label' => __( 'Mobile', 'avator-widget-pack' )
			]
		);

		$this->add_control(
			'filter_mbtn_width',
			[
				'label' => __('Button Width(%)', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 100
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'width: {{SIZE}}%;'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_color',
			[
				'label'     => __( 'Button Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_background',
			[
				'label'     => __( 'Button Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropdown-nav li' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_background',
			[
				'label'     => __( 'Dropdown Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dropdown' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filter_mbtn_dropdown_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-dropdown-nav li',
			]
		);

		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_category',
			[
				'label'      => esc_html__( 'Category', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_category',
							'value' => 'yes'
						],
						[
							'name'  => 'show_filter_bar',
							'value' => 'yes'
						]
					]
				]
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__( 'Category Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .avt-portfolio-gallery .avt-gallery-item-tag',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[
				'label'     => esc_html__( 'Pagination', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_pagination_style' );

		$this->start_controls_tab(
			'tab_pagination_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a, {{WRAPPER}} ul.avt-pagination li span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'pagination_background',
				'selector'  => '{{WRAPPER}} ul.avt-pagination li a',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'pagination_border',
				'label'    => esc_html__( 'Border', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} ul.avt-pagination li a',
			]
		);

		$this->add_responsive_control(
			'pagination_offset',
			[
				'label'     => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-pagination' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_space',
			[
				'label'     => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-pagination'     => 'margin-left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-pagination > *' => 'padding-left: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_padding',
			[
				'label'     => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_radius',
			[
				'label'     => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_arrow_size',
			[
				'label'     => esc_html__( 'Arrow Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a svg' => 'height: {{SIZE}}px; width: auto;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ul.avt-pagination li a, {{WRAPPER}} ul.avt-pagination li span',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagination_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'pagination_hover_background',
				'selector' => '{{WRAPPER}} ul.avt-pagination li a:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagination_active',
			[
				'label' => esc_html__( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li.avt-active a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.avt-pagination li.avt-active a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'pagination_active_background',
				'selector' => '{{WRAPPER}} ul.avt-pagination li.avt-active a',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();
	}

	public function get_taxonomies() {
		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

		$options = [ '' => '' ];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

	public function query_posts() {
		$settings = $this->get_settings_for_display();

		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } 
		elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } 
		else { $paged = 1; }

		$args = array(
			'post_type'      => 'portfolio',
			'posts_per_page' => $settings['limit'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish',
			'paged'          => $paged
		);

		if ( 'by_name' === $settings['source'] and !empty($settings['post_categories']) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'portfolio_filter',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		}

		$query = new \WP_Query( $args );

		return $query;
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		$wp_query = $this->query_posts();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->render_header();

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post();
		}

		$this->render_footer();

		if ($settings['show_pagination']) {
			widget_pack_post_pagination($wp_query);
		}
		
		wp_reset_postdata();

	}

	public function render_thumbnail() {
		$settings = $this->get_settings_for_display();

		$settings['thumbnail_size'] = [
			'id' => get_post_thumbnail_id(),
		];

		$thumbnail_html      = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail_size' );
		$placeholder_img_src = Utils::get_placeholder_image_src();
		$img_url             = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

		if ( ! $thumbnail_html ) {
			$thumbnail_html = '<img src="' . esc_url( $placeholder_img_src) . '" alt="' . get_the_title() . '">';
		}

		?>
		<div class="avt-gallery-thumbnail">
			<?php echo $thumbnail_html ?>
		</div>
		<?php
	}

	public function render_filter_menu() {
		$settings = $this->get_settings_for_display();
		$portfolio_categories = [];

		$wp_query = $this->query_posts();

		if ( 'by_name' === $settings['source'] and !empty($settings['portfolio_categories'] ) ) {
			$portfolio_categories = $settings['portfolio_categories'];
		} else {

			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$terms = get_the_terms( get_the_ID(), 'portfolio_filter' );
				if (is_array($terms)) {
					foreach ($terms as $term) {
						$portfolio_categories[] = esc_attr($term->slug);
					}
				}
			endwhile;

			$portfolio_categories = array_unique($portfolio_categories);

			wp_reset_postdata();

		}

		?>
		<div class="avt-wipa-grid-filters-wrapper">

			<button class="avt-button avt-button-default avt-hidden@m" type="button"><?php esc_html_e( 'Filter', 'avator-widget-pack' ); ?></button>

			<div avt-dropdown="mode: click;" class="avt-dropdown avt-margin-remove-top avt-margin-remove-bottom">
			    <ul class="avt-nav avt-dropdown-nav">

					<li class="avt-active" avt-filter-control><?php esc_html_e( 'All', 'avator-widget-pack' ); ?></li>

				    <?php foreach($portfolio_categories as $portfolio_category => $value) : ?>
					    <?php $filter_name = get_term_by('slug', $value, 'portfolio_filter'); ?>
                        <li class="avt-wipa-grid-filter" avt-filter-control="[data-filter*='avtp-<?php echo esc_attr(trim($value)); ?>']">
						    <?php echo $filter_name->name; ?>
                        </li>
				    <?php endforeach; ?>
			    
			    </ul>
			</div>

			<ul id="avt-wipa-grid-filters<?php echo $this->get_id(); ?>" class="avt-wipa-grid-filters avt-visible@m" avt-margin>
				<li class="avt-wipa-grid-filter avt-active" avt-filter-control>
					<?php esc_html_e( 'All', 'avator-widget-pack' ); ?>
				</li>

				<?php foreach($portfolio_categories as $portfolio_category => $value) : ?>
					<?php $filter_name = get_term_by('slug', $value, 'portfolio_filter'); ?>
                    <li class="avt-wipa-grid-filter" avt-filter-control="[data-filter*='avtp-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo $filter_name->name; ?>
                    </li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}

	public function render_title() {
		$settings = $this->get_settings();

		if ( ! $settings['show_title'] ) {
			return;
		}

		$tag = $settings['title_tag'];
		$target = ( $settings['external_link'] ) ? 'target="_blank"' : '';

		?>
		<a href="<?php echo get_the_permalink(); ?>" <?php echo $target; ?>>
			<<?php echo $tag ?> class="avt-gallery-item-title avt-margin-remove">
				<?php the_title() ?>
			</<?php echo $tag ?>>
		</a>
		<?php
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'excerpt_limit' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {
		if ( ! $this->get_settings( 'show_excerpt' ) ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="avt-portfolio-excerpt">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_categories_names() {
		$settings = $this->get_settings_for_display();
		if ( ! $this->get_settings( 'show_category' ) ) {
			return; 
		}

		
		$this->add_render_attribute('portfolio-category', 'class', 'avt-gallery-item-tags', true);

		if ( 'yes' == $settings['show_category_on_hover'] ) {
			$this->add_render_attribute('portfolio-category', 'class', 'avt-category-on-hover-show');
		}

		global $post;
		
		$separator  = '<span class="avt-gallery-item-tag-separator"></span>';
		$tags_array = [];
		
		$item_filters = get_the_terms( $post->ID, 'portfolio_filter' ); 

		foreach ( $item_filters as $item_filter ) {
			$tags_array[] = '<span class="avt-gallery-item-tag">' . $item_filter->slug . '</span>';
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'portfolio-category' ); ?>>
			<?php echo implode( $separator, $tags_array ); ?>
		</div>
		<?php
	}

	public function render_overlay() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			[
				'content-position' => [
					'class' => [
						'avt-position-center',
					]
				]
			], '', '', true
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-position' ); ?>>
			<div class="avt-portfolio-content">
				<div class="avt-gallery-content-inner">
					<?php 

					$placeholder_img_src = Utils::get_placeholder_image_src();

					$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

					if ( ! $img_url ) {
						$img_url = $placeholder_img_src;
					} else {
						$img_url = $img_url[0];
					}

					$this->add_render_attribute(
						[
							'lightbox-settings' => [
								'class' => [
									'avt-gallery-item-link',
									'avt-gallery-lightbox-item',
									('icon' == $settings['link_type']) ? 'avt-link-icon' : 'avt-link-text'
								],
								'data-elementor-open-lightbox' => 'no',
								'data-caption'                 => get_the_title(),
								'href'                         => esc_url($img_url)
							]
						], '', '', true
					);					
					
					if ( 'none' !== $settings['show_link'])  : ?>
						<div class="avt-flex-inline avt-gallery-item-link-wrapper">
							<?php if (( 'lightbox' == $settings['show_link'] ) || ( 'both' == $settings['show_link'] )) : ?>
								<a <?php echo $this->get_render_attribute_string( 'lightbox-settings' ); ?>>
									<?php if ( 'icon' == $settings['link_type'] ) : ?>
										<span avt-icon="icon: search"></span>
									<?php elseif ( 'text' == $settings['link_type'] ) : ?>
										<span><?php esc_html_e( 'ZOOM', 'avator-widget-pack' ); ?></span>
									<?php endif; ?>
								</a>
							<?php endif; ?>
							
							<?php if (( 'post' == $settings['show_link'] ) || ( 'both' == $settings['show_link'] )) : ?>
								<?php 
									$link_type_class =  ( 'icon' == $settings['link_type'] ) ? ' avt-link-icon' : ' avt-link-text'; 
									$target =  ( $settings['external_link'] ) ? 'target="_blank"' : ''; 

								?>
								<a class="avt-gallery-item-link<?php echo esc_attr($link_type_class); ?>" href="<?php echo esc_attr(get_permalink()); ?>" <?php echo $target; ?>>
									<?php if ( 'icon' == $settings['link_type'] ) : ?>
										<span avt-icon="icon: link"></span>
									<?php elseif ( 'text' == $settings['link_type'] ) : ?>
										<span><?php esc_html_e( 'VIEW', 'avator-widget-pack' ); ?></span>
									<?php endif; ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function render_header($skin = 'default') {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-portfolio-gallery' . $this->get_id();

		$this->add_render_attribute('portfolio-wrapper', 'class', 'avt-portfolio-gallery-wrapper');

		$this->add_render_attribute('portfolio', 'id', esc_attr($id) );

		$this->add_render_attribute('portfolio', 'class', ['avt-portfolio-gallery', 'avt-wipa-grid-filter-container', 'avt-portfolio-gallery-skin-' . $skin]);

		$this->add_render_attribute('portfolio', 'avt-grid', '');
		$this->add_render_attribute('portfolio', 'class', ['avt-grid', 'avt-grid-medium']);

		$this->add_render_attribute('portfolio', 'class', 'avt-child-width-1-'. $settings['columns_mobile']);
		$this->add_render_attribute('portfolio', 'class', 'avt-child-width-1-'. $settings['columns_tablet'] .'@s');
		$this->add_render_attribute('portfolio', 'class', 'avt-child-width-1-'. $settings['columns'] .'@m');
		
		if ( $settings['masonry'] ) {
			$this->add_render_attribute('portfolio', 'avt-grid', 'masonry: true');
		}

		if ( $settings['show_filter_bar'] ) {
			$this->add_render_attribute('portfolio-wrapper', 'avt-filter', 'target: #avt-portfolio' . $this->get_id());
		}

		if ( 'lightbox' === $settings['show_link'] or 'both' === $settings['show_link'] ) {
			$this->add_render_attribute('portfolio', 'avt-lightbox', 'toggle: .avt-gallery-lightbox-item; animation:' . $settings['lightbox_animation'] . ';');
			if ($settings['lightbox_autoplay']) {
				$this->add_render_attribute('portfolio', 'avt-lightbox', 'autoplay: 500;');
				
				if ($settings['lightbox_pause']) {
					$this->add_render_attribute('portfolio', 'avt-lightbox', 'pause-on-hover: true;');
				}
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'portfolio-wrapper' ); ?>>
	
		<?php 
		if ( $settings['show_filter_bar'] ) {
			$this->render_filter_menu();
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'portfolio' ); ?>>

		<?php
	}

	public function render_footer() {
		?>

			</div>
		</div>
		<?php
	}

	public function render_desc() {
		?>
		<div class="avt-portfolio-desc">
			<?php
			$this->render_title();
			$this->render_excerpt();
			?>
		</div>
		<?php
	}

	public function render_post() {
		$settings = $this->get_settings_for_display();
		global $post;

		$element_key = 'portfolio-item-' . $post->ID;
		$item_filters = get_the_terms( $post->ID, 'portfolio_filter' );

		if ($settings['tilt_show']) {
			$this->add_render_attribute('portfolio-item-inner', 'data-tilt', '', true);
			if ($settings['tilt_scale']) {
				$this->add_render_attribute('portfolio-item-inner', 'data-tilt-scale', '1.2', true);
			}
		}

		$this->add_render_attribute('portfolio-item-inner', 'class', 'avt-portfolio-inner', true);

		$this->add_render_attribute('portfolio-item', 'class', 'avt-gallery-item avt-transition-toggle', true);

		if( $settings['show_filter_bar'] and is_array($item_filters) ) {
			foreach ($item_filters as $item_filter) {
				$this->add_render_attribute($element_key, 'data-filter', 'avtp-' . $item_filter->slug);
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( $element_key ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'portfolio-item' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'portfolio-item-inner' ); ?>>
					<div class="avt-portfolio-content-inner">
					<?php
					$this->render_thumbnail();
					$this->render_overlay();
					?>
					</div>
					<?php $this->render_desc(); ?>
					<?php $this->render_categories_names(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}
