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

		use WaughJ\ContentSecurityPolicy\ContentSecurityPolicy;
		use WaughJ\WPSettings\WPToolsSubPage;
		use WaughJ\WPSettings\WPSettingsSection;
		use WaughJ\WPSettings\WPSettingsOption;
		$admin_page = new WPToolsSubPage( 'security-headers', 'Security Headers' );
		$admin_page->submit();
		$easy_headers_section = new WPSettingsSection( $admin_page, 'easy-headers', 'Easy Headers' );
		$easy_headers_option = new WPSettingsOption( $easy_headers_section, 'easy-headers', 'Easy Headers', [ 'input_type' => 'checkbox' ] );

		$csp_section = new WPSettingsSection( $admin_page, 'content-security-policy', 'Content Security Policy' );
		$csp_options = [];
		foreach ( ContentSecurityPolicy::TYPES as $type )
		{
			$csp_options[ $type ] = new WPSettingsOption( $csp_section, "csp-{$type}", $type, [ 'input_type' => 'textarea' ] );
		}

		use WaughJ\SecurityHeaders\SecurityHeaders;
		if ( $easy_headers_option->getOptionValue() )
		{
			SecurityHeaders::setAllAutoPolicies();
		}

		$csp_values = [];
		foreach ( $csp_options as $csp_option_key => $csp_option )
		{
			$value = $csp_option->getOptionValue();
			if ( $value !== '' )
			{
				$csp_values[ $csp_option_key ] = $value;
			}
		}
		$csp = new ContentSecurityPolicy( $csp_values );
		if ( $csp->getHeaderString() !== '' )
		{
			$csp->submit();
		}
	}
