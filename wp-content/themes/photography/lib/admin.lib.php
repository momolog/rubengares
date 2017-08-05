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
	array('id'	=>	'dark6', 'title' => 'Dark Demo: Black Frame'),
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

$api_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

global $photograhy_options;

$photograhy_options = array (
 
//Begin admin header
array( 
		"name" => THEMENAME." Options",
		"type" => "title"
),
//End admin header


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


//Begin fifth tab "Social Profiles"
array( 	"name" => "Social-Profiles",
		"type" => "section",
		"icon" => "fa-facebook-official",
),
array( "type" => "open"),
	
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
	"html" => '<a id="'.SHORTNAME.'_advance_clear_cache" href="'.$api_url.'" class="button">Click here to start clearing cache files</a>',
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
		"html" => '<strong>*NOTE:</strong> If you import demo content. It will overwrite the existing data and settings. <strong>It\'s not included revolution slider.</strong> so you have to configure that settings once it\'s done.<br/><br/>'.photography_check_system().'
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
		"html" => 'Demo Revolution Sliders are included in import files. <a href="http://themes.themegoods2.com/photography/doc/import-demo-revolution-sliders/" target="_blank">Click here to download demo slider</a>
		',
	);
	 
	$photograhy_options[] = array( "type" => "close");
}


//Begin second tab "Auto update"
/*array( "name" => "Auto-update",
	"type" => "section",
	"icon" => "arrow_refresh.png",
),

array( "type" => "open"),

array( "name" => "<h2>Envato API Settings</h2>Envato Username",
	"desc" => "Enter you Envato username",
	"id" => SHORTNAME."_envato_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Envato API Key",
	"desc" => "Enter account API key. You can get it from Your account > Settings > API Keys",
	"id" => SHORTNAME."_envato_api_key",
	"type" => "text",
	"std" => ""
)*/

//Check if has new update
/*include_once(get_template_directory() . '/modules/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php');

$pp_envato_username = get_option('pp_envato_username');
$pp_envato_api_key = get_option('pp_envato_api_key');
$upgrader = array();

if(!empty($pp_envato_username) && !empty($pp_envato_api_key))
{
	$upgrader = new Envato_WordPress_Theme_Upgrader( $pp_envato_username, $pp_envato_api_key );
	$upgrader_obj = $upgrader->check_for_theme_update();
	
	if($upgrader_obj->updated_themes_count > 0)
	{
		$options[] = array( 
			"name" => "Update Theme<br/>",
			"desc" => "",
			"id" => SHORTNAME."_theme_go_update",
			"type" => "html",
			"html" => '
			Click to update '.THEMENAME.' theme to the latest version. If you made changes on any them code, please backup your changes first otherwise they will be overwritten by the update.<br/><br/>
			<a id="'.SHORTNAME.'_theme_go_update_bth" href="'.$api_url.'" class="button button-primary">Click here to update theme</a>
			<div class="update_message"><img src="'.get_template_directory_uri().'/functions/images/ajax-loader.gif" alt="" style="vertical-align: middle;"/><br/><br/>*Theme is being updated please be patient, don\'t navigate away from this page</div>',
		);
	}
}

$options[] = array( "type" => "close");*/
?>