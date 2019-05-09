# Castlegate IT WP Obfuscator #

Castlegate IT WP Obfuscator is a WordPress plugin that automatically obfuscates email addresses in the main content and excerpts of posts and pages by randomly replacing characters with HTML character entities.

The plugin provides two functions that can be used in your plugin or theme:

*   `cgit_obfuscate($str)` returns an obfuscated version of the string `$str`.
*   `cgit_obfuscate_link($email, $text)` returns a complete mailto: link to the email address `$email`. You can use `$text` to set the text of the link; otherwise it defaults to `$email` (also obfuscated).

You can also use the `Obfuscator` and `ContentObfuscator` classes directly to obfuscate individual strings and email addresses within content respectively:

~~~ php
$obfuscator = new \Cgit\Obfuscator\Obfuscator('example@example.com');
echo $obfuscator->obfuscate(); // obfuscated string
echo $obfuscator->obfuscateLink(); // obfuscated HTML email link
~~~

~~~ php
$obfuscator = new \Cgit\Obfuscator\ContentObfuscator($foo);
echo $obfuscator->obfuscate(); // HTML content with email addresses obfuscated
~~~

You can add attributes to links as associative arrays, for example:

~~~ php
echo cgit_obfuscate_link('example@example.com', 'email me', [
    'class' => 'email-link',
]);
~~~

## License

Copyright (c) 2019 Castlegate IT. All rights reserved.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.
