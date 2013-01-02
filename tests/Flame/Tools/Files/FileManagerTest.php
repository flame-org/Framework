<?php
/**
 * FileManagerTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    02.01.13
 */

namespace Flame\Tests\Tools\Files;

use org\bovigo\vfs\vfsStream;

class FileManagerTest extends \Flame\Tests\TestCase
{

	/**
	 * @var \org\bovigo\vfs\vfsStream
	 */
	private $root;

	/**
	 * @var \Flame\Tools\Files\FileManager
	 */
	private $fileManager;

	public function setUp()
	{
		$this->root = vfsStream::setup('root');
		$this->fileManager = new \Flame\Tools\Files\FileManager(vfsStream::url('root'));
	}

	public function testProperties()
	{
		$this->assertAttributeEquals(vfsStream::url('root'), 'baseDirPath', $this->fileManager);
		$this->assertAttributeEquals('/media/images', 'filesDirPath', $this->fileManager);

		$this->fileManager->setFilesDir('dir');
		$this->assertAttributeEquals('dir', 'filesDirPath', $this->fileManager);
	}

	public function testSaveFile()
	{
		//TODO
//		vfsStream::create(array('img.jpg' => 'content'));
//		$this->assertTrue($this->root->hasChild('img.jpg'));
//
//		$fileUploadMock = $this->getMockBuilder('Nette\Http\FileUpload')
//			->setConstructorArgs(
//				array(
//					array(
//						'tmp_name' => vfsStream::url('root') . '/img.jpg',
//						'name' => 'img.jpg',
//						'type' => 'jpg',
//						'size' => '567',
//						'error' => 0
//					)
//				)
//			)
//			->getMock();
//
//		$fileUploadMock->expects($this->once())
//			->method('isOk')
//			->will($this->returnValue(true));
//		$fileUploadMock->expects($this->once())
//			->method('move')
//			->with(vfsStream::url('root') . '/media/images/img.jpg');
//
//
//		//THERE IS A BUG - RETURN RANDOM FILE NAME
//		$this->assertEquals('/media/images/img.jpg', $this->fileManager->saveFile($fileUploadMock));
//		$this->assertTrue($this->root->hasChild(vfsStream::url('root') . '/media/images/img.jpg'));

	}

	public function testGetFileType()
	{
		$getFileTypeMethod = $this->getProtectedClassMethod('\Flame\Tools\Files\FileManager', 'getFileType');
		$result = $getFileTypeMethod->invoke($this->fileManager, 'img.jpg');
		$this->assertEquals('jpg', $result);

		$result = $getFileTypeMethod->invoke($this->fileManager, 'img.jpg.jpeg');
		$this->assertEquals('jpeg', $result);

		$result = $getFileTypeMethod->invoke($this->fileManager, '/dir/img_jpg.temp.jpg');
		$this->assertEquals('jpg', $result);
	}

	public function testRemoveFileType()
	{
		$removeFileTypeMethod = $this->getProtectedClassMethod('\Flame\Tools\Files\FileManager', 'removeFileType');
		$result = $removeFileTypeMethod->invoke($this->fileManager, 'file.txt');
		$this->assertEquals('file', $result);

		$removeFileTypeMethod = $this->getProtectedClassMethod('\Flame\Tools\Files\FileManager', 'removeFileType');
		$result = $removeFileTypeMethod->invoke($this->fileManager, '/dir/file_.txt');
		$this->assertEquals('/dir/file_', $result);

		$removeFileTypeMethod = $this->getProtectedClassMethod('\Flame\Tools\Files\FileManager', 'removeFileType');
		$result = $removeFileTypeMethod->invoke($this->fileManager, '/dir/file_.txt.temp');
		$this->assertEquals('/dir/file_.txt', $result);
	}

	public function testGetFileName()
	{
		$getFileNameMethod = $this->getProtectedClassMethod('\Flame\Tools\Files\FileManager', 'getFileName');
		$result = $getFileNameMethod->invoke($this->fileManager, '/dir/file.txt');
		$this->assertEquals('file.txt', $result);

		$getFileNameMethod = $this->getProtectedClassMethod('\Flame\Tools\Files\FileManager', 'getFileName');
		$result = $getFileNameMethod->invoke($this->fileManager, '/dir/file.txt/img.jpg');
		$this->assertEquals('img.jpg', $result);

		$getFileNameMethod = $this->getProtectedClassMethod('\Flame\Tools\Files\FileManager', 'getFileName');
		$result = $getFileNameMethod->invoke($this->fileManager, 'file.txt');
		$this->assertEquals('file.txt', $result);
	}

	public function testGetAbsolutePath()
	{
		$getAbsolutePathMethod = $this->getProtectedClassMethod('\Flame\Tools\Files\FileManager', 'getAbsolutePath');
		$result = $getAbsolutePathMethod->invoke($this->fileManager);
		$this->assertEquals(vfsStream::url('root') . '/media/images', $result);
	}

	public function testDownloadFile()
	{
		//TODO
//		vfsStream::create(array('file.txt' => 'content'));
//		$this->assertTrue($this->root->hasChild('file.txt'));
//		$this->assertNotEquals(false, $this->fileManager->downloadFile(vfsStream::url('root') . '/file.txt'));
//		//Return false instead of true
//		$this->assertTrue($this->root->hasChild(vfsStream::url('root') . '/media/images/file.txt'));
	}
}
