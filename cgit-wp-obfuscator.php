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
 *
 * @param string $str
 * @param string $mask
 *
 * @return string
 */
function cgit_obfuscate($str, $mask = '@.:') {
    $str = html_entity_decode($str);
    $output = '';

    for ($i = 0; $i < strlen($str); $i++) {
        $obfuscate = strpos($mask, $str[$i]) !== false ? 1 : rand(0, 2);

        if (!$obfuscate) {
            $output .= $str[$i];
            continue;
        }

        $code = ord($str[$i]);

        if (rand(0, 1)) {
            $code = 'x' . str_pad(dechex($code), 4, '0', STR_PAD_LEFT);
        }

        $output .= '&#' . $code . ';';
    }

    return $output;
}

/**
 * Return an obfuscated email link
 *
 * Generates an obfuscated HTML mailto: link, with optional link text. If no
 * text is entered, the email address is used for the text of the link.
 *
 * @param string $str
 * @param string $text
 *
 * @return void
 */
function cgit_obfuscate_link($str, $text = false) {
    $protocol = cgit_obfuscate('mailto:');
    $address = cgit_obfuscate($str);
    $output = '<a href="' . $protocol . $address . '">';

    if ($text) {
        $output .= $text;
    } else {
        $output .= $address;
    }

    $output .= '</a>';

    return $output;
}

/**
 * Obfuscate email addresses in content excerpts using filter
 */
foreach (['the_content', 'get_the_excerpt'] as $filter) {
    add_filter($filter, function($content) {
        return preg_replace_callback(
            '/(mailto:)?[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]+/',
            function($matches) {
                return cgit_obfuscate($matches[0]);
            },
            $content
        );
    });
}

/**
 * Add shortcode
 */
add_shortcode('obfuscate', function($atts, $content) {
    return cgit_obfuscate(strip_tags($content));
});
