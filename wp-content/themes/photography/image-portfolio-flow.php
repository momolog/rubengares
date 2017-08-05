<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );

//Get all portfolio items
$query_string = 'orderby=menu_order&order=ASC&post_type=portfolios&numberposts=-1&suppress_filters=0&posts_per_page=-1';
	
if(!empty($term))
{
    $ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    $custom_tax = $wp_query->query_vars['taxonomy'];
    $query_string .= '&posts_per_page=-1&'.$custom_tax.'='.$term;
}
query_posts($query_string);

header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="utf-8" ?>
		<bank>';
		
$tg_full_image_caption = kirki_get_option('tg_full_image_caption');

		
if (have_posts()) : while (have_posts()) : the_post();
	$image_url = '';
	$portfolio_ID = get_the_ID();
	    	
	if(has_post_thumbnail($portfolio_ID, 'original'))
	{
	    $image_id = get_post_thumbnail_id($portfolio_ID);
	    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
	}
	
	//Get image meta data
	$image_title = get_the_title();
	$image_excerpt = get_post_field('post_excerpt', $portfolio_ID);
	
	$portfolio_content = '<h4>'.$image_title.'</h4>';
	if(!empty($image_excerpt))
	{
		$portfolio_content.= '<div class="post_detail">'.$image_excerpt.'</div>';
	}

	echo '<img>';
	echo '<src>'.$image_url[0].'</src>';
	echo '<caption>'.esc_attr($portfolio_content).'</caption>';
	
	$portfolio_type = get_post_meta($portfolio_ID, 'portfolio_type', true);
	$portfolio_video_id = get_post_meta($portfolio_ID, 'portfolio_video_id', true);
	
	switch($portfolio_type)
	{
	    case 'External Link':
	    	$portfolio_link_url = get_post_meta($portfolio_ID, 'portfolio_link_url', true);
	    	echo '<link>'.esc_url($portfolio_link_url).'</link>';
	    break;
	    
	    case 'Portfolio Content':
	    	echo '<link>'.esc_url(get_permalink($portfolio_ID)).'</link>';
	    break;
	    
	    case 'Image':
	    default:
	    	echo '<link>'.$image_url[0].'</link>';
	    break;
	    
	    case 'Youtube Video':
	    	echo '<link>'.esc_url('https://www.youtube.com/embed/'.esc_attr($portfolio_video_id)).'</link>';
	    break;
	    
	    case 'Vimeo Video':
	    	echo '<link>'.esc_url('https://player.vimeo.com/video/'.esc_attr($portfolio_video_id)).'</link>';
	    break;
	}
	
	echo '</img>';
	
endwhile; endif;
		
echo '</bank>';
?>
