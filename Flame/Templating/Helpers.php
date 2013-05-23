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

use Nette\Callback;
use Nette\Diagnostics\Debugger;
use Nette\Object;

class Helpers extends Object
{

	/**
	 * @param $helper
	 * @return \Nette\Callback
	 */
	public function loader($helper)
	{
		if (method_exists($this, $helper)) {
			return Callback::create($this, $helper);
		}
	}

	/**
	 * @param $helper
	 * @return \Nette\Callback
	 */
	public static function staticLoader($helper)
	{
		if (method_exists(__CLASS__, $helper)) {
			return Callback::create(__CLASS__, $helper);
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

	/**
	 * @param $var
	 * @return mixed
	 */
	public static function dump($var)
	{
		return Debugger::dump($var);
	}

	/**
	 * @param $string
	 * @return string
	 */
	public static function br($string)
	{
		return nl2br((string)$string);
	}
}
