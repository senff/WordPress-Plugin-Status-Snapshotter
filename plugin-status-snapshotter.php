<?php
/*
Plugin Name: Plugin Status Snapshotter
Plugin URI: https://wordpress.org/plugins/plugin-status-snapshotter
Description: Saves a list of currently active plugins so that you can do some testing, and then when you're done, go back to how things were before.
Author: Senff
Author URI: http://www.senff.com
Version: 1.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: plugin-status-snapshotter
*/

defined('ABSPATH') or die('INSERT COIN');


// --- ON ACTIVATION: IF DATABASE VALUES ARE NOT SET AT ALL, ADD DEFAULT OPTIONS TO DATABASE ---------------------------

function pluginstatussnapshotter_default_options() {
	$versionNum = '1.0';
	if (get_option('pluginstatussnapshotter') === false) {
		$new_options['pss_version'] = $versionNum;		
		$new_options['pss_snapshots'] = [];		
		add_option('pluginstatussnapshotter',$new_options);
	} 
}


// --- ADD LINK TO SETTINGS PAGE TO SIDEBAR ------------------------------------------------------------

function pluginstatussnapshotter_menu() {
	add_management_page( 'Plugin Status Snapshotter', 'Plugin Status Snapshotter', 'manage_options', 'pluginstatussnapshotter', 'pluginstatussnapshotter_page' );
}


// --- ADD LINK TO SETTINGS PAGE TO PLUGIN ------------------------------------------------------------

function pluginstatussnapshotter_settings_link($links) { 
	$settings_link = '<a href="'.admin_url('tools.php?page=pluginstatussnapshotter').'">Create or Restore a Snapshot</a>'; 
	array_unshift($links, $settings_link); 
	return $links; 
}


// === THE WHOLE ADMIN SETTINGS PAGE ==================================================================

