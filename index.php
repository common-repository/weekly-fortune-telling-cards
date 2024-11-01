<?php
/**
 * Weekly Fortune Telling Cards
 * @package		Weekly Fortune Telling Cards
 * @author		PowerFortunes.com 
 * @copyright	2019 PowerFortunes.com
 * @license		GPL v2 or later
 * 
 * @wordpress-plugin
 * Plugin Name:			Weekly Fortune Telling Cards
 * Plugin URI:			https://www.powerfortunes.com/weekly-fortunetellingcards-signs.php
 * Description:			Visually appealing, weekly horoscope predictions, for each zodiac sign, displayed through 'Fortune Telling Cards'. These horoscopes automatically update on every Monday.
 * Version:				1.3.5
 * Requires at least:	5.2
 * Requires PHP:		7.0
 * Author:				PowerFortunes.com 
 * Author URI:			https://www.powerfortunes.com/about-astrology.php
 * License URI:			https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:			weekly-fortunetelling-cards-plugin
 */
/*
The weekly Fortune Telling Cards plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
The weekly Fortune Telling Cards plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with the weekly Fortune Telling Cards plugin. If not, see {URI to Plugin License}.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$ver = "1.3.3";
define( 'WFTC_PLUGIN_FILE', __FILE__ );
define( 'WFTC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WFTC_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'WFTC__VERSION', $ver);
		
if (!defined('WFTC__VERSION')){
define( 'WFTC__VERSION', $ver);
}

add_option('power_weekly_cards_plugin_version', $ver);

require_once( WFTC_PLUGIN_DIR . 'functions.php' );
register_activation_hook( __FILE__, 'power_daily_cards_plugin' );
register_deactivation_hook( __FILE__, 'weekly_cards_deactive' );

function power_weekly_cards_activation($vrs) {
if (get_option('power_weekly_cards_plugin_version') !== $vrs){
update_option('power_weekly_cards_plugin_version', WFTC__VERSION);
	}
}
power_weekly_cards_activation($ver);
		
function wftc_load_scripts() {
wp_enqueue_style( 'wftc_update_script', WFTC_PLUGIN_URL . 'css/dftc_styles.css', '', WFTC__VERSION); 
}
add_action('get_footer', 'wftc_load_scripts');