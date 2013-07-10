<?php
/**
 * Class Css
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 18.05.13
 */
namespace Flame\Utils;

use Nette\StaticClassException;
use Nette\Object;

class Css extends Object
{

	/**
	 * Static class - cannot be instantiated.
	 *
	 * @throws \Nette\StaticClassException
	 */
	final public function __construct()
	{
		throw new StaticClassException;
	}

	/**
	 * @param $content
	 * @return mixed
	 */
	public static function minify($content)
	{
		return str_replace('; ', ';',
			str_replace(' }', '}',
				str_replace('{ ', '{',
					str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), "",
						preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content))
				)
			)
		);
	}

}