function pluginstatussnapshotter_page() {

	?>

	<div id="pluginstatussnapshotter-settings" class="wrap">

		<h2><?php esc_html_e('Plugin Status Snapshotter','plugin-status-snapshotter'); ?></h2>

		<p>
			<strong><?php esc_html_e('Welcome to Plugin Status Snapshotter!','plugin-status-snapshotter'); ?></strong>
			<?php esc_html_e('With this plugin, you can make a Snaphot of which plugins are currently active in your site. That way, you can make a Snapshot, then activate and deactivate plugins for testing as much as you like, and then restore the Snapshot again to go back to how things were before.','plugin-status-snapshotter'); ?>
			<br>
			<?php esc_html_e('Snapshots will only save/restore if a plugin was ACTIVE or not. It will not back up the plugin\'s settings, or install/delete plugins.','plugin-status-snapshotter'); ?>
		</p>

		<div class="main-content">

			<h2 class="nav-tab-wrapper">	
				<a class="nav-tab" href="#main"><?php esc_html_e('SNAPSHOTS','plugin-status-snapshotter'); ?></a>			
				<a class="nav-tab additional" href="#faq"><?php esc_html_e('FAQ/Troubleshooting','plugin-status-snapshotter'); ?></a>
				<a class="nav-tab additional" href="#plugin-info"><?php esc_html_e('About','plugin-status-snapshotter'); ?></a>
			</h2>

			<br>

			<?php 

				if ( isset( $_GET['saved'] ) && ($_GET['saved'] == '1')) { 
					echo '<div id="message" class="fade updated"><p><strong>';
					esc_html_e('Snapshot saved successfully!','plugin-status-snapshotter');
					echo '</strong></p></div>';
				}	

				if ( isset( $_GET['saved'] ) && ($_GET['saved'] == '0')) { 
					echo '<div id="message" class="fade error"><p><strong>';
					esc_html_e('Something went wrong while saving a snapshot. Please try again.','plugin-status-snapshotter');
					echo '</strong></p></div>';
				}	

				if ( isset( $_GET['restored'] ) && ($_GET['restored'] == '1')) { 
					if ( isset( $_GET['warning'] ) && ($_GET['warning'] == '1')) { 
						echo '<div id="message" class="fade error"><p><strong>';
						esc_html_e('A problem occurred while saving a Snapshot.','plugin-status-snapshotter');
						echo '</strong></p><p>';
						esc_html_e('The following plugins were present in the Snapshot, but could not be activated:','plugin-status-snapshotter');
						echo '</p>';
						if ( isset( $_GET['failed'] ) ) { 
							$failed_plugins = sanitize_text_field(wp_unslash($_GET['failed']));
							$failed_plugins_array = array_map('trim', explode(',', $failed_plugins));
							$empty_element = array_pop($failed_plugins_array);
							echo '<ul class="plugin-list failed-plugins">';
							foreach ($failed_plugins_array as $failed_plugin) {
								echo '<li>'.esc_html($failed_plugin).'</li>';
							}
							echo '</ul>';
							echo '<p>';
							esc_html_e('It\'s possible that they are not installed anymore, or that required plugins are missing or inactive. You may need to activate them manually.','plugin-status-snapshotter');
							echo '</p></div>';
						}
					} else {
						echo '<div id="message" class="fade updated"><p><strong>';
						esc_html_e('Snapshot restored successfully!','plugin-status-snapshotter');
						echo '</strong></p></div>';
					}
				}	

				if ( isset( $_GET['restored'] ) && ($_GET['restored'] == '0')) { 
					echo '<div id="message" class="fade error"><p><strong>';
					esc_html_e('Something went wrong while restoring a snapshot. Please try again.','plugin-status-snapshotter');
					echo '</strong></p></div>';
				}				

				if ( isset( $_GET['deleted'] ) && ($_GET['deleted'] == '1')) { 
					echo '<div id="message" class="fade updated"><p><strong>';
					esc_html_e('Snapshot deleted successfully!','plugin-status-snapshotter');
					echo '</strong></p></div>';
				}	

				if ( isset( $_GET['deleted'] ) && ($_GET['deleted'] == '0')) { 
					echo '<div id="message" class="fade error"><p><strong>';
					esc_html_e('Something went wrong while attempting to delete a snapshot. Please try again.','plugin-status-snapshotter');
					echo '</strong></p></div>';
				}

			?>

			<div class="tabs-content">

				<div id="pluginstatussnapshotter-main">

					<div class="create-save-snapshot">

						<h3><?php esc_html_e('Create a New Snapshot','plugin-status-snapshotter'); ?></h3>

						<div class="postbox">

							<div class="save-snapshot">

								<p><?php esc_html_e('When you create a Snapshot, it will save a list of which plugins are currently active on your site. It will NOT save the individual configurations/settings of each plugin; ONLY whether or not they are active.','plugin-status-snapshotter'); ?></p>

								<form method="post" action="admin-post.php">
									<input type="hidden" name="action" value="save_pluginstatussnapshotter_snapshot" />
									<?php 
										wp_nonce_field( 'pss_save_snapshot' ); 
								    ?>
									<input type="submit" value="<?php esc_attr_e('Create Snapshot','plugin-status-snapshotter'); ?>" class="button-primary button-large button-action"/> <span id="plugin-check__spinner" class="spinner spinner-save" style="float: none;"></span>
								</form>							

							</div>

							<div class="active-plugins">

								<p><?php esc_html_e('The following plugins are currently active on your site:','plugin-status-snapshotter'); ?></p>							

								<?php	

									$pss_wp_options = get_option( 'active_plugins' );

									echo '<ul class="active-plugins-list">';
									foreach ($pss_wp_options as $plugin_file) {
										// Do this for each active plugin
										$active_plugin_name = getpluginname($plugin_file);
										$active_plugin_author = getpluginauthor($plugin_file);
										echo '<li><strong>'.esc_html($active_plugin_name).'</strong> '.esc_html__('by','plugin-status-snapshotter').' '.esc_html($active_plugin_author).'</li>';
									}
									echo '</ul>';

								?>

							</div>

						</div>

					</div>

					<div class="previous-snapshots">

						<h3><?php esc_html_e('Previously Saved Snapshots','plugin-status-snapshotter'); ?></h3>

						<?php

							// Retrieve all snapshots from database and put them in variables
							$snapshotdata = get_option( 'pluginstatussnapshotter' );
							$pss_snapshots = ( isset( $snapshotdata['pss_snapshots'] ) ) ? $snapshotdata['pss_snapshots'] : '';  // FULL 3D ARRAY
							$num_snaps = count($pss_snapshots);

							if (empty($pss_snapshots)) {
								echo '<div class="postbox"><p>';
				    			esc_html_e('There are no saved snapshots. ','plugin-status-snapshotter');
				    			echo '</div></p>';
							} else {

							?>

								<table class="existing-snapshots-table wp-list-table widefat striped">
									<thead>
										<tr style="margin-bottom: 4px;">
											<th class="snapshot-date"><?php esc_html_e('Date','plugin-status-snapshotter'); ?></th>
											<th class="snapshot-details"><?php esc_html_e('Details (click to show plugins)','plugin-status-snapshotter'); ?></th>
											<th class="snapshot-actions"><?php esc_html_e('Actions','plugin-status-snapshotter'); ?></th>
										</tr>		
									</thead>
									<tbody>

										<?php
											foreach ($pss_snapshots as $snapshot) { 
												// Do this for each snapshot
												// 0 = ID;
												// 1 = date
												// 2[0] = plugin;
												// 2[0][0] = path;
												// 2[0][1] = name;
												// 2[0][2] = author;
												$snapshot_plugins = $snapshot[2]; // Array of all plugins in this Snapshot
												$howmanyplugins = count($snapshot_plugins);											
												echo '<tr>';
												echo '<td class="snapshot-date data-snapshot="'.esc_attr($snapshot[0]).'"><strong>'.esc_attr($snapshot[1]).'</strong></td>';
												echo '<td class="snapshot-data">';
												echo '<p><strong>'.esc_html($howmanyplugins).'</strong> '.esc_html__('active plugins when this shapshot was made.','plugin-status-snapshotter').'</p>';
												echo '<button class="show-details button-secondary">'.esc_attr__('SHOW PLUGINS','plugin-status-snapshotter').'</button><button class="hide-details button-secondary">'.esc_html__('HIDE PLUGINS','plugin-status-snapshotter').'</button>';
												echo '<div class="plugins-in-snapshot"><ul>';
												foreach ($snapshot_plugins as $plugin) { 
													// Do this for each plugin
													echo '<li><strong>'.esc_html($plugin[1]). '</strong> by '.esc_html($plugin[2]).'</li>';
												}
												echo '</ul></div></td>';
												echo '<td class="snapshot-actions">';
												echo '<form id="pss-snapshot-restore-delete" data-snapshot-id="'.esc_attr($snapshot[0]).'" />';
												echo '<input type="button" class="button-primary button-restore" value="'. esc_attr__('Restore','plugin-status-snapshotter').'" data-snapshot-action="restore">';
												echo '<input type="button" class="button-primary button-delete" value="'. esc_attr__('Delete','plugin-status-snapshotter').'" data-snapshot-action="delete">';
												echo '</form>';
												echo '</td></tr>';
											}
										?>
									</tbody>
								</table>

							<?php

							}

						?>

					</div>

					<div class="pluginstatussnapshotter-confirmation-container">
						<div class="pluginstatussnapshotter-confirmation-dialog">

							<form method="post" action="admin-post.php">
								<input type="hidden" name="action" value="restoredelete_pluginstatussnapshotter_snapshot" />
								<input type="hidden" class="snapshotid" name="snapshot" value="">
								<?php 
									wp_nonce_field( 'pss_restoredelete_snapshot' ); 
							    ?>
							   	<div class="section-restore">
							   		<h3><?php esc_html_e('Restore Snapshot','plugin-status-snapshotter'); ?></h3>
									<p><?php esc_html_e('When you restore a Snapshot, it will activate all plugins that were active on your site when you created the Snapshot. Any plugins that were NOT active at the time (or were not installed at all), will be deactivated.','plugin-status-snapshotter'); ?></p>
									<p><strong><?php esc_html_e('This will only activate and deactivate plugins! It will NOT (re)install or delete any plugins, or restore/change the current configuration settings of any plugin. ','plugin-status-snapshotter'); ?></strong></p>
									<div class="buttons-container">
										<button type="submit" name="restoredelete" value="restore" class="button-primary button-action"><?php esc_html_e('RESTORE SNAPSHOT','plugin-status-snapshotter'); ?></button><input type="button" class="close-confirmation button-secondary" value="CANCEL"><br/><span id="plugin-check__spinner" class="spinner" style="float: none;"></span>
									</div>
								</div>
								<div class="section-delete">
								   	<h3><?php esc_html_e('Delete Snapshot','plugin-status-snapshotter'); ?></h3>
									<p><?php esc_html_e('CAUTION: This will only remove the Snapshot from the list of previously saved Snapshots.','plugin-status-snapshotter'); ?> <strong><?php esc_html_e('This will NOT actually activate, deactive or delete any plugins from your site.','plugin-status-snapshotter'); ?></strong></p>
									<p><?php esc_html_e('Are you sure you want to delete this Snapshot? This can not be undone.','plugin-status-snapshotter'); ?></p>
									<div class="buttons-container">
										<button type="submit" name="restoredelete" value="delete" class="button-primary button-action"><?php esc_html_e('DELETE SNAPSHOT','plugin-status-snapshotter'); ?></button><input type="button" class="close-confirmation button-secondary" value="CANCEL"><br/><span id="plugin-check__spinner" class="spinner" style="float: none;"></span>
									</div>
								</div>
								

							</form>

						</div>
					</div>

				</div>
			
				<div id="pluginstatussnapshotter-faq">
					<?php include 'assets/faq.php'; ?>
				</div>

				<div id="pluginstatussnapshotter-plugin-info">
					<?php include 'assets/plugin-info.php'; ?>
				</div>

			</div>

		</div>

	</div>
		
	<?php

	}


