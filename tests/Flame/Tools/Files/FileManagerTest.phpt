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

class FileManagerTest extends \Flame\Tests\TestCase
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

	public function testProperties()
	{
		Assert::equal($this->dir, $this->getAttributeValue($this->fileManager, 'baseDirPath'));
		Assert::equal('/media/images', $this->getAttributeValue($this->fileManager, 'filesDirPath'));

		$this->fileManager->setFilesDir('dir');
		Assert::equal('dir', $this->getAttributeValue($this->fileManager, 'filesDirPath'));
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

	/**
	 * @dataProvider fileTypesProvider
	 * @param $expected
	 * @param $filePath
	 */
	public function testGetFileType($expected, $filePath)
	{
		Assert::equal($expected, $this->invokeMethod($this->fileManager, 'getFileType', array($filePath)));

	}

	public function fileTypesProvider()
	{
		return array(
			array('jpg', 'img.jpg'),
			array('jpeg', 'img.jpg.jpeg'),
			array('jpg', '/dir/img_jpg.temp.jpg'),
		);
	}
	/**
	 * @dataProvider removeFileTypeProvider
	 * @param $expected
	 * @param $fileName
	 */
	public function testRemoveFileType($expected, $fileName)
	{
		Assert::equal($expected, $this->invokeMethod($this->fileManager, 'removeFileType', array($fileName)));
	}

	public function removeFileTypeProvider()
	{
		return array(
			array('file', 'file.txt'),
			array('/dir/file_', '/dir/file_.txt'),
			array('/dir/file_.txt', '/dir/file_.txt.temp')
		);
	}

	/**
	 * @dataProvider getFileNameProvider
	 * @param $expected
	 * @param $filePath
	 */
	public function testGetFileName($expected, $filePath)
	{
		Assert::equal($expected, $this->invokeMethod($this->fileManager, 'getFileName', array($filePath)));
	}

	/**
	 * @return array
	 */
	public function getFileNameProvider()
	{
		return array(
			array('file.txt', '/dir/file.txt'),
			array('img.jpg', '/dir/file.txt/img.jpg'),
			array('file.txt', 'file.txt')
		);
	}

	public function testGetAbsolutePath()
	{
		Assert::equal($this->dir . '/media/images', $this->invokeMethod($this->fileManager, 'getAbsolutePath'));
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

run(new FileManagerTest);
