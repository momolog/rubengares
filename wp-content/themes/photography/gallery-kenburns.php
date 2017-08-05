<?php
/**
 * The main template file.
 *
 * @package WordPress
 */

/**
*	Get Current page object
**/
$page = get_page($post->ID);
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

//Check if gallery template
global $photography_page_gallery_id;
if(!empty($photography_page_gallery_id))
{
	$current_page_id = $photography_page_gallery_id;
}

//Check if password protected
get_template_part("/templates/template-password");

//important to apply dynamic header & footer style
global $photography_homepage_style;
$photography_homepage_style = 'fullscreen';

get_header(); 

wp_enqueue_script("photography-kenburns", get_template_directory_uri()."/js/kenburns.js", false, THEMEVERSION, true);
wp_enqueue_script("photography-kenburns-gallery", get_template_directory_uri()."/templates/script-kenburns-gallery.php?gallery_id=".$current_page_id, false, THEMEVERSION, true);
?>
<div id="kenburns_overlay"></div>
<canvas id="kenburns">
    <p><?php esc_html_e('Your browser doesn\'t support canvas!', 'photography-translation' ); ?></p>
</canvas>

<?php
	get_footer();
?>