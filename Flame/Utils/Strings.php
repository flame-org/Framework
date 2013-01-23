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
	 * @param bool $replace
	 * @return mixed|string
	 * @throws \Nette\InvalidArgumentException
	 */
	public static function getLastPiece($s, $delimiter, $replace = true)
	{
		if(!\Nette\Utils\Strings::contains($s, $delimiter))
			throw new \Nette\InvalidArgumentException('String ' . $s . ' does not contain ' . $delimiter);

		$lastOne = strrchr($s, $delimiter);
		if($replace) $lastOne = str_replace($delimiter, '', $lastOne);
		return $lastOne;
	}

}
