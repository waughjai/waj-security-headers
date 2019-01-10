<?php

use PHPUnit\Framework\TestCase;
use WaughJ\WPSecurityHeaders\WPSecurityHeaders;

class WPSecurityHeadersTest extends TestCase
{
	public function testObjectWorks()
	{
		$object = new WPSecurityHeaders();
		$this->assertTrue( is_object( $object ) );
	}
}
