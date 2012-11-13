<?php
/**
 * Strings.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    13.11.12
 */

namespace Flame\Utils;

class Strings extends \Nette\Utils\Strings
{

	/**
	 * @param $name
	 * @return mixed
	 */
	public static function createSlug($name)
	{
		$url = preg_replace('~[^\\pL0-9_]+~u', '-', $name);
		$url = trim($url, "-");
		$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
		$url = strToLower($url);
		$url = preg_replace('~[^-a-z0-9_]+~', '', $url);

		return $url;
	}

}
