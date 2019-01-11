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
		use WaughJ\SecurityHeaders\SecurityHeaders;
		use WaughJ\WPSettings\WPToolsSubPage;
		use WaughJ\WPSettings\WPSettingsSection;
		use WaughJ\WPSettings\WPSettingsOption;

		// Create Admin Menu pages.
		$admin_page = new WPToolsSubPage( 'security-headers', 'Security Headers' );
		$admin_page->submit();
		$easy_headers_section = new WPSettingsSection( $admin_page, 'easy-headers', 'Easy Headers' );
		$easy_headers_option = new WPSettingsOption( $easy_headers_section, 'easy-headers', 'Easy Headers', [ 'input_type' => 'checkbox' ] );
		$csp_section = new WPSettingsSection( $admin_page, 'content-security-policy', 'Content Security Policy' );
		$csp_enable_option = new WPSettingsOption( $csp_section, "csp-enable", 'Enable Content Security Policy', [ 'input_type' => 'checkbox' ] );
		$csp_report_only_option = new WPSettingsOption( $csp_section, "csp-report-only", 'Report-Only?', [ 'input_type' => 'checkbox' ] );

		$csp_options = [];
		$csp_unsafe_inline_options = [];
		foreach ( ContentSecurityPolicy::TYPES as $type )
		{
			$csp_options[ $type ] = new WPSettingsOption( $csp_section, "csp-{$type}", $type, [ 'input_type' => 'textarea' ] );
			$csp_unsafe_inline_options[ $type ] = new WPSettingsOption( $csp_section, "csp-unsafe-inline-{$type}", "{$type} unsafe inline?", [ 'input_type' => 'checkbox' ] );
		}

		// Set Easy Headers if checked.
		if ( $easy_headers_option->getOptionValue() )
		{
			SecurityHeaders::setAllAutoPolicies();
		}

		// Set Content Security Policy if checked.
		if ( $csp_enable_option->getOptionValue() )
		{
			$csp_values = [];
			foreach ( $csp_options as $csp_option_key => $csp_option )
			{
				$value = $csp_option->getOptionValue();
				if ( !empty( $value ) )
				{
					$csp_values[ $csp_option_key ] = preg_replace( '/\s+/', ' ', $value );
				}
			}
			$csp = new ContentSecurityPolicy( $csp_values, [ 'report-only' => ( $csp_report_only_option->getOptionValue() == true ) ] );
			foreach ( $csp_options as $csp_option_key => $csp_option )
			{
				if ( $csp_unsafe_inline_options[ $csp_option_key ]->getOptionValue() )
				{
					//$csp = $csp->addUnsafeInline( $csp_option_key );
				}
			}
			$csp->submit();
		}
	}
