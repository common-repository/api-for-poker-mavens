<?php

/**
 * Plugin Name: API for Poker Mavens
 * Plugin URI: https://www.hillplace.info/api-for-poker-mavens.zip
 * Description: This adds Poker Mavens API features to a Wordpress website.
 * Version: 0.1.2
 * Author: Charles Drenth
 * Author URI: https://www.hillplace.info
 * Text Domain: api-for-poker-mavens
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

define('PMAPI_PLUGIN_PATH',plugin_dir_path(__FILE__));
define('PMAPI_BASE', plugin_basename(__FILE__));
define('PMAPI_URL', plugin_dir_url( __FILE__ ));

require_once(PMAPI_PLUGIN_PATH . 'include/css.php');
require_once(PMAPI_PLUGIN_PATH . 'include/utilities.php');
require_once(PMAPI_PLUGIN_PATH . 'include/outputfunctions.php');
require_once(PMAPI_PLUGIN_PATH . 'include/adminpluginsettings.php');
require_once(PMAPI_PLUGIN_PATH . 'include/adminsetup.php');
require_once(PMAPI_PLUGIN_PATH . 'include/adminplayers.php');
require_once(PMAPI_PLUGIN_PATH . 'include/admingames.php');
require_once(PMAPI_PLUGIN_PATH . 'include/shortcodes.php');
require_once(PMAPI_PLUGIN_PATH . 'include/pmpage.php');

?>