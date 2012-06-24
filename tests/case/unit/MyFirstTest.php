<?php
/**
 * MyFirstTest
 *
 * @Date: 16-05-2012
 * @author Radim Daniel Panek <rdpanek@gmail.com>
 */

namespace Tests;

/**
 * @group unit
 */
class MyFirstTest extends \NetteTestCase\TestCase
{

	public function setUp()
	{
		parent::setUp();
	}

	public function testFirst()
	{
		$this->assertTrue( TRUE );
	}
}
