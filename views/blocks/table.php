<?php
/**
 * Users List Table Block Template
 *
 * @package AhamedArshad\UsersList
 * @since 1.0.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$rest       = new \AhamedArshad\UsersList\Rest();
$table_data = $rest->getTable();

if ( ! is_array( $table_data ) || ! isset( $attributes['columns'] ) ) {
	return;
}

$table_data    = json_decode( wp_json_encode( $table_data ), true );
$table_headers = $table_data['data']['headers'];
$table_rows    = (array) array_values( $table_data['data']['rows'] );
$header_data   = [];

foreach ( array_keys( $table_rows[0] ) as $index => $key ) {

	if ( ! in_array( $key, $attributes['columns'], true ) ) {
		continue;
	}

	$header_data[ $key ] = $table_headers[ $index ];
}
?>
<table class="users-list-table">
	<thead>
		<tr>
		<?php foreach ( $header_data as $key => $label ) : ?>
			<td><?php echo esc_html( $label ); ?></td>
		<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ( $table_rows as $row ) {

			$tr = '<tr>';
			foreach ( array_keys( $row ) as $key ) {
				if ( ! in_array( $key, $attributes['columns'], true ) ) {
					continue;
				}
				$value = $row[ $key ];
				if ( 'date' === $key ) {
					$value = wp_date( 'Y/m/d', $value );
				}
				$tr .= '<td>' . $value . '</td>';
			}
			$tr .= '</tr>';

			echo $tr; //phpcs:ignore
		}
		?>
	</tbody>
</table>
