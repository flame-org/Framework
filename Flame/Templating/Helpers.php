<?php
/**
 * Helpers
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    11.07.12
 */

namespace Flame\Templating;

class Helpers extends \Nette\Object
{

	/**
	 * @param $helper
	 * @return \Nette\Callback
	 */
	public function loader($helper)
	{
		if (method_exists($this, $helper)) {
			return callback($this, $helper);
		}
	}

	/**
	 * @param $origName
	 * @param $width
	 * @param null $height
	 * @return string
	 */
	public function thumb($origName, $width, $height = null)
	{
		$baseDir = (isset($this->imageStorage['baseDir'])) ? $this->imageStorage['baseDir'] : '';
		$thumbDirUri = (isset($this->imageStorage['thumbDir'])) ? $this->imageStorage['thumbDir'] : '';
		$thumb = new \Flame\Utils\ThumbnailsCreator($thumbDirUri, $baseDir);
		return $thumb->thumb($origName, $width, $height);
	}

}
