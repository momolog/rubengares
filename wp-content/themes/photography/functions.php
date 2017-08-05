<?php
/*
Theme Name: Photography Theme
Theme URI: http://themes.themegoods2.com/photography
Author: ThemeGoods
Author URI: http://themeforest.net/user/ThemeGoods
License: GPLv2
*/

//Setup theme default constant and data
require_once get_template_directory() . "/lib/config.lib.php";

//Setup theme translation
require_once get_template_directory() . "/lib/translation.lib.php";

//Setup theme admin action handler
require_once get_template_directory() . "/lib/admin.action.lib.php";

//Setup theme support and image size handler
require_once get_template_directory() . "/lib/theme.support.lib.php";

//Get custom function
require_once get_template_directory() . "/lib/custom.lib.php";

//Setup menu settings
require_once get_template_directory() . "/lib/menu.lib.php";

//Setup CSS compression related functions
require_once get_template_directory() . "/lib/cssmin.lib.php";

//Setup JS compression related functions
require_once get_template_directory() . "/lib/jsmin.lib.php";

//Setup Sidebar
require_once get_template_directory() . "/lib/sidebar.lib.php";

//Setup theme custom widgets
require_once get_template_directory() . "/lib/widgets.lib.php";

//Setup auto update
require_once get_template_directory() . "/lib/theme.update.lib.php";

//Setup theme admin settings
require_once get_template_directory() . "/lib/admin.lib.php";

/**
*	Begin Theme Setting Panel
**/ 
function photography_add_menu_icons_styles(){
?>
 
<style>
#adminmenu .menu-icon-events div.wp-menu-image:before {
  content: '\f145';
}
#adminmenu .menu-icon-portfolios div.wp-menu-image:before {
  content: '\f119';
}
#adminmenu .menu-icon-galleries div.wp-menu-image:before {
  content: '\f161';
}
#adminmenu .menu-icon-testimonials div.wp-menu-image:before {
  content: '\f122';
}
#adminmenu .menu-icon-team div.wp-menu-image:before {
  content: '\f307';
}
#adminmenu .menu-icon-pricing div.wp-menu-image:before {
  content: '\f214';
}
#adminmenu .menu-icon-clients div.wp-menu-image:before {
  content: '\f110';
}
</style>
 
<?php
}
add_action( 'admin_head', 'photography_add_menu_icons_styles' );

//Create theme admin panel
function photography_add_admin() 
{
	global $photograhy_themename, $photograhy_shortname, $photograhy_options;
	
	if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__) ) {
	 
		if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {
	 
			foreach ($photograhy_options as $value) 
			{
				if($value['type'] != 'image' && isset($value['id']) && isset($_REQUEST[ $value['id'] ]))
				{
					update_option( $value['id'], $_REQUEST[ $value['id'] ] );
				}
			}
			
			foreach ($photograhy_options as $value) {
			
				if( isset($value['id']) && isset( $_REQUEST[ $value['id'] ] )) 
				{ 
	
					if($value['id'] != SHORTNAME."_sidebar0" && $value['id'] != SHORTNAME."_ggfont0")
					{
						//if sortable type
						if(is_admin() && $value['type'] == 'sortable')
						{
							$sortable_array = serialize($_REQUEST[ $value['id'] ]);
							
							$sortable_data = $_REQUEST[ $value['id'].'_sort_data'];
							$sortable_data_arr = explode(',', $sortable_data);
							$new_sortable_data = array();
							
							foreach($sortable_data_arr as $key => $sortable_data_item)
							{
								$sortable_data_item_arr = explode('_', $sortable_data_item);
								
								if(isset($sortable_data_item_arr[0]))
								{
									$new_sortable_data[] = $sortable_data_item_arr[0];
								}
							}
							
							update_option( $value['id'], $sortable_array );
							update_option( $value['id'].'_sort_data', serialize($new_sortable_data) );
						}
						elseif(is_admin() && $value['type'] == 'font')
						{
							if(!empty($_REQUEST[ $value['id'] ]))
							{
								update_option( $value['id'], $_REQUEST[ $value['id'] ] );
								update_option( $value['id'].'_value', $_REQUEST[ $value['id'].'_value' ] );
							}
							else
							{
								delete_option( $value['id'] );
								delete_option( $value['id'].'_value' );
							}
						}
						elseif(is_admin())
						{
							if($value['type']=='image')
							{
								update_option( $value['id'], esc_url($_REQUEST[ $value['id'] ])  );
							}
							elseif($value['type']=='textarea')
							{
								if(isset($value['validation']) && !empty($value['validation']))
								{
									update_option( $value['id'], esc_textarea($_REQUEST[ $value['id'] ]) );
								}
								else
								{
									update_option( $value['id'], $_REQUEST[ $value['id'] ] );
								}
							}
							elseif($value['type']=='iphone_checkboxes' OR $value['type']=='jslider')
							{
								update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
							}
							else
							{
								if(isset($value['validation']) && !empty($value['validation']))
								{
									$request_value = $_REQUEST[ $value['id'] ];
									
									//Begin data validation
									switch($value['validation'])
									{
										case 'text':
										default:
											$request_value = sanitize_text_field($request_value);
										
										break;
										
										case 'email':
											$request_value = sanitize_email($request_value);
	
										break;
										
										case 'javascript':
											$request_value = sanitize_text_field($request_value);
	
										break;
										
									}
									update_option( $value['id'], $request_value);
								}
								else
								{
									update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
								}
							}
						}
					}
					elseif(is_admin() && isset($_REQUEST[ $value['id'] ]) && !empty($_REQUEST[ $value['id'] ]))
					{
						if($value['id'] == SHORTNAME."_sidebar0")
						{
							//get last sidebar serialize array
							$current_sidebar = get_option(SHORTNAME."_sidebar");
							$request_value = $_REQUEST[ $value['id'] ];
							$request_value = sanitize_text_field($request_value);
							
							$current_sidebar[ $request_value ] = $request_value;
				
							update_option( SHORTNAME."_sidebar", $current_sidebar );
						}
						elseif($value['id'] == SHORTNAME."_ggfont0")
						{
							//get last ggfonts serialize array
							$current_ggfont = get_option(SHORTNAME."_ggfont");
							$current_ggfont[ $_REQUEST[ $value['id'] ] ] = $_REQUEST[ $value['id'] ];
				
							update_option( SHORTNAME."_ggfont", $current_ggfont );
						}
					}
				} 
				else 
				{ 
					if(is_admin() && isset($value['id']))
					{
						delete_option( $value['id'] );
					}
				} 
			}
	
			header("Location: admin.php?page=functions.php&saved=true".$_REQUEST['current_tab']);
		}  
	} 
	 
	add_theme_page('Theme Setting', 'Theme Setting', 'administrator', basename(__FILE__), 'photography_admin', '');
}

function photography_fonts_url() 
{
    //Get all Google Web font CSS
    global $photography_google_fonts;
    
    $tg_fonts_family = array();
    if(is_array($photography_google_fonts) && !empty($photography_google_fonts))
    {
    	foreach($photography_google_fonts as $tg_font)
    	{
    		$tg_fonts_family[] = kirki_get_option($tg_font);
    	}
    }

    $tg_fonts_family = array_unique($tg_fonts_family);
    $font_families = array();

    foreach($tg_fonts_family as $key => $tg_google_font)
    {	    
        if(!empty($tg_google_font))
        {
        	$font_families[] = $tg_google_font.':300,400,600,700,400italic';
        }
    }
    
    $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin,cyrillic-ext,greek-ext,cyrillic' ),
    );
    
    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
 
    return esc_url_raw( $fonts_url );
}

function photography_enqueue_admin_page_scripts() 
{
	global $current_screen;
	
	wp_enqueue_style('thickbox');
	
	if(property_exists($current_screen, 'base') && $current_screen->base != 'toplevel_page_revslider')
	{
		wp_enqueue_style('photography-jquery-ui', get_template_directory_uri().'/functions/jquery-ui/css/custom-theme/jquery-ui-1.8.24.custom.css', false, '1.0', 'all');
	}
	
	wp_enqueue_style('photography-functions', get_template_directory_uri().'/functions/functions.css', false, THEMEVERSION, 'all');
	
	if(property_exists($current_screen, 'post_type') && ($current_screen->post_type == 'page' OR $current_screen->post_type == 'portfolios'))
	{
		wp_enqueue_style('photography-jqueryui', get_template_directory_uri().'/css/jqueryui/custom.css', false, THEMEVERSION, 'all');
	}
	
	wp_enqueue_style('photography-colorpicker', get_template_directory_uri().'/functions/colorpicker/css/colorpicker.css', false, THEMEVERSION, 'all');
	wp_enqueue_style('photography-fancybox', get_template_directory_uri().'/js/fancybox/jquery.fancybox.admin.css', false, THEMEVERSION, 'all');
	wp_enqueue_style('photography-icheck', get_template_directory_uri().'/functions/skins/flat/blue.css', false, THEMEVERSION, 'all');
	wp_enqueue_style('photography-timepicker', get_template_directory_uri().'/functions/jquery.timepicker.css', false, THEMEVERSION, 'all');
	wp_enqueue_style("fontawesome", get_template_directory_uri()."/css/font-awesome.min.css", false, THEMEVERSION, "all");
	wp_enqueue_style("tooltipster", get_template_directory_uri()."/css/tooltipster.css", false, THEMEVERSION, "all");
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('jquery-ui-datepicker');
	
	$ap_vars = array(
	    'url' => esc_url(get_home_url('/')),
	    'includes_url' => esc_url(includes_url())
	);
	
	wp_register_script( 'photography-wpeditor', get_template_directory_uri() . '/functions/js-wp-editor.js', array( 'jquery' ), '1.1', true );
	wp_localize_script( 'photography-wpeditor', 'ap_vars', $ap_vars );
	wp_enqueue_script( 'photography-wpeditor' );
	
	wp_enqueue_script('photography-colorpicker', get_template_directory_uri().'/functions/colorpicker/js/colorpicker.js', false, THEMEVERSION);
	wp_enqueue_script('photography-eye', get_template_directory_uri().'/functions/colorpicker/js/eye.js', false, THEMEVERSION);
	wp_enqueue_script('photography-utils', get_template_directory_uri().'/functions/colorpicker/js/utils.js', false, THEMEVERSION);
	wp_enqueue_script('photography-icheck', get_template_directory_uri().'/functions/jquery.icheck.min.js', false, THEMEVERSION);
	wp_enqueue_script('photography-fancybox', get_template_directory_uri().'/js/fancybox/jquery.fancybox.admin.js', false, THEMEVERSION);
	wp_enqueue_script('photography-timepicker', get_template_directory_uri().'/functions/jquery.timepicker.js', false, THEMEVERSION);
	wp_enqueue_script('photography-tooltipster', get_template_directory_uri().'/js/jquery.tooltipster.min.js', false, THEMEVERSION);
	wp_register_script('photography-theme-script', get_template_directory_uri().'/functions/theme_script.js', false, THEMEVERSION, true);
	$params = array(
	  'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
	);
	wp_localize_script( 'photography-theme-script', 'tgAjax', $params );
	wp_enqueue_script( 'photography-theme-script' );
}

add_action('admin_enqueue_scripts',	'photography_enqueue_admin_page_scripts' );