// --- TRIGGERING THE FUNCTIONS TO SAVE, RESTORE OR DELETE A SNAPSHOT -----------------------------------

function pluginstatussnapshotter_admin_init() {
	add_action( 'admin_post_save_pluginstatussnapshotter_snapshot', 'pluginstatussnapshotter_save' );
	add_action( 'admin_post_restoredelete_pluginstatussnapshotter_snapshot', 'pluginstatussnapshotter_restoredelete' );
}


// --- SAVE A SNAPSHOT ----------------------------------------------------------------------------------

function pluginstatussnapshotter_save() {

	if ( !current_user_can( 'manage_options' ))
		wp_die( 'Not allowed');
	check_admin_referer('pss_save_snapshot');

	$pss_options = get_option( 'pluginstatussnapshotter' );
	$pss_allsnapshots = ( isset( $pss_options['pss_snapshots'] ) ) ? $pss_options['pss_snapshots'] : '';  // FULL 3D ARRAY
	$pss_id = (int)(microtime(true) * 1000);
	$current_date_time = sanitize_text_field(gmdate('l, M d, Y (H:i:s)'));
	$active_plugins = [];	// 2 dimensional array that will contain all active plugins

	$pss_wp_options = get_option( 'active_plugins' );
	foreach ($pss_wp_options as $active_plugin_file) {
		// Do this for each active plugin
		$plugin_file = sanitize_text_field($active_plugin_file);
		$plugin_name = sanitize_text_field(getpluginname($active_plugin_file));
		$plugin_author = sanitize_text_field(getpluginauthor($active_plugin_file));
		array_push($active_plugins, [$plugin_file,$plugin_name,$plugin_author]);
	}

	// We now have a new element to add to the base array, each one being [ID,DATE,[PLUGIN FILE, PLUGIN NAME, PLUGIN AUTHOR]]
	$pss_new_element = [$pss_id, $current_date_time, $active_plugins];
	array_push($pss_allsnapshots, $pss_new_element); // Add the new snapshot to the array of all snapshots
	// $pss_allsnapshots is an array that now contains the new snapshot and needs to go in the database

	$new_snapshots['pss_snapshots'] = $pss_allsnapshots;
	update_option( 'pluginstatussnapshotter', $new_snapshots );	
				
	if ($warning == 'true') {
 		wp_redirect( add_query_arg(
 			array('page' => 'pluginstatussnapshotter', 'saved' => '0', 'warning' => '1'),
 			admin_url( 'tools.php' ) 
 			)
 		);
	} else {
 		wp_redirect( add_query_arg(
 			array('page' => 'pluginstatussnapshotter', 'saved' => '1', 'warning' => '0'),
 			admin_url( 'tools.php' ) 
 			)
 		);	
		}

	exit;

}


