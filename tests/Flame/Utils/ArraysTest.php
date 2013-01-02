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
		$arrays = new Arrays();
	}

	public function testCallNetteArrays()
	{
		$this->assertEquals('test', Arrays::get(array('k' => 'test'), 'k'));
	}

	public function testSortBySubkey()
	{
		$input = array(
			array('order' => 1),
			array('order' => 0),
		);

		$output = array(
			array('order' => 0),
			array('order' => 1)
		);

		$this->assertEquals($output, Arrays::sortBySubkey($input, 'order'));
	}

	public function testSortByProperty()
	{

		$input = array(
			(object) array('order' => 1),
			(object) array('order' => 0),
		);

		$output = array(
			(object) array('order' => 0),
			(object) array('order' => 1)
		);

		$this->assertEquals($output, Arrays::sortByProperty($input, 'order'));

	}

}
