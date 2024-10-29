=== API for Poker Mavens ===
Contributors: hillplace
Tags: Poker Mavens, Briggs Softworks
Donate link: https://www.hillplace.info
Requires at least: 4.8
Tested up to: 4.8
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This adds some basic Poker Mavens API support to a wordpress Website

== Description ==
This program adds shortcodes for some basic Poker Mavens API functionality.  They are based on the examples at https://www.briggsoft.com/docs/pmavens/API_Examples.htm
on the Poker Mavens Support site.

Shortcodes include:
[pmapi_server_stats] - Adds the server stats.

[pmapi_server_top players="#"] - Adds the Top # Chip leaders (default is 10).

[pmapi_userinfo] - Adds a page to update basic userinfo of the username that matches the username of the wordpress user.  If there is no matching name on the Poker Mavens server, a page to create one will be shown.

[pmapi_login] - Adds a login username and password form.  If user is logged in it will output a button to sign out and a button linking to the poker server.  If logged in and there is no username on the poker server that matches the wordpress username, the api will create one.

[pmapi_rawdata] - Outputs raw data (for testing purposes).

[pmapi_playbutton signin="yes" signintext="Click Here to Sign in and Play!"] - Displays a playbutton, or a signin link if there is nobody logged in.  Does not display anything if no options are stet.  If signin is "yes" default signin text is "Sign In" if it is not set.


== Installation ==

upload the contents of the zip file to the plugins directory of your wordpress site.

== Frequently Asked Questions ==

How does a new wordpress account get validated if the Poker server already has a user with that name?

Wordpress play link will forward user to a password confirmation page.  That page will ask the user to input their Password (Poker Mavens Account Password) and if it is correct the wordpress Password hash will be stored in the "Custom" field of the Poker Mavens Server.  From there on wordpress will compare the hash with the logged in user password hash and if they match will allow for modification of the account data.  If the wordpress password changes account verification will be asked again.

== Screenshots ==

1. screenshot-1.jpg - Settings page
2. screenshot-2.jpg - API shortcode output
2. screenshot-3.jpg - Player Admin
2. screenshot-4.jpg - Game Admin

== Changelog ==

0.1.2 - Added Poker Player Admin Page, and Poker Game admin page.
	- Added functionality to some of the shortcodes.

	0.1.1 - Added code for validation if the poker account already exists.
	- Minor astetic changes.
	- Changed server_top10 to server_top.
	- restructured the location of some code and changed some depreeciated items to their updated counterparts.
	- Edited the version numbers in this file to be consistant with released version (0.9.0 changed to 0.1.0)

0.1.0 - First Release for feedback.

== Upgrade Notice ==

Upgrade to ensure you have the most recent security updates.