function photography_enqueue_front_page_scripts() 
{
    //enqueue frontend css files
	$pp_advance_combine_css = get_option('pp_advance_combine_css');
	
	//If enable animation
	$pp_animation = get_option('pp_animation');
	
	//Get theme cache folder
	$upload_dir = wp_upload_dir();
	$cache_dir = '';
	$cache_url = '';
	
	if(isset($upload_dir['basedir']))
	{
		$cache_dir = THEMEUPLOAD;
	}
	
	if(isset($upload_dir['baseurl']))
	{
		$cache_url = THEMEUPLOADURL;
	}
	    
	if(!empty($pp_advance_combine_css))
	{
	    if(!file_exists($cache_dir.'/combined.css'))
	    {
	    	$cssmin = new CSSMin();
	    	
	    	$css_arr = array(
	    	    get_template_directory().'/css/reset.css',
	    	    get_template_directory().'/css/wordpress.css',
	    	    get_template_directory().'/css/animation.css',
	    	    get_template_directory().'/css/jqueryui/custom.css',
	    	    get_template_directory().'/js/mediaelement/mediaelementplayer.css',
	    	    get_template_directory().'/js/flexslider/flexslider.css',
	    	    get_template_directory().'/css/tooltipster.css',
	    	    get_template_directory().'/css/odometer-theme-minimal.css',
	    	    get_template_directory().'/css/hw-parallax.css',
	    	    get_template_directory().'/css/screen.css',
	    	);
	    	
	    	//Check menu layout
			$tg_menu_layout = photography_menu_layout();
			
			switch($tg_menu_layout)
			{
				case 'leftmenu':
					$css_arr[] = get_template_directory_uri().'/css/menus/leftmenu.css';
				break;
				
				case 'leftalign':
					$css_arr[] = get_template_directory_uri().'/css/menus/leftalignmenu.css';
				break;
				
				case 'hammenufull':
					$css_arr[] = get_template_directory_uri().'/css/menus/hammenufull.css';
				break;
			}
	    	
	    	//If using child theme
	    	$pp_child_theme = get_option('pp_child_theme');
	    	if(empty($pp_child_theme))
	    	{
	    		$css_arr[] = get_template_directory().'/css/screen.css';
	    	}
	    	else
	    	{
	    		$css_arr[] = get_template_directory().'/style.css';
	    	}
	    	
	    	$cssmin->addFiles($css_arr);
	    	
	    	// Set original CSS from all files
	    	$cssmin->setOriginalCSS();
	    	$cssmin->compressCSS();
	    	
	    	$css = $cssmin->printCompressedCSS();
	    	
	    	global $wp_filesystem;
			$wp_filesystem->put_contents(
			  $cache_dir."combined.css",
			  $css,
			  FS_CHMOD_FILE
			);
	    }
	    
	    wp_enqueue_style("photography-ilightbox", get_template_directory_uri()."/css/ilightbox/ilightbox.css", false, "", "all");
	    wp_enqueue_style("photography-combined", $cache_url."combined.css", false, "");
	}
	else
	{
		wp_enqueue_style("photography-reset-css", get_template_directory_uri()."/css/reset.css", false, "");
		wp_enqueue_style("photography-wordpress-css", get_template_directory_uri()."/css/wordpress.css", false, "");
		wp_enqueue_style("photography-animation-css", get_template_directory_uri()."/css/animation.css", false, "", "all");
	    wp_enqueue_style("photography-ilightbox", get_template_directory_uri()."/css/ilightbox/ilightbox.css", false, "", "all");
	    wp_enqueue_style("photography-jquery-ui-css", get_template_directory_uri()."/css/jqueryui/custom.css", false, "");
	    wp_enqueue_style("photography-mediaelement", get_template_directory_uri()."/js/mediaelement/mediaelementplayer.css", false, "", "all");
	    wp_enqueue_style("photography-flexslider", get_template_directory_uri()."/js/flexslider/flexslider.css", false, "", "all");
	    wp_enqueue_style("photography-tooltipster", get_template_directory_uri()."/css/tooltipster.css", false, "", "all");
	    wp_enqueue_style("photography-odometer-theme", get_template_directory_uri()."/css/odometer-theme-minimal.css", false, "", "all");
	    wp_enqueue_style("photography-hw-parallax.css", get_template_directory_uri().'/css/hw-parallax.css', false, "", "all");
	    wp_enqueue_style("photography-screen", get_template_directory_uri().'/css/screen.css', false, "", "all");
	}
	
	//Check menu layout
	$tg_menu_layout = photography_menu_layout();
	
	switch($tg_menu_layout)
	{
		case 'leftmenu':
			wp_enqueue_style("photography-leftmenu", get_template_directory_uri().'/css/menus/leftmenu.css', false, "", "all");
		break;
		
		case 'leftalign':
			wp_enqueue_style("photography-leftalignmenu", get_template_directory_uri().'/css/menus/leftalignmenu.css', false, "", "all");
		break;
		
		case 'hammenufull':
			wp_enqueue_style("photography-hammenufull", get_template_directory_uri().'/css/menus/hammenufull.css', false, "", "all");
		break;
	}
	
	//Add Google Font
	wp_enqueue_style('photography-fonts', photography_fonts_url(), array(), null);
	
	//Add Font Awesome Support
	wp_enqueue_style("fontawesome", get_template_directory_uri()."/css/font-awesome.min.css", false, "", "all");
	
	$tg_boxed = kirki_get_option('tg_boxed');
    if(THEMEDEMO && isset($_GET['boxed']) && !empty($_GET['boxed']))
    {
    	$tg_boxed = 1;
    }
    
    if(!empty($tg_boxed) && $tg_menu_layout != 'leftmenu')
    {
    	wp_enqueue_style("photography-boxed", get_template_directory_uri().'/css/tg_boxed.css', false, "", "all");
    }
    
    //Add custom CSS
    if(THEMEDEMO && isset($_GET['menu']) && !empty($_GET['menu']))
	{
		wp_enqueue_style("photography-custom-css", get_template_directory_uri()."/templates/custom-css.php?menu=".$_GET['menu'], false, "", "all");
	}
	else
	{
		wp_enqueue_style("photography-custom-css", get_template_directory_uri()."/templates/custom-css.php", false, "", "all");
	}
	
	//If using child theme
	if(is_child_theme())
	{
	    wp_enqueue_style('photography-childtheme', get_stylesheet_directory_uri()."/style.css", false, "", "all");
	}
	
	//Enqueue javascripts
	wp_enqueue_script(array('jquery'));
	
	$js_path = get_template_directory()."/js/";
	$js_arr = array(
		'jquery.requestAnimationFrame.js',
		'jquery.mousewheel.min.js',
		'ilightbox.packed.js',
		'jquery.easing.js',
	    'waypoints.min.js',
	    'jquery.isotope.js',
	    'jquery.masory.js',
	    'jquery.tooltipster.min.js',
	    'hw-parallax.js',
	    'custom_plugins.js',
	    'custom.js',
	);
	$js = "";

	$pp_advance_combine_js = get_option('pp_advance_combine_js');
	
	if(!empty($pp_advance_combine_js))
	{	
		if(!file_exists($cache_dir."combined.js"))
		{
			foreach($js_arr as $file) {
				if($file != 'jquery.js' && $file != 'jquery-ui.js')
				{
    				$js .= JSMin::minify($wp_filesystem->get_contents($js_path.$file));
    			}
			}
			
			$wp_filesystem->put_contents(
			  $cache_dir."combined.js",
			  $js,
			  FS_CHMOD_FILE
			);
		}

		wp_enqueue_script("photography-combined", $cache_url."/combined.js", false, "", true);
	}
	else
	{
		foreach($js_arr as $file) {
			if($file != 'jquery.js' && $file != 'jquery-ui.js')
			{
				wp_enqueue_script("photography-".sanitize_title($file), get_template_directory_uri()."/js/".$file, false, "", true);
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'photography_enqueue_front_page_scripts' );


//Enqueue mobile CSS after all others CSS load
function photography_register_mobile_css() 
{
	//Check if enable responsive layout
	$tg_mobile_responsive = kirki_get_option('tg_mobile_responsive');
	
	if(!empty($tg_mobile_responsive))
	{
		//enqueue frontend css files
		$pp_advance_combine_css = get_option('pp_advance_combine_css');
	
		if(!empty($pp_advance_combine_css))
		{
			wp_enqueue_style('photography-responsive', get_template_directory_uri()."/templates/responsive-css.php", false, "", "all");
		}
		else
		{
	    	wp_enqueue_style('photography-responsive', get_template_directory_uri()."/css/grid.css", false, "", "all");
	    }
	}
}
add_action('wp_enqueue_scripts', 'photography_register_mobile_css', 15);


function photography_admin() 
{ 
	global $photograhy_themename, $photograhy_shortname, $photograhy_options;
	$i=0;
	
	$pp_font_family = get_option('pp_font_family');
	
	if(function_exists( 'wp_enqueue_media' )){
	    wp_enqueue_media();
	}
	?>
		
		<div id="pp_loading"><span><?php esc_html_e('Updating...', 'photography-translation' ); ?></span></div>
		<div id="pp_success"><span><?php esc_html_e('Successfully Update', 'photography-translation' ); ?></span></div>
		
		<?php
			if(isset($_GET['saved']) == 'true')
			{
		?>
			<script>
				jQuery('#pp_success').show();
		            	
		        setTimeout(function() {
	              jQuery('#pp_success').fadeOut();
	            }, 2000);
			</script>
		<?php
			}
		?>
		
		<form id="pp_form" method="post" enctype="multipart/form-data">
		<div class="pp_wrap rm_wrap">
		
		<div class="header_wrap">
			<div style="float:left">
			<h2><?php esc_html_e('Theme Setting', 'photography-translation' ); ?><span class="pp_version">v<?php echo THEMEVERSION; ?></span></h2>
			</div>
			<div style="float:right;margin:32px 0 0 0">
				<!-- input id="save_ppskin" name="save_ppskin" class="button secondary_button" type="submit" value="Save as Skin" / -->
				<input class="button button-large" type="submit" value="<?php esc_html_e( 'Documentation', 'grandnews' ); ?>" onclick="window.open('http://themes.themegoods2.com/photography/doc/','_blank')"/>
				<input id="save_ppsettings" name="save_ppsettings" class="button button-primary button-large" type="submit" value="<?php esc_html_e('Save All Changes', 'photography-translation' ); ?>" />
				<br/><br/>
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="current_tab" id="current_tab" value="#pp_panel_general" />
				<input type="hidden" name="pp_save_skin_flg" id="pp_save_skin_flg" value="" />
				<input type="hidden" name="pp_save_skin_name" id="pp_save_skin_name" value="" />
			</div>
			<input type="hidden" name="pp_admin_url" id="pp_admin_url" value="<?php echo get_template_directory_uri(); ?>"/>
			<br style="clear:both"/><br/>
	
	<?php
		//Check if theme has new update
	?>
	
		</div>
		
		<div class="pp_wrap">
		<div id="pp_panel">
		<?php 
			foreach ($photograhy_options as $value) {
				
				$active = '';
				
				if($value['type'] == 'section')
				{
					if($value['name'] == 'General')
					{
						$active = 'nav-tab-active';
					}
					echo '<a id="pp_panel_'.strtolower($value['name']).'_a" href="#pp_panel_'.strtolower($value['name']).'" class="nav-tab '.$active.'"><i class="fa '.$value['icon'].'"></i>'.str_replace('-', ' ', $value['name']).'</a>';
				}
			}
		?>
		</h2>
		</div>
	
		<div class="rm_opts">
		
	<?php 
	$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	
	foreach ($photograhy_options as $value) {
	switch ( $value['type'] ) {
	 
	case "open":
	?> <?php break;
	 
	case "close":
	?>
		
		</div>
		</div>
	
	
		<?php break;
	 
	case "title":
	?>
		<br />
	
	
	<?php break;
	 
	case 'text':
		
		//if sidebar input then not show default value
		if($value['id'] != SHORTNAME."_sidebar0" && $value['id'] != SHORTNAME."_ggfont0")
		{
			$default_val = get_option( $value['id'] );
		}
		else
		{
			$default_val = '';	
		}
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<input name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" type="<?php echo esc_attr($value['type']); ?>"
			value="<?php if ($default_val != "") { echo esc_attr(get_option( $value['id'])) ; } else { echo esc_attr($value['std']); } ?>"
			<?php if(!empty($value['size'])) { echo 'style="width:'.intval($value['size']).'"'; } ?> />
			<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		
		<?php
		if($value['id'] == SHORTNAME."_sidebar0")
		{
			$current_sidebar = get_option(SHORTNAME."_sidebar");
			
			if(!empty($current_sidebar))
			{
		?>
			<br class="clear"/><br/>
		 	<div class="pp_sortable_wrapper">
			<ul id="current_sidebar" class="rm_list">
	
		<?php
			foreach($current_sidebar as $sidebar)
			{
		?> 
				
				<li id="<?php echo esc_attr($sidebar); ?>"><div class="title"><?php echo esc_html($sidebar); ?></div><a href="<?php echo esc_url($url); ?>" class="sidebar_del" rel="<?php echo esc_attr($sidebar); ?>"><?php esc_html_e('Delete', 'photography-translation' ); ?></a><br style="clear:both"/></li>
		
		<?php
			}
		?>
		
			</ul>
			</div>
		
		<?php
			}
		}
		elseif($value['id'] == SHORTNAME."_ggfont0")
		{
		?>
			<?php esc_html_e('Below are fonts that already installed.', 'photography-translation' ); ?><br/>
			<select name="<?php echo SHORTNAME; ?>_sample_ggfont" id="<?php echo SHORTNAME; ?>_sample_ggfont">
			<?php 
				foreach ($pp_font_arr as $key => $option) { ?>
			<option
			<?php if (get_option( $value['id'] ) == $option['css-name']) { echo 'selected="selected"'; } ?>
				value="<?php echo esc_attr($option['css-name']); ?>" data-family="<?php echo esc_attr($option['font-name']); ?>"><?php echo esc_html($option['font-name']); ?></option>
			<?php } ?>
			</select> 
		<?php
			$current_ggfont = get_option(SHORTNAME."_ggfont");
			
			if(!empty($current_ggfont))
			{
		?>
			<br class="clear"/><br/>
		 	<div class="pp_sortable_wrapper">
			<ul id="current_ggfont" class="rm_list">
	
		<?php
		
			foreach($current_ggfont as $ggfont)
			{
		?> 
				
				<li id="<?php echo esc_attr($ggfont); ?>"><div class="title"><?php echo esc_html($ggfont); ?></div><a href="<?php echo esc_url($url); ?>" class="ggfont_del" rel="<?php echo esc_attr($ggfont); ?>"><?php esc_html_e('Delete', 'photography-translation' ); ?></a><br style="clear:both"/></li>
		
		<?php
			}
		?>
		
			</ul>
			</div>
		
		<?php
			}
		}
		?>
	
		</div>
		<?php
	break;
	
	case 'password':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<input name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" type="<?php echo esc_attr($value['type']); ?>"
			value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo esc_attr($value['std']); } ?>"
			<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?> />
		<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
	
		</div>
		<?php
	break;
	
	break;
	
	case 'image':
	case 'music':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<input id="<?php echo esc_attr($value['id']); ?>" type="text" name="<?php echo esc_attr($value['id']); ?>" value="<?php echo get_option($value['id']); ?>" style="width:200px" class="upload_text" readonly />
		<input id="<?php echo esc_attr($value['id']); ?>_button" name="<?php echo esc_attr($value['id']); ?>_button" type="button" value="Browse" class="upload_btn button" rel="<?php echo esc_attr($value['id']); ?>" style="margin:5px 0 0 5px" />
		<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		
		<script>
		jQuery(document).ready(function() {
			jQuery('#<?php echo esc_js($value['id']); ?>_button').click(function() {
	         	var send_attachment_bkp = wp.media.editor.send.attachment;
			    wp.media.editor.send.attachment = function(props, attachment) {
			    	formfield = jQuery('#<?php echo esc_js($value['id']); ?>').attr('name');
		         	jQuery('#'+formfield).attr('value', attachment.url);
			
			        wp.media.editor.send.attachment = send_attachment_bkp;
			    }
			
			    wp.media.editor.open();
	        });
	    });
		</script>
		
		<?php 
			$current_value = get_option( $value['id'] );
			
			if(!is_bool($current_value) && !empty($current_value))
			{
				$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			
				if($value['type']=='image')
				{
		?>
		
			<div id="<?php echo esc_attr($value['id']); ?>_wrapper" style="width:380px;font-size:11px;"><br/>
				<img src="<?php echo get_option($value['id']); ?>" style="max-width:500px"/><br/><br/>
				<a href="<?php echo esc_url($url); ?>" class="image_del button" rel="<?php echo esc_attr($value['id']); ?>"><?php esc_html_e('Delete', 'photography-translation' ); ?></a>
			</div>
			<?php
				}
				else
				{
			?>
			<div id="<?php echo esc_attr($value['id']); ?>_wrapper" style="width:380px;font-size:11px;">
				<br/><a href="<?php echo get_option( $value['id'] ); ?>">
				<?php esc_html_e('Listen current music', 'photography-translation' ); ?></a>&nbsp;<a href="<?php echo esc_url($url); ?>" class="image_del button" rel="<?php echo esc_attr($value['id']); ?>"><?php esc_html_e('Delete', 'photography-translation' ); ?></a>
			</div>
		<?php
				}
			}
		?>
	
		</div>
		<?php
	break;
	
	case 'jslider':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<div style="float:left;width:290px;margin-top:10px">
		<input name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" type="text" class="jslider"
			value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo esc_attr($value['std']); } ?>"
			<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?> />
		</div>
		<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		
		<script>jQuery("#<?php echo esc_js($value['id']); ?>").slider({ from: <?php echo esc_js($value['from']); ?>, to: <?php echo esc_js($value['to']); ?>, step: <?php echo esc_js($value['step']); ?>, smooth: true, skin: "round_plastic" });</script>
	
		</div>
		<?php
	break;
	
	case 'colorpicker':
	?>
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<input name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" type="text" 
			value="<?php if ( get_option( $value['id'] ) != "" ) { echo stripslashes(get_option( $value['id'])  ); } else { echo esc_attr($value['std']); } ?>"
			<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?>  class="color_picker" readonly/>
		<div id="<?php echo esc_attr($value['id']); ?>_bg" class="colorpicker_bg" onclick="jQuery('#<?php echo esc_js($value['id']); ?>').click()" style="background:<?php if (get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo esc_attr($value['std']); } ?> url(<?php echo get_template_directory_uri(); ?>/functions/images/trigger.png) center no-repeat;">&nbsp;</div>
			<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		
		</div>
		
	<?php
	break;
	 
	case 'textarea':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_textarea"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<textarea name="<?php echo esc_attr($value['id']); ?>"
			type="<?php echo esc_attr($value['type']); ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo esc_html($value['std']); } ?></textarea>
		<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
	
		</div>
	
		<?php
	break;
	 
	case 'select':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_select"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<select name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>">
			<?php foreach ($value['options'] as $key => $option) { ?>
			<option
			<?php if (get_option( $value['id'] ) == $key) { echo 'selected="selected"'; } ?>
				value="<?php echo esc_attr($key); ?>"><?php echo esc_html($option); ?></option>
			<?php } ?>
		</select> <small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		</div>
		<?php
	break;
	
	case 'font':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_font"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<div id="<?php echo esc_attr($value['id']); ?>_wrapper" style="float:left;font-size:11px;">
		<select class="pp_font" data-sample="<?php echo esc_attr($value['id']); ?>_sample" data-value="<?php echo esc_attr($value['id']); ?>_value" name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>">
			<option value="" data-family="">---- <?php esc_html_e('Theme Default Font', 'photography-translation' ); ?> ----</option>
			<?php 
				foreach ($pp_font_arr as $key => $option) { ?>
			<option
			<?php if (get_option( $value['id'] ) == $option['css-name']) { echo 'selected="selected"'; } ?>
				value="<?php echo esc_attr($option['css-name']); ?>" data-family="<?php echo esc_attr($option['font-name']); ?>"><?php echo esc_html($option['font-name']); ?></option>
			<?php } ?>
		</select> 
		<input type="hidden" id="<?php echo esc_attr($value['id']); ?>_value" name="<?php echo esc_attr($value['id']); ?>_value" value="<?php echo get_option( $value['id'].'_value' ); ?>"/>
		<br/><br/><div id="<?php echo esc_attr($value['id']); ?>_sample" class="pp_sample_text"><?php esc_html_e('Sample Text', 'photography-translation' ); ?></div>
		</div>
		<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		</div>
		<?php
	break;
	 
	case 'radio':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_select"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/><br/>
	
		<div style="margin-top:5px;float:left;<?php if(!empty($value['desc'])) { ?>width:300px<?php } else { ?>width:500px<?php } ?>">
		<?php foreach ($value['options'] as $key => $option) { ?>
		<div style="float:left;<?php if(!empty($value['desc'])) { ?>margin:0 20px 20px 0<?php } ?>">
			<input style="float:left;" id="<?php echo esc_attr($value['id']); ?>" name="<?php echo esc_attr($value['id']); ?>" type="radio"
			<?php if (get_option( $value['id'] ) == $key) { echo 'checked="checked"'; } ?>
				value="<?php echo esc_attr($key); ?>"/><?php echo esc_html($option); ?>
		</div>
		<?php } ?>
		</div>
		
		<?php if(!empty($value['desc'])) { ?>
			<small><?php echo stripslashes($value['desc']); ?></small>
		<?php } ?>
		<div class="clearfix"></div>
		</div>
		<?php
	break;
	
	case 'sortable':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_select"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<div style="float:left;width:100%;">
		<?php 
		$sortable_array = array();
		if(get_option( $value['id'] ) != 1)
		{
			$sortable_array = unserialize(get_option( $value['id'] ));
		}
		
		$current = 1;
		
		if(!empty($value['options']))
		{
		?>
		<select name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" class="pp_sortable_select">
		<?php
		foreach ($value['options'] as $key => $option) { 
			if($key > 0)
			{
		?>
		<option value="<?php echo esc_attr($key); ?>" data-rel="<?php echo esc_attr($value['id']); ?>_sort" title="<?php echo html_entity_decode($option); ?>"><?php echo html_entity_decode($option); ?></option>
		<?php }
		
				if($current>1 && ($current-1)%3 == 0)
				{
		?>
		
				<br style="clear:both"/>
		
		<?php		
				}
				
				$current++;
			}
		?>
		</select>
		<a class="button pp_sortable_button" data-rel="<?php echo esc_attr($value['id']); ?>" class="button" style="margin-top:10px;display:inline-block">Add</a>
		<?php
		}
		?>
		 
		 <br style="clear:both"/><br/>
		 
		 <div class="pp_sortable_wrapper">
		 <ul id="<?php echo esc_attr($value['id']); ?>_sort" class="pp_sortable" rel="<?php echo esc_attr($value['id']); ?>_sort_data"> 
		 <?php
		 	$sortable_data_array = unserialize(get_option( $value['id'].'_sort_data' ));
	
		 	if(!empty($sortable_data_array))
		 	{
		 		foreach($sortable_data_array as $key => $sortable_data_item)
		 		{
			 		if(!empty($sortable_data_item))
			 		{
		 		
		 ?>
		 		<li id="<?php echo esc_attr($sortable_data_item); ?>_sort" class="ui-state-default"><div class="title"><?php echo esc_html($value['options'][$sortable_data_item]); ?></div><a data-rel="<?php echo esc_attr($value['id']); ?>_sort" href="javascript:;" class="remove"><i class="fa fa-trash"></i></a><br style="clear:both"/></li> 	
		 <?php
		 			}
		 		}
		 	}
		 ?>
		 </ul>
		 
		 </div>
		 
		</div>
		
		<input type="hidden" id="<?php echo esc_attr($value['id']); ?>_sort_data" name="<?php echo esc_attr($value['id']); ?>_sort_data" value="" style="width:100%"/>
		<br style="clear:both"/><br/>
		
		<div class="clearfix"></div>
		</div>
		<?php
	break;
	 
	case "checkbox":
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_checkbox"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" value="true" <?php echo esc_html($checked); ?> />
	
	
		<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		</div>
	<?php break; 
	
	case "iphone_checkboxes":
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_checkbox"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label>
	
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" class="iphone_checkboxes" name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" value="true" <?php echo esc_html($checked); ?> />
	
		<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		</div>
	
	<?php break; 
	
	case "html":
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_checkbox"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<?php echo stripslashes($value['html']); ?>
	
		<small><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		</div>
	
	<?php break; 
	
	case "shortcut":
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_shortcut">
	
		<ul class="pp_shortcut_wrapper">
		<?php 
			$count_shortcut = 1;
			foreach ($value['options'] as $key_shortcut => $option) { ?>
			<li><a href="#<?php echo esc_attr($key_shortcut); ?>" <?php if($count_shortcut==1) { ?>class="active"<?php } ?>><?php echo esc_html($option); ?></a></li>
		<?php $count_shortcut++; } ?>
		</ul>
	
		<div class="clearfix"></div>
		</div>
	
	<?php break; 
		
	case "section":
	
	$i++;
	
	?>
	
		<div id="pp_panel_<?php echo strtolower($value['name']); ?>" class="rm_section">
		<div class="rm_title">
		<h3><img
			src="<?php echo get_template_directory_uri(); ?>/functions/images/trans.png"
			class="inactive" alt=""><?php echo stripslashes($value['name']); ?></h3>
		<span class="submit"><input class="button-primary" name="save<?php echo esc_attr($i); ?>" type="submit"
			value="Save changes" /> </span>
		<div class="clearfix"></div>
		</div>
		<div class="rm_options"><?php break;
	 
	}
	}
	?>
	 	
	 	<div class="clearfix"></div>
	 	</form>
	 	</div>
	</div>
<?php
}

add_action('admin_menu', 'photography_add_admin');

/**
*	End Theme Setting Panel
**/ 


//Setup theme custom filters
require_once get_template_directory() . "/lib/theme.filter.lib.php";

//Setup required plugin activation
require_once get_template_directory() . "/lib/tgm.lib.php";

//Setup Theme Customizer
require_once get_template_directory() . "/modules/kirki/kirki.php";
require_once get_template_directory() . "/lib/customizer.lib.php";

//Setup page custom fields and action handler
require_once get_template_directory() . "/fields/page.fields.php";

//Setup content builder
require_once get_template_directory() . "/modules/content_builder.php";

// Setup shortcode generator
require_once get_template_directory() . "/modules/shortcode_generator.php";


//Check if Woocommerce is installed	
if(class_exists('Woocommerce'))
{
	//Setup Woocommerce Config
	require_once get_template_directory() . "/modules/woocommerce.php";
}

/**
*	Setup AJAX portfolio content builder function
**/
add_action('wp_ajax_photography_ppb', 'photography_ppb');
add_action('wp_ajax_nopriv_photography_ppb', 'photography_ppb');

function photography_ppb() {
	if(is_admin() && isset($_GET['shortcode']) && !empty($_GET['shortcode']))
	{
		require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
		//pp_debug($ppb_shortcodes);
		
		if(isset($ppb_shortcodes[$_GET['shortcode']]) && !empty($ppb_shortcodes[$_GET['shortcode']]))
		{
			$selected_shortcode = $_GET['shortcode'];
			$selected_shortcode_arr = $ppb_shortcodes[$_GET['shortcode']];
			//pp_debug($selected_shortcode_arr);
			
			//get action value
			$ppb_builder_remove_id = '';
			if(isset($_GET['builder_action']) && isset($_GET['builder_action']) == 'add')
			{
				$ppb_builder_remove_id = $_GET['rel'];
			}
?>
			<!-- Display button for this content -->
			<div class="ppb_inline_title_bar">
				<h2><?php echo esc_html($selected_shortcode_arr['title']); ?></h2>
			</div>
			
			<div class="ppb_inline_wrap">
			    <a id="save_<?php echo esc_attr($_GET['rel']); ?>" data-parent="ppb_inline_<?php echo esc_attr($selected_shortcode); ?>" class="button ppb_inline_save" href="javascript:;"><?php esc_html_e('Update', 'photography-translation' ); ?></a>
			    
			    <a class="button" href="javascript:;" onClick="cancelContent('<?php echo esc_attr($ppb_builder_remove_id); ?>');"><?php esc_html_e('Cancel', 'photography-translation' ); ?></a>
			    
			</div>
			
			<div id="ppb_inline_<?php echo esc_attr($selected_shortcode); ?>" data-shortcode="<?php echo esc_attr($selected_shortcode); ?>" class="ppb_inline">
			<div class="ppb_inline_option_wrap">
				<?php
					if(isset($selected_shortcode_arr['title']) && $selected_shortcode_arr['title']!='Divider')
					{
				?>
				<div class="ppb_inline_option">
					
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_title"><?php esc_html_e('Title', 'photography-translation' ); ?></label><br/>
						<span class="label_desc"><?php esc_html_e('Enter Title for this content', 'photography-translation' ); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input type="text" id="<?php echo esc_attr($selected_shortcode); ?>_title" name="<?php echo esc_attr($selected_shortcode); ?>_title" data-attr="title" value="Title" class="ppb_input"/>
					</div>
				</div>
				<br/>
				<?php
					}
					else
					{
				?>
				<input type="hidden" id="<?php echo esc_attr($selected_shortcode); ?>_title" name="<?php echo esc_attr($selected_shortcode); ?>_title" data-attr="title" value="<?php echo esc_attr($selected_shortcode_arr['title']); ?>" class="ppb_input"/>
				<?php
					}
				?>
				
				<?php
					$num_attr = count($selected_shortcode_arr['attr']);
					$i_count = 0;
				
					foreach($selected_shortcode_arr['attr'] as $attr_name => $attr_item)
					{
						$last_class = '';
						if(++$i_count === $num_attr)
						{
							$last_class = 'last';
						}
					
						if(!isset($attr_item['title']))
						{
							$attr_title = ucfirst($attr_name);
						}
						else
						{
							$attr_title = $attr_item['title'];
						}
					
						if($attr_item['type']=='jslider')
						{
				?>
				<div class="ppb_inline_option">
				
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" type="range" class="ppb_input" min="<?php echo esc_attr($attr_item['min']); ?>" max="<?php echo esc_attr($attr_item['max']); ?>" step="<?php echo esc_attr($attr_item['step']); ?>" value="<?php echo esc_attr($attr_item['std']); ?>" /><output for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" onforminput="value = foo.valueAsNumber;"></output><br/>
					</div>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="jslider"/>
				</div>
				<br/>
				<?php
						}
				
						if($attr_item['type']=='file')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" type="text"  class="ppb_input ppb_file" />
						<a id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_button" name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_button" type="button" class="metabox_upload_btn button" rel="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>">Upload</a>
						<img id="image_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" class="ppb_file_image" />
					</div>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="file"/>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='select')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<select name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" class="ppb_input">
						<?php
								foreach($attr_item['options'] as $attr_key => $attr_item_option)
								{
						?>
								<option value="<?php echo esc_attr($attr_key); ?>"><?php echo ucfirst($attr_item_option); ?></option>
						<?php
								}
						?>
						</select>
					</div>	
					<br style="clear:both"/>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="select"/>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="select"/>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='select_multiple')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<select name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" class="ppb_input" multiple="multiple">
						<?php
								foreach($attr_item['options'] as $attr_key => $attr_item_option)
								{
									if(!empty($attr_item_option))
									{
						?>
									<option value="<?php echo esc_attr($attr_key); ?>"><?php echo ucfirst($attr_item_option); ?></option>
						<?php
									}
								}
						?>
						</select>
					</div>
					<br style="clear:both"/>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="select_multiple"/>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='text')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" type="text" class="ppb_input" />
					
						<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="text"/>
					</div>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='colorpicker')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" type="text" class="ppb_input color_picker" />
						<div id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_bg" class="colorpicker_bg" onclick="jQuery('#<?php echo esc_js($selected_shortcode); ?>_<?php echo esc_js($attr_name); ?>').click()" style="background-color:<?php echo esc_attr($attr_item['std']); ?>;background-image: url(<?php echo get_template_directory_uri(); ?>/functions/images/trigger.png);margin-top:3px">&nbsp;</div><br style="clear:both"/>
					</div>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="colorpicker"/>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='textarea')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<textarea name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" cols="" rows="3" class="ppb_input"></textarea>
					</div>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="textarea"/>
				</div>
				<br/>
				<?php
						}
					}
				?>
				
				<?php
					if(isset($selected_shortcode_arr['content']) && $selected_shortcode_arr['content'])
					{
				?>
					<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_content"><?php esc_html_e('Content', 'photography-translation' ); ?></label><br/>
						<span class="label_desc"><?php esc_html_e('You can enter text, HTML for its content', 'photography-translation' ); ?></span><br/><br/>
						
						<textarea id="<?php echo esc_attr($selected_shortcode); ?>_content" name="<?php echo esc_attr($selected_shortcode); ?>_content" cols="" rows="5" class="ppb_input <?php if($_GET['builder_action'] == 'add') { ?>ppb_textarea<?php } ?>"></textarea>
						
						<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="content"/>
					</div>
				<?php
					}
				?>
			</div>
		</div>
		
		<script>
		jQuery(document).ready(function(){
			var formfield = '';
			
			ppbSetUnsaveStatus();
			
			if(jQuery('body').hasClass('ppb_duplicated'))
			{
				jQuery('.fancybox-inner .ppb_inline_wrap').addClass('duplicated');
			}
	
			jQuery('.metabox_upload_btn').click(function() {
			    jQuery('.fancybox-overlay').css('visibility', 'hidden');
			    jQuery('.fancybox-wrap').css('visibility', 'hidden');
		     	formfield = jQuery(this).attr('rel');
			    
			    var send_attachment_bkp = wp.media.editor.send.attachment;
			    wp.media.editor.send.attachment = function(props, attachment) {
			     	jQuery('#'+formfield).attr('value', attachment.url);
			     	jQuery('#image_'+formfield).attr('src', attachment.url);
			
			        wp.media.editor.send.attachment = send_attachment_bkp;
			        jQuery('.fancybox-overlay').css('visibility', 'visible');
			     	jQuery('.fancybox-wrap').css('visibility', 'visible');
			    }
			
			    wp.media.editor.open();
		     	return false;
		    });
		
			jQuery("#ppb_inline :input").each(function(){
				if(typeof jQuery(this).attr('id') != 'undefined')
				{
					 jQuery(this).attr('value', '');
				}
			});
			
			var currentItemData = jQuery('#<?php echo esc_js($_GET['rel']); ?>').data('ppb_setting');
			var currentItemOBJ = jQuery.parseJSON(currentItemData);
			
			//If add action and has textarea then convert to visual editor
			jQuery('.ppb_textarea').wp_editor();
			
			jQuery.each(currentItemOBJ, function(index, value) { 
			  	if(typeof jQuery('#'+index) != 'undefined')
				{
					jQuery('#'+index).val(decodeURI(value));
					
					if(jQuery('#'+index).is('textarea'))
					{
					    jQuery('#'+index).html(decodeURI(value));
					    jQuery('#'+index).wp_editor();
					}
					
					//Check if color picker
					if(jQuery('#'+index).hasClass('color_picker'))
					{
						var inputID = jQuery('#'+index).attr('id');
						jQuery('#'+inputID+'_bg').css('backgroundColor', jQuery('#'+index).val());
					}
					
					//Check if in put file
					if(jQuery('#type_'+index).val()=='file')
					{
						jQuery('#image_'+index).attr('src', value);
					}
					
					//Check if in put video
					if(jQuery('#type_'+index).val()=='video')
					{
						jQuery('#video_view_'+index).attr('href', value);
					}
					
					//Check if multiple select
					if(jQuery('#type_'+index).val()=='select_multiple')
					{
						var data = value + '';
						var data_array = data.split(",");
						jQuery('#'+index).val(data_array);
					}
				}
			});
			
			jQuery('.color_picker').each(function()
			{	
			    var inputID = jQuery(this).attr('id');
			    
			    jQuery(this).ColorPicker({
			    	color: jQuery(this).val(),
			    	onShow: function (colpkr) {
			    		jQuery(colpkr).fadeIn(200);
			    		return false;
			    	},
			    	onHide: function (colpkr) {
			    		jQuery(colpkr).fadeOut(200);
			    		return false;
			    	},
			    	onChange: function (hsb, hex, rgb, el) {
			    		jQuery('#'+inputID).val('#' + hex);
			    		jQuery('#'+inputID+'_bg').css('backgroundColor', '#' + hex);
			    	}
			    });	
			    
			    jQuery(this).css('width', '200px');
			    jQuery(this).css('float', 'left');
			});
			
			var el, newPoint, newPlace, offset;
 
			 jQuery("input[type='range']").change(function() {
			 
			   el = jQuery(this);
			   
			   width = el.width();
			   newPoint = (el.val() - el.attr("min")) / (el.attr("max") - el.attr("min"));
			   el.next("output").text(el.val());
			 })
			 .trigger('change');
			
			jQuery("#save_<?php echo esc_js($_GET['rel']); ?>").click(function(){
				//Save undo data to localstorage
				ppbAddHistory('undo');
			
				tinyMCE.triggerSave();
			
			    var targetItem = '<?php echo esc_js($_GET['rel']); ?>';
			    var parentInline = jQuery(this).attr('data-parent');
			    var currentItemData = jQuery('#'+targetItem).find('.ppb_setting_data').attr('value');
			    var currentShortcode = jQuery('#'+parentInline).attr('data-shortcode');
			    
			    var itemData = {};
			    itemData.id = targetItem;
			    itemData.shortcode = currentShortcode;
			    
			    jQuery("#"+parentInline+" :input.ppb_input").each(function(){
			     	if(typeof jQuery(this).attr('id') != 'undefined')
			     	{	
			    	 	if(jQuery(this).attr('multiple') != 'multiple')
			     		{
			    	 		itemData[jQuery(this).attr('id')] = encodeURI(jQuery(this).attr('value'));
			    	 	}
			    	 	else
			    	 	{
				    	 	itemData[jQuery(this).attr('id')] = jQuery(this).val();
			    	 	}
			    	 	
				    	 if(jQuery(this).attr('data-attr') == 'title')
				    	 {
				    	 	//Set saved module title
				    	 	var shortcodeName = jQuery('#'+targetItem).find('.title').find('.shortcode_title').html();
				    	 	
				    	 	var updatedShortcodeTitle = '<div class="shortcode_title">'+shortcodeName+'</div>'+decodeURI(jQuery(this).attr('value'));
				    	 	
				    	  	jQuery('#'+targetItem).find('.title').html(updatedShortcodeTitle);
				    	  	
				    	  	if(jQuery('#'+targetItem).find('.ppb_unsave').length==0)
				    	  	{
				    	  		ppbSetUnsaveStatus();
				    	  	}
				    	 }
			     	}
			    });
			    
			    var currentItemDataJSON = JSON.stringify(itemData);
			    jQuery('#'+targetItem).data('ppb_setting', currentItemDataJSON);
			    
			    //If in live mode
				if(isLiveMode())
				{
					//Save all content
					ppbSaveAll();
					
					//Set preview frame data
					ppbSetPreviewData();
						
					//Reload preview frame
					ppbReloadPreview();
				}
			    
			    refreshBuilderBlockEvents();
			    
			    jQuery.fancybox.close();
			});
			
			jQuery.fancybox.hideLoading();
		});
		</script>
