<?php
/**
 * The main template file for display gallery page.
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
global $photograhy_page_gallery_id;
if(!empty($photograhy_page_gallery_id))
{
	$current_page_id = $photograhy_page_gallery_id;
}

//Check if password protected
get_template_part("/templates/template-password");

//Get gallery images
$all_photo_arr = array();

if(!isset($_GET['view'])) 
{
	$all_photo_arr = get_post_meta($current_page_id, 'wpsimplegallery_gallery', true);
}
else if(isset($_GET['view']) && $_GET['view'] == 'approve')
{
	$all_photo_arr = get_post_meta($current_page_id, 'gallery_images_approve', true);
}
else if(isset($_GET['view']) && $_GET['view'] == 'reject')
{
	$all_photo_arr = get_post_meta($current_page_id, 'wpsimplegallery_gallery', true);
	$current_images_approve = get_post_meta($current_page_id, 'gallery_images_approve', true);
	
	$all_photo_arr = array_diff($all_photo_arr, $current_images_approve);
}

//Get global gallery sorting
$all_photo_arr = photography_resort_gallery_img($all_photo_arr);

get_header();

global $photography_topbar;

//Get gallery header
get_template_part("/templates/template-gallery-header");

wp_register_script("photography-script-gallery-image-proofing-".$current_page_id, get_template_directory_uri()."/js/custom_proofing.js", false, THEMEVERSION, true);

$params = array(
  'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
  'ajax_nonce' => wp_create_nonce('tgajax-post-contact-nonce'),
);

wp_localize_script("photography-script-gallery-image-proofing-".$current_page_id, 'tgAjax', $params );

wp_enqueue_script("photography-script-gallery-image-proofing-".$current_page_id, get_template_directory_uri()."/js/custom_proofing.js", false, THEMEVERSION, true);


//Get current approved images
$current_images_approve = get_post_meta($current_page_id, 'gallery_images_approve', true);
if(!is_array($current_images_approve))
{
	$current_images_approve = array();
}
?>
<input type="hidden" id="gallery_proofing_status" name="gallery_proofing_status" value="0"/>

<ul class="portfolio_wall_filters filter full"> 
	<li>
		<a <?php if(!isset($_GET['view'])) { ?>class="active"<?php } ?> href="<?php echo esc_url(get_permalink($current_page_id)); ?>"><?php echo esc_html_e('All', 'photography-translation' ); ?></a>
		<span class="separator">/</span>
	</li>
	<li>
		<a <?php if(isset($_GET['view']) && $_GET['view'] == 'approve') { ?>class="active"<?php } ?> href="<?php echo esc_url(add_query_arg('view', 'approve', get_permalink($current_page_id))); ?>"><?php echo esc_html_e('Approved Photos', 'photography-translation' ); ?></a>
		<span class="separator">/</span>
	</li>
	<li>
		<a <?php if(isset($_GET['view']) && $_GET['view'] == 'reject') { ?>class="active"<?php } ?> href="<?php echo esc_url(add_query_arg('view', 'reject', get_permalink($current_page_id))); ?>"><?php echo esc_html_e('Rejected Photos', 'photography-translation' ); ?></a>
		<span class="separator">/</span>
	</li>
</ul>
    
<div class="inner">

	<?php
		//Check gallery proofing columns
		$tg_gallery_proofing_columns = kirki_get_option('tg_gallery_proofing_columns');
		if(THEMEDEMO && isset($_GET['columns']))
		{
			$tg_gallery_proofing_columns = $_GET['columns'];
		}
		
		switch($tg_gallery_proofing_columns)
		{
			case 1:
				$wrapper_class = 'one_cols';
				$grid_wrapper_class = 'classic1_cols';
				$column_class = 'one gallery1';
			break;
			
			case 2:
				$wrapper_class = 'two_cols';
				$grid_wrapper_class = 'classic2_cols';
				$column_class = 'one_half gallery2';
			break;
			
			case 3:
			default:
				$wrapper_class = 'three_cols';
				$grid_wrapper_class = 'classic3_cols';
				$column_class = 'one_third gallery3';
			break;
			
			case 4:
				$wrapper_class = 'four_cols';
				$grid_wrapper_class = 'classic4_cols';
				$column_class = 'one_fourth gallery4';
			break;
		}
	?>

	<div class="inner_wrapper nopadding">
	
	<div id="page_main_content" class="sidebar_content full_width nopadding fixed_column">
	
	<div id="portfolio_filter_wrapper" class="gallery <?php echo esc_attr($wrapper_class); ?> portfolio-content section content clearfix" data-columns="<?php echo esc_attr($tg_gallery_proofing_columns); ?>">
	
	<?php
		$tg_full_image_caption = kirki_get_option('tg_full_image_caption');
	
	    foreach($all_photo_arr as $key => $photo_id)
	    {
	        $small_image_url = '';
	        $image_url = '';
	        
	        if(!empty($photo_id))
	        {
	        	$image_url = wp_get_attachment_image_src($photo_id, 'original', true);
	        	$small_image_url = wp_get_attachment_image_src($photo_id, 'photography-gallery-masonry', true);
	        }
	        
	        //Get image meta data
	        $image_caption = get_post_field('post_excerpt', $photo_id);
	        $image_alt = get_post_meta($photo_id, '_wp_attachment_image_alt', true);
	        
	        //Get image purchase URL
			$photography_purchase_url = get_post_meta($photo_id, 'photography_purchase_url', true);
			
			if(!empty($photography_purchase_url))
			{
			    $image_caption.= '<a href="'.esc_url($photography_purchase_url).'" class="button ghost"><i class="fa fa-shopping-cart marginright"></i>'.esc_html__('Purchase', 'photography-translation' ).'</a>';
			}
	?>
	<div class="element grid <?php echo esc_attr($grid_wrapper_class); ?>">
	
		<div class="<?php echo esc_attr($column_class); ?> classic static filterable gallery_type animated<?php echo esc_attr($key+1); ?> proofing" data-id="post-<?php echo esc_attr($key+1); ?>">
		
			<?php 
			    if(isset($image_url[0]) && !empty($image_url[0]))
			    {	
			    	$is_approved = in_array($photo_id, $current_images_approve);
			?>		
			    <div id="image<?php echo esc_attr($photo_id); ?>_wrapper" class="overlay_mask">
			        <img src="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
			        
			        <div class="loading hidden"><i class="fa fa-circle-o-notch fa-spin"></i></div>
			        
			        <div class="onapprove <?php if(!$is_approved) { ?>hidden<?php } ?>"><?php esc_html_e('Approved', 'photography-translation' ); ?></div>
			        
			        <?php
			        	//Check how to display photo info
			        	$tg_gallery_proofing_info = kirki_get_option('tg_gallery_proofing_info');
			        	$gallery_proofing_info = '';
			        	
			        	if($tg_gallery_proofing_info == 'wordpress_id')
			        	{
			        		$gallery_proofing_info = $photo_id;
			        	}
			        	else if($tg_gallery_proofing_info == 'title')
			        	{
			        		$image_title = get_post_field('post_title', $photo_id);
			        		$gallery_proofing_info = $image_title;
			        	}
			        	else
			        	{
				        	$gallery_proofing_meta = wp_get_attachment_metadata($photo_id);
				        	
				        	if(isset($gallery_proofing_meta['file']))
				        	{
				        		$gallery_proofing_info = basename($gallery_proofing_meta['file']);
				        	}
			        	}
			        	
			        	if(!empty($gallery_proofing_info))
			        	{
			        ?>
			        	<div class="proofing_id"><?php echo esc_html($gallery_proofing_info); ?></div>
			        <?php
			        	}
			        ?>
			        
			        <div class="portfolio_classic_icon_wrapper">
					    <div class="portfolio_classic_icon_content">
					    	<div class="portfolio_classic_icon_content_middle">
						    	<a title="<?php esc_html_e('View', 'photography-translation' ); ?>" id="image<?php echo esc_attr($photo_id); ?>_image" <?php if(!empty($tg_full_image_caption)) { ?>data-caption="<?php if(!empty($image_caption)) { ?><?php echo esc_attr($image_caption); ?><?php } ?>"<?php } ?> class="fancy-gallery tooltip" href="<?php echo esc_url($image_url[0]); ?>">
							    	<i class="fa fa-search-plus"></i>
						    	</a>
						    	<a title="<?php esc_html_e('Download', 'photography-translation' ); ?>" id="image<?php echo esc_attr($photo_id); ?>_download" href="<?php echo esc_url($image_url[0]); ?>" class="tooltip" target="_blank">
							    	<i class="fa fa-download"></i>
						    	</a>
						    	<a title="<?php esc_html_e('Approve', 'photography-translation' ); ?>" id="image<?php echo esc_attr($photo_id); ?>_approve" href="javascript:;" class="image_approve <?php if($is_approved) { ?>hidden<?php } ?> tooltip" data-image="<?php echo esc_attr($photo_id); ?>" data-gallery="<?php echo esc_attr($current_page_id); ?>">
						    		<i class="fa fa-check"></i>
						    	</a>
						    	
						    	<a title="<?php esc_html_e('Reject', 'photography-translation' ); ?>" id="image<?php echo esc_attr($photo_id); ?>_unapprove" href="javascript:;" class="image_unapprove <?php if(!$is_approved) { ?>hidden<?php } ?> tooltip" data-image="<?php echo esc_attr($photo_id); ?>" data-gallery="<?php echo esc_attr($current_page_id); ?>">
						    		<i class="fa fa-minus"></i>
						    	</a>
					    	</div>
					    </div>
					</div>
			    </div>
			<?php
			    }		
			?>
		
		</div>
		
	</div>
	<?php
		}
	?>
		
	</div>
	
	<?php 
        if ( have_posts() ) {
        while ( have_posts() ) : the_post(); ?>		
    
        <br class="clear"/><?php the_content(); break;  ?><br/>

    <?php endwhile; 
    }
    ?>
    
    <?php
	if (comments_open($post->ID)) 
	{
	?>
	<div class="fullwidth_comment_wrapper">
		<?php comments_template( '', true ); ?>
	</div>
	<?php
	}
	?>
	
	</div>

</div>
</div>
<br class="clear"/>
</div>
<?php get_footer(); ?>
<!-- End content -->