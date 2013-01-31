<?php
/**
 * ThumbnailCreatorTest.php
 *
 * @testCase \Flame\Tests\Templating\Helpers\ThumbnailCreatorTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.01.13
 */

namespace Flame\Tests\Templating\Helpers;

require_once __DIR__ . '/../../bootstrap.php';

use Nette\Image;
use Nette\InvalidArgumentException;
use Tester\Assert;
use Flame\Tools\Files\FileSystem;

class ThumbnailCreatorTest extends \Flame\Tests\TestCase
{

	/**
	 * @var string
	 */
	private $dir;

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
		$this->dir = TEMP_DIR . '/test/ThumbnailCreator';
		$this->thumbnailsCreator = new \Flame\Templating\Helpers\ThumbnailsCreator($this->dir);
	}

	public function testProperties()
	{
		Assert::equal($this->dir, $this->getAttributeValue($this->thumbnailsCreator, 'baseDir'));
		Assert::equal($this->thumbDir, $this->getAttributeValue($this->thumbnailsCreator, 'thumbDirUri'));

		$flags = array(
			'fit' => Image::FIT,
			'fill' => Image::FILL,
			'exact' => Image::EXACT,
			'shrink' => Image::SHRINK_ONLY,
			'stretch' => Image::STRETCH,
		);
		Assert::equal($flags, $this->getAttributeValue($this->thumbnailsCreator, 'flags'));
	}

	/**
	 * @dataProvider flagsProvider
	 */
	public function testFlagsConverter($ex, $width, $height, $flag)
	{
		Assert::equal($ex, $this->invokeMethod($this->thumbnailsCreator, 'flagsConverter', array($width, $height, $flag)));
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
		Assert::equal($this->dir . $this->thumbDir, $this->invokeMethod($this->thumbnailsCreator, 'getThumbDirPath'));
	}

	public function testThumbException()
	{
		Assert::throws(function () {
			$this->thumbnailsCreator->thumb('/image.jpg', null, null);
		}, '\Nette\InvalidArgumentException');
	}

	public function testThumb()
	{
		//TODO: add test of existing thumbnail
		$file = $this->dir . '/image.gif';
		FileSystem::write($file, 'R0lGODlhEAAQANUsAPz6AABEAAB3AEBckvDw8eTk5IOQqtDV3/f39+Xk5OTk5enp6RgxYvHw8f//zBs1Zvr6+jBKfztWjTVQhvv8+9Ta5PHx8DZQhfDx8QqfBtna2TtWjB86a/f29yU/cUBbkypFeJKgu/Hx8dbW1prG5ktnoIYAAMsAABUuXgAAAP9mZv///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAACwALAAAAAAQABAAAAaJQFZpSCyWWEjWwEFqOp+DJGpKrVKTn5V2y11FkZKVYLw6mc2jTfIizgQoJ5XcNJokI6uAvmPq90chSSArIg0iBBYiGCIiCxVmLB4rVARVBghxJyYcKwkKBQkFBQoiEJmaD5NTlSgGB6cmLAwaI7W1C5gqZrFIVq6wScFJAAC7wscpxLzHwSnJx0EAOw%3D%3D');
		Assert::true(file_exists($file));
		$this->thumbnailsCreator->thumb('/image.gif', 56, null);
		Assert::true(file_exists($this->dir . $this->thumbDir));
	}

	public function testGgetAbsPathToImage()
	{
		Assert::equal($this->dir . '/image.jpg', $this->invokeMethod($this->thumbnailsCreator, 'getAbsPathToImage', array('/image.jpg')));
		Assert::equal($this->dir . '/image.jpg', $this->invokeMethod($this->thumbnailsCreator, 'getAbsPathToImage', array('image.jpg')));
	}
}
