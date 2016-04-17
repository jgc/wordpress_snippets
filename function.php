/*
 * Add to bottom of functions.php (for the relevant theme e.g. Twenty Fifteen
 */
 
/*
 * Remove Facebook share counts
 */
add_filter( 'jetpack_sharing_counts', '__return_false' );


/*
 * Remove default image links
 */
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
 * De-register styles
 */
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
if ( !is_page('Gallery') )
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
 * De-register scripts
 */
/* 
 *
    wp_enqueue_script('wrgf-hover-pack-js',WRGF_PLUGIN_URL.'js/hover-pack.js', array('jquery'));
 *
 */
function rvg_deregister_javascript() {
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

if ( !is_page('Gallery') ) {
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
