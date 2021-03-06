=== BuddyPress Global Search ===
Contributors: buddyboss
Donate link: http://www.buddyboss.com/donate/
Tags: buddypress, search, social networking, activity, profiles, messaging, friends, groups, forums, notifications, settings, social, community, networks, networking
Requires at least: 3.8
Tested up to: 4.1
Stable tag: 1.0.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

BuddyPress Global Search allows for a global, unified search of all BuddyPress components, with a live dropdown as you type.

== Description ==


Let your members search through every BuddyPress component, along with pages and posts and custom post types of your choice, all in one unified search bar with a live dropdown of results.

Just activate the plugin, and every WordPress search input will instantly search your entire BuddyPress site, returning the results in a native tabbed interface right on your default Search Results template, automatically styled by BuddyPress to fit with your theme.

BuddyPress Global Search is built by the experienced developers at BuddyBoss who also offer premium [BuddyPress themes](http://www.buddyboss.com/themes/ "BuddyPress themes from BuddyBoss") and [plugins](http://www.buddyboss.com/plugins/ "BuddyPress plugins from BuddyBoss") to build your social network.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'BuddyPress Global Search'
3. Activate BuddyPress Global Search from your Plugins page.

= From WordPress.org =

1. Download BuddyPress Global Search.
2. Upload the 'buddypress-global-search' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, etc...)
3. Activate BuddyPress Global Search from your Plugins page.

= Configuration =

1. Visit 'Settings > BP Global Search' and select which components should be searchable.
2. Adjust the CSS of your theme as needed, to make everything pretty.

== Frequently Asked Questions ==

= Where can I find documentation and tutorials? =

For help setting up and configuring any BuddyBoss plugin please refer to our [tutorials](http://www.buddyboss.com/tutorials/).

= Does this plugin require BuddyPress? =

Yes, it requires [BuddyPress](https://wordpress.org/plugins/buddypress/) to work.

= Will it work with my theme? =

Yes, BuddyPress Global Search should work with any theme, and will adopt your BuddyPress styling for search results. It may require some styling to make it match perfectly, depending on your theme.

= How do I code a search input into my theme? =

BuddyPress Global Search displays results in the default WordPress search inputs, meaning you can use the standard methods for [adding a search into your theme](http://codex.wordpress.org/Function_Reference/get_search_form). Usually, this will work: `<?php get_search_form( $echo ); ?>`

= Does it come with a language translation file? =

Yes, as well as translations for English, German, and Swedish

= Where can I request customizations? =

For BuddyPress customizations, submit your request at [BuddyBoss](http://www.buddyboss.com/buddypress-developers/).

== Screenshots ==

1. **Dropdown** - live dropdown showing results from all BuddyPress components
2. **Admin** - set which components should be searchable

== Changelog ==

= 1.0.6 = 
* Fixed dropdown hovering

= 1.0.5 = 
* Added Persian translation files - credits to Mahdiar Amani

= 1.0.4 = 
* Added option to disable AutoSuggest search dropdown
* Formatting adjustments
* Allow search to work if site is loaded in iframe

= 1.0.3 =
* Forum search results now displaying in dropdown
* Added Swedish translations - credits to Anton Andreasson
* Added German translations - credits to Marianne Taubl

= 1.0.2 =
* Updated readme

= 1.0.1 =
* Minor update

= 1.0.0 =
* Initial public release
* Removed WP-Updates, now updating via WP-Repo

= 0.0.3 =
* Minor bug fixes

= 0.0.2 =
* Removed empty a tag from autosuggest dropdown items
* Made pagination links dynamic, instead of page refresh

= 0.0.1 =
* Initial beta version
