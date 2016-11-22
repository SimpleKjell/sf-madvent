<?php
/*
Plugin Name: Mömax Advent
Plugin URI: http://simplefox.de
Description: Mömax Adventskalender
Version: 1.0.0
Author: Simplefox
Author URI: http://simplefox.de
*/

define('sfmadvent_url',plugin_dir_url(__FILE__ ));
define('sfmadvent_path',plugin_dir_path(__FILE__ ));
define('sfmadvent_template','basic');

// Plugin Version
function sfmadvent_get_plugin_version()
{
    $default_headers = array( 'Version' => 'Version' );
    $plugin_data = get_file_data( __FILE__, $default_headers, 'plugin' );
    return $plugin_data['Version'];
}

$plugin = plugin_basename(__FILE__);


/* Textdomain (localization) */
function sfmadvent_load_textdomain()
{
  $locale = apply_filters( 'plugin_locale', get_locale(), 'sf-madvent' );
  $mofile = sfmadvent_path . "languages/sfmadvent-$locale.mo";

	// Global + Frontend Locale
	load_textdomain( 'sfmadvent', $mofile );
	load_plugin_textdomain( 'sfmadvent', false, dirname(plugin_basename(__FILE__)).'/languages/' );
}
add_action('init', 'sfmadvent_load_textdomain');

/* Master Class  */
require_once (sfmadvent_path . 'sfmclasses/sfm.sfmadvent.class.php');
$sf_madvent = new SFMAdvent();
$sf_madvent->plugin_init();
