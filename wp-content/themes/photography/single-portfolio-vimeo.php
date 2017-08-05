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

<div id="vimeo_bg">
	<iframe frameborder="0" src="http://player.vimeo.com/video/<?php echo esc_attr($portfolio_video_id); ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1&amp;loop=0" webkitallowfullscreen="" allowfullscreen=""></iframe>
</div>

<?php
	get_footer();
?>