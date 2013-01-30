<?php
/**
 * MockTestCase.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    30.01.13
 */

namespace Flame\Tests;

abstract class MockTestCase extends \Flame\Tests\TestCase
{

	/**
	 * @var \Mockista\Registry
	 */
	protected $mockista;

	protected function setUp()
	{
		$this->mockista = new \Mockista\Registry();
	}

	protected function tearDown()
	{
		$this->mockista->assertExpectations();
	}
}
