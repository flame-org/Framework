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

use Nette\Image;
use Flame\Tools\Files\FileSystem;
use Nette\InvalidArgumentException;

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
	public function __construct($baseDir, $thumbDirUri = '/media/images_thumbnails')
	{
		$this->baseDir = (string) $baseDir;
		$this->thumbDirUri = (string) $thumbDirUri;
	}

	/**
	 * @param $imagePath
	 * @param $width
	 * @param null $height
	 * @param null $flags
	 * @return string
	 * @throws \Nette\InvalidArgumentException
	 */
	public function thumb($imagePath, $width, $height = null, $flags = null)
	{

		$thumbDirPath = $this->getThumbDirPath();
		$origPath = $this->getAbsPathToImage($imagePath);

		FileSystem::mkDir($thumbDirPath);

		if(($width === null && $height === null)){
			throw new InvalidArgumentException('Width of image must be set');
		}elseif(!is_dir($thumbDirPath) || !is_writable($thumbDirPath)){
			throw new InvalidArgumentException('Folder ' . $thumbDirPath . ' does not exist or is not writable');
		}elseif(!file_exists($origPath)){
			return $imagePath;
		}

		$thumbName = $this->getThumbName($imagePath, $width, $height, filemtime($origPath));
		$thumbUri = $this->thumbDirUri . DIRECTORY_SEPARATOR . $thumbName;
		$thumbPath = $thumbDirPath . DIRECTORY_SEPARATOR . $thumbName;

		if(file_exists($thumbPath)){
			return $thumbUri;
		}else{

			try {
				$image = Image::fromFile($origPath);
				$image->alphaBlending(false);
				$image->saveAlpha(true);

				$origWidth = $image->getWidth();
				$origHeight = $image->getHeight();

				if($flags === null)
					$flags = ($width !== null && $height !== null) ? Image::STRETCH : Image::FIT;

				$image->resize($width, $height, $flags)->sharpen();

				$newWidth = $image->getWidth();
				$newHeight = $image->getHeight();

				if ($newWidth !== $origWidth || $newHeight !== $origHeight) {
					$image->save($thumbPath);
					return $thumbUri;
				} else {
					return $imagePath;
				}
			}catch (\Exception $ex){
				return $imagePath;
			}
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
		$relPath = implode($sep, $tmp);
		$relPath .= $width . 'x' . $height . '-' . $mtime;
		$relPath = md5($relPath) . $sep . $ext;
		return $relPath;
	}

	/**
	 * @return string
	 */
	protected function getThumbDirPath()
	{
		return $this->baseDir . $this->thumbDirUri;
	}

	/**
	 * @param $relativePath
	 * @return string
	 */
	protected function getAbsPathToImage($relativePath)
	{
		if(\Nette\Utils\Strings::startsWith($relativePath, DIRECTORY_SEPARATOR)){
			return $this->baseDir . $relativePath;
		}else{
			return $this->baseDir . DIRECTORY_SEPARATOR . $relativePath;
		}

	}

}
