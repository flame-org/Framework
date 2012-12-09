<?php
/**
 * Assets.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    09.12.12
 */

namespace Flame\Utils;

class Assets extends \Nette\Object
{

	/**
	 * @param $path
	 * @return null
	 */
	public static function getFileNameFromPath($path)
	{
		$pieces = explode('/', $path);
		$index = count($pieces) - 1;
		return (isset($pieces[$index]) ? $pieces[$index] : null);
	}

	/**
	 * @param $name
	 * @return mixed
	 */
	public static function getCssFileNameFromLess($name)
	{
		return str_replace('less', 'css', $name);
	}

	/**
	 * @param $content
	 * @return mixed
	 */
	public static function compressString($content)
	{
		return str_replace('; ',';',str_replace(' }','}',str_replace('{ ','{',str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),"",preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$content)))));
	}

}
