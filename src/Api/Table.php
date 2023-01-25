<?php
/**
 * Class for Table API
 *
 * @package AhamedArshad\UsersList
 * @since 1.0.0
 */

namespace AhamedArshad\UsersList\Api;

/**
 * Table API class
 *
 * @since 1.0.0
 */
class Table extends Base {

	/**
	 * Get table data
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function fetch(): array {
		$this->method( 'GET' );
		$this->endpoint( 'challenge/1/' );

		$response = $this->request();
		return $this->processResponse( $response );
	}
}
