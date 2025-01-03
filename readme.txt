=== Plugin Status Snapshotter ===
Contributors: senff
Donate link: http://donate.senff.com
Tags: plugins, status, snapshots, save, restore
Plugin URI: https://wordpress.org/plugins/plugin-status-snapshotter
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Ever want to do some conflict testing by activating and deactivating a bunch of plugins, and then when you're done, go back to how things were before without having to make a full site backup? Plugin Status Snapshotter lets you make a Snaphot of which plugins are currently active in your site and then restore that Snapshot at a later time, instantly (re)activating all plugins from that Snapshot.

== Description ==

= Summary =

With Plugin Status Snapshotter, you can make a Snaphot of which plugins are currently active in your site. That way, you can make a Snapshot, then activate and deactivate plugins for testing as much as you like, and then restore the Snapshot again to go back to how things were before.

Snapshots will only keep track which plugins were ACTIVE or not. It will not back up any plugin's settings, or install/delete plugins.


= Features =

* One click to create or restore a Snapshot.
* Only saves which plugins are active and which aren't. 
* No full database/configuration backup, so Snapshots are created and restored lightning fast.
* View which plugins were active when a Snapshot was made, before you restore it.


== Installation ==

1. Upload the "plugin-status-snapshotter" directory to your "wp-content/plugins" directory
2. In your WordPress admin, go to PLUGINS and activate "Plugin Status Snapshotter"
3. Go to TOOLS - PLUGIN STATUS SNAPSHOTTER
4. Create your first Snapshot
5. Party!


== Frequently Asked Questions ==

= What does this plugin do, really? =
All it really does is save the state of all plugins in your site (active/deactivated). To get technical, it makes it easy to back up the "active_plugins" row in the "wp_options" table, and then restore that backup at a later time.

= So how is that useful? =

Imagine you have a bunch of plugins installed on your site -- some of which are active, and others aren't. Now let's say you want to do some testing on your site, by activating and deactivating plugins. And then when you're done, you want to go back to how things were before and have the exact same plugins active as before your testing.

This can get a bit tricky when you have a lot of plugins. 

Instead of writing down which plugins were active before testing, and then activate them again manually after testing, you can simply make a quick Snapshot before testing, and then restore that Snapshot after testing. Much easier and faster!

= Why is this better than making a backup of my site and then restore that? =

You can do that too, but that may be a bit of overkill if all you want is to have the same plugins active as you did before.  Making a full-site backup will do that too, but it will also back up a lot of other things (files, database, etc). This plugin only keeps track of which plugins are active.

= Does a Snapshot also save a plugin's settings or configuration? =

No. It ONLY saves whether or not a plugin was active. Let's say you save a snapshot when Plugin A and Plugin B are active, and Plugin X and Y are deactivated. Then you mess around with all your plugins (activate them, deactivate them, change settings, and so on). When you then restore the Snapshot, all it does is activate Plugins A and B, and deactivate Plugins X and Y.  Any settings you've changed in between saving and restoring the snapshot, will still be there.

= One or more plugins didn't activate when I restored a Snapshot. =

There are two common reasons for this. 
First, it's possible that a plugin was deleted since the Snapshot was made. In that case, Plugin Status Snapshotter won't be able to activate it, simply because it's not there anymore -- you'll have to reinstall that missing plugin first. 
Second, sometimes plugins can only be activated if another particular plugin is active (for example, WooPayments can only be activated if WooCommerce is already active). If the "main" plugin (WooCommerce in this example) has been deleted since the Snapshot was made, then the dependant (WooPayments in this example) can not be activated by Plugin Status Snapshotter. In that case, you'll need to install WooCommerce first, before you can activate WooPayments.

= I'll need more help please! =

If you're not sure how to use this, or you're running into any issues with it, post a message on the plugin's [WordPress.org support forum](https://wordpress.org/support/plugin/plugin-status-snapshotter).

= I've noticed that something doesn't work right, or I have an idea for improvement. How can I report this? =

Plugin Status Snapshotter's [community support forum](https://wordpress.org/support/plugin/plugin-status-snapshotter) would a good place, though if you want to add all sorts of -technical- details, it's best to report it on the plugin's [Github page](https://github.com/senff/WordPress-Plugin-Status-Snapshotter/issues). This is also where I consider code contributions.

= My question isn't listed here? =

Please go to the plugin's [community support forum](https://wordpress.org/support/plugin/plugin-status-snapshotter) and post a message. Note that support is provided on a voluntary basis and that it can be difficult to troubleshoot, as it may require access to your admin area. Needless to say, NEVER include any passwords of your site on a public forum!


== Screenshots ==

1. List of saved Snapshots
2. Saving a new Snapshot


== Changelog ==

= 1.0 =
* Initial release


== Upgrade Notice ==

= 1.0 =
* Initial release of the plugin
