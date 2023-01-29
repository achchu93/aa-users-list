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

/**
 * Get users list
 *
 * @since 1.0.0
 */
function aaul_get_users_list() {

	$transient_name = 'aaul_table_data';
	$cachedData     = get_transient( $transient_name );

	if ( is_array( $cachedData ) ) {
		return $cachedData;
	}

	try {
		$table = new \AhamedArshad\UsersList\Api\Table();
		$data  = $table->fetch();
		$data  = json_decode( wp_json_encode( $data ), true ); // force data to be array

		set_transient( $transient_name, $data, HOUR_IN_SECONDS );

		return $data;

	} catch ( \Exception $ex ) {

		return new \WP_Error( $ex->getCode(), $ex->getMessage() );
	}

}
