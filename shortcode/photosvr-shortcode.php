<?php

// create shortcode

function photosvr($atts) {
	$atts = shortcode_atts(
		array(
			'id'			=> '',
			'title'			=> '',
			'url'			=> '',
			'sizes'			=> 'SD,XHD',
			'hideControls'	=> 'true',
			'aspect_ratio'	=> '',
		), $atts, 'photosvr'
	);

	$sizes = explode(',', $atts["sizes"]);
	foreach($sizes as $size) {
		$list[] = "'$size':true";
	}

	foreach($list as $size) {
		$join = join(',',$list);
	}

	$e = '<script type="text/javascript" src="https://photosvr.online/js/obfuscated.5.3.js"></script>';
	$e .= '<div id="photosvr-'.esc_html($atts["id"]).'" class="photosvr '.esc_html($atts["aspect_ratio"]).'">';
	$e .= '</div>';
	$e .= '<script type="text/javascript">
		var ps = new photoSvr("photosvr-'.esc_html($atts["id"]).'","'.esc_html($atts["url"]).'", {"Title": "'.esc_html($atts["title"]).'", "Filename":"","NumCameras":8, "NumFrames": 40, "Dimensions":"0,0", "ClipRect":"0,0,0,0","StartFrame":"0,0", "OverlayFile": "https://photosvr.blob.core.windows.net/content/overlay.png?ver=1", "OverlayPostion":"0,0", "XLD":false,'.$join.', "HideControls": '.esc_html($atts['hideControls']).' },"/sd" );
	</script>';

	return $e;
}

function photosvr_shortcode_init() {
	add_shortcode('photosvr','photosvr');
}

add_action('init','photosvr_shortcode_init');