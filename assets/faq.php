<h2>
	<?php esc_html_e('FAQ','plugin-status-snapshotter'); ?>/<?php esc_html_e('Troubleshooting','plugin-status-snapshotter'); ?>
</h2>

<p>
	<strong>
		<?php esc_html_e('Q: What does this plugin do, really?','plugin-status-snapshotter'); ?>
	</strong>
</p>

<p class="faq-answer">
	<?php esc_html_e('All it really does is save the state of all plugins in your site (active/deactivated). To get technical, it makes it easy to back up the "active_plugins" row in the "wp_options" table, and then restore that backup at a later time.','plugin-status-snapshotter'); ?>
</p>

<p>
	<strong>
		<?php esc_html_e('Q: So how is that useful?','plugin-status-snapshotter'); ?>
	</strong>
</p>

<p class="faq-answer">
	<?php esc_html_e('Imagine you have a bunch of plugins installed on your site -- some of which are active, and others aren\'t. Now let\'s say you want to do some testing on your site, by activating and deactivating plugins. And then when you\'re done, you want to go back to how things were before and have the exact same plugins active as before your testing.','plugin-status-snapshotter'); ?>
</p>

<p class="faq-answer">
	<?php esc_html_e('This can get a bit tricky when you have a lot of plugins.','plugin-status-snapshotter'); ?>
</p>

<p class="faq-answer">
	<?php esc_html_e('Instead of writing down which plugins were active before testing, and then activate them again manually after testing, you can simply make a quick Snapshot before testing, and then restore that Snapshot after testing. Much easier and faster!','plugin-status-snapshotter'); ?>
</p>

<p>
	<strong>
		<?php esc_html_e('Q: Why is this better than making a backup of my site and then restore that?','plugin-status-snapshotter'); ?>
	</strong>
</p>

<p class="faq-answer">
	<?php esc_html_e('You can do that too, but that may be a bit of overkill if all you want is to have the same plugins active as you did before.  Making a full-site backup will do that too, but it will also back up a lot of other things (files, database, etc). This plugin only keeps track of which plugins are active.','plugin-status-snapshotter'); ?>
</p>

<p>
	<strong>
		<?php esc_html_e('Q: Does a Snapshot also save a plugin\'s settings or configuration?','plugin-status-snapshotter'); ?>
	</strong>
</p>

<p class="faq-answer">
	<?php esc_html_e('No. It ONLY saves whether or not a plugin was active. Let\'s say you save a snapshot when Plugin A and Plugin B are active, and Plugin X and Y are deactivated. Then you mess around with all your plugins (activate them, deactivate them, change settings, and so on). When you then restore the Snapshot, all it does is activate Plugins A and B, and deactivate Plugins X and Y.  Any settings you\'ve changed in between saving and restoring the snapshot, will still be there.','plugin-status-snapshotter'); ?>
</p>

<p>
	<strong>
		<?php esc_html_e('Q: One or more plugins didn\'t activate when I restored a Snapshot.','plugin-status-snapshotter'); ?>
	</strong>
</p>

<p class="faq-answer">
	<?php esc_html_e('There are two common reasons for this.','plugin-status-snapshotter'); ?>
</p>

<p class="faq-answer">
	<?php esc_html_e('First, it\'s possible that a plugin was deleted since the Snapshot was made. In that case, Plugin Status Snapshotter won\'t be able to activate it, simply because it\'s not there anymore -- you\'ll have to reinstall that missing plugin first.','plugin-status-snapshotter'); ?>
</p>

<p class="faq-answer">
	<?php esc_html_e('Second, sometimes plugins can only be activated if another particular plugin is active (for example, WooPayments can only be activated if WooCommerce is already active). If the "main" plugin (WooCommerce in this example) has been deleted since the Snapshot was made, then the dependant (WooPayments in this example) can not be activated by Plugin Status Snapshotter. In that case, you\'ll need to install WooCommerce first, before you can activate WooPayments.','plugin-status-snapshotter'); ?>
</p>

<p>
	<strong>
		<?php esc_html_e('Q: I\'ll need more help please!','plugin-status-snapshotter'); ?>
	</strong>
</p>

<p class="faq-answer">
	<?php esc_html_e('If you\'re not sure how to use this, or you\'re running into any issues with it, post a message on the plugin\'s','plugin-status-snapshotter'); ?>
	<a href="https://wordpress.org/support/plugin/plugin-status-snapshotter" target="_blank"><?php esc_html_e('WordPress.org support forum','plugin-status-snapshotter'); ?>.</a>
</p>

<p>
	<strong>
		<?php esc_html_e('Q: I\'ve noticed that something doesn\'t work right, or I have an idea for improvement. How can I report this?','plugin-status-snapshotter'); ?>
	</strong>
</p>

<p class="faq-answer">
	<?php esc_html_e('Plugin Status Snapshotter\'s','plugin-status-snapshotter'); ?>
	<a href="https://wordpress.org/support/plugin/plugin-status-snapshotter" target="_blank"><?php esc_html_e('community support forum','plugin-status-snapshotter'); ?></a> 
	<?php esc_html_e('would a good place, though if you want to add all sorts of -technical- details, it\'s best to report it on the plugin\'s ','plugin-status-snapshotter'); ?>
	<a href="https://github.com/senff/WordPress-Plugin-Status-Snapshotter/issues" target="_blank"><?php esc_html_e('Github page','plugin-status-snapshotter'); ?></a>
	<?php esc_html_e('This is also where I consider code contributions.','plugin-status-snapshotter'); ?>
</p>

<p>
	<strong>
		<?php esc_html_e('Q: My question isn\'t listed here?','plugin-status-snapshotter'); ?>
	</strong>
</p>

<p class="faq-answer">
	<?php esc_html_e('Please go to the plugin\'s ','plugin-status-snapshotter'); ?>
	<a href="https://wordpress.org/support/plugin/plugin-status-snapshotter" target="_blank"><?php esc_html_e('community support forum','plugin-status-snapshotter'); ?></a>
	<?php esc_html_e('and post a message. Note that support is provided on a voluntary basis and that it can be difficult to troubleshoot, as it may require access to your admin area. Needless to say,','plugin-status-snapshotter'); ?>
	<span class="bold-text" style="color:#ff0000;">
		<?php esc_html_e('NEVER include any passwords of your site on a public forum!','plugin-status-snapshotter'); ?>
	</span>
</p>
