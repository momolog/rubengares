<?php
	global $photography_topbar;
?>
<div id="page_caption" class="single_gallery <?php if(!empty($photography_topbar)) { ?>withtopbar<?php } ?>">
	<div class="page_title_wrapper">
		<div class="page_title_inner">
			<h1><?php the_title(); ?></h1>
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
	</div>
</div>

<!-- Begin content -->
<?php
global $photography_page_content_class;
?>
<div id="page_content_wrapper" class="<?php if(!empty($photography_page_content_class)) { echo esc_attr($photography_page_content_class); } ?>">