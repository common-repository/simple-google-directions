<?php
/*
Plugin Name: Simple Google Directions
Plugin URI: http://plugins.justingivens.com/?pid=Simple-Google-Directions
Description: Simple <a target="_blank" href="http://maps.google.com">Google Directions</a> uses the Maps API and returns step-by-step directions. Just use the shortcode <code>[simple_directions title="" lang="" address=""]</code>. <a href="http://goo.gl/g8xay" target="_blank">Google List of Language Codes</a>.
Version: 1.2
Author: Justin D. Givens
Text Domain: simple-google-directions
Author URI: http://plugins.justingivens.com/?aid=Simple-Google-Directions
Copyright 2011 Justin D. Givens

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*Globals*/
$SGD_Version = "1.2";
DEFINE('SGD_VERSION', $SGD_Version);
$add_my_script = false;
$gLang = 'en';

add_shortcode('simple_directions', 'custom_directionShortCode');
add_action('wp_footer', 'javascriptOutputInFooter');
add_action('init', 'sgd_register_script');
load_plugin_textdomain( 'simple-google-directions' , false , basename( dirname( __FILE__ ) ) . '/lang' );

function custom_directionShortCode ($atts, $content = null) {
	global $add_my_script, $gLang;
	$add_my_script = true;
	
	extract( shortcode_atts( array(
		'address' => '1600 Pennsylvania Ave NW, Washington, DC 20500',
		'title' => 'White House Address',
		'lang' => 'en',
	), $atts ) );
	
	$gLang = $lang;
	
	$EOT_OUTPUT_SAVE = '
  <form name="directions" id="directions" title="' . __('Get Directions', 'simple-google-directions') . '">
    <ul>
      <li><label for="address">' . __('From (Your Address)', 'simple-google-directions') . ':</label> <input title="' . __('Enter your address here', 'simple-google-directions') . '" type="text" name="address" id="address" value="" /> <small>'. __('Example', 'simple-google-directions') . ': '.$address.'</small></li>
      <li><label>' . __('To', 'simple-google-directions') . ':</label> '.$title.'<input type="hidden" name="sgdAddress" id="sgdAddress" value="'.$address.'" /></li>
      <li><input type="submit" id="submit" name="submit" value="' . __('Get Directions', 'simple-google-directions') . '" /><input type="reset" name="resetOptions" id="resetOptions" value="' . __('Reset Directions', 'simple-google-directions') . '" /></li>
    </ul>
  </form>
  <div id="results"></div><div style="clear:both;"></div>
	';
	return $EOT_OUTPUT_SAVE;
}
function sgd_register_script() {
	wp_register_script( 'sgd-script' , plugins_url('simple-google.php', __FILE__) , array('jquery') , SGD_VERSION , true );
}
function javascriptOutputInFooter() {
	global $add_my_script, $gLang;
	if ($add_my_script) {
		wp_print_scripts('sgd-script');
	}
}

?>