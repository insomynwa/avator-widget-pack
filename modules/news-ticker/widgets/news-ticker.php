<?php
namespace WidgetPack\Modules\NewsTicker\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use WidgetPack\Modules\QueryControl\Controls\Group_Control_Posts;
use WidgetPack\Modules\QueryControl\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class News Ticker
 */
class News_Ticker extends Widget_Base {

	/**
	 * @var \WP_Query
	 */
	private $_query = null;

	public function get_name() {
		return 'avt-news-ticker';
	}

	public function get_title() {
		return AWP . esc_html__( 'News Ticker', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-news-ticker';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'news', 'ticker', 'report', 'message', 'information', 'blog' ];
	}

	public function get_script_depends() {
		return ['avt-news-ticker'];
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

		$this->add_control(
			'show_label',
			[
				'label'   => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'news_label',
			[
				'label'       => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'LATEST NEWS', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'LATEST NEWS', 'avator-widget-pack' ),
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'news_content',
			[
				'label'   => esc_html__( 'News Content', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => [
					'title'   => esc_html__( 'Title', 'avator-widget-pack' ),
					'excerpt' => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'     => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'news_content' => 'title'
				],
			]
		);

		$this->add_control(
			'show_time',
			[
				'label'     => esc_html__( 'Time', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'news_content' => 'title'
				],
			]
		);

		$this->add_responsive_control(
            'news_ticker_height',
            [
				'label'   => __( 'Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 42,
				],
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-news-ticker' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}',
				],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label' => esc_html__( 'Navigation', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label'   => esc_html__( 'Navigation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'play_pause',
			[
				'label'   => esc_html__( 'Play/Pause Button', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'navigation_size',
			[
				'label'   => esc_html__( 'Navigation Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 3,
						'max' => 26,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-navigation svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_navigation' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'slider_animations',
			[
				'label'     => esc_html__( 'Animations', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'scroll'  	  => esc_html__( 'Scroll', 'avator-widget-pack' ),
					'slide-left'  => esc_html__( 'Slide Left', 'avator-widget-pack' ),
					'slide-up'    => esc_html__( 'Slide Up', 'avator-widget-pack' ),
					'slide-right' => esc_html__( 'Slide Right', 'avator-widget-pack' ),
					'slide-down'  => esc_html__( 'Slide Down', 'avator-widget-pack' ),
					'fade'        => esc_html__( 'Fade', 'avator-widget-pack' ),
					'typography'  => esc_html__( 'Typography', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);


		$this->add_control(
			'autoplay_interval',
			[
				'label'     => esc_html__( 'Autoplay Interval', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'   => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'              => esc_html__( 'Animation Speed', 'avator-widget-pack' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 500,
			]
		);

        $this->add_control(
            'scroll_speed',
            [
				'label'   => __( 'Scroll Speed', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'condition' => [
					'slider_animations' => 'scroll',
				],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_news_ticker',
			[
				'label'     => esc_html__( 'News Ticker', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_label',
			[
				'label'     => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-label-inner' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$border_side = is_rtl() ? 'right' : 'left';

		$this->add_control(
			'label_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-label'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-label:after' => 'border-' . $border_side . '-color: {{VALUE}};',
				],
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'label_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .avt-news-ticker .avt-news-ticker-label-inner',
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'heading_content',
			[
				'label' => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-content a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-content span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-news-ticker'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-content:before, {{WRAPPER}} .avt-news-ticker .avt-news-ticker-content:after'     => 'box-shadow: 0 0 12px 12px {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-news-ticker .avt-news-ticker-content',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => esc_html__( 'Navigation', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_navigation' => 'yes'
				]
			]
		);

		$this->add_control(
			'navigation_background',
			[
				'label'     => esc_html__( 'Navigation Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-navigation' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_arrow_style' );

		$this->start_controls_tab(
			'tab_arrow_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navigation_color',
			[
				'label'     => esc_html__( 'Navigation Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-navigation button span svg' => 'color: {{VALUE}}',
				],
			]
		);

		// $this->add_group_control(
		// 	Group_Control_Border::get_type(),
		// 	[
		// 		'name'        => 'arrow_border',
		// 		'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
		// 		'placeholder' => '1px',
		// 		'default'     => '1px',
		// 		'selector'    => '{{WRAPPER}} .avt-news-ticker .avt-news-ticker-navigation button',
		// 		'separator'   => 'before',
		// 	]
		// );

		// $this->add_control(
		// 	'arrow_border_radius',
		// 	[
		// 		'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
		// 		'type'       => Controls_Manager::DIMENSIONS,
		// 		'size_units' => [ 'px', '%' ],
		// 		'selectors'  => [
		// 			'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-navigation button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'arrow_padding',
		// 	[
		// 		'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
		// 		'type'       => Controls_Manager::DIMENSIONS,
		// 		'size_units' => [ 'px', 'em', '%' ],
		// 		'selectors'  => [
		// 			'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-navigation button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrow_hover',
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
					'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-navigation button:hover span svg' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'arrow_hover_border_color',
		// 	[
		// 		'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'condition' => [
		// 			'arrow_border_border!' => '',
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .avt-news-ticker .avt-news-ticker-navigation a:hover' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function query_posts() {
		$query_args = Module::get_query_args( 'posts', $this->get_settings() );

		$query_args['posts_per_page'] = $this->get_settings('posts_limit');

		$this->_query = new \WP_Query( $query_args );
	}

	public function render() {
		$settings = $this->get_settings();
		$this->query_posts();

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->render_header($settings);

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_loop_item($settings);
		}

		$this->render_footer($settings);

		wp_reset_postdata();

	}

	protected function render_title() {
		$classes = ['avt-news-ticker-content-title'];
		?>

		<a href="<?php echo esc_url(get_permalink()); ?>">
			<?php $this->render_date(); ?>

			<?php $this->render_time(); ?>

			<?php the_title() ?>
		</a>
		<?php
	}


	protected function render_excerpt() {
		
		?>
		<a href="<?php echo esc_url(get_permalink()); ?>">
			<?php the_excerpt(); ?>
		</a>
		<?php
	}

	protected function render_header($settings) {

	    $this->add_render_attribute(
			[
				'slider-settings' => [
					'class' => [
						'avt-news-ticker',
					],
					'data-settings' => [
						wp_json_encode(array_filter([
							"effect"       => $settings["slider_animations"],
							"autoPlay"     => ($settings["autoplay"]) ? true : false,
							"interval"     => $settings["autoplay_interval"],
							"pauseOnHover" => ($settings["pause_on_hover"]) ? true : false,
							"scrollSpeed"  => $settings["scroll_speed"]['size'],
							"direction"    => (is_rtl()) ? 'rtl' : false
						]))
					],
				]
			]
		);
	    
		?>
		<div id="newsTicker1" <?php echo $this->get_render_attribute_string( 'slider-settings' ); ?>>
			<?php if ( 'yes' == $settings['show_label'] ) : ?>
		    	<div class="avt-news-ticker-label">
					<div class="avt-news-ticker-label-inner">
						<?php echo wp_kses( $settings['news_label'], widget_pack_allow_tags('title') ); ?>
	    			</div>
	    		</div>
		    <?php endif; ?>
		    <div class="avt-news-ticker-content">
		        <ul>
		<?php
	}

	public function render_date() {

		if ( ! $this->get_settings('show_date') ) {
			return;
		}

		$news_month = get_the_date('m');
		$news_day = get_the_date('d');
		
		?>

		<span class="avt-news-ticker-date avt-margin-small-right" title="<?php esc_html_e( 'Published on:', 'avator-widget-pack' ); ?> <?php echo get_the_date(); ?>">
			<span class="avt-news-ticker-date-month"><?php echo esc_attr( $news_month ); ?></span>
			<span class="avt-news-ticker-date-sep">/</span>
			<span class="avt-news-ticker-date-day"><?php echo esc_attr( $news_day ); ?></span>
			<span>:</span>
		</span>

		<?php
	}

	public function render_time() {

		if ( ! $this->get_settings('show_time') ) {
			return;
		}

		$news_hour = get_the_time();
		//$news_day = get_the_time('d');
		
		?>

		<span class="avt-news-ticker-time avt-margin-small-right" title="<?php esc_html_e( 'Published on:', 'avator-widget-pack' ); ?> <?php echo get_the_date(); ?> <?php echo get_the_time(); ?>">
			<span class="avt-text-uppercase"><?php echo esc_attr( $news_hour ); ?></span>
			<span>:</span>
		</span>

		<?php
	}

	protected function render_footer($settings) {
		?>


		        </ul>
		    </div>
		    <?php if ( $settings['show_navigation'] ) : ?>
		    <div class="avt-news-ticker-controls avt-news-ticker-navigation">

		        <button class="avt-visible@m">
		        	<span class="avt-news-ticker-arrow avt-news-ticker-prev avt-icon">
		        		<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="chevron-left">
		        			<polyline fill="none" stroke="#000" stroke-width="1.03" points="13 16 7 10 13 4"></polyline>
		        		</svg>
		        	</span>
		        </button>

		        <?php if ($settings['play_pause']) : ?>
		        <button class="avt-visible@m">
		        	<span class="avt-news-ticker-action avt-icon">
		        		<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="play" class="avt-news-ticker-play-pause">
		        			<polygon fill="none" stroke="#000" points="4.9,3 16.1,10 4.9,17 "></polygon>

		        			<rect x="6" y="2" width="1" height="16"/>
							<rect x="13" y="2" width="1" height="16"/>
		        		</svg>
		        	</span>
		        </button>
		    	<?php endif ?>
		        
		        <button>
		        	<span class="avt-news-ticker-arrow avt-news-ticker-next avt-icon">
		        		<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="chevron-right">
		        			<polyline fill="none" stroke="#000" stroke-width="1.03" points="7 4 13 10 7 16"></polyline>
		        		</svg>
		        	</span>
		        </button>

		    </div>

			<?php endif; ?>
		</div>
		
		<?php
	}

	protected function render_loop_item($settings) {
		?>
		<li class="avt-news-ticker-item">
			

				<?php if( 'title' == $settings['news_content'] ) : ?>
					<?php $this->render_title(); ?>
				<?php endif; ?>

				<?php if( 'excerpt' == $settings['news_content'] )  : ?>
					<?php $this->render_excerpt(); ?>
				<?php endif; ?>

			
		</li>
		<?php
	}
}
