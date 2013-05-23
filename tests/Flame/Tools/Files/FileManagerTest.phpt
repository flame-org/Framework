<?php
/**
 * FileManagerTest.php
 *
 * @testCase \Flame\Tests\Tools\Files\FileManagerTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    02.01.13
 */

namespace Flame\Tests\Tools\Files;

require_once __DIR__ . '/../../bootstrap.php';

use Tester\Assert;
use Flame\Tools\Files\FileSystem;

class FileManagerTest extends \Flame\Tester\TestCase
{

	/**
	 * @var \Flame\Tools\Files\FileManager
	 */
	private $fileManager;

	/**
	 * @var stirng
	 */
	private $dir;

	public function setUp()
	{
		$this->dir = TEMP_DIR . '/test/fileManager';
		$this->fileManager = new \Flame\Tools\Files\FileManager($this->dir);
	}

	public function testDownloadFile()
	{
		$file = $this->dir . '/file.txt';
		FileSystem::write($file, 'content');
		Assert::true(file_exists($file));
		$this->fileManager->downloadFile($file);
		Assert::true(file_exists($this->dir . '/media/images/file.txt'));
	}
}

id(new FileManagerTest)->run();
