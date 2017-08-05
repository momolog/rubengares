<?php
/**
 * The main template file for display fullscreen vimeo video
 *
 * @package WordPress
 */
 
//Check if content builder preview
if(isset($_GET['rel']) && !empty($_GET['rel']) && isset($_GET['ppb_preview']))
{
	get_template_part("page-preview");
	die;
}

$portfolio_video_id = get_post_meta($post->ID, 'portfolio_video_id', true);

//important to apply dynamic header & footer style
global $photography_homepage_style;
$photography_homepage_style = 'fullscreen_video';

get_header();
?>

<div id="youtube_bg">
	<iframe src="//www.youtube.com/embed/<?php echo esc_attr($portfolio_video_id); ?>?autoplay=1&hd=1&rel=0&showinfo=0&wmode=opaque" frameborder="0" allowfullscreen></iframe>
</div>

<?php
	get_footer();
?>