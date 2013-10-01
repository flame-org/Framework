<?php
/**
 * Password.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    17.03.13
 */

namespace Flame\Security;

use Nette\Object;
use Nette\Utils\Strings;

class Password extends Object
{

	/** @var string */
	private $password;

	/** @var \Flame\Types\Password */
	private $object;

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return \Flame\Types\Password
	 */
	public function getObject()
	{
		return $this->object;
	}

	/**
	 * @param int $length
	 * @param string $charlist
	 * @return $this
	 */
	public function createRandom($length = 5, $charlist = '0-9a-z')
	{
		$this->password = Strings::random($length, $charlist);
		$this->object = new \Flame\Types\Password;
		$this->object->setPassword($this->password);

		return $this;
	}

}
