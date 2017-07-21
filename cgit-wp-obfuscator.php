<?php

/*

Plugin Name: Castlegate IT WP Obfuscator
Plugin URI: http://github.com/castlegateit/cgit-wp-obfuscator
Description: Automatically obfuscate email links in content, excerpts, and elsewhere.
Version: 2.0
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

require_once __DIR__ . '/classes/autoload.php';
require_once __DIR__ . '/functions.php';

$plugin = new \Cgit\Obfuscator\Plugin();

do_action('cgit_obfuscator_loaded');
