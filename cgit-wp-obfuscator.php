<?php

/*

Plugin Name: Castlegate IT WP Obfuscator
Plugin URI: http://github.com/castlegateit/cgit-wp-obfuscator
Description: Automatically obfuscate email links in content, excerpts, and elsewhere.
Version: 1.0
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

/**
 * Return an obfuscated string
 *
 * Replaces characters within a string with decimal or hexadecimal HTML entities
 * at random. Excludes certain forbidden characters.
 */
function cgit_obfuscate ($str) {

    $output    = '';
    $forbidden = array('@', '.', ':');

    for ($i = 0; $i < strlen($str); $i++) {
        $obfuscate = in_array($str[$i], $forbidden) ? 1 : rand(0, 1);
        if ($obfuscate) {
            $code = ord($str[$i]);
            $hex = rand(0, 1);
            if ($hex) {
                $code = dechex($code);
                while (strlen($code) < 4) {
                    $code = "0$code";
                }
                $code = "x$code";
            }
            $output .= "&#$code;";
        } else {
            $output .= $str[$i];
        }
    }

    return $output;

}

/**
 * Return an obfuscated email link
 *
 * Generates an obfuscated HTML mailto: link, with optional link text. If no
 * text is entered, the email address is used for the text of the link.
 */
function cgit_obfuscate_link ($str, $text = FALSE) {

    $protocol = cgit_obfuscate('mailto:');
    $address  = cgit_obfuscate($str);
    $text     = $text ? $text : $address;

    return "<a href='$protocol$address'>$text</a>";

}

/**
 * Callback for filter function
 */
function cgit_obfuscate_callback ($matches) {
    return cgit_obfuscate($matches[0]);
}

/**
 * Obfuscate email addresses in content and excerpts using filter
 */
function cgit_obfuscate_content ($content) {
    return preg_replace_callback('/(mailto:)?[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]+/', 'cgit_obfuscate_callback', $content);
}

add_filter('the_content', 'cgit_obfuscate_content');
add_filter('get_the_excerpt', 'cgit_obfuscate_content');

/**
 * Add shortcode
 */
function cgit_obfuscate_shortcode ($atts, $content) {
    return cgit_obfuscate( strip_tags($content) );
}

add_shortcode('obfuscate', 'cgit_obfuscate_shortcode');
