<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );

$all_photo_arr = array();
if(isset($_GET['gallery_id']) OR !empty($_GET['gallery_id']))
{
	$all_photo_arr = get_post_meta($_GET['gallery_id'], 'wpsimplegallery_gallery', true);
	
	//Get global gallery sorting
	$all_photo_arr = photography_resort_gallery_img($all_photo_arr);
}

header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="utf-8" ?>
		<bank>';
		
$tg_full_image_caption = kirki_get_option('tg_full_image_caption');

		
foreach($all_photo_arr as $photo_id)
{
	$full_image_url = wp_get_attachment_image_src( $photo_id, 'full' );
	$small_image_url = wp_get_attachment_image_src( $photo_id, 'large' );
	
	//Get image meta data
	$image_title = get_the_title($photo_id);
	$image_caption = get_post_field('post_excerpt', $photo_id);

	echo '<img>';
	echo '<src>'.$small_image_url[0].'</src>';
	echo '<link>'.$full_image_url[0].'</link>';
	
	if(!empty($tg_full_image_caption))
	{
		//Get image purchase URL
		$photography_purchase_url = get_post_meta($photo_id, 'photography_purchase_url', true);
		if(!empty($photography_purchase_url))
		{
			$image_caption.= '<br/><a href="'.esc_url($photography_purchase_url).'" class="button ghost"><i class="fa fa-shopping-cart marginright"></i>'.esc_html__('Purchase', 'photography-translation' ).'</a>';
		}
	
		echo '<caption>'.esc_attr($image_caption).'</caption>';
	}
	else
	{
		echo '<caption></caption>';
	}
	
	echo '</img>';
}
		
echo '</bank>';
?>