// --- RESTORE OR DELETE A SNAPSHOT ---------------------------------------------------------------------

function pluginstatussnapshotter_restoredelete() {

	if ( !current_user_can( 'manage_options' ))
		wp_die( 'Not allowed');
	check_admin_referer('pss_restoredelete_snapshot');	

	if (isset($_POST['restoredelete'])) {
    	$action_todo = sanitize_text_field(wp_unslash($_POST['restoredelete']));
    }	

	if (isset($_POST['snapshot'])) {
    	$snapshot_id = sanitize_text_field(wp_unslash($_POST['snapshot']));
    }	   

	$snapshotdata = get_option( 'pluginstatussnapshotter' );
	$pss_snapshots = ( isset( $snapshotdata['pss_snapshots'] ) ) ? $snapshotdata['pss_snapshots'] : '';  // FULL 3D ARRAY

   	if ($action_todo == 'delete') {
   		// DELETING A SAVED SNAPSHOT
		$pss_index = 0;
		$pss_position = '';
		foreach ($pss_snapshots as $snapshot) {
			// Loop through all snapshots to see if it has the ID we're looking for
			if ($snapshot[0] == $snapshot_id) {
				array_splice($pss_snapshots, $pss_index, 1); // Removing the element from the array
				$pss_position = $pss_index;
			} 
			$pss_index = $pss_index + 1;
		}

		// $pss_snapshots is a new array, with the one selected removed, that needs to go back in the database
		$new_snapshots['pss_snapshots'] = $pss_snapshots;
		update_option( 'pluginstatussnapshotter', $new_snapshots );	

		if ($warning == 'true') {
	 		wp_redirect( add_query_arg(
	 			array('page' => 'pluginstatussnapshotter', 'deleted' => '0'),
	 			admin_url( 'tools.php' ) 
	 			)
	 		);
		} else {
	 		wp_redirect( add_query_arg(
	 			array('page' => 'pluginstatussnapshotter', 'deleted' => '1'),
	 			admin_url( 'tools.php' ) 
	 			)
	 		);	
 		}

	} else {

   		// RESTORING A SAVED SNAPSHOT
		$pss_index = 0;
		$pss_position = '';
		$pss_failed = '';
		foreach ($pss_snapshots as $snapshot) {
			// Loop through all snapshots to see if it has the ID we're looking for
			if ($snapshot[0] == $snapshot_id) {
				$plugins_to_restore = $snapshot[2];
				// Deactivate everything first, except this one
				$active_plugins = get_option( 'active_plugins' );
				foreach ( $active_plugins as $plugin ) {
					if ($plugin != 'plugin-status-napshotter/plugin-status-snapshotter.php') {
    					deactivate_plugins( $plugin );
    				}
				}
				// Now activate all plugins that are in the restore point
				foreach ($plugins_to_restore as $plugin_to_restore) {
					$ptr_path = $plugin_to_restore[0];
					$ptr_name = $plugin_to_restore[1];
					if ( ! is_plugin_active( $ptr_path ) ) {
 						activate_plugin( $ptr_path );
					}
				}
				// Some plugins might have not been restored because they depend on other plugins
				// (e.g. WooPayments can not be activated if WooCommerce is not active)
				// Let's go through it again (now that WooCommerce is active, for example)
				foreach ($plugins_to_restore as $plugin_to_restore) {
					$ptr_path = $plugin_to_restore[0];
					$ptr_name = $plugin_to_restore[1];
					if ( ! is_plugin_active( $ptr_path ) ) {
 						activate_plugin( $ptr_path );
					}
					// Check if it's now active. If it's still not, flag a warning
					if ( ! is_plugin_active( $ptr_path ) ) {
						$warning = 'true'; 
						$pss_failed = $pss_failed.$ptr_name.', ';
					}
				}					
			} 
		}

		if ($warning == 'true') {
	 		wp_redirect( add_query_arg(
	 			array('page' => 'pluginstatussnapshotter', 'restored' => '1', 'warning' => '1', 'failed' => $pss_failed),
	 			admin_url( 'tools.php' ) 
	 			)
	 		);
		} else {
	 		wp_redirect( add_query_arg(
	 			array('page' => 'pluginstatussnapshotter', 'restored' => '1', 'warning' => '0' ),
	 			admin_url( 'tools.php' ) 
	 			)
	 		);	
 		}

	}

	exit;

}


