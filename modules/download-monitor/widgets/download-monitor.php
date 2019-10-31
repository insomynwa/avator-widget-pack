<?php
namespace WidgetPack\Modules\DownloadMonitor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DownloadMonitor extends Widget_Base {

	public function get_name() {
		return 'avt-download-monitor';
	}

	public function get_title() {
		return AWP . esc_html__( 'Download Monitor', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-download-monitor';
	}

	public function get_keywords() {
		return [ 'download', 'monitor' ];
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	protected function download_file_list() {
		$output       = '';
		$search_query = ( ! empty( $_POST['dlm_search'] ) ? esc_attr($_POST['dlm_search']) : '' );
		$limit        = 10;
		$page         = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
		$filters      = array( 'post_status' => 'publish' );
        if ( ! empty( $search_query ) ) { $filters['s'] = $search_query; }
        $d_num_rows = download_monitor()->service( 'download_repository' )->num_rows( $filters );
        $downloads  = download_monitor()->service( 'download_repository' )->retrieve( $filters, $limit, ( ( $page - 1 ) * $limit ) );

        foreach ( $downloads as $download ) {
        	$output[absint( $download->get_id() )] = $download->get_title() .' ('. $download->get_version()->get_filename() . ')';
        }

        return $output;
    }

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_download_monitor',
			[
				'label' => esc_html__( 'Content', 'avator-widget-pack' ),
			]
		);


		$file_list = $this->download_file_list();

		$this->add_control(
			'file_id',
			[
				'label'     => esc_html__( 'Select File', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $file_list,
			]
		);


		$this->add_control(
			'file_type_show',
			[
				'label'     => esc_html__( 'Show File Type', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'file_id!' => '',
				],
			]
		);

		$this->add_control(
			'file_size_show',
			[
				'label'     => esc_html__( 'Show File Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'file_id!' => '',
				],
			]
		);

		$this->add_control(
			'download_count_show',
			[
				'label'     => esc_html__( 'Show Download Count', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'file_id!' => '',
				],
			]
		);



		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'alt_title',
			[
				'label' => esc_html__( 'Alternative Title', 'avator-widget-pack' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'avator-widget-pack' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url'         => '#',
					'is_external' => '',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'prefix_class' => 'elementor-align%s-',
			]
		);

		$this->add_control(
			'download_monitor_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
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
					'download_monitor_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'download_monitor_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-download-monitor-button .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-download-monitor-button .avt-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();




		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_footer_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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
				'label' => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.avt-download-monitor-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.avt-download-monitor-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} a.avt-download-monitor-button',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} a.avt-download-monitor-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'button_border',
				'label' => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} a.avt-download-monitor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.avt-download-monitor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label' => esc_html__( 'Text Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.avt-download-monitor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => esc_html__( 'Title Typography', 'avator-widget-pack' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.avt-download-monitor-button .avt-dm-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_meta_typography',
				'label' => esc_html__( 'Meta Typography', 'avator-widget-pack' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.avt-download-monitor-button .avt-dm-meta > *',
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
				'label' => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.avt-download-monitor-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.avt-download-monitor-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background_hover_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} a.avt-download-monitor-button:hover',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} a.avt-download-monitor-button:hover',
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.avt-download-monitor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();




	}

	public function render() {
		$settings  = $this->get_settings();

		try {
			$download = download_monitor()->service( 'download_repository' )->retrieve_single( $settings['file_id'] );
		} catch ( \Exception $exception ) {
			$exception->getMessage();
			return;
		}

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-down';
		}

		$migrated  = isset( $settings['__fa4_migrated']['download_monitor_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		if (isset($download)) {

			$this->add_render_attribute(
				[
					'download-monitor-button' => [
						'class' => [
							'avt-download-monitor-button',
							'elementor-button',
							'elementor-size-sm',
							$settings['button_hover_animation'] ? 'elementor-animation-'.$settings['button_hover_animation'] : ''
						],
						'href' => [
							$download->get_the_download_link()
						],
						'target' => [
							$settings['link']['is_external'] ? "_blank" : "_self"
						]
					]
				]
			);

			?>
            <a <?php echo $this->get_render_attribute_string( 'download-monitor-button' ); ?>>

				<div class="avt-dm-description">
	            	<div class="avt-dm-title">
						<?php if ($settings['alt_title']) {
							echo esc_html( $settings['alt_title'] );
						} else {
							echo esc_html($download->get_title());
						} ?>
	            	</div>

					<div class="avt-dm-meta">
		            	<?php if ('yes' === $settings['file_type_show']) : ?>
		            	<div class="avt-dm-file">
		            		<?php echo esc_html($download->get_version()->get_filetype()); ?>
		            		
		            	</div>
		            	<?php endif; ?>
		            	
		            	<?php if ('yes' === $settings['file_size_show']) : ?>
		            	<div class="avt-dm-size">
		            		<?php echo esc_html($download->get_version()->get_filesize_formatted()); ?>
		            	</div>
		            	<?php endif; ?>

		            	<?php if ('yes' === $settings['download_count_show']) : ?>
		            	<div class="avt-dm-count">
		            		<?php esc_html_e('Downloaded', 'avator-widget-pack'); ?> <?php echo esc_html($download->get_download_count()); ?>
		            	</div>
		            	<?php endif; ?>
					</div>
				</div>
            	
            	<?php if ($settings['download_monitor_icon']['value']) : ?>
					<span class="avt-dm-button-icon avt-button-icon-align-<?php echo esc_html($settings['icon_align']); ?>">

						<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['download_monitor_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
				<?php endif; ?>

            </a>
			<?php
		}
	}

}