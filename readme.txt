=== Display Widgets ===
Contributors: sswells
Donate link: http://blog.strategy11.com/donate/
Tags: widget, widgets, admin, show, hide, page, Thesis, sidebar, content, wpmu, wordpress, plugin
Requires at least: 2.8
Tested up to: 2.8.4
Stable tag: 1.4

Adds checkboxes to each widget to either show or hide on every site page.

== Description ==

Avoid creating multiple sidebars and duplicating widgets by adding check boxes to each widget (as long as it is written in the version 2.8 format) which will either show or hide the widgets on every site page. Change your sidebar content with different pages. Great for use with Thesis theme, or just to avoid extra coding. 

By default, 'Hide on Checked' is selected with no boxes checked, so all current widgets will continue to display on all pages. 

== Installation ==

1. Upload `display-widgets.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the 'Widgets' menu and show the options panel for the widget you would like to hide.
4. Select either 'Show on Checked' or 'Hide on Checked' from the drop-down and check the boxes.


== Frequently Asked Questions ==

= Why aren't the options showing up on my widget? =

This is a known limitation. Widgets written in the pre-2.8 format don't work the same way, and don't have the hooks. Sorry.


== Screenshots ==

1. The extra widget options added.

== Changelog ==
= 1.4 =
* Changed "Home Page" check box to "Blog Page"

= 1.3 =
* Added check box for Home page if it is the blog page
* Added check boxes for single post and archive pages
* Save hide/show option correctly for more widgets

= 1.2 =
* Save page check boxes for more widgets

= 1.1 =
* Fixed bug that prevented other widget options to be displayed

