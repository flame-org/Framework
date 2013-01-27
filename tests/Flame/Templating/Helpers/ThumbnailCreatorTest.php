<?php
/**
 * ThumbnailCreatorTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.01.13
 */

namespace Flame\Tests\Templating\Helpers;

use org\bovigo\vfs\vfsStream;
use Nette\Image;
use Nette\InvalidArgumentException;

class ThumbnailCreatorTest extends \Flame\Tests\TestCase
{

	/**
	 * @var \org\bovigo\vfs\vfsStream
	 */
	private $root;

	/**
	 * @var \Flame\Templating\Helpers\ThumbnailsCreator
	 */
	private $thumbnailsCreator;

	/**
	 * @var string
	 */
	private $thumbDir = '/media/images_thumbnails';


	public function setUp()
	{
		$this->root = vfsStream::setup();
		$this->thumbnailsCreator = new \Flame\Templating\Helpers\ThumbnailsCreator(vfsStream::url('root'));
	}

	public function testProperties()
	{
		$this->assertAttributeEquals(vfsStream::url('root'), 'baseDir', $this->thumbnailsCreator);
		$this->assertAttributeEquals($this->thumbDir, 'thumbDirUri', $this->thumbnailsCreator);

		$flags = array(
			'fit' => Image::FIT,
			'fill' => Image::FILL,
			'exact' => Image::EXACT,
			'shrink' => Image::SHRINK_ONLY,
			'stretch' => Image::STRETCH,
		);
		$this->assertAttributeEquals($flags, 'flags', $this->thumbnailsCreator);
	}

	/**
	 * @dataProvider flagsProvider
	 */
	public function testFlagsConverter($ex, $width, $height, $flag)
	{
		$method = $this->getAccessibleMethod('\Flame\Templating\Helpers\ThumbnailsCreator', 'flagsConverter');
		$this->assertEquals($ex, $method->invoke($this->thumbnailsCreator, $width, $height, $flag));
	}

	public function flagsProvider()
	{
		return array(
			array(Image::FIT, 56, null, null),
			array(Image::FIT, null, 56, null),
			array(Image::STRETCH, 5, 45, null),
			array(Image::EXACT, null, 56, 'exact'),
			array(Image::FIT, null, 56, 'fit'),
			array(Image::FILL, null, 56, 'fill'),
			array(Image::STRETCH, null, 56, 'STRETCH'),
			array(Image::SHRINK_ONLY, null, 56, 'shrink'),
		);
	}

	public function testGetThumbDirPath()
	{
		$method = $this->getAccessibleMethod('\Flame\Templating\Helpers\ThumbnailsCreator', 'getThumbDirPath');
		$this->assertEquals(vfsStream::url('root') . $this->thumbDir, $method->invoke($this->thumbnailsCreator));
	}

	/**
	 * @expectedException \Nette\InvalidArgumentException
	 */
	public function testThumbException()
	{
		$this->thumbnailsCreator->thumb('/image.jpg', null, null);
	}

	public function testThumb()
	{
		vfsStream::create(array('image.jpg' => 'content'));
		$this->assertTrue($this->root->hasChild('image.jpg'));
		$r = $this->thumbnailsCreator->thumb('/image.jpg', 56, null);
		$this->assertTrue($this->root->hasChild('media/images_thumbnails'));
		//$this->assertNotEquals('/image.jpg', $r);
	}

	public function testGgetAbsPathToImage()
	{
		$method = $this->getAccessibleMethod('\Flame\Templating\Helpers\ThumbnailsCreator', 'getAbsPathToImage');
		$this->assertEquals(vfsStream::url('root') . '/image.jpg', $method->invoke($this->thumbnailsCreator, '/image.jpg'));

		$method = $this->getAccessibleMethod('\Flame\Templating\Helpers\ThumbnailsCreator', 'getAbsPathToImage');
		$this->assertEquals(vfsStream::url('root') . '/image.jpg', $method->invoke($this->thumbnailsCreator, 'image.jpg'));
	}
}
