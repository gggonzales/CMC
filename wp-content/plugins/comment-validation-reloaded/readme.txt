=== Comment Validation Reloaded ===
Contributors: austyfrosty
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CN9BU5LAYCXV8
Tags: comment, validation, comment validation, jquery validation, reloaded
Requires at least: 2.7
Tested up to: 3.5
Stable tag: trunk

Avoid those pesky blank page with an error message like "please fill out required fields" then loosing your/users comment info.

== Description ==

Avoid those pesky blank page with an error message like &ldquo;please fill out required fields&rdquo; then loosing your/users comment info. This plugin aims to help by adding validation to the comment form. When a user submits the form and something is missing, an appropiate message is displayed and individual fields are highlighted. When the email or url is in an incorrect format, a message is displayed accordingly. Requires the user to have javascript activated.

**Why should you install it?** Because you care for comments and want to help users reduce mistakes that hold them off from commenting at all.

**Whats the technology used?** [jQuery](http://jquery.com) and the [jQuery Validation plugin](http://bassistance.de/jquery-plugins/jquery-plugin-validation/) with a few customizations to make it fit into any WordPress theme.

== Installation ==

Follow the steps below to install the plugin.

1. Upload the `comment-validation-reloaded` folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings/Validation Reloaded to edit your settings.


== Frequently Asked Questions ==

= Why create this plugin? =
Because there is a newer validation script out there, but no updated plugins. 


= I think i want to uninstall but... =
Just delete the plugin.


== Screenshots ==

1. Admin options panel in `0.1`

2. Defualt error display


== Changelog ==

= Version 0.4.3.1 (12/3/12)

* Dashboard update.
* Feed update.
* Latest validate script.

= Version 0.4.3 (10/25/12)

* Update validate script to latest version.
* Update options in settings page to choose latest external CDN hosted version.

= Version 0.4.2 (08/16/12)

* Updated admin feeds.

= Version 0.4.1 (05/07/12)

* If the cache forlder isn't writeable, chmod `666` to avoid errors.

= Version 0.4 (04/17/12) =

* Fixed jQuery script to run on document ready.
* Updated Sprite
* Updated dashboard cache issues.

= Version 0.3.9 (12/25/11) =

* Fixed script causing server error on singluar pages.

= Version 0.3.8.1 (12/19/11) =

* Fixed broken translation output file.

= Version 0.3.8 (11/17/11) =

* Spelled fields wrong in the filter.
* Updated localization to not output when in english.

= Version 0.3.7 (11/15/11) =

* Added filter for *required fields text* `cvr_required_fields_text`.
* Removed `uninstall.php`

= Version 0.3.6 (11/14/11) =

* Updated validation script to 1.9.
* Moved inline jQuery into redirect script.
	-fixed so script loads after validation function.

= Version 0.3.5 (11/8/11) =

* Feeds updated.
* WordPress 3.3 check.

= Version 0.3.4 (9/8/11) =

* Dashboard fix.

= Version 0.3.3 (6/23/11) =

* [BUG FIX] An error in the dashboard widget is casuing some large images. Sorry. Always escape.

= Version 0.3.2 (6/7/11) =

* Bug fix for WordPress installs that have `WPLANG` defined.

= Version 0.3.1 (6/1/11) =

* Set up whole plugin for translation.
* New version of validation script version.
* Added translatable jQuery script, please visit settings to change!
* Fixed error when setting validator to external didn't validate.
* Getting ready for plugin overhaul.

= Version 0.3 (4/5/11) =

* Updated multiple error when running WP_DEBUG.
* Updated has_cap from `10` to role `moderate_comments`.
* Updated constants.
* Fixed dashboard cache error.
* Removed outdated javascript that might cause hangups.

= Version 0.2.9 (3/30/11) =

* Dashboard widget updated.

= Version 0.2.8 (2/24/11) =

* Removed javscript link causing hang-ups.

= Version 0.2.7 (2/9/11) =

* Updated the feed parser to comply with deprecated `rss.php` and use `class-simplepie.php`

= Version 0.2.6 =

* Updated version numbers.
* New version for external hosted script.

= Version 0.2.5.1 =

* Minor update for anchor class.

= Version 0.2.5 =

* Fixed XHTML in author link love.

= Version 0.2.4 =

* Fixed error where external code wasn't working
	* Fixed [error](http://snipt.org/Lpmi) Thanks to [John Kolbert](http://www.johnkolbert.com/)
* Use of external file will not validate correctly &amp; work ;)

= Version 0.2.3 =

* Added check for singular post with comments open to enqueue scripts and style
* Check for valication version
* Allow for internal or external validation script
	* Use internal if having issues (external is a php file with *header* JS
	* Having issues with external javascript (trying to execute with PHP)...

= Version 0.2.2 =

* Setting page version update
* Default version update

= Version 0.2.1 =

* Removed CDN(hosted) library in favor of version 1.7, which isn't hosted yet.
* Bug fix

= Version 0.2 =

* Using CDN(hosted) library version 1.6
* Added options to admin

= Version 0.1 =

* Initial release.


== Upgrade Notice ==

=  0.4.3 =
Update the version number if using CDN hosted javascript. Go to the settings page to update. Latest version `1.10.0`.

=  0.3.9 =
Very important, upgrade from `0.3.8.1`, must install!!

= 0.2.4 =
Validates &amp; external source is corrected.

= 0.2.1 =
Admin bug fix.

= 0.1 =
No need to upgrade, just install.