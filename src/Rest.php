<?php
/**
 * Class for Core Rest API
 *
 * @package AhamedArshad\UsersList
 * @since 1.0.0
 */

namespace AhamedArshad\UsersList;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Rest API class
 *
 * @since 1.0.0
 */
class Rest {

	/**
	 * REST api namespace
	 *
	 * @var string
	 * @since 1.0.0
	 */
	const NAMESPACE = 'aa-users-list/v1';

	/**
	 * Table API response transient
	 *
	 * @var string
	 * @since 1.0.0
	 */
	const TABLE_TRANSIENT = 'aaul_table_data';

	/**
	 * Register hooks
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'initApi' ] );
	}

	/**
	 * Register custom api endpoints
	 *
	 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints
	 * @since 1.0.0
	 */
	public function initApi() {
		register_rest_route(
			self::NAMESPACE,
			'/table-data',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'getTable' ],
				'permission_callback' => '__return_true',
			]
		);
	}

	/**
	 * Table data endpoint callback
	 *
	 * @return \WP_REST_Response|\WP_Error
	 * @since 1.0.0
	 */
	public function getTable() {

		$table_data = \aaul_get_users_list();

		if ( is_wp_error( $table_data ) ) {
			return $table_data;
		}

		return new \WP_REST_Response( $table_data );
	}
}
