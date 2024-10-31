=== One Call - WP REST API Extension ===
Contributors: amadercode
Donate link: http://www.amadercode.com/
Tags: wp rest api filter fields, wpi rest api prefix, wp rest api featured image, wp rest api all post fields details
Requires at least: 4.7
Tested up to: 4.9
Requires PHP: 5.6
Stable tag: 4.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Get featured images, categories, tags, taxonomies,custom fields & author details etc all together by one call from WordPress rest api to reduce responsed time by securing wp rest api pfefix.

== Description ==
One Call is a helper or extension of WP REST API. To get featured image details, Categories lits, Tags list, Custom fields & Author detials by single rest api response One Call is giving a you post fileds filter options with custom rest api prefix such as 'test-api' where 'wp-json' is default.By default wp rest api does not give featured image, tags names, categories name & author details etc and to get them you have to call another rest api for each term which slow down the procedures. One Call is the solution to speed up rest api call in this case. 

= The key features of One Call API are- =
* Custom and back end control rest api prefix such as 'test-api' where 'wp-json' is default to initially secure the api call.
* Get different reponse for list posts and single post responses.
* For posts list (multiple) call, you can control 'one_call' fields from back end.
* WordPress Posts fields filtering options from backend for posts litst (loop of Posts).


== Installation ==

1. Upload the plugin 'one-call' folder by uncompressing 'one-call.zip' to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress by clicking 'Activate' button below 'One Call - WP REST API Extension'.
3. Use the Settings->One Call API Settings screen  OR by clicking 'One Call API Settings' button below 'One Call - WP REST API Extension' to configure the plugin



== Frequently Asked Questions ==

= What is One Call - WP REST API Extension ? =

Single solution to get featured image details, Categories lits, Tags list, Custom fields & Author detials by single WP REST API response.


== Screenshots ==
1. To go configure page of 'One Call - WP REST API Extension'.
2. To configure  and saveing the options.
3. Response with out One Call request.
4. Response with One Call request.


== Changelog ==

= 1.0.0=
*The initial version.
= 1.1.0=
*WordPress Posts fields filtering options from backend for posts litst (loop of Posts).
*Setting options for ONE CALL fields are changed.
*WP REST API custom Prefix issue fixed.
= 1.1.0=
*After changing REST API prefix, permalink working fine in this update, no need permalink flash (reset).