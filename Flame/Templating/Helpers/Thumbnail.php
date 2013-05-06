<?php
/**
 * ThumbnailsCreator.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    02.08.12
 */

namespace Flame\Templating\Helpers;

use Nette\Diagnostics\Debugger;
use Nette\Image;
use Flame\Tools\Files\FileSystem;
use Nette\InvalidArgumentException;
use Nette\Object;

class Thumbnail extends Object
{

	/** @var \Flame\Templating\Helpers\ThumbnailHelper */
	private $helper;

	/**
	 * @param ThumbnailHelper $helper
	 */
	public function __construct(ThumbnailHelper $helper)
	{
		$this->helper = $helper;
	}

	/**
	 * @param      $imagePath
	 * @param      $width
	 * @param null $height
	 * @param null $flag
	 * @return string
	 * @throws \Nette\InvalidArgumentException
	 */
	public function create($imagePath, $width, $height = null, $flag = null)
	{

		$flag = $this->helper->convertFlag($width, $height, $flag);

		$thumbDirPath = $this->helper->getDirPath();
		$origPath = $this->helper->getImagePath($imagePath);

		if (!file_exists($thumbDirPath)) {
			FileSystem::mkDir($thumbDirPath);
		}


		if (($width === null && $height === null)) {
			throw new InvalidArgumentException('Width or height of image must be set');
		} elseif (!is_dir($thumbDirPath) || !is_writable($thumbDirPath)) {
			throw new InvalidArgumentException('Folder ' . $thumbDirPath . ' does not exist or is not writable');
		} elseif (!file_exists($origPath)) {
			return $imagePath;
		}

		$thumbName = $this->helper->getUniqueName($imagePath, $width, $height, $flag, filemtime($origPath));
		$thumbUri = $this->helper->getUrl($thumbName);
		$thumbPath = $thumbDirPath . DIRECTORY_SEPARATOR . $thumbName;

		if (file_exists($thumbPath)) {
			return $thumbUri;
		} else {

			try {
				$image = Image::fromFile($origPath);
				$image->alphaBlending(false);
				$image->saveAlpha(true);

				$origWidth = $image->getWidth();
				$origHeight = $image->getHeight();

				$image->resize($width, $height, $flag)->sharpen();

				$newWidth = $image->getWidth();
				$newHeight = $image->getHeight();

				if ($newWidth !== $origWidth || $newHeight !== $origHeight) {
					$image->save($thumbPath);

					return $thumbUri;
				} else {
					return $imagePath;
				}
			} catch (\Exception $ex) {
				Debugger::log($ex);

				return $imagePath;
			}
		}

	}


}
