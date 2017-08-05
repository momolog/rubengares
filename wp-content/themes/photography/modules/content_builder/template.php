<?php
	//Get demo page template
	require_once get_template_directory() . "/lib/contentbuilder.demo.lib.php";
?>
<!-- Display templates lightbox -->
<div id="ppb_template">

	<!-- Display templates tab options -->
	<div class="ppb_tab">
		<ul>
	    	<li><a href="#tabs-my-templates"><?php esc_html_e('My Templates', 'photography-translation' ); ?></a></li>
	    	<li><a href="#tabs-predefined-templates"><?php esc_html_e('Predefined Templates', 'photography-translation' ); ?></a></li>
	    </ul>

		<!-- Display my templates options -->
		<div id="tabs-my-templates">
			<!-- Display save as new template button -->
			<!-- a id="ppb_sortable_save_template_button" href="javascript:;"><i class="fa fa-cloud-download"></i><?php esc_html_e('Save Current Page as Template', 'photography-translation' ); ?></a -->
			
			<div id="template_save_form">
				<input type="text" id="ppb_new_template_name" name="ppb_new_template_name" value="" placeholder="<?php esc_html_e('Template Name', 'photography-translation' ); ?>"/>
				<a id="ppb_do_save_template_button" class="button button-primary" href="<?php echo esc_url(admin_url('admin-ajax.php?action=photography_ppb_set_template&page_id='.$post->ID)); ?>"><?php esc_html_e('Save', 'photography-translation' ); ?></a>
				
				<br/>
				<div class="pp_widget_description"><?php esc_html_e('Template Name must have at least 3 characters', 'photography-translation' ); ?></div>
			</div>
			
			<!-- Display demo templates -->
			<div class="template_sub_title_bar">
				<h3><?php esc_html_e('Saved Templates', 'photography-translation' ); ?></h3>
				<a href="javascript:;" class="inline_help tooltipster" title="<?php esc_html_e('Predefined templates are built-in theme using demo pages', 'photography-translation' ); ?>"><i class="fa fa-question-circle"></i></a>
			</div>
			
			<ul id="ppb_my_templates_wrapper">
			<?php
				//Get my templates list
				$my_current_templates = get_option(SHORTNAME."_my_templates");
				
				if(!empty($my_current_templates))
				{
			    	foreach($my_current_templates as $key => $my_current_template)		
					{
			?>
					<li id="ppb_my_page_<?php echo esc_attr($key); ?>" data-module="<?php echo esc_attr($key); ?>" data-title="<?php echo esc_attr($my_current_template); ?>" data-key="<?php echo esc_attr($key); ?>">
						<a href="javascript:;" class="confirm_import">
							<div class="builder_title"><?php echo esc_html($my_current_template); ?></div>
						</a>
						<a class="delete_link tooltipster" href="<?php echo esc_url(admin_url('admin-ajax.php?action=photography_ppb_remove_template&template_id='.$key)); ?>" title="<?php echo esc_html_e('Remove', 'photography-translation' ); ?>"><i class="fa fa-trash"></i></a>
					</li>
			<?php		
			    	} //End foreach
			    }
			?>
			</ul>
		</div>
		<!-- End display my templates options -->
		
		<!-- Display predefined templates options -->
		<div id="tabs-predefined-templates">
			<ul id="ppb_demo_pages_wrapper">
			<?php
			    foreach($ppb_demo_pages as $key => $ppb_demo_page)		
			    {
			?>
				<li id="ppb_demo_page_<?php echo esc_attr($key); ?>" data-module="<?php echo esc_attr($key); ?>" data-title="<?php echo esc_attr($ppb_demo_page['title']); ?>" data-type="demo_page" data-file="<?php echo esc_attr($ppb_demo_page['file']); ?>" data-key="<?php echo esc_attr($key); ?>">
					<a href="javascript:;" class="confirm_import">
			    		<div class="builder_title"><?php echo esc_html($ppb_demo_page['title']); ?></div>
					</a>
			    	<?php
					    if(!empty($ppb_demo_page['url']))
					    {
					?>
					<a class="preview_link tooltipster" href="<?php echo esc_url($ppb_demo_page['url']); ?>" target="_blank" title="<?php echo esc_html_e('Preview', 'photography-translation' ); ?> <?php echo esc_html($ppb_demo_page['title']); ?>"><i class="fa fa-external-link-square"></i></a>
					<?php
					    }
					?>
				</li>
			<?php		
			    } //End foreach
			?>
			</ul>
		</div>
		<!-- End display predefined templates options -->
	</div>
</div>
<!-- End display templates lightbox -->