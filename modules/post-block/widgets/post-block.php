<?php
namespace WidgetPack\Modules\PostBlock\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\QueryControl\Module;
use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;

use WidgetPack\Modules\PostBlock\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post_Block extends Widget_Base {

	public function get_name() {
		return 'avt-post-block';
	}

	public function get_title() {
		return AWP . esc_html__( 'Post Block', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-post-block';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'post', 'block', 'blog', 'recent', 'news' ];
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Genesis( $this ) );
		$this->add_skin( new Skins\Skin_Trinity( $this ) );
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

	protected function _register_controls() {
		$this->start_controls_section(
			'section_featured_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'featured_item',
			[
				'label'       => esc_html__( 'Featured Item', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => 'For good looking set it 1 for default skin and 2 for another skin',
				'options'     => [
					'1' => esc_html__( 'One', 'avator-widget-pack' ),
					'2' => esc_html__( 'Two', 'avator-widget-pack' ),
					'3' => esc_html__( 'Three', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'featured_show_tag',
			[
				'label'     => esc_html__( 'Tag', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin' => 'trinity',
				]
			]
		);

		$this->add_control(
			'featured_show_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'featured_show_date',
			[
				'label'   => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'featured_show_category',
			[
				'label'   => esc_html__( 'Category', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'featured_show_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin'   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'featured_excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 15,
				'condition' => [
					'featured_show_excerpt' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'featured_show_read_more',
			[
				'label'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin'   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'       => esc_html__( 'Read More Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
				'condition'   => [
					'featured_show_read_more' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'post_block_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition'   => [
					'featured_show_read_more' => 'yes',
					'_skin'                   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'post_block_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'post_block_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-post-block .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'trinity_column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'small'    => esc_html__( 'Small', 'avator-widget-pack' ),
					'medium'   => esc_html__( 'Medium', 'avator-widget-pack' ),
					'large'    => esc_html__( 'Large', 'avator-widget-pack' ),
					'collapse' => esc_html__( 'Collapse', 'avator-widget-pack' ),
				],
				'condition' => [
					'_skin' => 'trinity',
				],
			]
		);

		$this->add_responsive_control(
			'featured_item_height',
			[
				'label' => esc_html__( 'Featured Item Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-item.featured-part .avt-post-block-img-wrapper img' => 'height: {{SIZE}}px',
					'{{WRAPPER}} .avt-post-block .avt-post-block-item.featured-part .avt-post-block-thumbnail img' => 'height: {{SIZE}}px',
				]
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_layout',
			[
				'label'     => esc_html__( 'List Layout', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'_skin'   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'list_show_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'list_show_date',
			[
				'label'   => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'list_show_category',
			[
				'label' => esc_html__( 'Category', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_list_divider',
			[
				'label'   => esc_html__( 'Divider', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'list_space_between',
			[
				'label'      => esc_html__( 'Space Between', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-post-block.avt-post-block-skin-base .avt-list > li:nth-child(n+2)'           => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: {{SIZE}}{{UNIT}};',					
					'{{WRAPPER}} .avt-post-block.avt-post-block-skin-genesis .list-part ul li'       => 'margin-top: {{SIZE}}{{UNIT}};',					
					'{{WRAPPER}} .avt-post-block.avt-post-block-skin-genesis .list-part ul li > div' => 'padding-top: {{SIZE}}{{UNIT}};',					
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Posts::get_type(),
			[
				'name'  => 'posts',
				'label' => esc_html__( 'Posts', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => esc_html__( 'Advanced', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'posts_limit',
			[
				'label'   => esc_html__( 'Posts Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
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
			'section_featured_image_style',
			[
				'label'     => esc_html__( 'Featured Image Style', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => 'trinity',
				],
			]
		);

		$this->start_controls_tabs( 'featured_image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'featured_image_border',
				'selector' => '{{WRAPPER}} .featured-part .avt-post-block-img-wrapper img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'featured_image_radius',
			[
				'label' => __( 'Radius', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .featured-part .avt-post-block-img-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'featured_image_shadow',
				'selector' => '{{WRAPPER}} .featured-part .avt-post-block-img-wrapper img',
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => __( 'Opacity', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .featured-part .avt-post-block-img-wrapper img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .featured-part .avt-post-block-img-wrapper img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'opacity_hover',
			[
				'label' => __( 'Opacity', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .featured-part .avt-post-block-img-wrapper:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .featured-part .avt-post-block-img-wrapper:hover img',
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .featured-part .avt-post-block-img-wrapper img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_featured_style',
			[
				'label' => esc_html__( 'Featured Layout Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'featured_tag_heading',
			[
				'label'     => esc_html__( 'Tag', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
			]
		);

		$this->add_control(
			'tag_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-tag-wrap span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-tag-wrap span a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'tag_border',
				'label'     => __( 'Border', 'avator-widget-pack' ),
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'selector' => '{{WRAPPER}} .avt-post-block .avt-post-block-tag-wrap span',
			]
		);

		$this->add_control(
			'tag_border_radius',
			[
				'label'     => __( 'Border Radius', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-tag-wrap span' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'tag_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'featured_show_tag' => 'yes',
					'_skin'             => 'trinity',
				],
				'selector' => '{{WRAPPER}} .avt-post-block .avt-post-block-tag-wrap span',
			]
		);

		$this->add_control(
			'featured_title_heading',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .featured-part .avt-post-block-title a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'featured_show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'featured_title_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-block .featured-part .avt-post-block-title a',
				'condition' => [
					'featured_show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_date_heading',
			[
				'label'     => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_date_color',
			[
				'label'     => esc_html__( 'Date Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .featured-part .avt-post-block-meta span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'featured_show_date' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'featured_date_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-block .featured-part .avt-post-block-meta span',
				'condition' => [
					'featured_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_category_heading',
			[
				'label'     => esc_html__( 'Category', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_category_color',
			[
				'label'     => esc_html__( 'Category Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .featured-part .avt-post-block-meta a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'featured_show_category' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'featured_category_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-block .featured-part .avt-post-block-meta a',
				'condition' => [
					'featured_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_excerpt_category',
			[
				'label'     => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'featured_show_excerpt' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'featured_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .featured-part .avt-post-block-excerpt' => 'color: {{VALUE}};',
				],
				'condition' => [
					'featured_show_excerpt' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'featured_excerpt_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-block .featured-part .avt-post-block-excerpt',
				'condition' => [
					'featured_show_excerpt' => 'yes',
					'_skin'                 => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'trinity_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .featured-part .avt-overlay-primary' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'trinity',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_style',
			[
				'label'     => esc_html__( 'List Layout Style', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin'   => ['', 'genesis'],
				],
			]
		);

		$this->add_control(
			'list_layout_image_size',
			[
				'label' => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 64,
						'max'  => 150,
						'step' => 10,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .list-part .avt-post-block-thumbnail img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'list_layout_title_category',
			[
				'label' => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'list_layout_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .list-part .avt-post-block-title .avt-post-block-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_layout_title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-post-block .list-part .avt-post-block-title .avt-post-block-link',
			]
		);

		$this->add_control(
			'list_layout_date_heading',
			[
				'label'     => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'list_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'list_layout_date_color',
			[
				'label'     => esc_html__( 'Date Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .list-part .avt-post-block-meta span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'list_show_date' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'list_layout_date_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-block .list-part .avt-post-block-meta span',
				'condition' => [
					'list_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'list_layout_category_heading',
			[
				'label'     => esc_html__( 'Category', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'list_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'list_layout_category_color',
			[
				'label'     => esc_html__( 'Category Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .list-part .avt-post-block-meta a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'list_show_category' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'list_layout_category_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-block .list-part .avt-post-block-meta a',
				'condition' => [
					'list_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'list_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block.avt-post-block-skin-base .avt-list > li:nth-child(n+2)' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-block .list-part .avt-has-divider li > div' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'show_list_divider' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_read_more',
			[
				'label'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'featured_show_read_more' => 'yes',
					'_skin'                   => ['', 'genesis'],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_read_more_style' );

		$this->start_controls_tab(
			'tab_read_more_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'read_more_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'read_more_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'read_more_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-post-block .avt-post-block-read-more',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'read_more_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'read_more_box_shadow',
				'selector' => '{{WRAPPER}} .avt-post-block .avt-post-block-read-more',
			]
		);

		$this->add_control(
			'read_more_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'read_more_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-post-block .avt-post-block-read-more',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_read_more_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'read_more_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'read_more_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'read_more_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-block .avt-post-block-read-more:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'read_more_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
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

	public function get_posts_tags() {
		$taxonomy = $this->get_settings( 'taxonomy' );

		foreach ( $this->_query->posts as $post ) {
			if ( ! $taxonomy ) {
				$post->tags = [];

				continue;
			}

			$tags = wp_get_post_terms( $post->ID, $taxonomy );

			$tags_slugs = [];

			foreach ( $tags as $tag ) {
				$tags_slugs[ $tag->term_id ] = $tag;
			}

			$post->tags = $tags_slugs;
		}
	}

	public function query_posts($posts_per_page) {
		$query_args = Module::get_query_args( 'posts', $this->get_settings() );

		$query_args['posts_per_page'] = $posts_per_page;

		$this->_query = new \WP_Query( $query_args );
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'featured_excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt() {
		if ( ! $this->get_settings( 'featured_show_excerpt' ) ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		?>
		<div class="avt-post-block-excerpt">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render() {
		$settings = $this->get_settings();
		$id       = uniqid('avtpbm_');

		$animation        = ($settings['read_more_hover_animation']) ? ' elementor-animation-'.$settings['read_more_hover_animation'] : '';
		$avt_list_divider = ( $settings['show_list_divider'] ) ? ' avt-list-divider' : '';

		$this->query_posts($settings['posts_limit']);

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		if( $wp_query->have_posts() ) :

			$this->add_render_attribute(
				[
					'post-block' => [
						'id'    => esc_attr( $id ),
						'class' => [
							'avt-post-block',
							'avt-grid',
							'avt-grid-match',
							'avt-post-block-skin-base',
						],
						'avt-grid' => ''
					]
				]
			);

			if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
				// add old default
				$settings['icon'] = 'fas fa-arrow-right';
			}

			$migrated  = isset( $settings['__fa4_migrated']['post_block_icon'] );
			$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			?>
			<div <?php echo $this->get_render_attribute_string( 'post-block' ); ?>>

				<?php $avt_count = 0;
			
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					$placeholder_image_src = Utils::get_placeholder_image_src();

					$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );

					if ( ! $image_src ) {
						$image_src = $placeholder_image_src;
					} else {
						$image_src = $image_src[0];
					}
					
			  		if( $avt_count == 0) : ?>
			  			<div class="avt-width-1-2@m">
			  		<?php endif; ?>

		  			<?php $avt_count++; ?>
				  	<?php if( $avt_count <= $settings['featured_item']) : ?>

			  			<div class="avt-post-block-item featured-part avt-width-1-1@m avt-margin">
							<div class="avt-post-block-img-wrapper avt-margin-bottom">
								<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
				  					<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
				  				</a>
							</div>
					  		
					  		<div class="avt-post-block-desc">

								<?php if ('yes' == $settings['featured_show_title']) : ?>
									<h4 class="avt-post-block-title">
										<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-block-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
									</h4>
								<?php endif ?>

            	            	<?php if ($settings['featured_show_category'] or $settings['featured_show_date']) : ?>

            						<div class="avt-post-block-meta avt-subnav avt-flex-middle">
            							<?php if ($settings['featured_show_date']) : ?>
            								<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
            							<?php endif ?>

            							<?php if ($settings['featured_show_category']) : ?>
            								<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
            							<?php endif ?>
            							
            						</div>

            					<?php endif ?>

								<?php $this->render_excerpt(); ?>

								<?php if ($settings['featured_show_read_more']) : ?>
									<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-block-read-more avt-link-reset<?php echo esc_attr($animation); ?>"><?php echo esc_html($settings['read_more_text']); ?>
										
										<?php if ($settings['post_block_icon']['value']) : ?>
											<span class="avt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">

												<?php if ( $is_new || $migrated ) :
													Icons_Manager::render_icon( $settings['post_block_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
												else : ?>
													<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
												<?php endif; ?>

											</span>
										<?php endif; ?>
									</a>
								<?php endif ?>
					  		</div>
						</div>

						<?php if( $avt_count == $settings['featured_item']) : ?>

						</div>

				  		<div class="avt-width-1-2@m" avt-scrollspy="cls: avt-animation-fade; target: > ul > .avt-post-block-item; delay: 350;">
				  			<ul class="avt-list avt-list-large<?php echo esc_attr($avt_list_divider); ?>">

			  			<?php endif; ?>

					<?php else :

						$placeholder_image_src = Utils::get_placeholder_image_src();

						$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );

						if ( ! $image_src ) {
							$image_src = $placeholder_image_src;
						} else {
							$image_src = $image_src[0];
						}
			  			
			  			?>
			  			<li class="avt-post-block-item list-part">
				  			<div class="avt-grid avt-grid-small" avt-grid>
				  				<div class="avt-post-block-thumbnail avt-width-auto">
				  					<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
					  					<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
					  				</a>
				  				</div>
						  		<div class="avt-post-block-desc avt-width-expand">
									<?php if ('yes' == $settings['list_show_title']) : ?>
										<h4 class="avt-post-block-title">
											<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-block-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
										</h4>
									<?php endif ?>

					            	<?php if ($settings['list_show_category'] or $settings['list_show_date']) : ?>

										<div class="avt-post-block-meta avt-subnav avt-flex-middle">
											<?php if ($settings['list_show_date']) : ?>
												<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
											<?php endif ?>

											<?php if ($settings['list_show_category']) : ?>
												<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
											<?php endif ?>
											
										</div>
									<?php endif ?>
						  		</div>
							</div>
						</li>
					<?php endif; endwhile; ?>
					</ul>
				</div>		
			</div>
		
		 	<?php 
			wp_reset_postdata(); 
		endif;
	}
}