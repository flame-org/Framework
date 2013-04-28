<?php
/**
 * FileSystemTest.php
 *
 * @testCase \Flame\Tests\Tools\Files\FileSystemTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    02.01.13
 */

namespace Flame\Tests\Tools\Files;

require_once __DIR__ . '/../../bootstrap.php';

use Flame\Tools\Files\FileSystem;
use Tester\Assert;

class FileSystemTest extends \Flame\Tests\TestCase
{

	public function textConstructor()
	{
		Assert::throws(function () {
			$fileSystem = new FileSystem;
		}, '\Flame\StaticClassException');

	}

	public function testRmAndWrite()
	{
		$file = TEMP_DIR . '/test/file.txt';
		Assert::false(file_exists($file));
		FileSystem::write($file, 'content');
		Assert::true(file_exists($file));
		Assert::true(FileSystem::rm($file));
		Assert::false(file_exists($file));
	}

	public function testRemoveNoFile()
	{
		$file = TEMP_DIR . '/test/file.txt';
		Assert::false(file_exists($file));
		Assert::throws(function () use ($file) {
			FileSystem::rm($file);
		}, '\Flame\FileNotWritableException');
	}

	public function testRemoveDir()
	{
		$dir = TEMP_DIR . '/test';
		FileSystem::mkDir($dir);
		Assert::true(file_exists($dir));
		Assert::true(FileSystem::rm($dir));
	}


	public function testRemoveDirWithFiles()
	{
		$dir = TEMP_DIR . '/test';
		$file = $dir . '/file.txt';
		Assert::false(file_exists($file));
		FileSystem::write($file, 'content');
		Assert::true(file_exists($file));
		Assert::throws(function () use ($dir) {
			FileSystem::rm($dir);
		}, '\Flame\DirectoryNotWritableException');
		Assert::true(file_exists($dir));
	}

	protected function tearDown()
	{
		\Tester\Helpers::purge(TEMP_DIR);
	}

}

id(new FileSystemTest())->run();
