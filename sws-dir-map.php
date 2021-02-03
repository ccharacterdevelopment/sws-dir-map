<?php
/**
 * Plugin Name:       SWS Directory/Interactive Map
 * Plugin URI:        https://ccharacter.com/custom-plugins/sws-wp-tweaks/
 * Description:       Builds on the DBI to display interactive map/directory
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      5.5
 * Author:            Sharon Stromberg
 * Author URI:        https://ccharacter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sws-dir-maps
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once plugin_dir_path(__FILE__).'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/ccharacter/sws-dir-maps/main/plugin.json',
	__FILE__,
	'sws_dir_maps'
);




// SHORTCODE FOR COLLAPSING DIVS  
/*function sws_accordion_func($atts) {
	$a=shortcode_atts(array(
	  'item_id' => 'content',
	  'test' => 'foobar'
	), $atts);
	$itemID=$a['item_id']; // NOTE TO SELF: SHORTCODE_ATTS DOESN'T LIKE UPPERCASE!!!!
	ob_start();
	
?>
<script>
if ('#<?php echo $itemID; ?>').length()) {
	jQuery('#<?php echo $itemID; ?>').prepend("<div class='sws-magic-div'>");
	jQuery('#<?php echo $itemID; ?>').append("</div>");
				
	jQuery(".sws-magic-div > ul").each(function (index, element) {
		if ( jQuery( element ).children().length > 0) {
			jQuery(element).wrap("<div class='sws-accordion'></div>");
			jQuery(element).before( "<input type='checkbox' id='toggle" + index + "' class='sws-acc-ck' /><label for='toggle" + index + "'>&nbsp;&nbsp;&nbsp;</label>" );	
			jQuery(element).wrap("<div class='sws-acc-content'></div>");
			console.log('index' + index);
		}
		});
}		
</script> <?php
	ob_end_clean();
}

// register shortcode
add_shortcode('sws_accordion', 'sws_accordion_func'); 

// FIX SVG CROPPING ERROR
add_action( 'after_setup_theme', 'sws_bodhi_svg_theme_support', 11 );
function sws_bodhi_svg_theme_support() {

	remove_theme_support( 'custom-logo' );

	add_theme_support( 'custom-logo', array(
		'flex-width'  => true,
		'flex-height' => true,
	) );

}

*/

?>
