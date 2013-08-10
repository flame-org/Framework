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

	/**
	 * @return array
	 */
	public function providerFileNames()
	{
		return array(
			array('style.less', 'style.css'),
			array('style.css', 'style.css'),
			array('style', 'style'),
			array('/path/to/style.less', '/path/to/style.css')
		);
	}

	/**
	 * @dataProvider providerFileExtensions
	 * @param $path
	 * @param $result
	 */
	public function testGetFileExtension($path, $result)
	{
		Assert::equal($result, Files::getFileExtension($path));
	}

	/**
	 * @return array
	 */
	public function providerFileExtensions()
	{
		return array(
			array('style.css', 'css'),
			array('file.fake.txt', 'txt')
		);
	}

}

id(new FilesTest())->run();