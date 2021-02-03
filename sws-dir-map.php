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
		echo "<iframe src='".plugins_url( '/inc/dir/dir_unions.php', __FILE__ )."' style='width: 100%; height: 80vh; min-height: 50em;' frameborder='no' scrolling='no'></iframe>"; 
	return ob_get_clean();
}

// register shortcode
add_shortcode('sws_dir_listing', 'sws_dir_show'); 



function sws_style_links(){

$themedir=get_template_directory();
	
$mvar= <<<EOT
<html lang="en-US">
  <head>
  <link rel='stylesheet' id='slick-css'  href='//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css?ver=5.4' type='text/css' media='all' />
<link rel='stylesheet' id='alps/main_css-css'  href='//cdn.adventist.org/alps/2/latest/css/main.css?ver=5.4' type='text/css' media='all' />
<!--<link rel='stylesheet' id='alps/theme_css-css'  href='../Ze1Chi/themes/alps-wordpress/dist/styles/alps-theme.css' type='text/css' media='all' />
<link href="../Ze1Chi/themes/alps-wordpress/style.css" rel="stylesheet" type="text/css">-->
<link href="$themedir/style.css" rel="stylesheet" type="text/css">
<link href="assets/dir_styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../custom/javascript/sew_spamspan.js"></script>
</head>
<body>
EOT;
	return $myvar;
		
}



?>
