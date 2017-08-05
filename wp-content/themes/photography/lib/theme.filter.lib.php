<?php
// A callback function to add a custom field to our "gallery categories" taxonomy
function photography_gallerycat_taxonomy_custom_fields($tag) {

   // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
?>

<tr class="form-field">
	<th scope="row" valign="top">
		<label for="gallerycat_template"><?php _e('Gallery Category Page Template', 'photography-translation'); ?></label>
	</th>
	<td>
		<select name="gallerycat_template" id="gallerycat_template">
			<?php
				//Get all gallery archive templates
				$tg_gallery_archive_templates = array(
					'gallery-archive-fullscreen' => 'Fullscreen',
					'gallery-archive-split-screen' => 'Split Screen',
					'gallery-archive-2-contained' => '2 Columns Contained', 
					'gallery-archive-3-contained' => '3 Columns Contained',
					'gallery-archive-4-contained' => '4 Columns Contained',
					'gallery-archive-2-wide' => '2 Columns Wide',
					'gallery-archive-3-wide' => '3 Columns Wide',
					'gallery-archive-4-wide' => '4 Columns Wide',
					'gallery-archive-parallax' => 'Parallax',
				);
				
				foreach($tg_gallery_archive_templates as $key => $tg_gallery_archive_template)
				{
			?>
			<option value="<?php echo esc_attr($key); ?>" <?php if($term_meta['gallerycat_template']==$key) { ?>selected<?php } ?>><?php echo esc_html($tg_gallery_archive_template); ?></option>
			<?php
				}
			?>
		</select>
		<br />
		<span class="description"><?php _e('Select page template for this gallery category', 'photography-translation'); ?></span>
	</td>
</tr>

<?php
}