// --- GETTING THE NAME AND AUTHOR OF A PLUGIN ----------------------------------------------------------

function getpluginname($file_path) {
	// Check if the file exists
	if (!file_exists(WP_PLUGIN_DIR .'/'. $file_path)) {
		return false;
	}		
	$file_contents = file_get_contents(WP_PLUGIN_DIR .'/'. $file_path);
	preg_match('/Plugin Name:\s*(.*)/', $file_contents, $name);
 
 	// If a plugin name is found, return it
 	if (isset($name[1])) {
     return trim($name[1]);
 	} else {
 	  return 'Unknown Name';
 	}
 	return false;
}

function getpluginauthor($file_path) {
	// Check if the file exists
	if (!file_exists(WP_PLUGIN_DIR .'/'. $file_path)) {
		return false;
	}		
	$file_contents = file_get_contents(WP_PLUGIN_DIR .'/'. $file_path);
	preg_match('/Author:\s*(.*)/', $file_contents, $author);
 
 	// If a plugin author is found, return it
 	if (isset($author[1])) {
     return trim($author[1]);
 	} else {
 		return 'Unknown Author';
 	}
 	return false;
}


// --- ADDING THE JS AND CSS ----------------------------------------------------------

function pluginstatussnapshotter_admin($hook) {
	if ($hook != 'tools_page_pluginstatussnapshotter') {
		return;
	}

	wp_register_script('pluginstatussnapshotterAdminScript', plugins_url('/assets/js/plugin-status-snapshotter.js', __FILE__), array( 'jquery' ), '1.0', array( 'in_footer' => true ));
	wp_enqueue_script('pluginstatussnapshotterAdminScript');

	wp_register_style('pluginstatussnapshotterAdminStyle', plugins_url('/assets/css/plugin-status-snapshotter.css', __FILE__),'', '1.0' );
	wp_enqueue_style('pluginstatussnapshotterAdminStyle');		
}


// === HOOKS AND ACTIONS AND FILTERS AND SUCH ==========================================================

$plugin = plugin_basename(__FILE__); 

register_activation_hook( __FILE__, 'pluginstatussnapshotter_default_options' );
add_action('admin_menu', 'pluginstatussnapshotter_menu');
add_filter("plugin_action_links_$plugin", 'pluginstatussnapshotter_settings_link' );  // Needs double quotes!
add_action('admin_init', 'pluginstatussnapshotter_admin_init' );
add_action('admin_enqueue_scripts', 'pluginstatussnapshotter_admin' );	

