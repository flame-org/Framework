<?php
/**
 * Helpers
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    11.07.12
 */

namespace Flame\Templates;

class Helpers extends \Nette\Object
{
	/**
	 * @var array
	 */
	private $params;

	/**
	 * @param array $params
	 */
	public function __construct(array $params = array())
	{
		$this->params = $params;
	}

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
	public function thumb($origName, $width, $height = NULL)
	{
		$thumb = new \Flame\Utils\ThumbnailsCreator($this->params);
		return $thumb->thumb($origName, $width, $height);
	}


}
