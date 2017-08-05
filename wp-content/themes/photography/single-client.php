<?php
/**
 * The main template file for display client's galleries page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$ob_page = get_page($post->ID);
$current_page_id = '';

if(isset($ob_page->ID))
{
    $current_page_id = $ob_page->ID;
}

//Check if password protected
get_template_part("/templates/template-client-password");

get_header();

//Check if disable slideshow hover effect
$tg_gallery_hover_slide = kirki_get_option( "tg_gallery_hover_slide" );

if(!empty($tg_gallery_hover_slide))
{
	wp_enqueue_script("photography-jquery-cycle2", get_template_directory_uri()."/js/jquery.cycle2.min.js", false, THEMEVERSION, true);
	wp_enqueue_script("photography-custom-cycle", get_template_directory_uri()."/js/custom_cycle.js", false, THEMEVERSION, true);
}
?>

<?php
	global $photography_screen_class;
	$photography_screen_class = 'single_client';

    //Include custom header feature
	get_template_part("/templates/template-header");
?>

<!-- Begin content -->
<div class="inner">

	<div class="inner_wrapper nopadding">
	
	<div id="page_main_content" class="sidebar_content full_width nopadding fixed_column">
		
		<div id="client_header">
			<?php
				//Get client thumbnail
				$client_thumbnail = '';
				if(has_post_thumbnail($current_page_id, 'thumbnail') && empty($term))
			    {
			        $image_id = get_post_thumbnail_id($current_page_id); 
			        $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail', true);
			        
			        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
			        {
			        	$client_thumbnail = $image_thumb[0];
			        }
			    }
			    
			    if(!empty($client_thumbnail))
			    {
			?>
				<div class="client_thumbnail">
					<img src="<?php echo esc_url($client_thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"/>
				</div>
			<?php
			    }
			?>
	
			<?php 
		        if(have_posts()) 
				{
			?>
				 <div class="client_content">
				 	<h1><?php the_title(); ?></h1><br/>
				 	
				 	<hr class="title_break left"/><br class="clear"/>
				 	
				 	<div class="page_tagline">
						<?php
					        while ( have_posts() ) : the_post(); ?>		
						        <?php the_content(); break;  ?>
					    <?php endwhile; ?>
				 	</div>
		    	</div>
		    <?php
		    }
		    ?>
		    <br class="clear"/>
		</div>
	
	<div id="portfolio_filter_wrapper" class="gallery three_cols portfolio-content section content clearfix" data-columns="3">
	
	<?php
	    //Get galleries
	    $client_galleries = get_post_meta($current_page_id, 'client_galleries', true);
	
	    $key = 0;
	    if (!empty($client_galleries) && is_array($client_galleries))
	    {
	    	foreach($client_galleries as $client_gallery)
	    	{
		    	$small_image_url = array();
		        $image_url = '';
		        $gallery_ID = $client_gallery;
		        		
		        if(has_post_thumbnail($gallery_ID, 'original'))
		        {
		            $image_id = get_post_thumbnail_id($gallery_ID);
		            $small_image_url = wp_get_attachment_image_src($image_id, 'photography-gallery-grid', true);
		        }
		        
		        $permalink_url = get_permalink($gallery_ID);
		        $obj_gallery = get_post($gallery_ID);
	?>
		<div class="element grid classic3_cols">
		
			<div class="one_third gallery3 static filterable gallery_type archive animated<?php echo esc_attr($key+1); ?>" data-id="post-<?php echo esc_attr($key+1); ?>">
			
				<?php 
				    if(!empty($small_image_url[0]))
				    {
				?>	
				    <a href="<?php echo esc_url($permalink_url); ?>">
				    	<div class="gallery_archive_desc">
				    		<h4><?php echo esc_html($obj_gallery->post_title); ?></h4>
				    		<div class="post_detail"><p><?php echo esc_html($obj_gallery->post_excerpt); ?></p></div>
				    	</div>
				    	<?php
					    	$all_photo_arr = array();
					    	
					    	if(!empty($tg_gallery_hover_slide))
					    	{
					    		//Get gallery images
					    		$all_photo_arr = get_post_meta($gallery_ID, 'wpsimplegallery_gallery', true);
					    		
					    		//Get only 5 recent photos
					    		$all_photo_arr = array_slice($all_photo_arr, 0, 5);
					    	}
					    	
						    if(!empty($all_photo_arr))
						    {
						?>
						<ul class="gallery_img_slides">
						<?php
						    foreach($all_photo_arr as $photo)
						    {
						    	$slide_image_url = wp_get_attachment_image_src($photo, 'photography-gallery-grid', true);
						?>
						<li><img src="<?php echo esc_url($slide_image_url[0]); ?>" alt="" class="static"/></li>
						<?php
						    }
						?>
						</ul>
						<?php
						    }
						?>
				        <img src="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
				    </a>
				<?php
				    }		
				?>
			
			</div>
			
		</div>
	<?php
			}
	    $key++;
		}
	?>
		
	</div>
	
	</div>

</div>
</div>
<br class="clear"/>
</div>
<?php get_footer(); ?>
<!-- End content -->