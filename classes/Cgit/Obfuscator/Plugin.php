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
        add_filter('acf/load_value', [$this, 'sanitizeContent']);
    }

    /**
     * Automatically obfuscate email addresses in content
     *
     * @param mixed $content
     * @return mixed
     */
    public function sanitizeContent($content)
    {
        if (!is_string($content)) {
            return $content;
        }

        return (new ContentObfuscator($content))->obfuscate();
    }
}
