<?php
	//Check if display sharing buttons
	$tg_blog_content_sharing = kirki_get_option('tg_blog_content_sharing');
	if(!empty($tg_blog_content_sharing))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $pin_thumb = wp_get_attachment_image_src($image_id, 'grandnews_gallery_grid', true);
	    
	    if(!isset($pin_thumb[0]))
	    {
		    $pin_thumb[0] = '';
	    }
?>
	<div class="social_share_button_wrapper">
		<ul>
			<li><a class="tooltip facebook_share" title="<?php esc_html_e( 'Share On Facebook', 'grandnews' ); ?>" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fa fa-facebook"></i><?php esc_html_e( 'Share On Facebook', 'grandnews' ); ?></a></li>
			<li><a class="tooltip twitter_share" title="<?php esc_html_e( 'Share On Twitter', 'grandnews' ); ?>" target="_blank" href="https://twitter.com/intent/tweet?original_referer=<?php echo get_permalink(); ?>&url=<?php echo get_permalink(); ?>"><i class="fa fa-twitter"></i><?php esc_html_e( 'Tweet It', 'grandnews' ); ?></a></li>
			<li><a class="tooltip pinterest_share" title="<?php esc_html_e( 'Share On Pinterest', 'grandnews' ); ?>" target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode($pin_thumb[0]); ?>"><i class="fa fa-pinterest"></i></a></li>
			<li><a class="tooltip google_share" title="<?php esc_html_e( 'Share On Google+', 'grandnews' ); ?>" target="_blank" href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>"><i class="fa fa-google-plus"></i></a></li>
			<li><a class="tooltip email_share" title="<?php esc_html_e('Share by Email', 'grandnews' ); ?>" href="mailto:?Subject=<?php echo esc_attr(urldecode($post->post_title)); ?>&amp;Body=<?php echo esc_attr(urldecode($post->post_title)); ?>&nbsp;<?php echo esc_attr(get_permalink($post->ID)); ?>"><i class="fa fa-envelope"></i></a></li>
		</ul>
	</div>
	<br class="clear"/>
<?php
	}
?>