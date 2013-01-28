<?php
/**
 * ArraysTest.php
 *
 * @testCase \Flame\Tests\Utils\ArraysTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    25.12.12
 */

namespace Flame\Tests\Utils;

require_once __DIR__ . '/../bootstrap.php';

use Tester\Assert;
use Flame\Utils\Arrays;

class ArraysTest extends \Flame\Tests\TestCase
{

	public function testConstructor()
	{
		Assert::exception(function (){
			$arrays = new Arrays();
		}, '\Flame\StaticClassException');

	}

	public function testCallNetteArrays()
	{
		Assert::equal('test', Arrays::get(array('k' => 'test'), 'k'));
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

		Assert::equal($output, Arrays::sortBySubkey($input, 'order'));
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

		Assert::equal($output, Arrays::sortByProperty($input, 'order'));
	}

}

run(new ArraysTest());
