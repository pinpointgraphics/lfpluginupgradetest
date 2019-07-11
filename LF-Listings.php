<?php
/*
Plugin Name: Lightning Fast Listings
Plugin URI: https://lightningfastlistings.ca
Description: Lightning Fast Listings is a WordPress plugin exclusively designed for Canadian Real Estate Agents who are licensed by the Canadian Real Estate Association (CREA ®) to display listings via the Data Distribution Facility (DDF ®). All real estate listings are served "lightning fast", designed and hosted remotely to not take up any of the website's own resources.
Version: 1.0.6
Author: Pinpoint Media Design
Author URI: https://www.pinpointmediadesign.com
License: GLP2
*/
?>
<?php

// global variables
$pluginPrefix = 'LF';
define( 'LF_PLUGIN', __FILE__ );
define( 'LF_PLUGIN_BASENAME', plugin_basename( LF_PLUGIN ) );
define( 'LF_PLUGIN_NAME', trim( dirname( LF_PLUGIN_BASENAME ), '/' ) );
define( 'LF_PLUGIN_DIR', untrailingslashit( dirname( LF_PLUGIN ) ) );
define('API_URL','https://ddf.dfiner.net/v1');

// required getpages
require_once LF_PLUGIN_DIR. '/settings.php';
require_once LF_PLUGIN_DIR. '/detailpage.php';
require_once LF_PLUGIN_DIR. '/inc/functions.php';
require_once LF_PLUGIN_DIR. '/inc/listings.php';

/**
 * this function is called when user activates the plugin.
 * this basically prepares the database table.
 */
register_activation_hook(__FILE__,'LF_plugin_on_activation');
function LF_plugin_on_activation()
{
	$termsandcondition = '<p>This website is operated by Royal LePage Trinity Realty, Brokerage, a Brokerage who is a member of The Canadian Real Estate Association (CREA<sup>®</sup>). The content on this website is owned or controlled by CREA<sup>®</sup>. By accessing this website, the user agrees to be bound by these terms of use as amended from time to time, and agrees that these terms of use constitute a binding contract between the user, Royal LePage Trinity Realty, Brokerage, and CREA<sup>®</sup>.</p>
	<h4>Copyright</h4>
	<p>The listing content on this website is protected by copyright and other laws, and is intended solely for the private, non-commercial use by individuals. Any other reproduction, distribution or use of the content, in whole or in part, is specifically forbidden. The prohibited uses include commercial use, "screen scraping", "database scraping", and any other activity intended to collect, store, reorganize or manipulate data on the pages produced by or displayed on this website.</p>
	<h4>Trademarks</h4>
	<p>REALTOR<sup>®</sup>, REALTORS<sup>®</sup>, and the REALTOR<sup>®</sup> logo are certification marks that are owned by REALTOR<sup>®</sup> Canada Inc. and licensed exclusively to The Canadian Real Estate Association (CREA<sup>®</sup>). These certification marks identify real estate professionals who are members of CREA<sup>®</sup> and who must abide by CREA<sup>®</sup>\'s By-Laws, Rules, and the REALTOR<sup>®</sup> Code. The MLS<sup>®</sup> trademark and the MLS<sup>®</sup> logo are owned by CREA<sup>®</sup> and identify the professional real estate services provided by members of CREA<sup>®</sup>.</p>
	<h4>Liability and Warranty Disclaimer</h4>
	<p>The information contained on this website is based in whole or in part on information that is provided by members of CREA<sup>®</sup>, who are responsible for its accuracy. CREA<sup>®</sup> reproduces and distributes this information as a service for its members, and assumes no responsibility for its completeness or accuracy.
		  Amendments  may at any time amend these Terms of Use by updating this posting. All users of this site are bound by these amendments should they wish to continue accessing the website, and should therefore periodically visit this page to review any and all such amendments.</p>';

	//create table to store multiple information.
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix.'LF_listing_settings';

	$sql = "CREATE TABLE if not exists $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		meta_key varchar(100) NOT NULL,
		meta_value LONGTEXT NULL DEFAULT NULL,
		PRIMARY KEY  (id),
		UNIQUE (meta_key)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_column',
			'meta_value' => 3
		)
	);
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_page',
			'meta_value' => 12
		)
	);
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_show_priceOrder',
			'meta_value' => 'yes'
		)
	);
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'termsandcondition',
			'meta_value' => stripslashes_deep($termsandcondition)
		)
	);
	$stylesheetUrl = plugin_dir_path( __FILE__ ).'assets/css/style.css';
	$stylesheet = stripslashes_deep(file_get_contents($stylesheetUrl));
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'customCss',
			'meta_value' => $stylesheet
		)
	);
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_MailText',
			'meta_value' => '<p>Hello,</p><p>Here are the details of the inquiry form:</p>'
		)
	);
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_detail_footer',
			'meta_value' => 'MLS&reg;, REALTOR&reg;, and the associated logos are trademarks of The Canadian Real Estate Association'
		)
	);
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_reCaptchastate',
			'meta_value' => 'no-captch'
		)
	);
	$wpdb->insert(
                $table_name,
                array(
                        'meta_key' => 'LF_show_search',
                        'meta_value' => 'yes'
                )
        );
	$wpdb->insert(
                $table_name,
                array(
                        'meta_key' => 'LF_priceOrder',
                        'meta_value' => 'ASC'
                )
        );
	LFUpdateCSS();
}

