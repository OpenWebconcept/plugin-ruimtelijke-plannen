<?php

/**
 * Plugin Name:       Yard | Ruimtelijke plannen
 * Plugin URI:        https://www.openwebconcept.nl/
 * Description:       Plugin enables CPT 'Spatial plans' and API endpoints including filtering based on taxonomy 'show-on'.
 * Version:           1.0.4
 * Author:            Yard | Digital Agency
 * Author URI:        https://www.yard.nl/
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       ruimtelijke-plannen
 * Domain Path:       /languages
 */

/**
 * If this file is called directly, abort.
 */
if (!defined('WPINC')) {
    die;
}

define('RP_DIR', basename(__DIR__));
define('RP_FILE', basename(__FILE__));

/**
 * Manual loaded file: the autoloader.
 */
require_once __DIR__ . '/autoloader.php';
$autoloader = new OWC\RuimtelijkePlannen\Autoloader();

/**
 * Begin execution of the plugin
 *
 * This hook is called once any activated plugins have been loaded. Is generally used for immediate filter setup, or
 * plugin overrides. The plugins_loaded action hook fires early, and precedes the setup_theme, after_setup_theme, init
 * and wp_loaded action hooks.
 */
\add_action('plugins_loaded', function () {
    $plugin = new OWC\RuimtelijkePlannen\Foundation\Plugin(__DIR__);
    $plugin->boot();
}, 10);
