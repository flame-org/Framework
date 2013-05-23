<?php
/**
 * FilesTest.php
 *
 * @testCase \Flame\Tests\Utils\FilesTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    25.12.12
 */

namespace Flame\Tests\Utils;

require_once __DIR__ . '/../bootstrap.php';

use Flame\Utils\Files;
use Tester\Assert;

class FilesTest extends \Flame\Tester\TestCase
{

	/**
	 * @dataProvider providerPaths
	 * @param $path
	 * @param $result
	 */
	public function testGetFileNameFromPath($path, $result)
	{
		Assert::equal($result, Files::getFileName($path));
	}

	/**
	 * @return array
	 */
	public function providerPaths()
	{
		return array(
			array('path/to/something/file.jpg', 'file.jpg'),
			array('file.jpg', 'file.jpg'),
			array('/path/to/file.jpg', 'file.jpg'),
			array('', ''),
			array('path/file', 'file'),
		);
	}

	/**
	 * @dataProvider providerFileNames
	 * @param $filename
	 * @param $result
	 */
	public function testModifyType($filename, $result)
	{
		Assert::equal($result, Files::modifyType($filename));
	}

	public function providerFileNames()
	{
		return array(
			array('style.less', 'style.css'),
			array('style.css', 'style.css'),
			array('style', 'style'),
			array('/path/to/style.less', '/path/to/style.css')
		);
	}

}

id(new FilesTest())->run();