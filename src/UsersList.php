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
	 * Hold the instance of plugin main class
	 *
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
		new Blocks();
		new CLI();
		new Admin\Admin();
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

	/**
	 * Get plugin directory path
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function pluginDirPath(): string {
		return plugin_dir_path( AA_USERS_LIST_FILE );
	}
}
