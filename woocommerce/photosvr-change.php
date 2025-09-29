<?php

function replace_thumbnail_photosvr($product_id) {

	global $woocommerce, $post;

	$enabled = get_post_meta($product_id,'_photosvr_enabled',true);

	if($enabled != "yes" ) {

		remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_images',20);

		function wc_template_loop_replaced_thumbnail() {

			global $woocommerce, $post;
			$product_id = $post->ID;
			$enabled = get_post_meta($product_id,'_photosvr_enabled',true);
			$title = get_post_meta($product_id,'_photosvr_title',true);
			$blob = get_post_meta($product_id,'_photosvr_blob_data',true);
			$sizes = get_post_meta($product_id,'_photosvr_size_data',true);
			$hideControls = get_post_meta($product_id,'_photosvr_hide_controls',true);
			$aspectRatio = get_post_meta($product_id,'_aspect_ratio',true);

			if($sizes)
			{
				foreach($sizes as $item) {
					$list[] = "'$item':true,";
				}
			}

			if($enabled == 'yes') {
				?>
				<script type="text/javascript" src="https://photosvr.online/js/obfuscated.5.3.js"></script>
				<div class="woocommerce-product-gallery images">
					<div class="woocommerce-product-gallery__wrapper">
						<div id="photosvr-<?php echo $product_id; ?>" class="photosvr <?php echo $aspectRatio; ?>">

						</div>
					</div>
				</div>
				<script type="text/javascript">
					var ps = new photoSvr('photosvr-<?php echo $product_id; ?>','<?php echo $blob; ?>', {"Title": "<?php echo $title; ?>", "Filename":"","NumCameras":8, "NumFrames": 40, "Dimensions":"0,0", "ClipRect":"0,0,0,0","StartFrame":"0,0", "OverlayFile": "https://photosvr.blob.core.windows.net/content/overlay.png?ver=1", "OverlayPostion":"0,0", "XLD":false, <?php foreach($list as $size) { echo $size; } ?> "HideControls": <?php echo $hideControls; ?> },'/sd' );
				</script>
				<?php
			} else {

				global $product;

				$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
				$post_thumbnail_id = $product->get_image_id();
				$wrapper_classes   = apply_filters(
					'woocommerce_single_product_image_gallery_classes',
					array(
						'woocommerce-product-gallery',
						'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
						'woocommerce-product-gallery--columns-' . absint( $columns ),
						'images',
					)
				);
				?>
				<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
					<div class="woocommerce-product-gallery__wrapper">
						<?php
						if ( $post_thumbnail_id ) {
							$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
						} else {
							$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
							$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
							$html .= '</div>';
						}

						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

						do_action( 'woocommerce_product_thumbnails' );
						?>
					</div>
				</div>
				<?php
			}

		}
		add_action('woocommerce_before_single_product_summary','wc_template_loop_replaced_thumbnail',20);

		?>

		<?php

	}
}
add_action('woocommerce_init','replace_thumbnail_photosvr');