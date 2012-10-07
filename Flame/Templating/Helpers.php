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

		$thumb = new \Flame\Utils\ThumbnailsCreator;
		return $thumb->thumb($origName, $width, $height);
	}

}
