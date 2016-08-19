<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	/*
	 * Enable support for custom logo.
	 *
	 * @since Twenty Fifteen 1.5
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 248,
		'width'       => 248,
		'flex-height' => true,
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * ADDED BY JC
 */

add_filter( 'jetpack_sharing_counts', '__return_false' );

// http://www.wpbeginner.com/wp-tutorials/automatically-remove-default-image-links-wordpress/
// also look at http://www.wpbeginner.com/wp-tutorials/how-to-disable-image-attachment-pages-in-wordpress/
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
//Break facebook opening as a pop-up???
//add_action('admin_init', 'wpb_imagelink_setup', 10);


/*
 * http://www.wpbeginner.com/wp-tutorials/how-wordpress-plugins-affect-your-sites-load-time/
    wp_enqueue_style('bootstrap.min.css', WRGF_PLUGIN_URL.'css/bootstrap-admin.css');
    wp_enqueue_style('wrgf-font-awesome', WRGF_PLUGIN_URL.'css/font-awesome-latest/css/font-awesome.min.css');
    wp_enqueue_style('wrgf-pricing-table-css', WRGF_PLUGIN_URL.'css/pricing-table.css');
    wp_enqueue_style('wrgf-boot-strap-admin', WRGF_PLUGIN_URL.'css/bootstrap-admin.css');
    wp_enqueue_style('wrgf-hover-pack-css', WRGF_PLUGIN_URL.'css/hover-pack.css');
    wp_enqueue_style('wrgf-boot-strap-css', WRGF_PLUGIN_URL.'css/bootstrap.css');
    wp_enqueue_style('wrgf-img-gallery-css', WRGF_PLUGIN_URL.'css/img-gallery.css');
    wp_enqueue_style('admin_caching_style', plugins_url('css/admin.css', dirname(__FILE__)));
    seo ?
    
    wp_enqueue_script('admin_caching_script', plugins_url( 'js/function.js', dirname(__FILE__)), array( 'jquery' ));
    
 */
function rvg_deregister_styles() 
{
// Responsive gallery
  $page_title = wp_title( '|', false );
//$page_title = the_title_attribute();  // breaks logo
//$page_title = get_the_title(); //throws undefined
//$page_title = $wp_query->post->post_title; //throws undefined
if (strpos($page_title, 'gallery') == false)
//if ( !is_page('Gallery') )
	{
	// Responsive gallery
	//wp_deregister_style( 'bootstrap.min.css' );
	
	wp_deregister_style( 'wrgf-font-awesome' );
	wp_deregister_style( 'wrgf-pricing-table-css' );
	wp_deregister_style( 'wrgf-boot-strap-admin' );
	wp_deregister_style( 'wrgf-hover-pack-css' );
	wp_deregister_style( 'wrgf-boot-strap-css' );
	wp_deregister_style( 'wrgf-img-gallery-css' );
	wp_deregister_style( 'wl-wrgf-swipe-css' );
	wp_deregister_style( 'wrgf-font-awesome-4' );
	
	//wp_deregister_style( 'boxes' );
	//wp_deregister_style( 'dashicons' );
	//wp_deregister_style( 'admin-bar' );
   	}
// Browser cache
if ( !is_admin() )  	
	{
	wp_deregister_style( 'admin_caching_style' );
	}

}
add_action( 'wp_print_styles', 'rvg_deregister_styles', 200 );

/*
 *
    wp_enqueue_script('wrgf-hover-pack-js',WRGF_PLUGIN_URL.'js/hover-pack.js', array('jquery'));
 *
 */
function rvg_deregister_javascript() {
  $page_title = wp_title( '|', false );
//$page_title = the_title_attribute();
if ( !is_admin() )
{
	//wp_deregister_script('jquery');
	//wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"), false, '1.12.3', true);
	//wp_enqueue_script('jquery');
	wp_deregister_script('admin_caching_script');
}

if ( !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) )
//if ( !in_array( $_SERVER['PHP_SELF'], array( '/wp-login.php', '/wp-register.php' ) ) )
{
	wp_deregister_script('google-recaptcha');
}

if (strpos($page_title, 'gallery') == false) 
//if ( !is_page('Gallery') )
  {

	wp_deregister_script( 'wrgf-hover-pack-js' );
	wp_deregister_script( 'wl-wrgf-swipe-js' );
	wp_deregister_script( 'wrgf_masonry' );
	wp_deregister_script( 'wrgf_masonry' );
	wp_deregister_script( 'wrgf_imagesloaded' );

	//wp_deregister_script('jquery');
	//wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"), false, '1.12.3', true);
	//wp_enqueue_script('jquery');
   }
	//add_filter('json_enabled', '__return_false');
	//add_filter('json_jsonp_enabled', '__return_false');
	//add_filter('xmlrpc_enabled', '__return_false');
}


add_action( 'wp_print_scripts', 'rvg_deregister_javascript', 100 );


