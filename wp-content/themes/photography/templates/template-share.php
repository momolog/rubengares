<?php
    $pin_thumb = wp_get_attachment_image_src($post->ID, 'photography-gallery-grid', true);
    if(!isset($pin_thumb[0]))
    {
	    $pin_thumb[0] = '';
    }
?>
<div id="social_share_wrapper">
	<ul>
		<li><a class="tooltip" title="<?php esc_html_e('Share On Facebook', 'photography-translation' ); ?>" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fa fa-facebook marginright"></i></a></li>
		<li><a class="tooltip" title="<?php esc_html_e('Share On Twitter', 'photography-translation' ); ?>" target="_blank" href="https://twitter.com/intent/tweet?original_referer=<?php echo get_permalink(); ?>&amp;url=<?php echo get_permalink(); ?>"><i class="fa fa-twitter marginright"></i></a></li>
		<li><a class="tooltip" title="<?php esc_html_e('Share On Pinterest', 'photography-translation' ); ?>" target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;media=<?php echo urlencode($pin_thumb[0]); ?>"><i class="fa fa-pinterest marginright"></i></a></li>
		<li><a class="tooltip" title="<?php esc_html_e('Share On Google+', 'photography-translation' ); ?>" target="_blank" href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>"><i class="fa fa-google-plus marginright"></i></a></li>
		<li><a class="tooltip" title="<?php esc_html_e('Share by Email', 'photography-translation' ); ?>" href="mailto:?Subject=<?php echo esc_attr(urldecode($post->post_title)); ?>&amp;Body=<?php echo esc_attr(urldecode($post->post_title)); ?>&nbsp;<?php echo esc_attr(get_permalink($post->ID)); ?>"><i class="fa fa-envelope marginright"></i></a></li>
	</ul>
</div>