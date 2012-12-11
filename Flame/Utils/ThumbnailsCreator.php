<?php
/**
 * ThumbnailsCreator.php
 *
 * @author  uestla
 * @package Flame
 *
 * @date    02.08.12
 */

namespace Flame\Utils;

use Nette\Image;

abstract class ThumbnailsCreator extends \Nette\Object
{

	/** @var string */
	public static $thumbDirUri = 'thumbs';

	/**
	 * @param $origName
	 * @param $width
	 * @param null $height
	 * @return string
	 */
	public static function thumb($origName, $width, $height = null)
	{

		$thumbDirPath = WWW_DIR . '/' . trim(static::$thumbDirUri, '/\\');
		$origPath = WWW_DIR . '/' . $origName;

		if(!is_dir($thumbDirPath)) static::createDir($thumbDirPath);
		if (($width === null && $height === null) || !is_file($origPath) || !is_dir($thumbDirPath) || !is_writable($thumbDirPath))
			return $origName;

		$thumbName = static::getThumbName($origName, $width, $height, filemtime($origPath));

		$thumbUri = trim(static::$thumbDirUri, '/\\') . '/' . $thumbName;
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

				if (is_file($thumbPath))
					return $thumbUri;
				else
					return $origName;

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
	protected static function getThumbName($relPath, $width, $height, $mtime)
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
	 * @param $path
	 * @return bool
	 */
	protected static function createDir($path)
	{
		if(!file_exists($path)) return @mkdir($path, 0777, true);
	}

}
