# Castlegate IT WP Obfuscator #

Castlegate IT WP Obfuscator is a WordPress plugin that automatically obfuscates email addresses in the main content and excerpts of posts and pages by randomly replacing characters with HTML character entities. It also provides a shortcode that can be used to obfuscate text anywhere in that shortcodes are processed:

    Lorem ipsum [obfuscate]dolor sit amet[/obfuscate] consectetur

The plugin provides two functions that can be used in your plugin or theme:

*   `cgit_obfuscate($str)` returns an obfuscated version of the string `$str`.
*   `cgit_obfuscate_link($email, $text)` returns a complete mailto: link to the email address `$email`. You can use `$text` to set the text of the link; otherwise it defaults to `$email` (also obfuscated).
