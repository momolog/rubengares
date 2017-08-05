<?php header("content-type: application/x-javascript"); ?>
<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );

$wrapper_id = '';
$gallery_id = '';
$items = 1;
$columns = 2;
$type = 'grid';

if(isset($_GET['id']) && !empty($_GET['id']))
{
	$wrapper_id = $_GET['id'];
}

if(isset($_GET['gallery_id']))
{
	$gallery_id = $_GET['gallery_id'];
}

if(isset($_GET['items']))
{
	$items = $_GET['items'];
}

if(isset($_GET['columns']))
{
	$columns = $_GET['columns'];
}

if(isset($_GET['type']))
{
	$type = $_GET['type'];
}
?>
function loadGalleryImage<?php echo esc_js($wrapper_id); ?>()
{
	if(jQuery('#<?php echo esc_js($wrapper_id); ?>_status').val() == 0)
	{
		var currentOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val());
		jQuery('#<?php echo esc_js($wrapper_id); ?>_loading').addClass('visible');
	
		jQuery.ajax({
	        url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
	        type:'POST',
	        data: 'action=photography_gallery_grid&gallery_id=<?php echo esc_js($gallery_id); ?>&items=<?php echo esc_js($items); ?>&offset='+currentOffset+'&columns=<?php echo esc_js($columns); ?>&type=<?php echo esc_js($type); ?>&tg_security='+tgAjax.ajax_nonce, 
	        success: function(html)
	        {
	        	jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val(parseInt(currentOffset+<?php echo esc_js($items); ?>));
	        
	            var newItems = jQuery(html);
				jQuery('#<?php echo esc_js($wrapper_id); ?>').isotope( 'insert', newItems );
				
				jQuery('#<?php echo esc_js($wrapper_id); ?>').imagesLoaded(function(){
					jQuery('#<?php echo esc_js($wrapper_id); ?>').children('.element').children('.gallery_type').each(function(){
					    jQuery(this).addClass('fadeIn');
				    });
				    
				    jQuery('#<?php echo esc_js($wrapper_id); ?>').isotope('reloadItems').isotope({ sortBy: 'original-order' });
				});
				
				jQuery(document).setiLightbox();
				
				jQuery('#<?php echo esc_js($wrapper_id); ?>_loading').removeClass('visible');
	        }
	    });
	}
}

jQuery(window).load(function(){ 
	jQuery(document).ajaxStart(function() {
	  	jQuery('#<?php echo esc_js($wrapper_id); ?>_status').val(1);
	});
	
	jQuery(document).ajaxStop(function() {
	  	jQuery('#<?php echo esc_js($wrapper_id); ?>_status').val(0);
	});

	if (jQuery(document).height() <= jQuery(window).height())
	{
        var currentOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val());
		var total = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_total').val());
		
		if (currentOffset > total)
	    {
	        return false;
	    }
	    else
	    {
	        loadGalleryImage<?php echo esc_js($wrapper_id); ?>();
	    }
    }

	jQuery(window).on('scroll', function() {
		var currentOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val());
		var total = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_total').val());
		var wrapperHeight = jQuery(this).height();
		
		if(jQuery(window).height() > 1000)
		{
		    var targetOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>').offset().top/2);
		}
		else
		{
		    var targetOffset = jQuery('#<?php echo esc_js($wrapper_id); ?>').offset().top;
		}

	
	    if(jQuery(window).scrollTop() > targetOffset)
	    {
	    	if (currentOffset >= total)
	    	{
	    		return false;
	    	}
	    	else
	    	{
	    		loadGalleryImage<?php echo esc_js($wrapper_id); ?>();
	    	}
	    }
	});
});