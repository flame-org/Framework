<?php
/**
 * FileSystemTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    02.01.13
 */

namespace Flame\Tests\Tools\Files;

use org\bovigo\vfs\vfsStream;
use Flame\Tools\Files\FileSystem;

class FileSystemTest extends \Flame\Tests\TestCase
{

	/**
	 * @var \org\bovigo\vfs\vfsStream
	 */
	private $root;

	public function setUp()
	{
		$this->root = vfsStream::setup('root');
	}

	/**
	 * @expectedException \Flame\StaticClassException
	 */
	public function textConstructor()
	{
		$fileSystem = new FileSystem;
	}

	public function testRemove()
	{
		vfsStream::create(array('someFile.txt' => 'some text'));
		$this->assertTrue(FileSystem::rm(vfsStream::url('root') . '/someFile.txt'));
		$this->assertFalse($this->root->hasChild('someFile.txt'));
	}

	/**
	 * @expectedException \Flame\FileNotWritableException
	 */
	public function testRemoveNoFile()
	{
		$this->assertFalse($this->root->hasChild('file.txt'));
		FileSystem::rm(vfsStream::url('root') . '/file.txt');
	}

	public function testRemoveDir()
	{
		vfsStream::create(array('dir' => array()));
		$this->assertTrue($this->root->hasChild('dir'));
		$this->assertTrue(FileSystem::rm(vfsStream::url('root') . '/dir'));
	}

	/**
	 * @expectedException \Flame\DirectoryNotWritableException
	 */
	public function testRemoveDirWithFiles()
	{
		vfsStream::create(array('dir' => array('file.txt' => 'content')));
		$this->assertTrue($this->root->hasChild('dir/file.txt'));
		FileSystem::rm(vfsStream::url('root') . '/dir');
	}

}
