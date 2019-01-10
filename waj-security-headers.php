<?php
	/*
	Plugin Name:  WAJ Security Headers
	Plugin URI:   https://github.com/waughjai/waj-security-headers
	Description:  Easily set security headers, including content security policies.
	Version:      1.0.0
	Author:       Jaimeson Waugh
	Author URI:   https://www.jaimeson-waugh.com
	License:      GPL2
	License URI:  https://www.gnu.org/licenses/gpl-2.0.html
	Text Domain:  waj-security-headers
	*/

	namespace WaughJ\WPSecurityHeaders
	{
		require_once( 'vendor/autoload.php' );

		require_once( 'src/WPToolsPage.php' );
		use WaughJ\WPToolsPage\WPToolsPage;
		$admin_page = new WPToolsPage( 'security-headers', 'Security Headers' );
		$admin_page->submit();
	}
