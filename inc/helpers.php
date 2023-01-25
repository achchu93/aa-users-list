<?php
/**
 * Helpers
 *
 * @package AhamedArshad\UsersList
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get view by name
 *
 * @param string $name Path to the file
 * @return string $file
 *
 * @since 1.0.0
 */
function aaul_get_view( $name ): string {
	$file = \AhamedArshad\UsersList\UsersList::instance()->pluginDirPath() . "{$name}.php";

	if ( file_exists( $file ) ) {
		return $file;
	}

	return '';
}