<?php
		}
	}
	
	die();
}

/**
*	Setup AJAX portfolio content builder preview function
**/
add_action('wp_ajax_photography_ppb_preview', 'photography_ppb_preview');
add_action('wp_ajax_nopriv_photography_ppb_preview', 'photography_ppb_preview');

function photography_ppb_preview() {
	if(is_admin() && isset($_GET['page_id']) && !empty($_GET['page_id']) && isset($_GET['rel']) && !empty($_GET['rel']))
	{
		$page_id = $_GET['page_id'];
		$page_title = $_GET['title'];
		$ppb_form_item = $_GET['rel'];
		$preview_url = get_permalink($page_id);
		$preview_url.= '?ppb_preview=true&rel='.$ppb_form_item;
?>
	<iframe id="ppb_preview_frame" src="<?php echo esc_url($preview_url); ?>"></iframe>
<?php
	}
	die();
}

/**
*	Setup AJAX portfolio content builder preview page function
**/
add_action('wp_ajax_photography_ppb_preview_page', 'photography_ppb_preview_page');
add_action('wp_ajax_nopriv_photography_ppb_preview_page', 'photography_ppb_preview_page');

function photography_ppb_preview_page() {
	if(is_admin() && isset($_GET['page_id']) && !empty($_GET['page_id']))
	{
		$page_id = $_GET['page_id'];
		$page_title = get_the_title($page_id);
		$preview_url = get_permalink($page_id);
		$preview_url.= '?ppb_preview_page=true';
?>
	<iframe id="ppb_preview_frame" src="<?php echo esc_url($preview_url); ?>"></iframe>
<?php
	}
	die();
}


