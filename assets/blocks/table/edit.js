/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Panel, PanelBody, PanelRow, CheckboxControl, BaseControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { useEffect, useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

import './editor.scss';

/**
 * Column Sort Order
 */
const COLUMNS_ORDER = [ 'id', 'fname', 'lname', 'email', 'date' ];

/**
 * Format timestamp date to readable
 */
const getFormattetDate = ( timestamp ) => new Date( timestamp * 1000 ).toISOString().split( 'T' )[0].replaceAll( '-', '/' );

/**
 * Table Component
 *
 * @param {*} param0
 * @returns {JSX}
 */
const Table = ( { columns, headers, rows } ) => {

	columns.sort( ( a, b ) => COLUMNS_ORDER.indexOf( a ) - COLUMNS_ORDER.indexOf( b ) );

	return (
		<table className="users-list-table">
			<thead>
				<tr>
				{
					columns.map( ( col, index ) => (
						<th key={ index }>
							{ headers.find( header => header.name === col )['label'] }
						</th>
					) )
				}
				</tr>
			</thead>
			<tbody>
				{
					rows.map( ( row, index ) => (
						<tr key={ index }>
							{
								Object.entries( row ).map( ( [ key, value ], index ) => {
									return columns.includes( key ) && (
										<td key={ index }>
											{key === 'date' ? getFormattetDate( value ) : value}
										</td>
									)
								} )
							}
						</tr>
					) )
				}
			</tbody>
		</table>
	)
}

/**
 * Edit component.
 * See https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-edit-save/#edit
 *
 * @returns {Component} Render the edit component
 */
const TableBlockEdit = ( { attributes, setAttributes } ) => {

	const { columns } = attributes;
	const [ headers, setHeaders ] = useState();
	const [ rows, setRows ] = useState( [] );
	const [ limited, setLimited ] = useState( false );

	const blockProps = useBlockProps();

	useEffect( async () => {

		if ( Array.isArray( headers ) ) {
			return;
		}

		const data  = await apiFetch(
			{
				path: '/aa-users-list/v1/table-data'
			}
		)
		.catch(() => {
			return [];
		});

		const rows = data?.data?.rows || null;

		if ( ! rows ) {
			setHeaders([]);
			return;
		}

		setRows( Object.values( rows ) );

		const firstRow = Object.values( rows )[0];
		const newHeaders = Object.keys( firstRow ).map( ( key, i ) => ( { name: key, checked: columns.includes( key ), label: data.data.headers[i] } ) );
		setHeaders( newHeaders );
	} );

	const onChecked = ( checked, name ) => {

		const selectedColumns = columns;

		if ( checked && ! columns.includes( name ) ) {
			selectedColumns.push( name );
		}

		if ( ! checked ) {
			const index = selectedColumns.indexOf( name );
			if ( index > -1 ) {
				selectedColumns.splice( index, 1 );
			}
		}

		setAttributes( { columns: [ ...selectedColumns ] } );
		setLimited( selectedColumns.length <= 3 );
		setHeaders( headers.map( header => {
			return { ...header, checked: selectedColumns.includes( header.name ) };
		} ) );
	}

    return (
		<div { ...blockProps } >
			<InspectorControls>
				<Panel>
					<PanelBody title={__( 'Column Settings', 'aa-userslist' )} initialOpen={ true }>
						<PanelRow>
							<BaseControl label={ __( 'Select table columns', 'aa-userslist' ) }>
								<ul>
								{
									headers && headers.map( ( header, index ) => {
										return (
											<li key={ index }>
												<CheckboxControl
													label={ header.label }
													checked={ header.checked }
													onChange={ ( state ) => onChecked( state, header.name ) }
													disabled={ limited && header.checked }
												/>
											</li>
										)
									} )
								}
								</ul>
								{ limited && (
									<p><small>{ __( 'Atleast 3 columns needed for the table.', 'aa-userslist' ) }</small></p>
								) }
							</BaseControl>
						</PanelRow>
					</PanelBody>
				</Panel>
			</InspectorControls>
			{  columns && headers && rows && <Table columns={columns} headers={headers} rows={rows} /> }
		</div>
    );
}
export default TableBlockEdit;
