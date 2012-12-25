<?php
/**
 * ArraysTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    25.12.12
 */

namespace Flame\Tests\Utils;

use Flame\Utils\Arrays;

class ArraysTest extends \Flame\Tests\TestCase
{

	/**
	 * @expectedException \Flame\StaticClassException
	 */
	public function testConstructor()
	{
		new Arrays();
	}

	public function testCallNetteArrays()
	{
		$this->assertEquals('test', Arrays::get(array('k' => 'test'), 'k'));
	}

	public function testSortBySubkey()
	{
		//TODO
	}

}