/**
*	Setup content builder set data for preview page function
**/
add_action('wp_ajax_photography_ppb_preview_page_set_data', 'photography_ppb_preview_page_set_data');
add_action('wp_ajax_nopriv_photography_ppb_preview_page_set_data', 'photography_ppb_preview_page_set_data');

function photography_ppb_preview_page_set_data() {
	
	if(is_admin() && isset($_POST['page_id']) && !empty($_POST['page_id']))
	{
		$page_id = $_POST['page_id'];
		$data = mb_convert_encoding($_POST['data'],'UTF-8','UTF-8');
		$data = json_decode($_POST['data']);
		//var_dump($_POST['data']);
		//var_dump($_POST['data_order']);
		$data_order = $_POST['data_order'];
		
		//Set data order to WordPress cache
		set_transient('photography_'.$page_id.'_data_order', $data_order, 3600 );
		
		//Convert order data to array
		$ppb_form_item_arr = array();
		if(!empty($data_order))
		{
		    $ppb_form_item_arr = explode(',', $data_order);
		}
		
		if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
		{
		    $data_arr = array();
		    $size_arr = array();
		
		    foreach($ppb_form_item_arr as $key => $ppb_form_item)
		    {
		    	if(isset($_POST[$ppb_form_item.'_data']))
		    	{
			    	$data_arr[$ppb_form_item] = $_POST[$ppb_form_item.'_data'];
			    	$size_arr[$ppb_form_item] = $_POST[$ppb_form_item.'_size'];
		    	}
		    }
		}
		
		set_transient('photography_'.$page_id.'_data', $data_arr, 3600 );
		set_transient('photography_'.$page_id.'_size', $size_arr, 3600 );
?>
	
<?php
	}
	die();
}


