<?php

/**
 * Return an obfuscated string
 *
 * @param string $str
 * @return string
 */
function cgit_obfuscate($str)
{
    return (new \Cgit\Obfuscator\Obfuscator($str))->obfuscate();
}

/**
 * Return an obfuscated email link
 *
 * @param string $email
 * @param string $text
 * @return string
 */
function cgit_obfuscate_link($email, $text = null)
{
    return (new \Cgit\Obfuscator\Obfuscator($email))->obfuscateLink($text);
}
