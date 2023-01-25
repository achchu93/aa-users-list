<?php
/**
 * Plugin Name:       Users List
 * Description:       A simple users list.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Author:            Ahamed Arshad
 * Author URI:        https://github.com/achchu93/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       aa-userslist
 * Domain Path:       /languages
 *
 * @package AhamedArshad\UsersList
 */

namespace AhamedArshad\UsersList;

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'AA_USERS_LIST_FILE', __FILE__ );

require 'vendor/autoload.php';

UsersList::instance();
