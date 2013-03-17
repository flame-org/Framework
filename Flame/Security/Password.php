<?php
/**
 * Password.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    17.03.13
 */

namespace Flame\Security;

class Password extends \Nette\Object
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
	 * @return Password
	 */
	public function createRandom()
	{
		$this->password = \Nette\Utils\Strings::random();
		$this->object = new \Flame\Types\Password;
		$this->object->setPassword($this->password);
		return $this;
	}

}
