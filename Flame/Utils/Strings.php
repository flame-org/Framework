<?php
/**
 * Strings.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    23.01.13
 */

namespace Flame\Utils;

class Strings extends \Nette\Utils\Strings
{

	/**
	 * @param $s
	 * @param $delimiter
	 * @return mixed
	 */
	public static function getLastPiece($s, $delimiter)
	{
		if (static::contains($s, $delimiter)) {
			$lastOne = strrchr($s, $delimiter);
			$lastOne = str_replace($delimiter, '', $lastOne);
			return $lastOne;
		}
	}

	/**
	 * @param $s
	 * @param $delimiter
	 * @param $index
	 * @return mixed
	 */
	public static function getPiece($s, $delimiter, $index)
	{
		if (static::contains($s, $delimiter)) {
			$pieces = explode($delimiter, $s);
			if (isset($pieces[$index]))
				return $pieces[$index];
		}
	}

}
