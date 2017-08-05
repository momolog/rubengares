<?php
/**
 * The main template file for client password page
 *
 * @package WordPress
*/

session_start();

/**
*	Get current page id
**/
$current_page_id = '';

/**
*	Get Current page object
**/

$page = get_page($post->ID);

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

//Check if password protected
$client_password = get_post_meta($current_page_id, 'client_password', true);

if(!empty($client_password) && (!isset($_SESSION['gallery_page_'.$current_page_id]) OR empty($_SESSION['gallery_page_'.$current_page_id])))
{
	$notice_text = '';
	if(isset($_POST['gallery_password']))
	{
		//check gallery password
		$client_password = get_post_meta($current_page_id, 'client_password', true);
		
		if($_POST['gallery_password'] != $client_password)
		{
			$notice_text = esc_html__('Error Password is incorrect', 'photography-translation' );
		}
		else
		{	
			$_SESSION['gallery_page_'.$current_page_id] = $current_page_id;
			
			$permalink = get_permalink($current_page_id);
			header("Location: ".$permalink);
			exit;
		}
	}
	
	global $photography_homepage_style;
	$photography_homepage_style = 'fullscreen';
	
	get_header(); 
	?>
	
	<br class="clear"/>
	
	<?php
	 //Get client's galleries
	 $image_thumb = '';
	 $client_galleries = get_post_meta($current_page_id, 'client_galleries', true);
	 
	 if(!empty($client_galleries) && is_array($client_galleries))
	 {
	   	foreach($client_galleries as $client_gallery)
	    {
	    	$gallery_ID = $client_gallery;
		        		
		    if(has_post_thumbnail($gallery_ID, 'original'))
		    {
		        $image_id = get_post_thumbnail_id($gallery_ID);
		        $image_thumb = wp_get_attachment_image_src($image_id, 'original', true);
		        break;
		    }
	    }
	}
	?>
	<div class="password_overlay"></div>
	<div class="password_container" <?php if(isset($image_thumb[0]) && !empty($image_thumb[0])) { ?>style="background-image:url(<?php echo esc_url($image_thumb[0]); ?>);"<?php }?>>
		<div class="password_wrapper">
			<!-- Begin main content -->
		    <div class="vertical_center_wrapper transparentbg" style="text-align:center">
			    <div class="overlay_gallery_wrapper">
				    <div class="overlay_gallery_border">
					    <div class="overlay_gallery_content">
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
							
							<h1><?php the_title(); ?></h1><br/>
					    	
					        <p><?php esc_html_e('This is restricted area. Please enter your password below to authenticate', 'photography-translation' ); ?></p><br/>
					        	
					        <?php 
					            if(!empty($notice_text))
					            {
					        ?>
					            	<span class="error"><?php echo esc_html($notice_text); ?></span>
					        <?php
					            }
					        ?>
					        <form id="gallery_password_form" method="post" action="<?php echo get_permalink($current_page_id); ?>">
					            <input id="gallery_password" name="gallery_password" type="password" placeholder="<?php echo esc_attr(esc_html__('Password', 'photography-translation' )); ?>"/><br/><br/>
					            <input type="submit" value="<?php echo esc_html__('Login', 'photography-translation' ); ?>" class="login_gallery"/>
					        </form>
					    </div>
				    </div>
			    </div>
		    </div>
		</div>
	</div>
	<?php get_footer(); ?>
<?php

exit;
}
?>