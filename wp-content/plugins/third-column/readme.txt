=== Third Column ===
Contributors: marcus.downing
Tags: admin, edit
Requires at least: 3.8
Tested up to: 3.9.1
Stable tag: trunk

Adds a third column on the Edit Post screen.

== Description ==

Add the option for a third column on the Edit Post and Edit Page screens. This is useful if you have a lot of boxes on your edit screen, from custom taxonomies and plugins.

Also adds a pair of mini columns underneath the edit boxes, giving you space for more small boxes.


== Installation ==

1. Upload the `third-column` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Edit any post
1. Drag boxes to the third column


== Screenshots ==

1. The option to show three columns

2. An edit page with boxes in the third column and the mini columns



== Frequently Asked Questions ==

= Do I need to modify my installation of WordPress to enable this third column? =

No, you don't need to modify WordPress at all.

= Can I have different layouts? =

The layout of boxes is specific to the post type, so you can have one layout for Posts, one for Pages, and one for each custom post type.

= Why don't I see the third column? =

Open up the "Screen Options" panel in the top-right. Under the "Screen Layout" section, set the "Number of Columns" option to 3.

If that doesn't work, make sure you have Javascript turned on.

= What happens when I switch the plugin off? =

The boxes should all jump back to the second column.

If it doesn't work - if your boxes disappear - try turning the plugin on again, then back off.


== Changelog ==

= 2.0 =
* Major update to work on new versions of Wordpress (3.8+)
* Added "mini columns" under the main editor

= 1.0 =
* First release