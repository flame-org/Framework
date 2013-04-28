<?php
/**
 * StringsTest.php
 *
 * @testCase \Flame\Tests\Utils\StringsTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    23.01.13
 */

namespace Flame\Tests\Utils;

require_once __DIR__ . '/../bootstrap.php';

use Flame\Utils\Strings;
use Tester\Assert;

class StringsTest extends \Flame\Tests\TestCase
{

	/**
	 * @dataProvider stringsProviderGetLast
	 */
	public function testGetLastPiece($s, $expected)
	{
		Assert::equal($expected, Strings::getLastPiece($s, '/'));
	}

	/**
	 * @dataProvider stringsProviderGetByIndex
	 */
	public function testGetPiece($s, $expected)
	{
		Assert::equal($expected, Strings::getPiece($s, '/', 3));
	}

	/**
	 * @return array
	 */
	public function stringsProviderGetLast()
	{
		return array(
			array('random/string/to/exam', 'exam'),
			array('random/string/to/exam ', 'exam '),
			array('/random/string/', '')
		);
	}

	/**
	 * @return array
	 */
	public function stringsProviderGetByIndex()
	{

		return array(
			array('random/string/to/exam', 'exam'),
			array('random/string/to/exam ', 'exam '),
			array('/random/string/', ''),
			array('/string', null),
		);

	}

}

id(new StringsTest())->run();
