<?php
/**
 * Class containing users list table
 *
 * @package AhamedArshad\UsersList
 * @since 1.0.0
 */

namespace AhamedArshad\UsersList\Admin;

/**
 * Class UsersListTable
 *
 * @package AhamedArshad\UsersList
 */
class UsersListTable extends ListTable {

	/**
	 * Hold api data
	 *
	 * @var array $apiData Api data to use through out the intance
	 *
	 * @since 1.0.0
	 */
	private $apiData = [];

	/**
	 * Setup parent data and api data
	 *
	 * @param array $args Arguments
	 * @since 1.0.0
	 */
	public function __construct( $args = [] ) {
		parent::__construct( $args );

		$this->apiData = \aaul_get_users_list();
	}

	/**
	 * Get table columns
	 *
	 * @return array $array Table Columns
	 * @since 1.0.0
	 */
	public function get_columns() {
		$table_data = $this->apiData;

		$columns = [];
		$headers = $table_data['data']['headers'];
		$rows    = array_values( $table_data['data']['rows'] ); // resetting array keys

		foreach ( array_keys( $rows[0] ) as $index => $key ) {
			$columns[ $key ] = $headers[ $index ];
		}

		return $columns;
	}

	/**
	 * Get sorable columns list
	 *
	 * @return array $sortable Sortable columns
	 * @since 1.0.0
	 */
	protected function get_sortable_columns() {
		$sortable     = [];
		$columns      = $this->get_columns();
		$first_column = array_key_first( $columns );

		foreach ( $columns as $key => $column ) {
			$sortable[ $key ] = [ $key, $first_column === $key ? 'asc' : false ];
		}

		return $sortable;
	}

	/**
	 * Prepare table rows and headers
	 *
	 * @since 1.0.0
	 */
	public function prepare_items() {
		$table_data = $this->apiData;
		$rows       = $table_data['data']['rows'];

		usort( $rows, [ $this, 'reorder_table' ] );

		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );
		$this->items           = $rows;
	}

	/**
	 * Table empty state message
	 *
	 * @since 1.0.0
	 */
	public function no_items() {
		echo esc_html__( 'No users available.', 'aa-userslist' );
	}

	/**
	 * Formatting column data
	 *
	 * @param array  $item Row data
	 * @param string $column_name Column name
	 *
	 * @return mix Formatted column value
	 * @since 1.0.0
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'date':
				return wp_date( 'Y/m/d', $item[ $column_name ] );
			default:
				return $item[ $column_name ] ?? '';
		}
	}

	/**
	 * Showing api title
	 *
	 * @return string $title Title for the table
	 * @since 1.0.0
	 */
	public function get_table_title() {
		return $this->apiData['title'] ?? __( 'Users Table', 'aa-userslist' );
	}

	/**
	 * Sort table data based on columns
	 *
	 * @param array $a Row data
	 * @param array $b Row data to be compared
	 *
	 * @return int $result Sort order
	 * @since 1.0.0
	 */
	public function reorder_table( $a, $b ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : array_key_first( $this->get_columns() ); // default to first column
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$order  = ( ! empty( $_GET['order'] ) ) ? $_GET['order'] : 'asc'; // default to asc order
		$result = strcmp( $a[ $orderby ], $b[ $orderby ] );

		switch ( $orderby ) {
			case 'id':
			case 'date':
				$result = $a[ $orderby ] - $b[ $orderby ];
				break;
		}

		return ( 'asc' === $order ) ? $result : -$result;
	}

}
