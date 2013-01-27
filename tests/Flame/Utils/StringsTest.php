<?php
/**
 * StringsTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    23.01.13
 */

namespace Flame\Tests\Utils;

use Flame\Utils\Strings;

class StringsTest extends \Flame\Tests\TestCase
{

	/**
	 * @dataProvider stringsProviderGetLast
	 */
	public function testGetLastPiece($s, $expected)
	{
		$this->assertEquals($expected, Strings::getLastPiece($s, '/'));
	}

	/**
	 * @dataProvider stringsProviderGetByIndex
	 */
	public function testGetPiece($s, $expected)
	{
		$this->assertEquals($expected, Strings::getPiece($s, '/', 3));
	}

	public function stringsProviderGetLast()
	{
		return array(
			array('random/string/to/exam', 'exam'),
			array('random/string/to/exam ', 'exam '),
			array('/random/string/', '')
		);
	}

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
