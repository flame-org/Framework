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

use \Nette\Image;

class ThumbnailsCreator extends \Nette\Object
{

	/**
	 * @var string
	 */
	private $thumbDirUri;

	/**
	 * @var string
	 */
	private $baseDir;


	/**
	 * @param string $thumbDirUri
	 * @param string $baseDir
	 */
	public function __construct($thumbDirUri = 'media/images_thumbnails', $baseDir = WWW_DIR)
	{
		$this->thumbDirUri = $thumbDirUri;
		$this->baseDir = $baseDir;
	}

	/**
	 * @param $origName
	 * @param $width
	 * @param null $height
	 * @return string
	 * @throws \Nette\InvalidArgumentException
	 */
	public function thumb($origName, $width, $height = null)
	{

		if(!$this->baseDir or !$this->thumbDirUri){
			throw new \Nette\InvalidArgumentException('Invalid parameters: ' . get_class($this) . '::$baseDir or $thumbDirUri');
		}

		$thumbDirPath = $this->baseDir . '/' . trim($this->thumbDirUri, '/\\');
		$origPath = $this->baseDir . '/' . $origName;

		$this->createDirForThumbnails($thumbDirPath);

		if (($width === null && $height === null) || !is_file($origPath) || !is_dir($thumbDirPath) || !is_writable($thumbDirPath))
			return $origName;

		$thumbName = $this->getThumbName($origName, $width, $height, filemtime($origPath));
		$thumbUri = trim($this->thumbDirUri, '/\\') . '/' . $thumbName;
		$thumbPath = $thumbDirPath . '/' . $thumbName;

		// miniatura jiz existuje
		if (is_file($thumbPath)) {
			return $thumbUri;
		}


		try {

			$image = Image::fromFile($origPath);

			// zachovani pruhlednosti u PNG
			$image->alphaBlending(false);
			$image->saveAlpha(true);

			$origWidth = $image->getWidth();
			$origHeight = $image->getHeight();

			//crop
//			if($origWidth > $width and $origHeight > $height){
//				$image->crop(0, 0, $width, $height);
//			}else{
//				$image->resize($width, $height,
//					$width !== NULL && $height !== NULL ? Image::STRETCH : Image::FIT)
//					->sharpen();
//			}

			$image->resize($width, $height,
				$width !== null && $height !== null ? Image::STRETCH : Image::FIT)
				->sharpen();


			$newWidth = $image->getWidth();
			$newHeight = $image->getHeight();

			// doslo ke zmenseni -> ulozime miniaturu
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
	private function getThumbName($relPath, $width, $height, $mtime)
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
	private function createDirForThumbnails($filepath)
	{
		if(!file_exists($filepath)) return @mkdir($filepath, 0777, true);
	}

}