// https://wordpress.org/support/topic/google-webmaster-tools-errors-missing-author-missing-updated
/* Note addition to custom  css
/* Customise hatom structure 
.hatom-extra {
	font-style: none;
	color: #444444;
	font-size: 10px;
	margin-top: 6px;
	margin-bottom: 6px;
	padding-top: 10px;
	padding-left: 0;
}
*/
/* Fix "Missing Author" and "Missing Updated" issue - START */
add_filter( 'the_content', 'custom_author_code');
function custom_author_code($content) {
if (is_home() || is_singular() || is_single() || is_archive()) {
return $content .
'<div class="hatom-extra" style="display:none;visibility:hidden;"><span class="title">'. get_the_title() .'</span> was last updated <span class="updated"> '. get_the_modified_time('F jS, Y') .'</span> by <span class="author vcard"><span class="fn">'. get_the_author() .'</span></span></div>' ;
} else {
return $content;
}
}
/* Fix "Missing Author" and "Missing Updated" issue - END */

/* Fix "Missing Entry Title" issue - START */
//add hatom data
function add_suf_hatom_data($content) {
$t = get_the_modified_time('F jS, Y');
$author = get_the_author();
$title = get_the_title();
if (is_home() || is_singular() || is_archive() ) {
$content .= '<div class="hatom-extra" style="display:none;visibility:hidden;"><span class="entry-title">'.$title.'</span> was last modified: <span class="updated"> '.$t.'</span> by <span class="author vcard"><span class="fn">'.$author.'</span></span></div>';
}
return $content;
}
add_filter('the_content', 'add_suf_hatom_data');
/* Fix "Missing Entry Title" issue - END */


//AMP Google Analytics
function my_amp_scripts( $data ) {
$data['amp_component_scripts'] = array(
'amp-analytics' => 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js'
);
return $data;
}
add_filter( 'amp_post_template_data', 'my_amp_scripts' );

function my_amp_analytics( $amp_template ) {
?><amp-analytics type="googleanalytics">
<script type="application/json">
{
"vars": {
"account": "UA-3831745-12"
},
"triggers": {
"trackPageview": {
"on": "visible",
"request": "pageview"
}
}
}
</script>
</amp-analytics><?php
}
add_action( 'amp_post_template_footer', 'my_amp_analytics' );

/* Register template redirect action callback */
//http://mekshq.com/remove-archives-wordpress-improve-seo/
add_action('template_redirect', 'meks_remove_wp_archives');
/* Remove archives */
function meks_remove_wp_archives(){
  //If we are on category or tag or date or author archive
  if( is_category() || is_tag() || is_date() || is_author() ) {
    global $wp_query;
    $wp_query->set_404(); //set to 404 not found page
  }
}


add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
wp_enqueue_style( 'dashicons' );
}

function twentyfifteen_entry_meta() {
}


function my_gwolle_gb_widget( $widget_html ) {
	// $widget_html is a string
	$old = 'https://ribblevalleygundogs.com/';
	$new = 'https://ribblevalleygundogs.com/testimonials/';
	$widget_html = str_replace( $old, $new, $widget_html );	
	$old = 'Click here to get to the guestbook.';
	$new = 'Click to read testimonials.';
	$widget_html = str_replace( $old, $new, $widget_html );
	$old = '&raquo;';
	$new = '';
	$widget_html = str_replace( $old, $new, $widget_html );
	
	return $widget_html;
}
add_filter( 'gwolle_gb_widget', 'my_gwolle_gb_widget', 10, 1 );

function my_gwolle_gb_button( $button ) {
	// $button is a string
	$button = '
		<div id="gwolle_gb_write_button">
			<input type="button" value="Add a testimonial" />
		</div>';

	return $button;
}
add_filter( 'gwolle_gb_button', 'my_gwolle_gb_button', 10, 1 );

/*
// Disable Update Check and Notification for Specific Plugin
function wcs_disable_plugin_update_check( $r, $url ) {
    if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
        return $r;

    // array of the plugins
    $blocked_plugins = array(
        'responsive-gallery-with-lightbox/responsive-gallery-with-lightbox.php', //current version = 1.5.5 
    );

    if ( 0 === (int) count( $blocked_plugins ) )
        return $r;

    $installed_plugins = unserialize( $r['body']['plugins'] );
    foreach( $blocked_plugins as $p ) {
        unset( $installed_plugins->plugins[ $p ] );
        unset( $installed_plugins->active[ array_key_exists( $p, $installed_plugins ) ] );
    }
    $r['body']['plugins'] = serialize( $installed_plugins );

    return $r;
}
add_filter( 'http_request_args', 'wcs_disable_plugin_update_check', 5, 2 );
*/

add_filter('final_output', function($output) {
    //return preg_replace( 'alt=\"(.*?)\"', '', $output);
      return preg_replace('/alt=\"(.*?)\"/', '', $output);
    //return str_replace('foo', 'bar', $output);
});

/**
 * Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address. 
 */
function wpcodex_hide_email_shortcode( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}

	return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . ' (click to email)</a>';
}
add_shortcode( 'email', 'wpcodex_hide_email_shortcode' );


/**
 * Hide phone from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address. 
 */
function wpcodex_hide_text_shortcode( $atts , $content = null ) {
	/*
	if ( ! is_email( $content ) ) {
		return;
	}
	*/

	return antispambot( $content );
}
add_shortcode( 'hidetext', 'wpcodex_hide_text_shortcode' );
