<?php
/**
 * Main plugin class
 *
 * @package AhamedArshad\UsersList
 * @since 1.0.0
 */

namespace AhamedArshad\UsersList;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * UsersList class
 *
 * @since 1.0.0
 */
class UsersList {

	/**
	 * @var null|UsersList $instance Plugin instance
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Load core functionalities
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		new Rest();
	}

	/**
	 * Get plugin instance
	 *
	 * @return UsersList
	 * @since 1.0.0
	 */
	public static function instance(): UsersList {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
