<?php
namespace WidgetPack\Modules\Comment\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Comment extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'avt-comment'; 
	}

	public function get_title() {
		return AWP . esc_html__( 'Comment', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-comment';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'comment', 'remark', 'note' ];
	}

	public function get_script_depends() {
		return [ 'wipa-comment' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/csvMTyUx7Hs';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);


		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Comment Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' =>  [
					''         => esc_html__( 'Select', 'avator-widget-pack' ),
					'disqus'   => esc_html__( 'Disqus', 'avator-widget-pack' ),
					'facebook' => esc_html__( 'Facebook', 'avator-widget-pack' ),
				],
			]
		);


		$this->add_control(
			'comments_number',
			[
				'label'       => __( 'Comment Count', 'avator-widget-pack' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 5,
				'max'         => 100,
				'default'     => 10,
				'description' => __( 'Minimum number of comments: 5', 'avator-widget-pack' ),
				'condition' => [
					'layout' => 'facebook',
				]
			]
		);

		$this->add_control(
			'order_by',
			[
				'label'   => __( 'Order By', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'social',
				'options' => [
					'social'       => __( 'Social', 'avator-widget-pack' ),
					'reverse_time' => __( 'Reverse Time', 'avator-widget-pack' ),
					'time'         => __( 'Time', 'avator-widget-pack' ),
				],
				'condition' => [
					'layout' => 'facebook',
				]
			]
		);

		$this->end_controls_section();
	}


	public function render() {
		$settings  = $this->get_settings();
		$id        = $this->get_id();
		$permalink = get_the_permalink();
		$options   = get_option( 'widget_pack_api_settings' );
		$user_name = (!empty($options['disqus_user_name'])) ? $options['disqus_user_name'] : 'avator';
		$app_id    = (!empty($options['facebook_app_id'])) ? $options['facebook_app_id'] : '461738690569028';

		$this->add_render_attribute( 'comment', 'class', 'avt-comment-container' );

		$this->add_render_attribute(
			[
				'comment' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"layout" => $settings["layout"],
							"username" => $user_name,
							"permalink" => $permalink,
							"app_id" => $app_id,
				        ]))
					],
					"style" => "min-height: 1px;",
				]
			]
		);
		
		?>
		
		<div <?php echo $this->get_render_attribute_string( 'comment' ); ?>>
			<?php if ('disqus' === $settings['layout']) : ?>
				<div id="disqus_thread"></div>
				
				<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

			<?php elseif('facebook' === $settings['layout']) : ?>
				<?php 
					$attributes = [
						'class'         => 'fb-comments',
						'data-href'     => $permalink,
						'data-numposts' => $settings['comments_number'],
						'data-order-by' => $settings['order_by'],
					];

					$this->add_render_attribute( 'fb-comment', $attributes );
				?>
				<div <?php echo $this->get_render_attribute_string( 'fb-comment' ); ?>></div>
				<div id="fb-root"></div>
			<?php else : ?>
				<div class="avt-alert-warning" avt-alert>
				    <a class="avt-alert-close" avt-close></a>
				    <p>Select your comment provider from settings.</p>
				</div>
			<?php endif; ?>
			<div class="avt-clearfix"></div>
		</div>
		<?php
	}

}
