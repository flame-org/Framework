<?php
/**
 * ThumbnailsCreator.php
 *
 * @author  uestla <http://forum.nette.org/cs/profile.php?id=2325>
 * @package Flame
 *
 * @date    02.08.12
 */

namespace Flame\Templating\Helpers;

use Nette\Image;

class ThumbnailsCreator extends \Nette\Object
{

	/** @var string */
	private $thumbDirUri;

	/** @var string */
	private $baseDir;


	/**
	 * @param string $thumbDirUri
	 * @param string $baseDir
	 */
	public function __construct($baseDir, $thumbDirUri = 'media/images_thumbnails')
	{
		$this->thumbDirUri = (string) $thumbDirUri;
		$this->baseDir = (string) $baseDir;
	}

	/**
	 * @param $origName
	 * @param $width
	 * @param null $height
	 * @return string
	 */
	public function thumb($origName, $width, $height = null)
	{

		$thumbDirPath = $this->baseDir . '/' . trim($this->thumbDirUri, '/\\');
		$origPath = $this->baseDir . '/' . $origName;

		$this->createDir($thumbDirPath);

		if (($width === null && $height === null) || !is_file($origPath) || !is_dir($thumbDirPath) || !is_writable($thumbDirPath))
			return $origName;

		$thumbName = $this->getThumbName($origName, $width, $height, filemtime($origPath));
		$thumbUri = trim($this->thumbDirUri, '/\\') . '/' . $thumbName;
		$thumbPath = $thumbDirPath . '/' . $thumbName;

		if (is_file($thumbPath)) return $thumbUri;

		try {

			$image = Image::fromFile($origPath);
			$image->alphaBlending(false);
			$image->saveAlpha(true);

			$origWidth = $image->getWidth();
			$origHeight = $image->getHeight();

			$image->resize($width, $height,
				$width !== null && $height !== null ? Image::STRETCH : Image::FIT)
				->sharpen();

			$newWidth = $image->getWidth();
			$newHeight = $image->getHeight();

			if ($newWidth !== $origWidth || $newHeight !== $origHeight) {
				$image->save($thumbPath);
				return (is_file($thumbPath)) ? $thumbUri : $origName;
			} else {
				return $origName;
			}

		} catch (Exception $e) {
			\Nette\Diagnostics\Logger::ERROR($e);
			return $origName;
		}
	}


	/**
	 * @param $relPath
	 * @param $width
	 * @param $height
	 * @param $mtime
	 * @return string
	 */
	protected function getThumbName($relPath, $width, $height, $mtime)
	{
		$sep = '.';
		$tmp = explode($sep, $relPath);
		$ext = array_pop($tmp);
		// cesta k obrazku (ale bez pripony)
		$relPath = implode($sep, $tmp);
		// pripojime rozmery a mtime
		$relPath .= $width . 'x' . $height . '-' . $mtime;
		// zahashujeme a vratime priponu
		$relPath = md5($relPath) . $sep . $ext;
		return $relPath;
	}

	/**
	 * @param $filepath
	 * @return bool
	 */
	protected function createDir($filepath)
	{
		if(!file_exists($filepath)) return @mkdir($filepath, 0777, true);
	}

}
