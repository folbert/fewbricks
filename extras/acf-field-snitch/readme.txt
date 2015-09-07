Originally a WordPress plugin which seems to have been left to die. Updated by Bryan Willis: https://gist.github.com/bryanwillis/bbfdce5febd3db16c53c#file-acf-field-snitch-v5-js .

=== Advanced Custom Fields: Field Snitch ===

Contributors: stupid_studio
Requires at least: 3.4.0
Tags: admin, advanced custom field, custom field, acf, fields, developer, aid, snitch
Tested up to: 3.9.0
Stable tag: 1.0.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

== Description ==

This add-on to [Advanced Custom Fields (ACF)](http://www.advancedcustomfields.com/) aids developers in finding the field names and field keys while editing content, instead of having to to back and forth to the "Custom Fields"-pages.

Now some of the information a developer often needs, is rightly available.

**Simply double tap Esc to reveal the field names and keys on any edit page containing ACF-fields!**

We decided to create this plugin, as we've noticed how we often forget the field name and field key and had to go back and forth to the Custom Fields-page to figure out these names.

This software is licensed under the GNU General Public License version 3. See gpl.txt included with this software for more detail.

Please note, that this plugin is an unofficial Advanced Custom Fields-plugin.


== How to use ==

First of all, you have to be logged in as an administrator. The plugin is simply not enabled for other roles.

Then, once on a content page, simply **double-tap the Esc-button** to enable the visual aid. For each ACF-field, you should now see the field name and field key displays along with the label.

If you click a field name or key, it will copy the value to your clipboard (requires Adobe Flash-plugin enabled in your browser).


== Installation ==

Install this plugin by searching for it in your plugins manager within your WordPress site.


== Usage ==

See the screenshots. It should be pretty self explainatory.


== Screenshots ==

1. Editing a post after ouble tapping on the Esc-key.
2. The same field, prior to double-tapping.


== Changelog ==

= 1.0.3 =
 * WordPress 3.9 compability

= 1.0.2 =
 * Support for flexible content row layouts.

= 1.0.1 =
 * Switched clipboard library from zClip to ZeroClipboard, due to a security issue with zClip (thanks to WordPress review team for pointing this out).
 * Clone to clipboard now also works in repeaters and flexible content.

= 1.0.0 =
Initial release.