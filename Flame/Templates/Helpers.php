<?php
/**
 * Thumbnail
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    11.07.12
 */

namespace Flame\Templates;

class Helpers extends \Nette\Object
{

	private $params;

	public function __construct(array $params = array())
	{
		$this->params = $params;
	}

	public function loader($helper)
	{
		if (method_exists($this, $helper)) {
			return callback($this, $helper);
		}
	}

	public function thumb($origName, $width, $height = NULL)
	{
		$thumb = new \Flame\Utils\ThumbnailsCreator($this->params);
		return $thumb->thumb($origName, $width, $height);
	}


}
