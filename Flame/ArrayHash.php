<?php
/**
 * Class ArrayHash
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 02.08.13
 */
namespace Flame;

use Nette;

class ArrayHash extends Nette\ArrayHash
{

	/**
	 * @param $name
	 * @param bool $need
	 * @return mixed
	 * @throws \Nette\InvalidStateException
	 */
	public function getValue($name, $need = true)
	{
		if(isset($this->$name)) {
			return $this->$name;
		}

		if($need === true) {
			throw new Nette\InvalidStateException('Missing value for key: "' . $name . '"');
		}
	}

} 