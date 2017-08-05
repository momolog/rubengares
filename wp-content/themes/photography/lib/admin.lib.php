<?php

$customizer_styling_arr = array( 
	array('id'	=>	'white1', 'title' => 'White Demo: Left Align Menu'),
	array('id'	=>	'white2', 'title' => 'White Demo: Center Align Menu'),
	array('id'	=>	'white3', 'title' => 'White Demo: With Top Bar'),
	array('id'	=>	'white4', 'title' => 'White Demo: Fullscreen Menu'),
	array('id'	=>	'white5', 'title' => 'White Demo: Left Vertical Menu'),
	array('id'	=>	'white6', 'title' => 'White Demo: Black Frame'),
	array('id'	=>	'white8', 'title' => 'White Demo: Boxed Layout'),
	array('id'	=>	'dark1', 'title' => 'Dark Demo: Left Align Menu'),
	array('id'	=>	'dark2', 'title' => 'Dark Demo: Center Align Menu'),
	array('id'	=>	'dark3', 'title' => 'Dark Demo: With Top Bar'),
	array('id'	=>	'dark4', 'title' => 'Dark Demo: Fullscreen Menu'),
	array('id'	=>	'dark5', 'title' => 'Dark Demo: Left Vertical Menu'),
	array('id'	=>	'dark6', 'title' => 'Dark Demo: White Frame'),
	array('id'	=>	'dark8', 'title' => 'Dark Demo: Boxed Layout'),
);

$customizer_styling_html = '';

foreach($customizer_styling_arr as $customizer_styling)
{
	$customizer_styling_html.= '
		<li data-styling="'.$customizer_styling['id'].'">
	    	<div class="item_thumb"><img src="'.get_template_directory_uri().'/cache/demos/customizer/screenshots/'.$customizer_styling['id'].'.jpg" alt=""/></div>
	    	<div class="item_content">
			    '.$customizer_styling['title'].'
			</div>
	    </li>';
}

/*
	Begin creating admin options
*/

$getting_started_html = '<div class="one">
		<div class="step_icon">
			<a href="'.admin_url("themes.php?page=install-required-plugins").'">
				<i class="fa fa-plug"></i>
				<div class="step_title">Install Plugins</div>
			</a>
		</div>
		<div class="step_info">
			Theme has required and recommended plugins in order to build your website using layouts you saw on our demo site. We recommend you to install all plugins first.
		</div>
	</div>';

//Check if Photography plugin is installed	
$photography_custom_post = 'photography-custom-post/photography-custom-post.php';

