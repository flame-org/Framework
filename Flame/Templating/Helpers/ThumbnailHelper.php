<?php
/**
 * Class ThumbnailHelper
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 05.05.13
 */
namespace Flame\Templating\Helpers;

use Nette\Object;
use Nette\Utils\Strings;
use Nette\Image;

class ThumbnailHelper extends Object
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
	public function __construct($baseDir, $thumbDirUri = '/media/thumbnails')
	{
		$this->baseDir = (string)$baseDir;
		$this->thumbDirUri = (string)$thumbDirUri;
	}

	/**
	 * @param $relPath
	 * @param $width
	 * @param $height
	 * @param $mtime
	 * @param $flag
	 * @return string
	 */
	public function getUniqueName($relPath, $width, $height, $flag, $mtime)
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
	public function getDirPath()
	{
		return $this->baseDir . $this->thumbDirUri;
	}

	/**
	 * @param $relativePath
	 * @return string
	 */
	public function getImagePath($relativePath)
	{
		if (Strings::startsWith($relativePath, DIRECTORY_SEPARATOR) || Strings::endsWith($this->baseDir, DIRECTORY_SEPARATOR)) {
			return $this->baseDir . $relativePath;
		}

		return $this->baseDir . DIRECTORY_SEPARATOR . $relativePath;
	}

	/**
	 * @param $width
	 * @param $height
	 * @param $flag
	 * @return int
	 */
	public function convertFlag($width, $height, $flag)
	{
		if ($flag === null)
			$flag = ($width !== null && $height !== null) ? 'STRETCH' : 'FIT';

		$flag = strtolower((string)$flag);

		return (isset($this->flags[$flag])) ? $this->flags[$flag] : Image::FIT;
	}

	/**
	 * @param $thumbName
	 * @return string
	 */
	public function getUrl($thumbName)
	{
		if (Strings::startsWith($thumbName, '/') || Strings::endsWith($this->thumbDirUri, '/')) {
			return $this->thumbDirUri . $thumbName;
		}

		return $this->thumbDirUri . '/' . $thumbName;
	}
}