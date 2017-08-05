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
global $photography_page_gallery_id;
if(!empty($photography_page_gallery_id))
{
	$current_page_id = $photography_page_gallery_id;
}

//Check if password protected
get_template_part("/templates/template-password");

//Get gallery images
$all_photo_arr = get_post_meta($current_page_id, 'wpsimplegallery_gallery', true);

//Get global gallery sorting
$all_photo_arr = photography_resort_gallery_img($all_photo_arr);

global $photography_homepage_style;

$tg_menu_layout = photography_menu_layout();
if($tg_menu_layout == 'leftmenu')
{
	$photography_homepage_style = 'fullscreen';
}

get_header();

//Include custom header feature
global $photography_screen_class;
$photography_screen_class = 'split wide';

global $photography_page_content_class;
$photography_page_content_class = 'split wide';

get_template_part("/templates/template-header");
?>
<div class="post_caption">
    <h1><?php echo the_title(); ?></h1>
    <?php
	    $gallery_excerpt = get_the_excerpt();
	
	    if(!empty($gallery_excerpt))
	    {
	?>
	    <hr class="title_break"/>
	    <div class="page_tagline">
	    	<?php echo wp_kses_post($gallery_excerpt); ?>
	    </div>
	<?php
	    }
	?>
</div>

<div class="inner">

    <!-- Begin main content -->
    <div class="inner_wrapper">

	    <div class="sidebar_content full_width fixed_column">
	
			<div id="portfolio_filter_wrapper" class="gallery two_cols portfolio-content section content clearfix wide" data-columns="2">
	
			<?php
				foreach($all_photo_arr as $key => $photo_id)
				{
				    $small_image_url = '';
				    $image_url = '';
				    
				    if(!empty($photo_id))
				    {
				    	$image_url = wp_get_attachment_image_src($photo_id, 'original', true);
				    	$small_image_url = wp_get_attachment_image_src($photo_id, 'photography-gallery-grid', true);
				    }
				    
				    //Get image meta data
				    $image_caption = get_post_field('post_excerpt', $photo_id);
				    $image_alt = get_post_meta($photo_id, '_wp_attachment_image_alt', true);
				    $tg_full_image_caption = kirki_get_option('tg_full_image_caption');
				    
				    //Get image purchase URL
				    $photography_purchase_url = get_post_meta($photo_id, 'photography_purchase_url', true);
				    
				    if(!empty($photography_purchase_url))
				    {
					    $image_caption.= '<a href="'.esc_url($photography_purchase_url).'" class="button ghost"><i class="fa fa-shopping-cart marginright"></i>'.esc_html__('Purchase', 'photography-translation' ).'</a>';
				    }
			?>
			<div class="element grid classic2_cols">
			
				<div class="one_half gallery2 static filterable gallery_type animated<?php echo esc_attr($key+1); ?>" data-id="post-<?php echo esc_attr($key+1); ?>">
				<?php 
				    if(isset($image_url[0]) && !empty($image_url[0]))
					{
				?>		
				    <a <?php if(!empty($tg_full_image_caption)) { ?>data-caption="<?php if(!empty($image_caption)) { ?><?php echo esc_attr($image_caption); ?><?php } ?>"<?php } ?> class="fancy-gallery" href="<?php echo esc_url($image_url[0]); ?>">
					    <img src="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
			        </a>
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
				get_template_part("/templates/template-footer-split");
			?>
	
	    </div>
	
    </div>
    <!-- End main content -->
    	
</div>
<?php
	get_footer();
?>