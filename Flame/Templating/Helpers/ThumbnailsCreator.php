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

	/** @var array */
	private $flags = array(
		'fit' => Image::FIT,
		'fill' => Image::FILL,
		'exact' => Image::EXACT,
		'shrink' => Image::SHRINK_ONLY,
		'stretch' => Image::STRETCH,
	);

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
	 * @param null $flag
	 * @return string
	 * @throws \Nette\InvalidArgumentException
	 */
	public function thumb($imagePath, $width, $height = null, $flag = null)
	{

		$flag = $this->flagsConverter($width, $height, $flag);

		$thumbDirPath = $this->getThumbDirPath();
		$origPath = $this->getAbsPathToImage($imagePath);

		FileSystem::mkDir($thumbDirPath);

		if(($width === null && $height === null)){
			throw new InvalidArgumentException('Width or height of image must be set');
		}elseif(!is_dir($thumbDirPath) || !is_writable($thumbDirPath)){
			throw new InvalidArgumentException('Folder ' . $thumbDirPath . ' does not exist or is not writable');
		}elseif(!file_exists($origPath)){
			return $imagePath;
		}

		$thumbName = $this->getThumbName($imagePath, $width, $height, $flag, filemtime($origPath));
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

				$image->resize($width, $height, $flag)->sharpen();

				$newWidth = $image->getWidth();
				$newHeight = $image->getHeight();

				if ($newWidth !== $origWidth || $newHeight !== $origHeight) {
					$image->save($thumbPath);
					return $thumbUri;
				} else {
					return $imagePath;
				}
			}catch (\Exception $ex){
				\Nette\Diagnostics\Debugger::log($ex);
				return $imagePath;
			}
		}

	}


	/**
	 * @param $relPath
	 * @param $width
	 * @param $height
	 * @param $mtime
	 * @param $flag
	 * @return string
	 */
	protected function getThumbName($relPath, $width, $height, $flag, $mtime)
	{
		$sep = '.';
		$tmp = explode($sep, $relPath);
		$ext = array_pop($tmp);
		$relPath = implode($sep, $tmp);
		$relPath .= $width . 'x' . $height . '-' . $mtime . '-' . $flag;
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

	/**
	 * @param $width
	 * @param $height
	 * @param $flag
	 * @return int
	 */
	protected function flagsConverter($width, $height, $flag)
	{
		if($flag === null)
			$flag = ($width !== null && $height !== null) ? 'STRETCH' : 'FIT';

		$flag = strtolower((string) $flag);
		return (isset($this->flags[$flag])) ? $this->flags[$flag] : Image::FIT;
	}

}
