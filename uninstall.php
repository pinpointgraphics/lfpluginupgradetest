<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN'))
{
  die;
}

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix.'LF_listing_settings';

// Lets delete the table if we are uninstalling
$wpdb->query( "DROP TABLE IF EXISTS $table_name" );

?>
