<?php

namespace Cgit\Obfuscator;

class ContentObfuscator
{
    /**
     * Source string
     *
     * The complete HTML content to be scanned for email addresses, each of
     * which will be obfuscated by the Obfuscator class.
     *
     * @var string
     */
    private $content;

    /**
     * Constructor
     *
     * @param string $content
     * @return string
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Return content with all email addresses obfuscated
     *
     * @return string
     */
    public function obfuscate()
    {
        return self::encode($this->content);
    }

    /**
     * Obfuscate all email addresses in a string
     *
     * Performs obfuscation of all email addresses within an HTML string, using
     * the Obfuscator class.
     *
     * @param string $str
     * @return string
     */
    private static function encode($str)
    {
        $pattern = '/(mailto:)?[\w\.\-]+@([\w\-]+\.)+[a-z]+/i';

        return preg_replace_callback($pattern, function ($matches) {
            return (new Obfuscator($matches[0]))->obfuscate();
        }, $str);
    }
}
