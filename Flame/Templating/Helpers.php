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
	public static function loader($helper)
	{
		if (method_exists(__CLASS__, $helper)) {
			return new \Nette\Callback(__CLASS__, $helper);
		}
	}

	/**
	 * @param $string
	 * @return string
	 */
	public static function urlencode($string)
	{
		return urlencode($string);
	}

	/**
	 * @param $string
	 * @return string
	 */
	public static function urldecode($string)
	{
		return urldecode($string);
	}

}
