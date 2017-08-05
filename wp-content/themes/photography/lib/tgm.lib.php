<?php
require_once get_template_directory() . "/modules/class-tgm-plugin-activation.php";
add_action( 'tgmpa_register', 'photography_require_plugins' );
 
function photography_require_plugins() {
 
    $plugins = array(
	    array(
	        'name'               => 'Photography Theme Custom Post Type',
	        'slug'               => 'photography-custom-post',
	        'source'             => get_template_directory() . '/lib/plugins/photography-custom-post.zip',
	        'required'           => true, 
	        'version'            => '2.0.2',
	    ),
	    array(
	        'name'               => 'Revolution Slider',
	        'slug'               => 'revslider',
	        'source'             => get_template_directory() . '/lib/plugins/revslider.zip',
	        'required'           => true, 
	        'version'            => '5.2.6',
	    ),
	    array(
	        'name'      => 'oAuth Twitter Feed for Developers',
	        'slug'      => 'oauth-twitter-feed-for-developers',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'MailChimp for WordPress',
	        'slug'      => 'mailchimp-for-wp',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'Facebook Widget',
	        'slug'      => 'facebook-pagelike-widget',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'EWWW Image Optimizer',
	        'slug'      => 'ewww-image-optimizer',
	        'required'  => false, 
	    ),
	    array(
	        'name'      => 'Imsanity',
	        'slug'      => 'imsanity',
	        'required'  => false, 
	    ),
	);
	
	$config = array(
		'domain'	=> 'photography-translation',
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'install-required-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'          => array(
	        'page_title'                      => esc_html__('Install Required Plugins', 'photography-translation' ),
	        'menu_title'                      => esc_html__('Install Plugins', 'photography-translation' ),
	        'installing'                      => esc_html__('Installing Plugin: %s', 'photography-translation' ),
	        'oops'                            => esc_html__('Something went wrong with the plugin API.', 'photography-translation' ),
	        'return'                          => esc_html__('Return to Required Plugins Installer', 'photography-translation' ),
	        'plugin_activated'                => esc_html__('Plugin activated successfully.', 'photography-translation' ),
	        'complete'                        => esc_html__('All plugins installed and activated successfully. %s', 'photography-translation' ),
	        'nag_type'                        => 'updated'
	    )
    );
 
    tgmpa( $plugins, $config );
 
}
?>