/**
*	Setup preview demo page function
**/
add_action('wp_ajax_photography_ppb_demo_preview', 'photography_ppb_demo_preview');
add_action('wp_ajax_nopriv_photography_ppb_demo_preview', 'photography_ppb_demo_preview');

function photography_ppb_demo_preview() {
	if(is_admin() && isset($_POST['key']) && !empty($_POST['key']))
	{
		require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
		
		if(isset($ppb_shortcodes[$_POST['key']]))
		{
			$page_title = $ppb_shortcodes[$_POST['key']]['title'];
			$preview_url = $ppb_shortcodes[$_POST['key']]['url'];
?>
	<div class="ppb_inline_wrap preview">
	    <h2><?php esc_html_e('Preview', 'photography-translation' ); ?> <?php echo urldecode($page_title); ?></h2>
	    <a class="button button-primary" href="javascript:;" onClick="jQuery.fancybox.close();"><?php esc_html_e('Close', 'photography-translation' ); ?></a>
	</div>	
	<iframe id="ppb_preview_frame" src="<?php echo esc_url($preview_url); ?>"></iframe>
<?php
		}
	}
	die();
}


/**
*	Setup live preview element function
**/
add_action('wp_ajax_photography_ppb_get_live_preview', 'photography_ppb_get_live_preview');
add_action('wp_ajax_nopriv_photography_ppb_get_live_preview', 'photography_ppb_get_live_preview');

function photography_ppb_get_live_preview() {

	if(is_admin() && isset($_POST['data']) && !empty($_POST['data']) && isset($_POST['size']) && !empty($_POST['size']))
	{
		$ppb_form_item = $_POST['rel'];
		$ppb_form_item_size = $_POST['size'];
		$ppb_form_item_data = $_POST['data'];
		$ppb_form_item_data = mb_convert_encoding($ppb_form_item_data,'UTF-8','UTF-8');
		$ppb_form_item_data_obj = json_decode(stripslashes($ppb_form_item_data));
	    $ppb_shortcode_content_name = $_GET['shortcode'];
	    $ppb_shortcode_code = '';
	    
	    /*print '<pre>';
	    print_r($ppb_form_item_data_obj);
	    print '</pre>';*/
	    
	    $ppb_shortcodes = array();
		require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
	    
	    if(isset($ppb_form_item_data_obj->$ppb_shortcode_content_name))
	    {
	        $ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size.'" ';
	        
	        //Get shortcode title
	        $ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	        if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
	        {
	        	$ppb_shortcode_code.= 'title="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
	        }
	        
	        //Get shortcode attributes
	        if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
	        {
	        	$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
	        	
	        	foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
	        	{
	        		$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
	        		
	        		if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
	        		{
	        			$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_name)).'" ';
	        		}
	        	}
	        }
	
	        $ppb_shortcode_code.= ']'.rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_content_name).'[/'.$ppb_form_item_data_obj->shortcode.']';
	    }
	    else
	    {
	        $ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size.'" ';
	        
	        //Get shortcode title
	        $ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	        if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
	        {
	        	$ppb_shortcode_code.= 'title="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
	        }
	        
	        //Get shortcode attributes
	        if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
	        {
	        	$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
	        	
	        	foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
	        	{
	        		$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
	        		
	        		if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
	        		{
	        			$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_name)).'" ';
	        		}
	        	}
	        }
	        
	        $ppb_shortcode_code.= ']';
	    }
	    //echo $ppb_shortcode_code;
	    echo do_shortcode($ppb_shortcode_code);
	}
	die();
}


/**
*	Save current as template function
**/
add_action('wp_ajax_photography_ppb_set_template', 'photography_ppb_set_template');
add_action('wp_ajax_nopriv_photography_ppb_set_template', 'photography_ppb_set_template');

function photography_ppb_set_template() {
	if(is_admin() && isset($_POST['template_name']) && !empty($_POST['template_name']) && isset($_GET['page_id']) && !empty($_GET['page_id']) && strlen($_POST['template_name']) >= 3)
	{
		//Get page ID
		$page_id = $_GET['page_id'];
		
		//get list of my templates in array
		$my_current_templates = get_option(SHORTNAME."_my_templates");
		
		//set new template ID and name
		$new_template_name = sanitize_text_field($_POST['template_name']);
		$new_template_id = $page_id.'_'.time();
		$my_current_templates[$new_template_id] = $new_template_name;
		
		//Update my template list
		update_option( SHORTNAME."_my_templates", $my_current_templates );
		
		//Save current page builder content to my template
		$ppb_form_data_order = get_post_meta($page_id, 'ppb_form_data_order');
		$export_options_arr = array();

		if(!empty($ppb_form_data_order))
		{
		    $export_options_arr['ppb_form_data_order'] = $ppb_form_data_order;

		    //Get each builder module data
		    $ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
		
		    foreach($ppb_form_item_arr as $key => $ppb_form_item)
		    {
		    	$ppb_form_item_data = get_post_meta($post_id, $ppb_form_item.'_data');
		    	$export_options_arr[$ppb_form_item.'_data'] = $ppb_form_item_data;
		    	
		    	$ppb_form_item_size = get_post_meta($post_id, $ppb_form_item.'_size');
		    	$export_options_arr[$ppb_form_item.'_size'] = $ppb_form_item_size;
		    }
		}
		
		update_option( SHORTNAME."_template_".$new_template_id, json_encode($export_options_arr) );
		
		//return template ID
		echo $new_template_id;
	}
	
	die();
}


/**
*	Remove current template function
**/
add_action('wp_ajax_photography_ppb_remove_template', 'photography_ppb_remove_template');
add_action('wp_ajax_nopriv_photography_ppb_remove_template', 'photography_ppb_remove_template');

function photography_ppb_remove_template() {
	if(is_admin() && isset($_GET['template_id']) && !empty($_GET['template_id']))
	{
		//get list of my templates in array
		$my_current_templates = get_option(SHORTNAME."_my_templates");
		$template_id = $_GET['template_id'];
		
		if(isset($my_current_templates[$template_id]))
		{
			//Remove template from array
			unset($my_current_templates[$template_id]);
			
			//Remove from my template list
			update_option( SHORTNAME."_my_templates", $my_current_templates );
			
			//Remove template data
			delete_option( SHORTNAME."_template_".$template_id );
			
			//display to AJAX response
			echo 1;
		}
	}
	
	die();
}


/**
*	Save page builder custom fields
**/
add_action('wp_ajax_photography_ppb_save_page_builder', 'photography_ppb_save_page_builder');
add_action('wp_ajax_nopriv_photography_ppb_save_page_builder', 'photography_ppb_save_page_builder');

function photography_ppb_save_page_builder() {
	if(is_admin() && isset($_POST['data_order']) && isset($_GET['page_id']) && !empty($_GET['page_id']))
	{
		$page_id = $_GET['page_id'];
		
		 //Get builder item
	    $ppb_form_data_order = $_POST['data_order'];
	    $ppb_form_item_arr = array();
	    
	    if(isset($ppb_form_data_order))
	    {
	    	$ppb_form_item_arr = explode(',', $ppb_form_data_order);
	    }
	    
	    if(!empty($ppb_form_item_arr))
	    {
	    	update_post_meta($page_id, 'ppb_form_data_order', $ppb_form_data_order);
	    
	    	foreach($ppb_form_item_arr as $key => $ppb_form_item)
	    	{
	    		update_post_meta($page_id, $ppb_form_item.'_data', $_POST[$ppb_form_item.'_data']);
	    		update_post_meta($page_id, $ppb_form_item.'_size', $_POST[$ppb_form_item.'_size']);
	    	}
	    }
	}
	
	die();
}


