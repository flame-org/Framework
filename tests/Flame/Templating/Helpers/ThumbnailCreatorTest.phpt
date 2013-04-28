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
	private $thumbDir = '/media/thumbnails';


	public function setUp()
	{
		$this->dir = TEMP_DIR . '/test/ThumbnailCreator';
		$this->thumbnailsCreator = new \Flame\Templating\Helpers\ThumbnailsCreator($this->dir);
	}

	public function testThumbException()
	{
		Assert::throws(function () {
			$this->thumbnailsCreator->thumb('/image.jpg', null, null);
		}, '\Nette\InvalidArgumentException');
	}

	public function testThumb()
	{
		$source = realpath(TEMP_DIR . '/../data/images/apple.jpg');
		Assert::true(file_exists($source));
		$image = $this->dir . '/apple.jpg';
		FileSystem::cp($source, $image);
		Assert::true(file_exists($image));
		$this->thumbnailsCreator->thumb('/apple.jpg', 56, null);
		Assert::true(file_exists($this->dir . $this->thumbDir));
	}
}

id(new ThumbnailCreatorTest())->run();
