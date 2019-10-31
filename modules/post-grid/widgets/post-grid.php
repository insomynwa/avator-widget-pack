<?php
namespace WidgetPack\Modules\PostGrid\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\QueryControl\Module;
use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;

use WidgetPack\Modules\PostGrid\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post_Grid extends Widget_Base {

	public function get_name() {
		return 'avt-post-grid';
	}

	public function get_title() {
		return AWP . esc_html__( 'Post Grid', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-post-grid';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'post', 'grid', 'blog', 'recent', 'news' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Modern( $this ) );
		$this->add_skin( new Skins\Skin_Elanza( $this ) );
		$this->add_skin( new Skins\Skin_Carmie( $this ) );
		$this->add_skin( new Skins\Skin_Trosia( $this ) );
		$this->add_skin( new Skins\Skin_Harold( $this ) );
		$this->add_skin( new Skins\Skin_Reverse( $this ) );
		$this->add_skin( new Skins\Skin_Alter( $this ) );
		$this->add_skin( new Skins\Skin_Paddle( $this ) );
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
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
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
				'condition' => [
					'_skin' => ['avt-carmie', 'avt-harold'],
				],
			]
		);

		$this->add_control(
			'carmie_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'_skin' => ['avt-carmie'],
				],
				'default' => [
					'size' => 6,
				],
			]
		);

		$this->add_control(
			'harold_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'_skin' => ['avt-harold'],
				],
				'default' => [
					'size' => 3,
				],
			]
		);

		$this->add_control(
			'trosia_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'_skin' => 'avt-trosia',
				],
				'default' => [
					'size' => 9,
				],
			]
		);

		$this->add_control(
			'reverse_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 21,
					],
				],
				'condition' => [
					'_skin' => 'avt-reverse',
				],
				'default' => [
					'size' => 6,
				],
			]
		);

		$this->add_control(
			'alter_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 21,
					],
				],
				'condition' => [
					'_skin' => 'avt-alter',
				],
				'default' => [
					'size' => 6,
				],
			]
		);

		$this->add_control(
			'paddle_item_limit',
			[
				'label' => esc_html__( 'Item Limit', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 21,
					],
				],
				'condition' => [
					'_skin' => 'avt-paddle',
				],
				'default' => [
					'size' => 8,
				],
			]
		);

		$this->add_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'small',
				'options' => [
					'small'    => esc_html__( 'Small', 'avator-widget-pack' ),
					'medium'   => esc_html__( 'Medium', 'avator-widget-pack' ),
					'large'    => esc_html__( 'Large', 'avator-widget-pack' ),
					'collapse' => esc_html__( 'Collapse', 'avator-widget-pack' ),
				],
				'condition' => [
					'_skin!' => ['avt-reverse', 'avt-alter']
				]
			]
		);

		$this->add_control(
			'odd_item_columns',
			[
				'label'          => esc_html__( 'Odd Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '2',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => [
					'_skin' => 'avt-paddle',
				],
			]
		);

		$this->add_control(
			'even_item_columns',
			[
				'label'          => esc_html__( 'Even Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'condition' => [
					'_skin' => 'avt-paddle',
				],
			]
		);

		$this->add_responsive_control(
			'primary_item_height',
			[
				'label' => esc_html__( 'Primary Item Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-primary .avt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin!' => ['avt-carmie', 'avt-trosia', 'avt-reverse', 'avt-alter', 'avt-paddle'],
				],
			]
		);

		$this->add_responsive_control(
			'odd_item_height',
			[
				'label' => esc_html__( 'Odd Item Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-primary .avt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => 'avt-paddle',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'primary_thumbnail',
				'exclude'   => [ 'custom' ],
				'default'   => 'full',
				'condition' => [
					'_skin' => ['', 'avt-harold', 'avt-elanza', 'avt-modern', 'avt-paddle'],
				],
			]
		);

		$this->add_responsive_control(
			'secondary_item_height',
			[
				'label' => esc_html__( 'Secondary Item Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-secondary .avt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin!' => ['avt-carmie', 'avt-trosia', 'avt-reverse', 'avt-alter', 'avt-paddle'],
				],
			]
		);

		$this->add_responsive_control(
			'even_item_height',
			[
				'label' => esc_html__( 'Even Item Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-secondary .avt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => 'avt-paddle',
				],
			]
		);

		$this->add_control(
			'secondary_grid_height',
			[
				'label'        => esc_html__('Secondary Grid Height', 'avator-widget-pack'),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'         => esc_html__('None', 'avator-widget-pack'),
					'match-height' => esc_html__('Match Height', 'avator-widget-pack'),
				],
				'condition' => [
					'_skin' => 'avt-harold'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'secondary_thumbnail',
				'default'   => 'medium',
				'exclude'   => [ 'custom' ],
				'condition' => [
					'_skin' => ['', 'avt-harold', 'avt-elanza', 'avt-modern', 'avt-paddle'],
				],
			]
		);

		$this->add_responsive_control(
			'carmie_item_height',
			[
				'label' => esc_html__( 'Item Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid.avt-post-grid-skin-carmie .avt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => 'avt-carmie',
				],
			]
		);

		$this->add_responsive_control(
			'trosia_item_height',
			[
				'label' => esc_html__( 'Item Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid.avt-post-grid-skin-trosia .avt-post-grid-img-wrap a' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => 'avt-trosia',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
				'exclude'   => [ 'custom' ],
				'condition' => [
					'_skin' => ['avt-carmie', 'avt-trosia', 'avt-reverse', 'avt-alter'],
				],
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label' => esc_html__( 'Pagination', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_grid_query',
			[
				'label' => esc_html__( 'Query', 'avator-widget-pack' ),
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
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date'  => esc_html__( 'Date', 'avator-widget-pack' ),
					'post_title' => esc_html__( 'Title', 'avator-widget-pack' ),
					'menu_order' => esc_html__( 'Menu Order', 'avator-widget-pack' ),
					'rand'       => esc_html__( 'Random', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'ASC', 'avator-widget-pack' ),
					'desc' => esc_html__( 'DESC', 'avator-widget-pack' ),
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
			'section_content_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
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
			'show_author',
			[
				'label'   => esc_html__( 'Author', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label'     => esc_html__( 'Comments', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'_skin!' => 'avt-carmie',
				],
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'   => esc_html__( 'Category', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
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
			'excerpt_length',
			[
				'label'      => esc_html__( 'Excerpt Length', 'avator-widget-pack' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 15,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes'
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'avt-harold'
						]
					]
				]
			]
		);

		$this->add_control(
			'primary_excerpt_length',
			[
				'label'      => esc_html__( 'Primary Excerpt Length', 'avator-widget-pack' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 40,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes'
						],
						[
							'name'  => '_skin',
							'value' => 'avt-harold'
						]
					]
				]
			]
		);

		$this->add_control(
			'secondary_excerpt_length',
			[
				'label'      => esc_html__( 'Secondary Excerpt Length', 'avator-widget-pack' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 15,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_excerpt',
							'value' => 'yes'
						],
						[
							'name'  => '_skin',
							'value' => 'avt-harold'
						]
					]
				]
			]
		);

		$this->add_control(
			'show_readmore',
			[
				'label'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'_skin!' => 'avt-carmie',
				],
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label'       => esc_html__( 'Read More Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
				'condition'   => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->add_control(
			'post_grid_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition'   => [
					'show_readmore' => 'yes',
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
					'post_grid_icon[value]!' => '',
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
					'post_grid_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-post-grid .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_animation',
			[
				'label'   => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'scale-up',
				'options' => [
					'scale-up'   => esc_html__( 'Scale-Up', 'avator-widget-pack' ),
					'scale-down' => esc_html__( 'Scale-Down', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-post-grid .avt-post-grid-item',
				'condition'   => [
					'_skin!' => ['avt-reverse', 'avt-alter'],
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-title'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-post-grid .avt-secondary .avt-post-grid-title' => 'margin-bottom: 0;',
				],
				'condition' => [
					'_skin!' => 'avt-carmie',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector'  => '{{WRAPPER}} .avt-post-grid .avt-post-grid-title a',
				'condition' => [
					'_skin' => ['avt-carmie', 'avt-reverse', 'avt-alter', 'avt-trosia'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'        => 'primary_title_typography',
				'label'       => esc_html__( 'Primary Typography', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} .avt-post-grid .avt-primary .avt-post-grid-title a',
				'condition'   => [
					'_skin!' => ['avt-carmie', 'avt-reverse', 'avt-alter', 'avt-trosia'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'        => 'secondary_title_typography',
				'label'       => esc_html__( 'Secondary Typography', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} .avt-post-grid .avt-secondary .avt-post-grid-title a',
				'condition'   => [
					'_skin!' => ['avt-carmie', 'avt-reverse', 'avt-alter', 'avt-trosia'],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_author',
			[
				'label'     => esc_html__( 'Author', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'author_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-author a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-post-grid .avt-post-grid-author a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_date',
			[
				'label'     => esc_html__( 'Date', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'date_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-subnav span:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'date_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .avt-post-grid .avt-post-grid-date',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_comments',
			[
				'label'      => esc_html__( 'Comments', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'show_comments',
							'value' => 'yes',
						],
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'avt-carmie',
						],
					],
				],
			]
		);

		$this->add_control(
			'comments_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-comments *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'comments_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .avt-post-grid .avt-post-grid-comments',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_category',
			[
				'label'     => esc_html__( 'Category', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__( 'Category Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-category a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-category a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .avt-post-grid .avt-post-grid-category a',
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
				'label'     => esc_html__( 'Excerpt Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .avt-post-grid .avt-post-grid-excerpt',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[
				'label'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_readmore' => 'yes',
 				],
			]
		);

		$this->start_controls_tabs( 'tabs_readmore_style' );

		$this->start_controls_tab(
			'tab_readmore_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'readmore_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'readmore_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_shadow',
				'selector' => '{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore',
			]
		);

		$this->add_responsive_control(
			'readmore_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'readmore_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_readmore_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'readmore_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'readmore_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-readmore:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_skin',
			[
				'label'     => esc_html__( 'Skin', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => ['avt-carmie', 'avt-trosia'],
				],
			]
		);

		$this->add_control(
			'carmie_desc_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-desc' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'avt-carmie',
				],
			]
		);

		$this->add_control(
			'overlay_background',
			[
				'label'     => esc_html__( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-grid .avt-custom-overlay' => 'background-color: {{VALUE}};',					
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-desc' => 'background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,{{VALUE)}} 70%);',
					'{{WRAPPER}} .avt-post-grid .avt-post-grid-desc' => 'background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,{{VALUE)}} 70%);',
				],
				'separator' => 'before',
				'condition' => [
					'_skin' => 'avt-trosia',
				],
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
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} ul.avt-pagination li a',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'pagination_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'selector'    => '{{WRAPPER}} ul.avt-pagination li a',
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
					'{{WRAPPER}} .avt-pagination' => 'margin-left: {{SIZE}}px;',
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
				'name'      => 'pagination_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} ul.avt-pagination li a:hover',
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

		$this->start_controls_section(
			'section_style_description',
			[
				'label'     => esc_html__( 'Description', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => ['avt-reverse', 'avt-alter'],
				],
			]
		);

		$this->add_control(
			'description_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-reverse .avt-post-grid-img-wrap:after'      => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .avt-plane .avt-post-grid-img-wrap:after'        => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-grid-skin-reverse .avt-post-grid-desc' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'avt-reverse',
				],
			]
		);

		$this->add_control(
			'alter_description_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-alter .avt-post-grid-img-wrap:after'      => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .avt-plane .avt-post-grid-img-wrap:after'      => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-grid-skin-alter .avt-post-grid-desc' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'_skin' => 'avt-alter',
				],
			]
		);

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

	public function render_image($image_id, $size) {
		$placeholder_image_src = Utils::get_placeholder_image_src();

		$image_src = wp_get_attachment_image_src( $image_id, $size );

		if ( ! $image_src ) {
			$image_src = $placeholder_image_src;
		} else {
			$image_src = $image_src[0];
		}

		echo 
			'<div class="avt-post-grid-img-wrap avt-overflow-hidden">
				<a href="' . esc_url(get_permalink()) . '" class="avt-transition-' . esc_attr($this->get_settings('image_animation')) . ' avt-background-cover avt-transition-opaque avt-flex" title="' . esc_attr(get_the_title()) . '" style="background-image: url(' . esc_url($image_src) . ')">
  				</a>
			</div>';
	}

	public function render_title() {

		if ( ! $this->get_settings('show_title') ) {
			return;
		}
		
		echo 
			'<h4 class="avt-post-grid-title">
				<a href="' . esc_url(get_permalink()) . '" class="avt-post-grid-link" title="' . esc_attr(get_the_title()) . '">
					' . esc_html(get_the_title())  . '
				</a>
			</h4>';
	}

	public function render_author() {

		if ( ! $this->get_settings('show_author') ) {
			return;
		}
		
		echo 
			'<span class="avt-post-grid-author"><a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author().'</a></span>';		
	}

	public function render_date() {

		if ( ! $this->get_settings('show_date') ) {
			return;
		}
		
		echo 
			'<span class="avt-post-grid-date">'.get_the_date().'</span>';		
	}

	public function render_comments() {

		if ( ! $this->get_settings('show_comments') ) {
			return;
		}
		
		echo 
			'<div class="avt-post-grid-comments avt-position-medium avt-position-bottom-right"><span><i class="ep-bubble" aria-hidden="true"></i> '.get_comments_number().'</span></div>';
	}

	public function render_category() {

		if ( ! $this->get_settings( 'show_category' ) ) { return; }
		?>
		<div class="avt-post-grid-category avt-position-small avt-position-top-left">
			<?php echo get_the_category_list(' '); ?>
		</div>
		<?php
	}

	public function render_excerpt($excerpt_length ) {

		if ( ! $this->get_settings('show_excerpt') ) {
			return;
		}
		
		echo 
			'<div class="avt-post-grid-excerpt">' . \widget_pack_helper::custom_excerpt( $excerpt_length) . '</div>';
	}

	public function render_readmore() {
		$settings        = $this->get_settings_for_display();

		if ( ! $this->get_settings('show_readmore') ) {
			return;
		}
		
		$animation = ($this->get_settings('readmore_hover_animation')) ? ' elementor-animation-'.$this->get_settings('readmore_hover_animation') : '';

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['post_grid_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>

		<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-grid-readmore avt-display-inline-block <?php echo esc_attr($animation); ?>">
				<?php echo esc_html($this->get_settings('readmore_text')); ?>
				
				<?php if ( $settings['post_grid_icon']['value']) : ?>
						<span class="avt-button-icon-align-<?php echo esc_attr($this->get_settings('icon_align')); ?>">

							<?php if ( $is_new || $migrated ) :
								Icons_Manager::render_icon( $settings['post_grid_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
							else : ?>
								<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
							<?php endif; ?>

						</span>
				<?php endif; ?>
		</a>
		<?php
	}

	public function render_post_grid_item( $post_id, $image_size, $excerpt_length ) {
		$settings = $this->get_settings();

		?>
		<div class="avt-post-grid-item avt-transition-toggle avt-position-relative">
								
			<?php $this->render_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>

			<div class="avt-custom-overlay avt-position-cover"></div>
	  		
	  		<div class="avt-post-grid-desc avt-position-medium avt-position-bottom-left">

				<?php $this->render_title(); ?>

            	<?php if ($settings['show_author'] or $settings['show_date']) : ?>
					<div class="avt-post-grid-meta avt-subnav avt-flex-middle">
						<?php $this->render_author(); ?>
						<?php $this->render_date(); ?>
					</div>
				<?php endif; ?>

				<?php $this->render_excerpt($excerpt_length); ?>
				<?php $this->render_readmore(); ?>

			</div>

			<?php $this->render_category(); ?>
			<?php $this->render_comments(); ?>

		</div>
		<?php
	}


	protected function render() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$this->query_posts(5);
		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		?> 
		<div id="avt-post-grid-<?php echo esc_attr($id); ?>" class="avt-post-grid avt-post-grid-skin-default">
	  		<div class="avt-grid avt-grid-<?php echo esc_attr($settings['column_gap']); ?>" avt-grid>

				<?php $avt_count = 0;
			
				while ($wp_query->have_posts()) :
					$wp_query->the_post();
						
		  			$avt_count++;

		  			if ( $avt_count <= 2) {
		  				$avt_grid_raw = 2;
		  				$avt_post_class = ' avt-primary';
		  				$thumbnail_size = $settings['primary_thumbnail_size'];
		  			} else {
		  				$avt_grid_raw = 3;
		  				$avt_post_class = ' avt-secondary';
		  				$thumbnail_size = $settings['secondary_thumbnail_size'];
		  			}

		  			$avt_grid_raw = ( $avt_count <= 2) ? 2 : 3;
		  			$avt_post_class = ( $avt_count <= 2) ? ' avt-primary' : ' avt-secondary';
		  			?>

		  			<div class="avt-width-1-<?php echo esc_attr($avt_grid_raw); ?>@m<?php echo esc_attr($avt_post_class); ?>">
						<?php $this->render_post_grid_item( get_the_ID(), $thumbnail_size, $settings['excerpt_length'] ); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	
 		<?php 

 		if ($settings['show_pagination']) {
 			widget_pack_post_pagination($wp_query);
 		}
		wp_reset_postdata();
	}
}