if( !function_exists('is_plugin_active') ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$photography_custom_post_activated = is_plugin_active($photography_custom_post);
if($photography_custom_post_activated)
{
	$getting_started_html.= '<div class="one">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=galleries").'">
				<i class="fa fa-photo"></i>
				<div class="step_title">Create Gallery</div>
			</a>
		</div>
		<div class="step_info">
			'.THEMENAME.' provide advanced gallery option. You can use bulk images uploader, select from various gallery templates option.
		</div>
	</div>
	
	<br style="clear:both;"/>
	
	<div class="one">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=portfolios").'">
				<i class="fa fa-folder-open-o"></i>
				<div class="step_title">Create Portfolio</div>
			</a>
		</div>
		<div class="step_info">
			'.THEMENAME.' provide advanced portfolio option. Portfolio is using for other portfolio content type for example text, HTML or video.
		</div>
	</div>';
}
	
$getting_started_html.='<div class="one">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=page").'">
				<i class="fa fa-file-text-o"></i>
				<div class="step_title">Create Page</div>
			</a>
		</div>
		<div class="step_info">
			'.THEMENAME.' support standard WordPress page option. You can also use our live content builder to create and organise page contents.
		</div>
	</div>
	
	<div class="one">
		<div class="step_icon">
			<a href="'.admin_url("customize.php").'">
				<i class="fa fa-sliders"></i>
				<div class="step_title">Customize Theme</div>
			</a>
		</div>
		<div class="step_info">
			Start customize theme\'s layouts, typography, elements colors using WordPress customize and see your changes in live preview instantly.
		</div>
	</div>
	
	<div class="one">
		<div class="step_icon">
			<a href="javascript:;" onclick="jQuery(\'#pp_panel_demo-content_a\').trigger(\'click\');">
				<i class="fa fa-database"></i>
				<div class="step_title">Import Demo</div>
			</a>
		</div>
		<div class="step_info">
			Upload demo content from our demo site. We recommend you to install all recommended plugins before importing demo contents.
		</div>
	</div>
	
	<br style="clear:both;"/>
	
	<div style="height:30px"></div>
	
	<h1>Support</h1>
	<div class="getting_started_desc">To access our support portal. You first must find your purchased code.</div>
	<div style="height:30px"></div>
	<hr/>
	<div style="height:30px"></div>
	<div class="one">
		<div class="step_icon">
			<a href="https://themegoods.ticksy.com/submit/" target="_blank">
				<i class="fa fa-commenting-o"></i>
				<div class="step_title">Submit a Ticket</div>
			</a>
		</div>
		<div class="step_info">
			We offer excellent support through our ticket system. Please make sure you prepare your purchased code first to access our services.
		</div>
	</div>
	
	<div class="one">
		<div class="step_icon">
			<a href="http://themes.themegoods.com/photography/doc" target="_blank">
				<i class="fa fa-book"></i>
				<div class="step_title">Theme Document</div>
			</a>
		</div>
		<div class="step_info">
			This is the place to go find all reference aspects of theme functionalities. Our online documentation is resource for you to start using theme.
		</div>
	</div>
';

/*
	Begin creating admin options
*/

$api_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

global $photograhy_options;

$photograhy_options = array (
 
//Begin admin header
array( 
		"name" => THEMENAME." Options",
		"type" => "title"
),
//End admin header

//Begin second tab "Home"
array( 	"name" => "Home",
		"type" => "section",
		"icon" => "fa-home",	
),
array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => SHORTNAME."_home",
	"type" => "html",
	"html" => '
	<h1>Getting Started</h1>
	<div class="getting_started_desc">Welcome to '.THEMENAME.' theme. '.THEMENAME.' is now installed and ready to use! Read below for additional informations. We hope you enjoy using the theme!</div>
	<div style="height:30px"></div>
	<hr/>
	<div style="height:30px"></div>
	'.$getting_started_html.'
	',
),

array( "type" => "close"),
//End second tab "Home"

//Begin second tab "General"
array( 	"name" => "General",
		"type" => "section",
		"icon" => "fa-gear",	
),
array( "type" => "open"),

array( "name" => "<h2>Contact Form Settings</h2>Your email address",
	"desc" => "Enter which email address will be sent from contact form",
	"id" => SHORTNAME."_contact_email",
	"type" => "text",
	"validation" => "email",
	"std" => ""

),
array( "name" => "Select and sort contents on your contact page. Use fields you want to show on your contact form",
	"sort_title" => "Contact Form Manager",
	"desc" => "",
	"id" => SHORTNAME."_contact_form",
	"type" => "sortable",
	"options" => array(
		0 => 'Empty field',
		1 => 'Name',
		2 => 'Email',
		3 => 'Message',
		4 => 'Address',
		5 => 'Phone',
		6 => 'Mobile',
		7 => 'Company Name',
		8 => 'Country',
	),
	"options_disable" => array(1, 2, 3),
	"std" => ''
),

array( "name" => "<h2>Google Maps Setting</h2>API Key",
	"desc" => "Enter Google Maps API Key <a href=\"https://themegoods.ticksy.com/article/7785/\" target=\"_blank\">How to get API Key</a>",
	"id" => SHORTNAME."_googlemap_api_key",
	"type" => "text",
	"std" => ""
),

array( "name" => "Custom Google Maps Style",
	"desc" => "Enter javascript style array of map. You can get sample one from <a href=\"https://snazzymaps.com\" target=\"_blank\">Snazzy Maps</a>",
	"id" => SHORTNAME."_googlemap_style",
	"type" => "textarea",
	"std" => ""
),

array( "name" => "<h2>Captcha Settings</h2>Enable Captcha",
	"desc" => "If you enable this option, contact page will display captcha image to prevent possible spam",
	"id" => SHORTNAME."_contact_enable_captcha",
	"type" => "iphone_checkboxes",
	"std" => 1,
),

array( "name" => "<h2>Custom Sidebar Settings</h2>Add a new sidebar",
	"desc" => "Enter sidebar name",
	"id" => SHORTNAME."_sidebar0",
	"type" => "text",
	"validation" => "text",
	"std" => "",
),

array( "type" => "close"),
//End second tab "General"


//Begin second tab "Styling"
array( "name" => "Styling",
	"type" => "section",
	"icon" => "fa-paint-brush",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => SHORTNAME."_get_styling_button",
	"type" => "html",
	"html" => '
	<ul id="get_styling_content" class="styling_list">
	    '.$customizer_styling_html.'
	</ul>
	<input id="pp_get_styling_button" name="pp_get_styling_button" type="button" value="Get Selected Styling" class="upload_btn button-primary"/>
	<input type="hidden" id="pp_get_styling" name="pp_get_styling" value=""/>
	<div class="styling_message"><img src="'.get_template_directory_uri().'/functions/images/ajax-loader.gif" alt="" style="vertical-align: middle;"/><br/><br/>*Data is being procressed please be patient, don\'t navigate away from this page</div>
	',
),

array( "name" => "<h2>Theme Customize</h2>",
	"desc" => "",
	"id" => SHORTNAME."_open_customize",
	"type" => "html",
	"html" => 'Or you can open theme customize and start customizing theme elements, colors, typography yourself by clicking below button or open Appearance > Customize<br/><br/><br/>
	<input id="pp_open_customize_button" name="pp_open_customize_button" type="button" value="Open Theme customize" class="button" onclick="window.location=\''.esc_url(admin_url('customize.php')).'\'"/>
	',
),
 
array( "type" => "close"),


//Begin second tab "Images"
array( "name" => "Images",
	"type" => "section",
	"icon" => "fa-image",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => SHORTNAME."_gallery_image_dimensions_notice",
	"type" => "html",
	"html" => 'These settings affect the display and dimensions of images in your gallery, blog pages – the display on the front-end will still be affected by CSS styles. After changing these settings you may need to <a href="https://wordpress.org/plugins/force-regenerate-thumbnails/" target="_blank">regenerate your thumbnails</a>
	',
),
array( "name" => "<h2>Gallery Grid Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery grid image width(in pixels).",
	"id" => SHORTNAME."_gallery_grid_image_width",
	"type" => "text",
	"std" => "705",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery grid image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_gallery_grid_image_height",
	"type" => "text",
	"std" => "529",
	"validation" => "text",
),
array( "name" => "<h2>Gallery Grid Large Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery grid large image width(in pixels).",
	"id" => SHORTNAME."_gallery_grid_large_image_width",
	"type" => "text",
	"std" => "987",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery grid large image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_gallery_grid_large_image_height",
	"type" => "text",
	"std" => "740",
	"validation" => "text",
),
array( "name" => "<h2>Gallery Masonry Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery masonry image width(in pixels).",
	"id" => SHORTNAME."_gallery_masonry_image_width",
	"type" => "text",
	"std" => "705",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery masonry image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_gallery_masonry_image_height",
	"type" => "text",
	"std" => "9999",
	"validation" => "text",
),
array( "name" => "<h2>Gallery Striped Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery striped image width(in pixels).",
	"id" => SHORTNAME."_gallery_striped_image_width",
	"type" => "text",
	"std" => "270",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery striped image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_gallery_striped_image_height",
	"type" => "text",
	"std" => "690",
	"validation" => "text",
),
array( "name" => "<h2>Blog Featured Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter blog featured image width(in pixels).",
	"id" => SHORTNAME."_blog_image_width",
	"type" => "text",
	"std" => "960",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter blog featured image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_blog_image_height",
	"type" => "text",
	"std" => "636",
	"validation" => "text",
),
 
array( "type" => "close"),


//Begin fifth tab "Social Profiles"
array( 	"name" => "Social-Profiles",
		"type" => "section",
		"icon" => "fa-facebook-official",
),
array( "type" => "open"),
	
array( "name" => "<h2>Facebook Sharing Settings</h2>Disable Theme Facebook Open Graph Tags",
	"desc" => "If you are using other 3rd party plugin for handling Facebook Open Graph Tags. You can disable this option to avoid conflict with theme.",
	"id" => SHORTNAME."_facebook_theme_graph",
	"type" => "iphone_checkboxes",
	"std" => 1,
),
array( "name" => "<h2>Accounts Settings</h2>Facebook page URL",
	"desc" => "Enter full Facebook page URL",
	"id" => SHORTNAME."_facebook_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Twitter Username",
	"desc" => "Enter Twitter username",
	"id" => SHORTNAME."_twitter_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Google Plus URL",
	"desc" => "Enter Google Plus URL",
	"id" => SHORTNAME."_google_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Flickr Username",
	"desc" => "Enter Flickr username",
	"id" => SHORTNAME."_flickr_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Youtube Profile URL",
	"desc" => "Enter Youtube Profile URL",
	"id" => SHORTNAME."_youtube_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Vimeo Username",
	"desc" => "Enter Vimeo username",
	"id" => SHORTNAME."_vimeo_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Tumblr Username",
	"desc" => "Enter Tumblr username",
	"id" => SHORTNAME."_tumblr_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Dribbble Username",
	"desc" => "Enter Dribbble username",
	"id" => SHORTNAME."_dribbble_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Linkedin URL",
	"desc" => "Enter full Linkedin URL",
	"id" => SHORTNAME."_linkedin_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Pinterest Username",
	"desc" => "Enter Pinterest username",
	"id" => SHORTNAME."_pinterest_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Instagram Username",
	"desc" => "Enter Instagram username",
	"id" => SHORTNAME."_instagram_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Behance Username",
	"desc" => "Enter Behance username",
	"id" => SHORTNAME."_behance_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "500px Profile URL",
	"desc" => "Enter 500px Profile URL",
	"id" => SHORTNAME."_500px_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "<h2>Photo Stream</h2>Select photo stream photo source. It displays before footer area",
	"desc" => "",
	"id" => SHORTNAME."_photostream",
	"type" => "select",
	"options" => array(
		'' => 'Disable Photo Stream',
		'instagram' => 'Instagram',
		'flickr' => 'Flickr',
	),
	"std" => ''
),
array( "name" => "Instagram Access Token <a href=\"https://instagram.com/oauth/authorize/?client_id=3a81a9fa2a064751b8c31385b91cc25c&scope=basic+public_content&redirect_uri=https://smashballoon.com/instagram-feed/instagram-token-plugin/?return_uri=".admin_url("themes.php?page=functions.php")."&response_type=token\" >Find you Access Token here</a>",
	"desc" => "Enter Instagram Access Token",
	"id" => SHORTNAME."_instagram_access_token",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),

array( "name" => "Flickr ID <a href=\"http://idgettr.com/\" target=\"_blank\">Find your Flickr ID here</a>",
	"desc" => "Enter Flickr ID",
	"id" => SHORTNAME."_flickr_id",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "type" => "close"),

//End fifth tab "Social Profiles"


//Begin second tab "Script"
array( "name" => "Script",
	"type" => "section",
	"icon" => "fa-css3",
),

array( "type" => "open"),

array( "name" => "<h2>CSS Settings</h2>Custom CSS for desktop",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css",
	"type" => "textarea",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for iPad Portrait View",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css_tablet_portrait",
	"type" => "textarea",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for iPhone Landscape View",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css_mobile_landscape",
	"type" => "textarea",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for iPhone Portrait View",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css_mobile_portrait",
	"type" => "textarea",
	"std" => "",
	'validation' => '',
),

array( "name" => "<h2>CSS and Javascript Optimisation Settings</h2>Combine and compress theme's CSS files",
	"desc" => "Combine and compress all CSS files to one. Help reduce page load time. NOTE: If you enable child theme CSS compression is not support",
	"id" => SHORTNAME."_advance_combine_css",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "name" => "Combine and compress theme's javascript files",
	"desc" => "Combine and compress all javascript files to one. Help reduce page load time",
	"id" => SHORTNAME."_advance_combine_js",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "name" => "<h2>Cache Settings</h2>Clear Cache",
	"desc" => "Try to clear cache when you enable javascript and CSS compression and theme went wrong",
	"id" => SHORTNAME."_advance_clear_cache",
	"type" => "html",
	"html" => '<br/><a id="'.SHORTNAME.'_advance_clear_cache" href="'.$api_url.'" class="button">Click here to start clearing cache files</a>',
),
 
array( "type" => "close"),

);

