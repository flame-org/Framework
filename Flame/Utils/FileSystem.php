<?php
/**
 * Class FileSystem
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 10.08.13
 */
namespace Flame\Utils;

use Nette\InvalidStateException;
use Nette\Object;

class FileSystem extends Object
{

	/**
	 * @param $file
	 * @param bool $need
	 * @return string
	 * @throws \Nette\InvalidStateException
	 */
	public static function read($file, $need = true)
	{
		if (false === ($contents = @file_get_contents($file)) && $need) {
			throw new InvalidStateException('File "' . $file . '" is not readable.');
		}

		return $contents;
	}

} 