function LF_settings_activation_link( $links ) {
	$links = array_merge( array(
		'<a href="' . esc_url( admin_url( '?page=LF-setting' ) ) . '">' . __( 'Settings', 'LF Settings' ) . '</a>'
	), $links );
	return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'LF_settings_activation_link' );

/**
 * this function registers the query variables so that we
 * get the them and show appropriate page.
 */
add_filter( 'query_vars', 'LF_register_query_vars',10,1 );
function LF_register_query_vars( $vars )
{
	$vars[] = 'listkey';
	return $vars;
}

// register our main short code.
if(!is_admin())
{
	add_shortcode( "LF-Listings", function($atts) {
		ob_start();
		include('LF-Listings-shortcode.php');
		$returned = ob_get_contents();
		ob_end_clean();

	  return $returned;
	});
}

/**
 * this function basically grabs the URL and convert it
 * to SEO friendly URLs for single listing page
 */
add_action('init', 'LF_plugin_init', 20, 30);
function LF_plugin_init()
{
	session_start();
	if (!isset($_SESSION['EXPIRES']))
	{
		$_SESSION['EXPIRES'] = time() + 3600;
	}
	else if(time() > $_SESSION['EXPIRES'])
	{
		unset($_SESSION['EXPIRES']);
		unset($_SESSION['acceptTerms']);
	}

	$pattern = get_shortcode_regex();
	$option_name = 'LF-Listings';
	$postContent = LF_find_shortcode_occurencesName($option_name);
	$slug = trim(getCurrentPageSlug());

	if(empty($slug)){
		$slug = $postContent['slug'];
	}


	if ( preg_match_all( '/'. $pattern .'/s', $postContent['content'], $matches )
	&& array_key_exists( 2, $matches )
	&& in_array( 'LF-Listings', $matches[2] ) )
	{
		add_rewrite_rule( '^'.$slug.'/([0-9]+)/?', 'index.php?pagename='.$slug.'&listkey=$matches[1]&title=$matches[2]','top' );

		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}

	require_once( LF_PLUGIN_DIR.'/updater.php' );
	if ( is_admin() )
	{
	    	new LF_Listings_Plugin_Updater( __FILE__, 'pinpointgraphics', "LF-Listings" );
	}
}

// add default editor
add_filter( 'wp_default_editor', 'LF_default_editor' );
function LF_default_editor( $editor )
{
    return 'tinymce';
}

add_action( 'save_post', 'LF_save_post_function', 10, 3 );
function LF_save_post_function( $post_ID, $post, $update ) {
	$_SESSION['pageUpdated'] = "yes";
}
?>
