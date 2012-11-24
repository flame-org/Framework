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

	/** @var string */
	private $wwwDir;

	/**
	 * @param $wwwDir
	 */
	public function __construct($wwwDir)
	{
		$this->wwwDir = (string) $wwwDir;
	}

	/**
	 * @param $helper
	 * @return \Nette\Callback
	 */
	public function loader($helper)
	{
		if (method_exists($this, $helper)) {
			return \Nette\Callback::create($this, $helper);
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

		$thumb = new \Flame\Utils\ThumbnailsCreator($this->wwwDir);
		return $thumb->thumb($origName, $width, $height);
	}

}
