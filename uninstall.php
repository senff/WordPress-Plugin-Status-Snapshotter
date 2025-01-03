<?php
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit;
	if ( get_option( 'pluginstatussnapshotter' ) != false ) {
		delete_option( 'pluginstatussnapshotter' );
	}
?>