// A callback function to save our extra taxonomy field(s)
function photography_save_gallerycat_custom_fields( $term_id ) {
    if ( isset( $_POST['gallerycat_template'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_$t_id" );

        if ( isset( $_POST['gallerycat_template'] ) ){
            $term_meta['gallerycat_template'] = $_POST['gallerycat_template'];
        }
        
        //save the option array
        update_option( "taxonomy_term_$t_id", $term_meta );
    }
}

// Add the fields to the "gallery categories" taxonomy, using our callback function
add_action( 'gallerycat_edit_form_fields', 'photography_gallerycat_taxonomy_custom_fields', 10, 2 );

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action( 'edited_gallerycat', 'photography_save_gallerycat_custom_fields', 10, 2 );


// A callback function to add a custom field to our "gallery categories" taxonomy
function photography_portfoliosets_taxonomy_custom_fields($tag) {

   // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
?>

<tr class="form-field">
	<th scope="row" valign="top">
		<label for="portfoliosets_template"><?php _e('Portfolio Category Page Template', 'photography-translation'); ?></label>
	</th>
	<td>
		<select name="portfoliosets_template" id="portfoliosets_template">
			<?php
				//Get all gallery archive templates
				$tg_gallery_archive_templates = array(
					'portfolio-fullscreen' => 'Fullscreen',
					'portfolio-parallax' => 'Parallax',
					'portfolio-2-contained' => '2 Columns Contained',
					'portfolio-3-contained' => '3 Columns Contained',
					'portfolio-4-contained' => '4 Columns Contained',
					'portfolio-2-contained-classic' => '2 Columns Classic',
					'portfolio-3-contained-classic' => '3 Columns Classic',
					'portfolio-4-contained-classic' => '4 Columns Classic',
					'portfolio-2-wide' => '2 Columns Wide',
					'portfolio-3-wide' => '3 Columns Wide',
					'portfolio-4-wide' => '4 Columns Wide',
					'portfolio-5-wide' => '5 Columns Wide',
					'portfolio-2-wide-classic' => '2 Columns Wide Classic',
					'portfolio-3-wide-classic' => '3 Columns Wide Classic',
					'portfolio-4-wide-classic' => '4 Columns Wide Classic',
					'portfolio-3-wide-masonry' => 'Masonry',
					'portfolio-split-screen' => 'Split Screen',
					'portfolio-split-screen-wide' => 'Split Screen Wide',
					'portfolio-split-screen-masonry' => 'Split Screen Masonry',
				);
				
				foreach($tg_gallery_archive_templates as $key => $tg_gallery_archive_template)
				{
			?>
			<option value="<?php echo esc_attr($key); ?>" <?php if($term_meta['portfoliosets_template']==$key) { ?>selected<?php } ?>><?php echo esc_html($tg_gallery_archive_template); ?></option>
			<?php
				}
			?>
		</select>
		<br />
		<span class="description"><?php _e('Select page template for this gallery category', 'photography-translation'); ?></span>
	</td>
</tr>

<?php
}

// A callback function to save our extra taxonomy field(s)
function photography_save_portfoliosets_custom_fields( $term_id ) {
    if ( isset( $_POST['portfoliosets_template'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_$t_id" );

        if ( isset( $_POST['portfoliosets_template'] ) ){
            $term_meta['portfoliosets_template'] = $_POST['portfoliosets_template'];
        }
        
        //save the option array
        update_option( "taxonomy_term_$t_id", $term_meta );
    }
}

// Add the fields to the "portfolio categories" taxonomy, using our callback function
add_action( 'portfoliosets_edit_form_fields', 'photography_portfoliosets_taxonomy_custom_fields', 10, 2 );

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action( 'edited_portfoliosets', 'photography_save_portfoliosets_custom_fields', 10, 2 );


function photography_tag_cloud_filter($args = array()) {
   $args['smallest'] = 13;
   $args['largest'] = 13;
   $args['unit'] = 'px';
   return $args;
}

add_filter('widget_tag_cloud_args', 'photography_tag_cloud_filter', 90);

//Control post excerpt length
function photography_custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'photography_custom_excerpt_length', 200 );

//Customise Widget Title Code
add_filter( 'dynamic_sidebar_params', 'photography_wrap_widget_titles', 1 );
function photography_wrap_widget_titles( array $params ) 
{
	$widget =& $params[0];
	$widget['before_title'] = '<h2 class="widgettitle"><span>';
	$widget['after_title'] = '</span></h2>';
	
	return $params;
}

/**
 * Change default fields, add placeholder and change type attributes.
 *
 * @param  array $fields
 * @return array
 */
add_filter( 'comment_form_default_fields', 'photography_comment_placeholders' );
 
function photography_comment_placeholders( $fields )
{
    $fields['author'] = str_replace('<input', '<input placeholder="'. esc_html__('Name', 'photography-translation'). '*"',$fields['author']);
    $fields['email'] = str_replace('<input id="email" name="email" type="text"', '<input type="email" placeholder="'.esc_html__('Email', 'photography-translation').'*"  id="email" name="email"',$fields['email']);
    $fields['url'] = str_replace('<input id="url" name="url" type="text"', '<input placeholder="'.esc_html__('Website', 'photography-translation').'" id="url" name="url" type="url"',$fields['url']);

    return $fields;
}

//Make widget support shortcode
add_filter('widget_text', 'do_shortcode');

//Add upload form to page
if (is_admin()) {
  $current_admin_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);

  if ($current_admin_page == 'post' || $current_admin_page == 'post-new')
  {
 
    /** Need to force the form to have the correct enctype. */
    function photography_add_post_enctype() {
      echo "<script type=\"text/javascript\">
        jQuery(document).ready(function(){
        jQuery('#post').attr('enctype','multipart/form-data');
        jQuery('#post').attr('encoding', 'multipart/form-data');
        });
        </script>";
    }
 
    add_action('admin_head', 'photography_add_post_enctype');
  }
}

// remove version query string from scripts and stylesheets
function photography_remove_script_styles_version( $src ){
    return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', 'photography_remove_script_styles_version' );
add_filter( 'style_loader_src', 'photography_remove_script_styles_version' );


function photography_theme_queue_js(){
  if (!is_admin()){
    if (!is_page() AND is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}
add_action('get_header', 'photography_theme_queue_js');


/**
* Add Photographer Name and URL fields to media uploader
*/
 
function phorography_attachment_field_credit ($form_fields, $post) {
	$form_fields['photography-purchase-url'] = array(
		'label' => esc_html__('Purchase URL', 'photography-translation'),
		'input' => 'text',
		'value' => esc_url(get_post_meta( $post->ID, 'photography_purchase_url', true )),
	);

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'phorography_attachment_field_credit', 10, 2 );

/**
* Save values of Photographer Name and URL in media uploader
*/

function phorography_attachment_field_credit_save ($post, $attachment) {
	if( isset( $attachment['photography-purchase-url'] ) )
update_post_meta( $post['ID'], 'photography_purchase_url', esc_url( $attachment['photography-purchase-url'] ) );

	return $post;
}

add_filter( 'attachment_fields_to_save', 'phorography_attachment_field_credit_save', 10, 2 );

add_action( 'add_meta_boxes', array ( 'Photography_Richtext_Excerpt', 'switch_boxes' ) );

function photography_add_meta_tags() {
    global $post;
    
    echo '<meta charset="'.get_bloginfo( 'charset' ).'" />';
    
    //Check if responsive layout is enabled
    $tg_mobile_responsive = kirki_get_option('tg_mobile_responsive');
	
	if(!empty($tg_mobile_responsive))
	{
		echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
	}
	
	//meta for phone number link on mobile
	echo '<meta name="format-detection" content="telephone=no">';
    
    //check if single post then add meta description and keywords
    if (is_single()) 
    {
        //Prepare data for Facebook opengraph sharing
        if(has_post_thumbnail(get_the_ID(), 'photography-blog'))
		{
		    $image_id = get_post_thumbnail_id(get_the_ID());
		    $fb_thumb = wp_get_attachment_image_src($image_id, 'photography-blog', true);
		}
	
		if(isset($fb_thumb[0]) && !empty($fb_thumb[0]))
		{
			$post_content = get_post_field('post_excerpt', $post->ID);
			
			echo '<meta property="og:type" content="article" />';
			echo '<meta property="og:image" content="'.esc_url($fb_thumb[0]).'"/>';
			echo '<meta property="og:title" content="'.esc_attr(get_the_title()).'"/>';
			echo '<meta property="og:url" content="'.esc_url(get_permalink($post->ID)).'"/>';
			echo '<meta property="og:description" content="'.esc_attr(strip_tags($post_content)).'"/>';
		}
    }
}
add_action( 'wp_head', 'photography_add_meta_tags' , 2 );

add_filter('redirect_canonical','custom_disable_redirect_canonical');
function custom_disable_redirect_canonical($redirect_url) {if (is_paged() && is_singular()) $redirect_url = false; return $redirect_url; }

/**
 * Replaces the default excerpt editor with TinyMCE.
 */
class Photography_Richtext_Excerpt
{
    /**
     * Replaces the meta boxes.
     *
     * @return void
     */
    public static function switch_boxes()
    {
        if ( ! post_type_supports( $GLOBALS['post']->post_type, 'excerpt' ) )
        {
            return;
        }

        remove_meta_box(
            'postexcerpt' // ID
        ,   ''            // Screen, empty to support all post types
        ,   'normal'      // Context
        );

        add_meta_box(
            'postexcerpt2'     // Reusing just 'postexcerpt' doesn't work.
        ,   esc_html__('Excerpt', 'photography-translation' )    // Title
        ,   array ( __CLASS__, 'show' ) // Display function
        ,   null              // Screen, we use all screens with meta boxes.
        ,   'normal'          // Context
        ,   'core'            // Priority
        );
    }

    /**
     * Output for the meta box.
     *
     * @param  object $post
     * @return void
     */
    public static function show( $post )
    {
    	$screen = get_current_screen();
		
		if($screen->post_type != 'product')
		{
    ?>
	        <label class="screen-reader-text" for="excerpt"><?php
	        esc_html_e('Excerpt', 'photography-translation' )
	        ?></label>
	        <?php
	        // We use the default name, 'excerpt', so we don’t have to care about
	        // saving, other filters etc.
	        wp_editor(
	            self::unescape( $post->post_excerpt ),
	            'excerpt',
	            array (
	            'textarea_rows' => 15
	        ,   'media_buttons' => FALSE
	        ,   'teeny'         => TRUE
	        ,   'tinymce'       => TRUE
	            )
	        );
        }
    }

    /**
     * The excerpt is escaped usually. This breaks the HTML editor.
     *
     * @param  string $str
     * @return string
     */
    public static function unescape( $str )
    {
        return str_replace(
            array ( '&lt;', '&gt;', '&quot;', '&amp;', '&nbsp;', '&amp;nbsp;' )
        ,   array ( '<',    '>',    '"',      '&',     ' ', ' ' )
        ,   $str
        );
    }
}

add_action( 'edit_form_after_title', 'photography_content_builder_enable');

function photography_content_builder_enable ($post) 
{
	//Check if enable content builder
	$ppb_enable = get_post_meta($post->ID, 'ppb_enable');
	$enable_builder_class = '';
	$enable_classic_builder_class = '';
	
	if(!empty($ppb_enable))
	{
		$enable_builder_class = 'hidden';
		$enable_classic_builder_class = 'visible';
	}
	
	//Check if user edit page
	$page_id = '';
	
	if (isset($_GET['action']) && $_GET['action'] == 'edit')
	{
		$page_id = $post->ID;
	}

	//Display only on page and portfolio
	if($post->post_type == 'page' OR $post->post_type == 'portfolios')
	
    echo '<a href="javascript:;" id="enable_builder" class="'.esc_attr($enable_builder_class).'" data-page-id="'.esc_attr($page_id).'"><i class="fa fa-th-list"></i>'.esc_html__('Edit in Content Builder', 'photography-translation' ).'</a>';
    echo '<a href="javascript:;" id="enable_classic_builder" class="'.esc_attr($enable_classic_builder_class).'"><i class="fa fa-edit"></i>'.esc_html__('Edit in Classic Editor', 'photography-translation' ).'</a>';
}
?>