if(true)
{
	//Begin second tab "Demo"
	$photograhy_options[] = array( "name" => "Demo-Content",
		"type" => "section",
		"icon" => "fa-database",
	);
	
	$photograhy_options[] = array( "type" => "open");
	
	$photograhy_options[] = array( "name" => "<h2>Import Demo Content</h2>",
		"desc" => "",
		"id" => SHORTNAME."_import_demo_content",
		"type" => "html",
		"html" => photography_check_system().'<p>
			<strong>*Notice: Please note that all recommended value suggested for above table is only if you want to use DEMO CONTENT IMPORTER feature only. If you won\'t use importer, you can ignore them.</strong>
		</p>
		<ul id="import_demo_content" class="demo_list">
		    <li class="fullwidth selected" data-demo="1">
		    	<div class="item_content_wrapper">
		    		<div class="item_content">
		    			<div class="item_thumb"><img src="'.get_template_directory_uri().'/screenshot.png" alt=""/></div>
		    			<div class="item_content">
					    	<strong>What\'s Included?</strong>: posts, pages and custom post type contents, images, videos and theme settings.
					    	<br/><br/>
					    	<strong>What\'s NOT Included?</strong>: Revolution Slider.
					    </div>
				    </div>
			    </div>
		    </li>
		</ul>
		<input id="pp_import_content_button" name="pp_import_content_button" type="button" value="Import Selected" class="upload_btn button-primary"/>
		<input type="hidden" id="photography_import_demo_content" name="photography_import_demo_content" value="1"/>
		<div class="import_message"><img src="'.get_template_directory_uri().'/functions/images/ajax-loader.gif" alt="" style="vertical-align: middle;"/><br/><br/>*Data is being imported please be patient, don\'t navigate away from this page</div>
		',
	);
	
	$photograhy_options[] = array( "name" => "<h2>Import Revolution Slider</h2>",
		"desc" => "",
		"id" => SHORTNAME."_import_revslider",
		"type" => "html",
		"html" => 'Demo Revolution Sliders are included in import files. <a href="http://themes.themegoods.com/photography/doc/import-demo-revolution-sliders/" target="_blank">Click here to download demo slider</a>
		',
	);
	 
	$photograhy_options[] = array( "type" => "close");
}
?>