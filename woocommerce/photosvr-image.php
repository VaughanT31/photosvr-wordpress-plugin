<?php
/**
* Add New Tab
**/

function photosvr_product_tab($default_tabs) {
	global $post;

	$tabs = array(
		'photosvr_tab' => array(
			'label'		=> esc_html__('PhotoSVR 3D Image', 'elementor-photosvr-widget'),
			'target'	=> 'photosvr_tab',
			'priority'	=> 60,
			'class'		=> array(),
		),
	);

	$default_tabs = array_merge($default_tabs,$tabs);
	return $default_tabs;
}

add_filter('woocommerce_product_data_tabs','photosvr_product_tab',10,1);

/**
* Add content to tab
**/

function photosvr_tab_field() {
	global $woocommerce, $post;
	?>
	<div id="photosvr_tab" class="panel woocommerce_options_panel">
		<?php
		woocommerce_wp_checkbox(
			array(
				'id'				=> '_photosvr_enabled',
				'label'				=> __('Enabled PhotoSVR','woocommerce'),
				'desc_tip'      	=> false,
				'cbvalue'			=> 'yes',
			)
		);
		woocommerce_wp_text_input(
			array(
				'id'                => '_photosvr_title',
				'label'             => __( 'PhotoSVR Title', 'woocommerce' ),
				'type'              => 'text',
			)
		);
		woocommerce_wp_text_input(
			array(
				'id'                => '_photosvr_blob_data',
				'label'             => __( 'PhotoSVR Blob URL', 'woocommerce' ),
				'desc_tip'          => 'true',
				'description'       => __( 'Enter the Blob URL you received from PhotoSVR.', 'woocommerce' ),
				'type'              => 'text',
			)
		);
		woocommerce_wp_select(
			array(
				'id'      => '_photosvr_size_data',
				'name'      => '_photosvr_size_data[]',
				'class'	  => 'wc-enhanced-select',
				'label'   => __( 'Select Sizes', 'woocommerce' ),
				'options' => array(
					'LD' => 'Low Definition - 640p',
					'SD' => 'Standard Definition - 720p',
					'HD' => 'High Definition - 1080p',
					'XHD' => 'Extra High Definition - 2160p',
				),
				'custom_attributes' => array('multiple' => 'multiple'),
				'default'	=> 'SD',
				'desc_tip'          => 'true',
				'description'       => __( 'Select multiple sizes you would like to display. This only works when you show controls', 'woocommerce' ),
			)
		);
		woocommerce_wp_select(
			array(
				'id'      => '_photosvr_hide_controls',
				'label'   => __( 'Show/Hide Controls', 'woocommerce' ),
				'options' => array(
					'true' => 'Hide Controls',
					'false' => 'Show Controls',
				),
				'default'	=> 'true',
			)
		);

		woocommerce_wp_select(
			array(
				'id'      => '_aspect_ratio',
				'label'   => __( 'Aspect Ratio', 'woocommerce' ),
				'options' => array(
					'square' => '1:1 Square',
					'wide' => '3:2 Wide',
				),
			)
		);
		?>
	</div>
	<?php
}
add_filter('woocommerce_product_data_panels','photosvr_tab_field',10,1);

add_action('woocommerce_process_product_meta','save_options');

function save_options($product_id) {
	$keys = array(
		'_photosvr_title',
		'_photosvr_blob_data',
		'_photosvr_size_data',
		'_photosvr_hide_controls',
		'_aspect_ratio',
	);

	foreach($keys as $key) {
		if(isset($_POST[$key])) {
			update_post_meta($product_id,$key, $_POST[$key]);

			$_photosvr_enabled = isset($_POST['_photosvr_enabled'] ) ? 'yes' : 'no';
			update_post_meta($product_id,'_photosvr_enabled',$_photosvr_enabled);
		}
	}
}