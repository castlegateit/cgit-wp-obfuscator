<?php

namespace Cgit\Obfuscator;

class Plugin
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        add_filter('the_content', [$this, 'sanitizeContent']);
        add_filter('get_the_excerpt', [$this, 'sanitizeContent']);
    }

    /**
     * Automatically obfuscate email addresses in content
     *
     * @param string $content
     * @return string
     */
    public function sanitizeContent($content)
    {
        return (new ContentObfuscator($content))->obfuscate();
    }
}
