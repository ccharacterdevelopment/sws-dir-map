<?php
/**s
 * Plugin Name:       SWS Directory/Interactive Map
 * Plugin URI:        https://ccharacter.com/custom-plugins/sws-dir-map/
 * Description:       Builds on the DBI to display interactive map/directory
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      5.5
 * Author:            Sharon Stromberg
 * Author URI:        https://ccharacter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sws-dir-map
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once plugin_dir_path(__FILE__).'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/ccharacter/sws-dir-map/main/plugin.json',
	__FILE__,
	'sws_dir_map'
);




// SHORTCODE FOR directories  
function sws_dir_show($atts) {
	$a=shortcode_atts(array(
	  'group' => 'conf_asam',
	  'test' => 'foobar'
	), $atts);
	$list_shortname=$a['group']; // NOTE TO SELF: SHORTCODE_ATTS DOESN'T LIKE UPPERCASE!!!!
	ob_start(); 
		echo "<iframe src='".plugins_url( '/inc/dir/dir_page.php', __FILE__ )."'></iframe>";
	return ob_get_clean();
}

// register shortcode
add_shortcode('sws_dir_listing', 'sws_dir_show'); 


?>