/**
*	Save page custom fields
**/
add_action('wp_ajax_photography_ppb_save_page_custom_field', 'photography_ppb_save_page_custom_field');
add_action('photography_ppb_save_page_custom_field', 'photography_ppb_save_page_custom_field');

function photography_ppb_save_page_custom_field() {
	if(is_admin() && isset($_GET['page_id']) && !empty($_GET['page_id']) && isset($_POST['field']) && !empty($_POST['field']) && isset($_POST['data']))
	{
		echo $page_id;
		$page_id = $_GET['page_id'];
		update_post_meta($page_id, $_POST['field'], $_POST['data']);
	}
	
	die();
}

/**
*	Setup one click importer function
**/
add_action('wp_ajax_photography_import_demo_content', 'photography_import_demo_content');
add_action('wp_ajax_nopriv_photography_import_demo_content', 'photography_import_demo_content');

function photography_import_demo_content() {
	if(is_admin() && isset($_POST['demo']) && !empty($_POST['demo']))
	{
	    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	    
	    // Load Importer API
	    require_once ABSPATH . 'wp-admin/includes/import.php';
	
	    if ( ! class_exists( 'WP_Importer' ) ) {
	        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	        if ( file_exists( $class_wp_importer ) )
	        {
	            require $class_wp_importer;
	        }
	    }
	
	    if ( ! class_exists( 'WP_Import' ) ) {
	        $class_wp_importer = get_template_directory() ."/modules/import/wordpress-importer.php";
	        if ( file_exists( $class_wp_importer ) )
	            require $class_wp_importer;
	    }
	
	    $import_files = array();
	    $page_on_front ='';

		//Check import selected demo
	    if ( class_exists( 'WP_Import' ) ) 
	    { 
	    	switch($_POST['demo'])
	    	{
		    	case 1:
		    	default:
		    		//Check if install Woocommerce
		    		if(!class_exists('Woocommerce'))
					{
		    			$import_filepath = get_template_directory() ."/cache/demos/1.xml" ;
		    		}
		    		else
		    		{
			    		$import_filepath = get_template_directory() ."/cache/demos/1_woo.xml" ;
		    		}
		    		
		    		$page_on_front = 3602; //Demo Homepage ID
		    		$oldurl = 'http://themes.themegoods2.com/photography/demo1';
		    	break;
	    	}
			
			//Run and download demo contents
			$wp_import = new WP_Import();
	        $wp_import->fetch_attachments = true;
	        $wp_import->import($import_filepath);
	    }
	    
	    //Setup default front page settings.
	    update_option('show_on_front', 'page');
	    update_option('page_on_front', $page_on_front);
	    
	    //Set default custom menu settings
	    $locations = get_theme_mod('nav_menu_locations');
		$locations['primary-menu'] = 22;
		$locations['top-menu'] = 25;
		$locations['side-menu'] = 24;
		set_theme_mod( 'nav_menu_locations', $locations );
		
		//Import widgets
		$import_widget_filepath = get_template_directory() ."/cache/demos/1.wie" ;
		
		// Get file contents and decode
		WP_Filesystem();
		global $wp_filesystem;
		$data = $wp_filesystem->get_contents($import_widget_filepath);
		$data = json_decode( $data );
	
		// Import the widget data
		// Make results available for display on import/export page
		$widget_import_results = photography_import_data( $data );
		
		//Set default Blog Slider category
		set_theme_mod( 'tg_blog_slider_cat', 2 );
		
		//Change all URLs from demo URL to localhost
		$update_options = array ( 0 => 'content', 1 => 'excerpts', 2 => 'links', 3 => 'attachments', 4 => 'custom', 5 => 'guids', );
		$newurl = esc_url( site_url() ) ;
		photography_update_urls($update_options, $oldurl, $newurl);
		
		//Refresh rewrite rules
		flush_rewrite_rules();
	    
		exit();
	}
}

/**
*	Setup get styling function
**/
add_action('wp_ajax_photography_get_styling', 'photography_get_styling');
add_action('wp_ajax_nopriv_photography_get_styling', 'photography_get_styling');

function photography_get_styling() {
	if(is_admin() && isset($_POST['styling']) && !empty($_POST['styling']))
	{
	    require_once ABSPATH . 'wp-admin/includes/file.php';
		$styling_file = get_template_directory() . "/cache/demos/customizer/settings/".$_POST['styling'].".dat";

		if(file_exists($styling_file))
		{
			WP_Filesystem();
			global $wp_filesystem;
			$styling_data = $wp_filesystem->get_contents($styling_file);
			$styling_data_arr = unserialize($styling_data);
			
			if(isset($styling_data_arr['mods']) && is_array($styling_data_arr['mods']))
			{	
				// Get menu locations and save to array
				$locations = get_theme_mod('nav_menu_locations');
				$save_menus = array();
				foreach( $locations as $key => $val ) 
				{
					$save_menus[$key] = $val;
				}
			
				//Remove all theme customizer
				remove_theme_mods();
				
				//Re-add the menus
				set_theme_mod('nav_menu_locations', array_map( 'absint', $save_menus ));
			
				foreach($styling_data_arr['mods'] as $key => $styling_mod)
				{
					if(!is_array($styling_mod))
					{
						set_theme_mod( $key, $styling_mod );
					}
				}
			}
		    
			exit();
		}
	}
}

/**
*	Setup AJAX search function
**/
add_action('wp_ajax_photography_ajax_search', 'photography_ajax_search');
add_action('wp_ajax_nopriv_photography_ajax_search', 'photography_ajax_search');

function photography_ajax_search() {
	global $wpdb;
	
	if (strlen($_POST['s'])>0) {
		$limit=5;
		$s=strtolower(addslashes($_POST['s']));
		$querystr = "
			SELECT $wpdb->posts.*
			FROM $wpdb->posts
			WHERE 1=1 AND ((lower($wpdb->posts.post_title) like %s))
			AND $wpdb->posts.post_type IN ('post', 'page', 'portfolios', 'galleries')
			AND (post_status = 'publish')
			ORDER BY $wpdb->posts.post_date DESC
			LIMIT $limit;
		 ";

	 	$pageposts = $wpdb->get_results($wpdb->prepare($querystr, '%'.$wpdb->esc_like($s).'%'), OBJECT);
	 	
	 	if(!empty($pageposts))
	 	{
			echo '<ul>';
	
	 		foreach($pageposts as $result_item) 
	 		{
	 			$post=$result_item;
	 			
	 			$post_type = get_post_type($post->ID);
				$post_type_class = '';
				$post_type_title = '';
				
				switch($post_type)
				{
				    case 'galleries':
				    	$post_type_class = '<i class="fa fa-picture-o"></i>';
				    	$post_type_title = esc_html__('Gallery', 'photography-translation' );
				    break;
				    
				    case 'page':
				    default:
				    	$post_type_class = '<i class="fa fa-file-text-o"></i>';
				    	$post_type_title = esc_html__('Page', 'photography-translation' );
				    break;
				    
				    case 'projects':
				    	$post_type_class = '<i class="fa fa-folder-open-o"></i>';
				    	$post_type_title = esc_html__('Projects', 'photography-translation' );
				    break;
				    
				    case 'services':
				    	$post_type_class = '<i class="fa fa-star"></i>';
				    	$post_type_title = esc_html__('Service', 'photography-translation' );
				    break;
				    
				    case 'clients':
				    	$post_type_class = '<i class="fa fa-user"></i>';
				    	$post_type_title = esc_html__('Client', 'photography-translation' );
				    break;
				}
				
				$post_thumb = array();
				if(has_post_thumbnail($post->ID, 'thumbnail'))
				{
				    $image_id = get_post_thumbnail_id($post->ID);
				    $post_thumb = wp_get_attachment_image_src($image_id, 'thumbnail', true);
				    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				    
				    if(isset($post_thumb[0]) && !empty($post_thumb[0]))
				    {
				        $post_type_class = '<div class="search_thumb"><img src="'.$post_thumb[0].'" alt="'.esc_attr($image_alt).'"/></div>';
				    }
				}
	 			
				echo '<li>';
				
				if(!isset($post_thumb[0]))
				{
					echo '<div class="post_type_icon">';
				}
				
				echo '<a href="'.get_permalink($post->ID).'">'.$post_type_class.'</i></a>';
				
				if(!isset($post_thumb[0]))
				{
					echo '</div>';
				}
				
				echo '<div class="ajax_post">';
				echo '<a href="'.get_permalink($post->ID).'"><strong>'.$post->post_title.'</strong><br/>';
				echo '<span class="post_detail">'.date(THEMEDATEFORMAT, strtotime($post->post_date)).'</span></a>';
				echo '</div>';
				echo '</li>';
			}
			
			echo '<li class="view_all"><a href="javascript:jQuery(\'#searchform\').submit()">'.esc_html__('View all results', 'photography-translation' ).'</a></li>';
	
			echo '</ul>';
		}

	}
	else 
	{
		echo '';
	}
	die();

}


/**
*	End theme custom AJAX calls handler
**/

/**
*	Setup contact form mailing function
**/
add_action('wp_ajax_photography_contact_mailer', 'photography_contact_mailer');
add_action('wp_ajax_nopriv_photography_contact_mailer', 'photography_contact_mailer');

function photography_contact_mailer() {
	check_ajax_referer( 'tgajax-post-contact-nonce', 'tg_security' );
	
	//Error message when message can't send
	define('ERROR_MESSAGE', 'Oops! something went wrong, please try to submit later.');
	
	if (isset($_POST['your_name'])) {
	
		//Get your email address
		$contact_email = get_option('pp_contact_email');
		$pp_contact_thankyou = esc_html__('Thank you! We will get back to you as soon as possible', 'photography-translation' );
		
		/*
		|
		| Begin sending mail
		|
		*/
		
		$from_name = $_POST['your_name'];
		$from_email = $_POST['email'];
		
		//Get contact subject
		if(!isset($_POST['subject']))
		{
			$contact_subject = esc_html__('[Email Contact]', 'photography-translation' ).' '.get_bloginfo('name');
		}
		else
		{
			$contact_subject = $_POST['subject'];
		}
		
		$headers = "";
	   	//$headers.= 'From: '.$from_name.' <'.$from_email.'>'.PHP_EOL;
	   	$headers.= 'Reply-To: '.$from_name.' <'.$from_email.'>'.PHP_EOL;
	   	$headers.= 'Return-Path: '.$from_name.' <'.$from_email.'>'.PHP_EOL;
		
		$message = esc_html__('Name', 'photography-translation' ).': '.$from_name.PHP_EOL;
		$message.= esc_html__('Email', 'photography-translation' ).': '.$from_email.PHP_EOL.PHP_EOL;
		$message.= esc_html__('Message', 'photography-translation' ).': '.PHP_EOL.$_POST['message'].PHP_EOL.PHP_EOL;
		
		if(isset($_POST['address']))
		{
			$message.= esc_html__('Address', 'photography-translation' ).': '.$_POST['address'].PHP_EOL;
		}
		
		if(isset($_POST['phone']))
		{
			$message.= esc_html__('Phone', 'photography-translation' ).': '.$_POST['phone'].PHP_EOL;
		}
		
		if(isset($_POST['mobile']))
		{
			$message.= esc_html__('Mobile', 'photography-translation' ).': '.$_POST['mobile'].PHP_EOL;
		}
		
		if(isset($_POST['company']))
		{
			$message.= esc_html__('Company:', 'photography-translation' ).': '.$_POST['company'].PHP_EOL;
		}
		
		if(isset($_POST['country']))
		{
			$message.= esc_html__('Country:', 'photography-translation' ).': '.$_POST['country'].PHP_EOL;
		}
		    
		
		if(!empty($from_name) && !empty($from_email) && !empty($message))
		{
			wp_mail($contact_email, $contact_subject, $message, $headers);
			echo '<p>'.$pp_contact_thankyou.'</p>';
			
			die;
		}
		else
		{
			echo '<p>'.ERROR_MESSAGE.'</p>';
			
			die;
		}

	}
	else 
	{
		echo '<p>'.ERROR_MESSAGE.'</p>';
	}
	die();
}

/**
*	End theme contact form mailing function
**/


/**
*	Setup gallery grid infinite scroll function
**/
add_action('wp_ajax_photography_gallery_grid', 'photography_gallery_grid');
add_action('wp_ajax_nopriv_photography_gallery_grid', 'photography_gallery_grid');

