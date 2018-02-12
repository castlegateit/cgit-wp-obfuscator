<?php

use \Cgit\Obfuscator\Obfuscator;

/**
 * Return an obfuscated string
 *
 * @param string $str
 * @return string
 */
function cgit_obfuscate($str)
{
    return (new Obfuscator($str))->obfuscate();
}

/**
 * Return an obfuscated email link
 *
 * @param string $email
 * @param string $text
 * @return string
 */
function cgit_obfuscate_link($email, $text = null, $attributes = [])
{
    return (new Obfuscator($email))->obfuscateLink($text, $attributes);
}
