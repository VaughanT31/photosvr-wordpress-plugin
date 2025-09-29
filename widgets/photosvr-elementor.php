<?php

if(! defined( 'ABSPATH' ) ) {
	exit;
}

class Elementor_PhotoSVR_Widget extends \Elementor\Widget_base {
	public function get_name() {
		return 'PhotoSVR';
	}
	public function get_title() {
		return esc_html__('PhotoSVR','elementor-photosvr-widget');
	}
	public function get_icon() {
		return 'eicon-drag-n-drop';
	}
	public function get_custom_help_url() {
		return 'https://photosvr.net';
	}
	public function get_catgories() {
		return ['general'];
	}
	public function get_keywords() {
		return ['link','url','photosvr','Photo','SVR'];
	}
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[

				'label'		=> esc_html__('PhotoSVR to Display','elementor-photosvr-widget'),
				'tab'		=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'text_id',
			[
				'label'			=> esc_html__('Unique ID', 'elementor-photosvr-widget'),
				'type'			=> \Elementor\Controls_Manager::TEXT,
				'input_type'	=> 'text',
				'placeholder'	=> esc_html__('Enter Unique ID','elementor-photosvr-widget'),
			]
		);

		$this->add_control(
			'title',
			[
				'label'			=> esc_html('PhotoSVR Title','elementor-photosvr-widget'),
				'type'			=> \Elementor\Controls_Manager::TEXT,
				'input_type'	=> 'text',
				'placeholder' 	=> esc_html__('SVR Title','elementor-photosvr-widget'),
			]
		);

		$this->add_control(
			'url',
			[
				'label' 		=> esc_html__('PhotoSVR Blob URL','elementor-photosvr-widget'),
				'type'			=> \Elementor\Controls_Manager::TEXT,
				'input_type'	=> 'url',
				'placeholder'	=> esc_html__('https://photosvr.online/p/b652f643-93f4-4b76-9a56-a4fb797474e4','elementor-photosvr-widget'),
			]
		);

		$this->add_control(
			'list',
			[
				'label'			=> esc_html__('Sizes','elementor-photosvr-widget'),
				'type'			=> \Elementor\Controls_Manager::SELECT2,
				'label_block'	=> true,
				'multiple'		=> true,
				'options'		=> [
					'LD'		=> esc_html__('LD','elementor-photosvr-widget'),
					'SD'		=> esc_html__('SD','elementor-photosvr-widget'),
					'HD'		=> esc_html__('HD','elementor-photosvr-widget'),
					'XHD'		=> esc_html__('XHD','elementor-photosvr-widget'),
				],
				'default'		=> ['SD','XHD'],
			]
		);

		$this->add_control(
			'show_controls',
			[
				'label'			=> esc_html__('Show/Hide Controls','elementor-photosvr-widget'),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'true'		=> esc_html__('Hide Controls','elementor-photosvr-widget'),
					'false'		=> esc_html__('Show Controls',' elementor-photosvr-widget'),
				],
				'default'		=> 'true',
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label'			=> esc_html__('Aspect Ratio','elementor-photosvr-widget'),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'square'		=> esc_html__('1:1 Square','elementor-photosvr-widget'),
					'wide'		=> esc_html__('3:2 Wide',' elementor-photosvr-widget'),
				],
				'default'		=> 'wide',
			]
		);

		$this->end_controls_section();
	}
	protected function render() {

		$settings = $this->get_settings_for_display();
		$uniqueid = wp_oembed_get($settings['text_id']);
		$html = wp_oembed_get($settings['url']);
		$title = wp_oembed_get($settings['title']);
		$controls = wp_oembed_get($settings['show_controls']);
		$aspect_ratio = wp_oembed_get($settings['aspect_ratio']);

		if($settings['list'])
		{
			foreach($settings['list'] as $item) {
				$list[] = "'$item':true,";
			}
		}

		?>
		<script type="text/javascript" src="https://photosvr.online/js/obfuscated.5.3.js"></script>
		
		<div id="photosvr-<?php echo ($uniqueid) ? $uniqueid : $settings['text_id']; ?>" class="photosvr <?php echo ($aspect_ratio) ? $aspect_ratio : $settings['aspect_ratio']; ?>">

		</div>
		<script type="text/javascript">
			var ps = new photoSvr('photosvr-<?php echo ($uniqueid) ? $uniqueid : $settings["text_id"]; ?>','<?php echo ($html) ? $html : $settings["url"]; ?>', {"Title": "<?php echo ($title) ? $title : $settings["title"]; ?>", "Filename":"","NumCameras":8, "NumFrames": 40, "Dimensions":"0,0", "ClipRect":"0,0,0,0","StartFrame":"0,0", "OverlayFile": "https://photosvr.blob.core.windows.net/content/overlay.png?ver=1", "OverlayPostion":"0,0", "XLD":false, <?php foreach($list as $size) { echo $size; } ?> "HideControls": <?php echo ($controls) ? $controls : $settings['show_controls']; ?> },'/sd' );
		</script>

		<?php

	}
}