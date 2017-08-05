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
$action = 'photography_portfolio_grid';

if(isset($_GET['id']) && !empty($_GET['id']))
{
	$wrapper_id = $_GET['id'];
}

if(isset($_GET['cat']))
{
	$cat = $_GET['cat'];
}

if(isset($_GET['items']))
{
	$items = $_GET['items'];
}

if(isset($_GET['items_ini']))
{
	$items_ini = $_GET['items_ini'];
}

if(isset($_GET['columns']))
{
	$columns = $_GET['columns'];
}

if(isset($_GET['type']))
{
	$type = $_GET['type'];
}

if(isset($_GET['order']))
{
	$order = $_GET['order'];
}

if(isset($_GET['order_by']))
{
	$order_by = $_GET['order_by'];
}

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}
?>
function loadPortfolioImage<?php echo esc_js($wrapper_id); ?>()
{
	if(jQuery('#<?php echo esc_js($wrapper_id); ?>_status').val() == 0)
	{
		var currentOffset = parseInt(jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val());
		jQuery('#<?php echo esc_js($wrapper_id); ?>_loading').addClass('visible');
	
		jQuery.ajax({
	        url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
	        type:'POST',
	        data: 'action=<?php echo esc_js($action); ?>&cat=<?php echo esc_js($cat); ?>&items=<?php echo esc_js($items); ?>&items_ini=<?php echo esc_js($items_ini); ?>&offset='+currentOffset+'&columns=<?php echo esc_js($columns); ?>&type=<?php echo esc_js($type); ?>&order=<?php echo esc_js($order); ?>&order_by=<?php echo esc_js($order_by); ?>&tg_security='+tgAjax.ajax_nonce, 
	        success: function(html)
	        {
	        	jQuery('#<?php echo esc_js($wrapper_id); ?>_offset').val(parseInt(currentOffset+<?php echo esc_js($items_ini); ?>));
	        	
	            var newItems = jQuery(html);
				jQuery('#<?php echo esc_js($wrapper_id); ?>').isotope( 'insert', newItems );
				
				jQuery('#<?php echo esc_js($wrapper_id); ?>').imagesLoaded(function(){
					jQuery('#<?php echo esc_js($wrapper_id); ?>').children('.element').children('.portfolio_type').each(function(){
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
	        loadPortfolioImage<?php echo esc_js($wrapper_id); ?>();
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
	    		loadPortfolioImage<?php echo esc_js($wrapper_id); ?>();
	    	}
	    }
	});
});