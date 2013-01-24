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
	 * @param bool $need
	 * @return mixed|string
	 * @throws \Nette\InvalidArgumentException
	 */
	public static function getLastPiece($s, $delimiter, $replace = true, $need = true)
	{
		if(!\Nette\Utils\Strings::contains($s, $delimiter) and $need)
			throw new \Nette\InvalidArgumentException('String ' . $s . ' does not contain ' . $delimiter);

		$lastOne = strrchr($s, $delimiter);
		if($replace) $lastOne = str_replace($delimiter, '', $lastOne);
		return $lastOne;
	}

}
