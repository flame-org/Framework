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

	public function testGetLastPiece()
	{
		$s = 'random\string\to\exam';
		$this->assertEquals('exam', Strings::getLastPiece($s, '\\'));
		$this->assertEquals('\exam', Strings::getLastPiece($s, '\\', false));

		$anotherS = ':random:string:';
		$this->assertEquals('', Strings::getLastPiece($anotherS, ':'));
		$this->assertEquals(':', Strings::getLastPiece($anotherS, ':', false));

		$this->assertEquals('', Strings::getLastPiece('hello', 'd', true, false));
	}

	/**
	 * @expectedExcpeption \Nette\InvalidArgumentException
	 */
	public function testNoDelimiterInGetLastPiece()
	{
		Strings::getLastPiece('hello', 'd');
	}

}