function photography_gallery_grid() {
	check_ajax_referer( 'tgajax-post-contact-nonce', 'tg_security' );
	
	$gallery_id = '';
	$items = 1;
	$columns = 2;
	$offset = 0;
	$type = 'grid';
	$image_size = 'photography-gallery-grid';
	
	if(isset($_POST['gallery_id']))
	{
		$gallery_id = $_POST['gallery_id'];
	}
	
	if(isset($_POST['items']))
	{
		$items = $_POST['items'];
	}
	
	if(isset($_POST['columns']))
	{
		$columns = $_POST['columns'];
	}
	
	if(isset($_POST['offset']))
	{
		$offset = $_POST['offset'];
	}
	
	if(isset($_POST['type']))
	{
		$type = $_POST['type'];
	}
	
	//Check if masonry image size
	if($type != 'grid')
	{
		$image_size = 'photography-gallery-masonry';
	}
	
	$images_arr = get_post_meta($gallery_id, 'wpsimplegallery_gallery', true);
	$images_arr = photography_resort_gallery_img($images_arr);
	$images_arr = array_values($images_arr);
	
	$return_html = '';
	
	if(!is_numeric($columns))
	{
		$columns = 4;
	}
	
	$wrapper_class = '';
	$grid_wrapper_class = '';
	$column_class = '';
	
	switch($columns)
	{
		case 2:
			$wrapper_class = 'two_cols';
			$grid_wrapper_class = 'classic2_cols';
			$column_class = 'one_half gallery2';
		break;
		
		case 3:
			$wrapper_class = 'three_cols';
			$grid_wrapper_class = 'classic3_cols';
			$column_class = 'one_third gallery3';
		break;
		
		case 4:
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
		break;
		
		case 5:
			$wrapper_class = 'five_cols';
			$grid_wrapper_class = 'classic5_cols';
			$column_class = 'one_fifth gallery5';
		break;
	}
	
	$current_offset = intval($offset+$items-1);
	if($current_offset > count($images_arr))
	{
		$current_offset = count($images_arr);
	}
	
	if(!empty($images_arr))
	{	
		for($i = $offset; $i <= $current_offset; $i++)
		{
			if(isset($images_arr[$i]))
			{
				$image = $images_arr[$i];
		    	$obj_image = wp_get_attachment_image_src($image, 'original');
				
				$image_url = wp_get_attachment_image_src($image, 'original', true);
				$small_image_url = wp_get_attachment_image_src($image, $image_size, true);
				
				$image_caption = get_post_field('post_excerpt', $image);
				$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
				
				//Get image purchase URL
				$photography_purchase_url = get_post_meta($image, 'photography_purchase_url', true);
				
				if(!empty($photography_purchase_url))
				{
				    $image_caption.= '<a href="'.esc_url($photography_purchase_url).'" class="button ghost"><i class="fa fa-shopping-cart marginright"></i>'.esc_html__('Purchase', 'photography-translation' ).'</a>';
				}
				
				$tg_lightbox_enable_caption = kirki_get_option('tg_lightbox_enable_caption');
				
				$return_html.= '<div class="element grid ' .esc_attr($grid_wrapper_class).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' static filterable gallery_type">';
				$return_html.= '<a class="fancy-gallery" href="'.esc_url($image_url[0]).'" ';
				
				if(!empty($tg_lightbox_enable_caption)) 
				{
					$return_html.= 'data-caption="'.esc_attr($image_caption).'" ';
				}
				
				$return_html.= '>';
				$return_html.= '<img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($image_alt).'" width="'.esc_attr($obj_image[1]).'" height="'.esc_attr($obj_image[2]).'"/>';
				
				$return_html.= '</a>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
		}
	}
	
	echo stripslashes($return_html);
	die();
}

/**
*	End gallery grid infinite scroll function
**/


/**
*	Setup portfolio grid infinite scroll function
**/
add_action('wp_ajax_photography_portfolio_grid', 'photography_portfolio_grid');
add_action('wp_ajax_nopriv_photography_portfolio_grid', 'photography_portfolio_grid');

function photography_portfolio_grid() {
	check_ajax_referer( 'tgajax-post-contact-nonce', 'tg_security' );
	
	$cat = '';
	$items = 1;
	$items_ini = 0;
	$columns = 2;
	$offset = 0;
	$type = 'grid';
	$image_size = 'photography-gallery-grid';
	
	if(isset($_POST['cat']))
	{
		$cat = $_POST['cat'];
	}
	
	if(isset($_POST['items']))
	{
		$items = $_POST['items'];
	}
	
	if(isset($_POST['items_ini']))
	{
		$items_ini = $_POST['items_ini'];
	}
	
	if(isset($_POST['columns']))
	{
		$columns = $_POST['columns'];
	}
	
	if(isset($_POST['offset']))
	{
		$offset = $_POST['offset'];
	}
	
	if(isset($_POST['type']))
	{
		$type = $_POST['type'];
	}
	
	if(isset($_POST['order']))
	{
		$portfolio_order = $_POST['order'];
	}
	
	if(isset($_POST['order_by']))
	{
		$portfolio_order_by = $_POST['order_by'];
	}
	
	if(isset($_POST['layout']))
	{
		$layout = $_POST['layout'];
	}
	
	//Check if masonry image size
	if($type != 'grid')
	{
		$image_size = 'photography-gallery-masonry';
	}
	
	$return_html = '';
	
	$portfolio_order = 'ASC';
	$portfolio_order_by = 'menu_order';
	switch($portfolio_order)
	{
		case 'default':
			$portfolio_order = 'ASC';
			$portfolio_order_by = 'menu_order';
		break;
		
		case 'newest':
			$portfolio_order = 'DESC';
			$portfolio_order_by = 'post_date';
		break;
		
		case 'oldest':
			$portfolio_order = 'ASC';
			$portfolio_order_by = 'post_date';
		break;
		
		case 'title':
			$portfolio_order = 'ASC';
			$portfolio_order_by = 'title';
		break;
		
		case 'random':
			$portfolio_order = 'ASC';
			$portfolio_order_by = 'rand';
		break;
	}
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'order' => $portfolio_order,
	    'orderby' => $portfolio_order_by,
	    'post_type' => array('portfolios'),
	    'suppress_filters' => false,
	);
	
	if(!empty($cat))
	{
		$args['portfoliosets'] = $cat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$wrapper_class = '';
	$grid_wrapper_class = '';
	$column_class = '';
	
	switch($columns)
	{
		case 2:
			$wrapper_class = 'two_cols';
			$grid_wrapper_class = 'classic2_cols';
			$column_class = 'one_half gallery2';
		break;
		
		case 3:
			$wrapper_class = 'three_cols';
			$grid_wrapper_class = 'classic3_cols';
			$column_class = 'one_third gallery3';
		break;
		
		case 4:
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
		break;
		
		case 4:
			$wrapper_class = 'five_cols';
			$grid_wrapper_class = 'classic5_cols';
			$column_class = 'one_fifth gallery5';
		break;
	}
	
	$current_offset = intval($offset+$items_ini-1);
	if($current_offset > count($portfolios_arr))
	{
		$current_offset = count($portfolios_arr);
	}

	if(!empty($portfolios_arr))
	{	
		for($i = $offset; $i <= $current_offset; $i++)
		{
			if(isset($portfolios_arr[$i]))
			{
				$key = $i;
				$image_url = '';
				$portfolio_ID = $portfolios_arr[$i]->ID;
						
				if(has_post_thumbnail($portfolio_ID, 'original'))
				{
				    $image_id = get_post_thumbnail_id($portfolio_ID);
				    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
				    
				    $small_image_url = wp_get_attachment_image_src($image_id, $image_size, true);
				}
				
				$portfolio_link_url = get_post_meta($portfolio_ID, 'portfolio_link_url', true);
				
				if(empty($portfolio_link_url))
				{
				    $permalink_url = get_permalink($portfolio_ID);
				}
				else
				{
				    $permalink_url = $portfolio_link_url;
				}
				
				//Begin display HTML
				$return_html.= '<div class="element '.esc_attr($grid_wrapper_class).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' filterable static animated'.($key+1).' portfolio_type">';
				
				if(!empty($image_url[0]))
				{
					$portfolio_type = get_post_meta($portfolio_ID, 'portfolio_type', true);
				    $portfolio_video_id = get_post_meta($portfolio_ID, 'portfolio_video_id', true);
				    
				    switch($portfolio_type)
				    {
				    case 'External Link':
						$portfolio_link_url = get_post_meta($portfolio_ID, 'portfolio_link_url', true);
				
						$return_html.= '<a target="_blank" href="'.esc_url($portfolio_link_url).'"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div id="portfolio_desc_'.esc_attr($portfolio_ID).'" class="portfolio_title">
	        					<div class="table">
	        						<div class="cell">
							            <h5>'.$portfolios_arr[$i]->post_title.'</h5>
							            <div class="post_detail">'.$portfolios_arr[$i]->post_excerpt.'</div>
	        						</div>
	        					</div>
					        </div></a>';
				        
				    break;
				    //end external link
				    
				    case 'Project Content':
	        	    default:
	
			        	$return_html.= '<a href="'.get_permalink($portfolio_ID).'"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div id="portfolio_desc_'.esc_attr($portfolio_ID).'" class="portfolio_title">
	        					<div class="table">
	        						<div class="cell">
							            <h5>'.$portfolios_arr[$i]->post_title.'</h5>
							            <div class="post_detail">'.$portfolios_arr[$i]->post_excerpt.'</div>
	        						</div>
	        					</div>
					        </div></a>';
		        
				    break;
				    //end external link
	        	    
	        	    case 'Image':
				
						$return_html.= '<a data-caption="'.esc_attr($portfolios_arr[$i]->post_title).'" href="'.esc_url($image_url[0]).'" class="fancy-gallery"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div id="portfolio_desc_'.esc_attr($portfolio_ID).'" class="portfolio_title">
	        					<div class="table">
	        						<div class="cell">
							            <h5>'.$portfolios_arr[$i]->post_title.'</h5>
							            <div class="post_detail">'.$portfolios_arr[$i]->post_excerpt.'</div>
	        						</div>
	        					</div>
					        </div></a>';
				
				    break;
				    //end image
				    
				    case 'Youtube Video':
				
						$return_html.= '<a href="https://www.youtube.com/embed/'.esc_attr($portfolio_video_id).'" class="lightbox_youtube" data-options="width:900, height:488"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div id="portfolio_desc_'.esc_attr($portfolio_ID).'" class="portfolio_title">
	        					<div class="table">
	        						<div class="cell">
							            <h5>'.$portfolios_arr[$i]->post_title.'</h5>
							            <div class="post_detail">'.$portfolios_arr[$i]->post_excerpt.'</div>
	        						</div>
	        					</div>
					        </div></a>';
				
				    break;
				    //end youtube
				
				case 'Vimeo Video':
	
						$return_html.= '<a href="https://player.vimeo.com/video/'.esc_attr($portfolio_video_id).'" class="lightbox_vimeo" data-options="width:900, height:506"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div id="portfolio_desc_'.esc_attr($portfolio_ID).'" class="portfolio_title">
	        					<div class="table">
	        						<div class="cell">
							            <h5>'.$portfolios_arr[$i]->post_title.'</h5>
							            <div class="post_detail">'.$portfolios_arr[$i]->post_excerpt.'</div>
	        						</div>
	        					</div>
					        </div></a>';
				
				    break;
				    //end vimeo
				    
				case 'Self-Hosted Video':
				
				    //Get video URL
				    $portfolio_mp4_url = get_post_meta($portfolio_ID, 'portfolio_mp4_url', true);
				    $preview_image = wp_get_attachment_image_src($image_id, 'large', true);
				    
						$return_html.= '<a href="'.esc_url($portfolio_mp4_url).'" class="lightbox_vimeo"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div id="portfolio_desc_'.esc_attr($portfolio_ID).'" class="portfolio_title">
	        					<div class="table">
	        						<div class="cell">
							            <h5>'.$portfolios_arr[$i]->post_title.'</h5>
							            <div class="post_detail">'.$portfolios_arr[$i]->post_excerpt.'</div>
	        						</div>
	        					</div>
					        </div></a>';
				
				    break;
				    //end self-hosted
				    }
				    //end switch
				}
				$return_html.= '</div>';
				
				$return_html.= '</div>';
			}
		}
	}
	
	echo stripslashes($return_html);
	die();
}

/**
*	End portfolio grid infinite scroll function
**/


/**
*	Setup portfolio classic infinite scroll function
**/
add_action('wp_ajax_photography_portfolio_classic', 'photography_portfolio_classic');
add_action('wp_ajax_nopriv_photography_portfolio_classic', 'photography_portfolio_classic');

function photography_portfolio_classic() {
	check_ajax_referer( 'tgajax-post-contact-nonce', 'tg_security' );
	
	$cat = '';
	$items = 1;
	$items_ini = 0;
	$columns = 2;
	$offset = 0;
	$type = 'grid';
	$image_size = 'photography-gallery-grid';
	
	if(isset($_POST['cat']))
	{
		$cat = $_POST['cat'];
	}
	
	if(isset($_POST['items']))
	{
		$items = $_POST['items'];
	}
	
	if(isset($_POST['items_ini']))
	{
		$items_ini = $_POST['items_ini'];
	}
	
	if(isset($_POST['columns']))
	{
		$columns = $_POST['columns'];
	}
	
	if(isset($_POST['offset']))
	{
		$offset = $_POST['offset'];
	}
	
	if(isset($_POST['type']))
	{
		$type = $_POST['type'];
	}
	
	if(isset($_POST['order']))
	{
		$portfolio_order = $_POST['order'];
	}
	
	if(isset($_POST['order_by']))
	{
		$portfolio_order_by = $_POST['order_by'];
	}
	
	if(isset($_POST['layout']))
	{
		$layout = $_POST['layout'];
	}
	
	//Check if masonry image size
	if($type != 'grid')
	{
		$image_size = 'photography-gallery-masonry';
	}
	
	$return_html = '';
	
	$portfolio_order = 'ASC';
	$portfolio_order_by = 'menu_order';
	switch($portfolio_order)
	{
		case 'default':
			$portfolio_order = 'ASC';
			$portfolio_order_by = 'menu_order';
		break;
		
		case 'newest':
			$portfolio_order = 'DESC';
			$portfolio_order_by = 'post_date';
		break;
		
		case 'oldest':
			$portfolio_order = 'ASC';
			$portfolio_order_by = 'post_date';
		break;
		
		case 'title':
			$portfolio_order = 'ASC';
			$portfolio_order_by = 'title';
		break;
		
		case 'random':
			$portfolio_order = 'ASC';
			$portfolio_order_by = 'rand';
		break;
	}
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'order' => $portfolio_order,
	    'orderby' => $portfolio_order_by,
	    'post_type' => array('portfolios'),
	    'suppress_filters' => false,
	);
	
	if(!empty($cat))
	{
		$args['portfoliosets'] = $cat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$wrapper_class = '';
	$grid_wrapper_class = '';
	$column_class = '';
	
	switch($columns)
	{
		case 2:
			$wrapper_class = 'two_cols';
			$grid_wrapper_class = 'classic2_cols';
			$column_class = 'one_half gallery2';
		break;
		
		case 3:
			$wrapper_class = 'three_cols';
			$grid_wrapper_class = 'classic3_cols';
			$column_class = 'one_third gallery3';
		break;
		
		case 4:
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
		break;
		
		case 4:
			$wrapper_class = 'five_cols';
			$grid_wrapper_class = 'classic5_cols';
			$column_class = 'one_fifth gallery5';
		break;
	}
	
	$current_offset = intval($offset+$items_ini-1);
	if($current_offset > count($portfolios_arr))
	{
		$current_offset = count($portfolios_arr);
	}

	if(!empty($portfolios_arr))
	{	
		for($i = $offset; $i <= $current_offset; $i++)
		{
			if(isset($portfolios_arr[$i]))
			{
				$key = $i;
				$image_url = '';
				$portfolio_ID = $portfolios_arr[$i]->ID;
						
				if(has_post_thumbnail($portfolio_ID, 'original'))
				{
				    $image_id = get_post_thumbnail_id($portfolio_ID);
				    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
				    
				    $small_image_url = wp_get_attachment_image_src($image_id, $image_size, true);
				}
				
				$portfolio_link_url = get_post_meta($portfolio_ID, 'portfolio_link_url', true);
				
				if(empty($portfolio_link_url))
				{
				    $permalink_url = get_permalink($portfolio_ID);
				}
				else
				{
				    $permalink_url = $portfolio_link_url;
				}
				
				//Begin display HTML
				$return_html.= '<div class="element '.esc_attr($grid_wrapper_class).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' classic filterable static animated'.($key+1).'">';
				
				if(!empty($image_url[0]))
				{
					$portfolio_type = get_post_meta($portfolio_ID, 'portfolio_type', true);
				    $portfolio_video_id = get_post_meta($portfolio_ID, 'portfolio_video_id', true);
				    
				    switch($portfolio_type)
				    {
				    case 'External Link':
						$portfolio_link_url = get_post_meta($portfolio_ID, 'portfolio_link_url', true);
				
						$return_html.= '<a target="_blank" href="'.esc_url($portfolio_link_url).'"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div class="portfolio_classic_icon_wrapper">
							<div class="portfolio_classic_icon_content">
								<i class="fa fa-chain"></i>
							</div>
						</div></a>';
				        
				    break;
				    //end external link
				    
				    case 'Project Content':
	        	    default:
	
			        	$return_html.= '<a href="'.get_permalink($portfolio_ID).'"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div class="portfolio_classic_icon_wrapper">
							<div class="portfolio_classic_icon_content">
								<i class="fa fa-mail-forward"></i>
							</div>
						</div></a>';
		        
				    break;
				    //end external link
	        	    
	        	    case 'Image':
				
						$return_html.= '<a data-caption="'.esc_attr($portfolios_arr[$i]->post_title).'" href="'.esc_url($image_url[0]).'" class="fancy-gallery"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div class="portfolio_classic_icon_wrapper">
							<div class="portfolio_classic_icon_content">
								<i class="fa fa-search-plus"></i>
							</div>
						</div></a>';
				
				    break;
				    //end image
				    
				    case 'Youtube Video':
				
						$return_html.= '<a href="https://www.youtube.com/embed/'.esc_attr($portfolio_video_id).'" class="lightbox_youtube" data-options="width:900, height:488"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div class="portfolio_classic_icon_wrapper">
							<div class="portfolio_classic_icon_content">
								<i class="fa fa-play"></i>
							</div>
						</div></a>';
				
				    break;
				    //end youtube
				
				case 'Vimeo Video':
	
						$return_html.= '<a href="https://player.vimeo.com/video/'.esc_attr($portfolio_video_id).'" class="lightbox_vimeo" data-options="width:900, height:506"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div class="portfolio_classic_icon_wrapper">
							<div class="portfolio_classic_icon_content">
								<i class="fa fa-play"></i>
							</div>
						</div></a>';
				
				    break;
				    //end vimeo
				    
				case 'Self-Hosted Video':
				
				    //Get video URL
				    $portfolio_mp4_url = get_post_meta($portfolio_ID, 'portfolio_mp4_url', true);
				    $preview_image = wp_get_attachment_image_src($image_id, 'large', true);
				    
						$return_html.= '<a href="'.esc_url($portfolio_mp4_url).'" class="lightbox_vimeo"><img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($portfolios_arr[$i]->post_title).'"/><div class="portfolio_classic_icon_wrapper">
							<div class="portfolio_classic_icon_content">
								<i class="fa fa-play"></i>
							</div>
						</div></a>';
				
				    break;
				    //end self-hosted
				    }
				    //end switch
				}
				$return_html.= '</div>';
				
				//Display portfolio detail
				$return_html.= '<br class="clear"/><div id="portfolio_desc_'.esc_attr($portfolio_ID).'" class="portfolio_desc portfolio'.esc_attr($columns).' filterable">';
	            $return_html.= '<h5>'.$portfolios_arr[$i]->post_title.'</h5>';
	            $return_html.= '<div class="post_detail">'.$portfolios_arr[$i]->post_excerpt.'</div>';
				$return_html.= '</div>';
				
				$return_html.= '</div>';
			}
		}
	}
	
	echo stripslashes($return_html);
	die();
}

/**
*	End portfolio classic infinite scroll function
**/


/**
*	Setup image proofing function
**/
add_action('wp_ajax_photography_image_proofing', 'photography_image_proofing');
add_action('wp_ajax_nopriv_photography_image_proofing', 'photography_image_proofing');

function photography_image_proofing() {
	if(!THEMEDEMO)
	{
		check_ajax_referer( 'tgajax-post-contact-nonce', 'tg_security' );
		
		$gallery_id = '';
		$image_id = '';
		
		if(isset($_POST['gallery_id']))
		{
			$gallery_id = $_POST['gallery_id'];
		}
		
		if(isset($_POST['image_id']))
		{
			$image_id = $_POST['image_id'];
		}
		
		if(isset($_POST['method']) && $_POST['method'] == 'approve')
		{
			//Get current approved images
			$current_images_approve = get_post_meta($gallery_id, 'gallery_images_approve', true);
			
			if(!empty($current_images_approve))
			{
				if ( !in_array( $image_id, $current_images_approve ) ) {
					$current_images_approve[] = $image_id;
				}
	
				$current_images_approve = array_unique($current_images_approve);
				update_post_meta($gallery_id, 'gallery_images_approve', $current_images_approve);
			}
			else
			{
				$current_images_approve[] = $image_id;
				$current_images_approve = array_unique($current_images_approve);
				update_post_meta($gallery_id, 'gallery_images_approve', $current_images_approve);	
			}
		}
		else if(isset($_POST['method']) && $_POST['method'] == 'unapprove')
		{
			//Get current approved images
			$current_images_approve = get_post_meta($gallery_id, 'gallery_images_approve', true);
			
			if(!empty($current_images_approve))
			{
				if (($key = array_search($image_id, $current_images_approve)) !== false) 
				{
				    unset($current_images_approve[$key]);
				}
				
				update_post_meta($gallery_id, 'gallery_images_approve', $current_images_approve);
			}
		}
	}
	
	die();
}

/**
*	End image proofing function
**/


if(THEMEDEMO)
{
	function photography_add_my_query_var( $link ) 
	{
		$arr_params = array();
	    
	    if(isset($_GET['topbar'])) 
		{
			$arr_params['topbar'] = $_GET['topbar'];
		}
		
		if(isset($_GET['menu'])) 
		{
			$arr_params['menu'] = $_GET['menu'];
		}
		
		if(isset($_GET['frame'])) 
		{
			$arr_params['frame'] = $_GET['frame'];
		}
		
		if(isset($_GET['frame_color'])) 
		{
			$arr_params['frame_color'] = $_GET['frame_color'];
		}
		
		if(isset($_GET['boxed'])) 
		{
			$arr_params['boxed'] = $_GET['boxed'];
		}
		
		if(isset($_GET['footer'])) 
		{
			$arr_params['footer'] = $_GET['footer'];
		}
		
		if(isset($_GET['menulayout'])) 
		{
			$arr_params['menulayout'] = $_GET['menulayout'];
		}
		
		$link = add_query_arg( $arr_params, $link );
	    
	    return $link;
	}
	add_filter('category_link','photography_add_my_query_var');
	add_filter('page_link','photography_add_my_query_var');
	add_filter('post_link','photography_add_my_query_var');
	add_filter('term_link','photography_add_my_query_var');
	add_filter('tag_link','photography_add_my_query_var');
	add_filter('category_link','photography_add_my_query_var');
	add_filter('post_type_link','photography_add_my_query_var');
	add_filter('attachment_link','photography_add_my_query_var');
	add_filter('year_link','photography_add_my_query_var');
	add_filter('month_link','photography_add_my_query_var');
	add_filter('day_link','photography_add_my_query_var');
	add_filter('search_link','photography_add_my_query_var');
	add_filter('previous_post_link','photography_add_my_query_var');
	add_filter('next_post_link','photography_add_my_query_var');
}


//Setup custom settings when theme is activated
if (isset($_GET['activated']) && $_GET['activated']){
	//Add default contact fields
	$pp_contact_form = get_option('pp_contact_form');
	if(empty($pp_contact_form))
	{
		add_option( 'pp_contact_form', 's:1:"3";' );
	}
	
	$pp_contact_form_sort_data = get_option('pp_contact_form_sort_data');
	if(empty($pp_contact_form_sort_data))
	{
		add_option( 'pp_contact_form_sort_data', 'a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";}' );
	}

	wp_redirect(admin_url("admin.php?page=functions.php&activate=true"));
}
?>