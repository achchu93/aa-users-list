<?php
/**
 * Class containing admin functions
 *
 * @package AhamedArshad\UsersList
 * @since 1.0.0
 */

namespace AhamedArshad\UsersList\Admin;

/**
 * Class Admin
 *
 * @package AhamedArshad\UsersList
 */
class Admin  {

	/**
	 * Setup admin functions
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if ( ! is_admin() ) {
			return;
		}

		$this->init();
	}

	/**
	 * Init hooks
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'admin_menu', [ $this, 'addUsersTablePage' ] );
	}

	/**
	 * Register admin menu
	 *
	 * @since 1.0.0
	 */
	public function addUsersTablePage() {
		add_menu_page(
			__( 'Users Table', 'aa-userslist' ),
			__( 'Users Table', 'aa-userslist' ),
			'list_users',
			'aa-userslist',
			[ $this, 'renderUsersTablePage' ],
			'dashicons-	editor-table',
			10
		);
	}

	/**
	 * Render table page
	 *
	 * @since 1.0.0
	 */
	public function renderUsersTablePage() {
		$table = new UsersListTable();
		$table->prepare_items();

		include_once \aaul_get_view( 'views/admin/list-table' );
	}

}
