<?php
/**
 * Class for custom WP CLI command
 *
 * @package AhamedArshad\UsersList
 * @since 1.0.0
 */

namespace AhamedArshad\UsersList;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * CLI class
 *
 * @since 1.0.0
 */
class CLI {

	/**
	 * Bail out if WP_CLI is not defined
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
			return;
		}

		\WP_CLI::add_command( 'users-list', __CLASS__ );

	}

	/**
	 * Subcommand to clear table cache
	 *
	 * @param array $args Arguments
	 * @param array $assoc_args Flag arguments
	 */
	public function clear( array $args,  array $assoc_args ) {

		$transient_name = \AhamedArshad\UsersList\Rest::TABLE_TRANSIENT;

		if ( $assoc_args['dry-run'] ) {

			$timeout = get_option( '_transient_timeout_' . $transient_name );

			if ( $timeout ) {

				$timeLeft = $timeout - time();
				$timeLeft = round( $timeLeft / 60 ); // In minutes

				if ( $timeLeft > 0 ) {
					\WP_CLI::success(
						/* translators: %d minutes left */
						sprintf(
							esc_html__( 'You have a cache with %d mins left. Run command without `--dry-run` to clear it.', '' ),
							intval( $timeLeft )
						)
					);
					return;
				}
			}
		}

		if ( false !== get_transient( $transient_name ) ) {

			delete_transient( $transient_name );

			\WP_CLI::success( esc_html__( 'Cache cleared!', 'aa-userslist' ) );
			return;
		}

		\WP_CLI::success( esc_html__( 'No cache to clear!', 'aa-userslist' ) );
	}

}
