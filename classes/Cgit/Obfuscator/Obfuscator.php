<?php

namespace Cgit\Obfuscator;

class Obfuscator
{
    /**
     * Source string
     *
     * The original source string to be obfuscated, which should not contain any
     * HTML entities.
     *
     * @var string
     */
    private $source;

    /**
     * Constructor
     *
     * Sets the source string, removing any HTML entities and replacing them
     * with their plain text equivalents.
     *
     * @param string $source
     * @return void
     */
    public function __construct($source)
    {
        $this->source = html_entity_decode($source);
    }

    /**
     * Return obfuscated string
     *
     * @return string
     */
    public function obfuscate()
    {
        return self::encode($this->source);
    }

    /**
     * Return obfuscated HTML email link
     *
     * Provides the option of specifying the text of the link, which will also
     * be obfuscated. If no text is provided, the source email address will be
     * used instead.
     *
     * @param string $text
     * @return string
     */
    public function obfuscateLink($text = null, $attributes = [])
    {
        if (is_null($text)) {
            $text = self::encode($this->source);
        }

        $attributes['href'] = self::encode('mailto:' . $this->source);

        return '<a ' . $this->attributes($attributes) . '>' . $text . '</a>';
    }

    /**
     * Randomly encode a character or sequence of characters
     *
     * Provided with a single character, this method will randomly (i) leave it
     * unmodified, (ii) encode it as a decimal HTML entity, or (iii) encode it
     * as a hexadecimal HTML entity. Provided with multiple characters, this
     * will split the string into its component characters and perform the same
     * operation on each one.
     *
     * @param string $str
     * @return string
     */
    private static function encode($str)
    {
        if (strlen($str) > 1) {
            $chars = str_split($str);

            foreach ($chars as &$char) {
                $char = self::encode($char);
            }

            return implode('', $chars);
        }

        // Decimal code point for the character
        $code = ord($str);

        switch (rand(0, 2)) {
            case 0:
                return $str;
            case 1:
                // Convert the decimal code to a hexadecimal code
                $code = 'x' . str_pad(dechex($code), 4, '0', STR_PAD_LEFT);
        }

        // Return the code as an HTML entity
        return '&#' . $code . ';';
    }

    /**
     * Format attributes
     *
     * Converts an associative array into valid HTML attributes. Nested arrays
     * are converted to space-separated strings.
     *
     * @param array $attributes
     * @return string
     */
    private static function attributes($attributes)
    {
        $pairs = [];

        if (!$attributes || !is_array($attributes)) {
            return '';
        }

        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                $value = implode(' ', $value);
            }

            if ($key != 'href') {
                $value = htmlspecialchars($value);
            }

            $pairs[] = $key . '="' . $value . '"';
        }

        return implode(' ', $pairs);
    }
}
