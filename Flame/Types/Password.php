<?php
/**
 * Password.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    05.11.12
 */

namespace Flame\Types;

use Nette\Utils\Strings;

/**
 * @author Filip Procházka <filip@prochazka.su>
 *
 * @property string $salt
 */
class Password extends \Nette\Object
{

	/** @var string */
	const SEPARATOR = '##';

	/** @var string */
	private $value;

	/** @var string */
	private $salt;

	/**
	 * @param string $hash
	 * @param string $salt
	 */
	public function __construct($hash = null, $salt = null)
	{
		$this->value = $hash;
		$this->salt = $salt;
	}

	/**
	 * @param string $salt
	 */
	public function setSalt($salt)
	{
		$this->salt = $salt;
	}

	/**
	 * @return string
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * @return string
	 */
	public function createSalt()
	{
		return $this->salt = Strings::random(5);
	}

	/**
	 * @return string
	 */
	public function getHash()
	{
		return $this->value;
	}

	/**
	 * @param $password
	 * @param null $salt
	 * @return Password
	 */
	public function setPassword($password, $salt = null)
	{
		if ($password === null) {
			$this->value = null;
			$this->salt = null;
			return $this;
		}

		if ($salt !== null) {
			$this->salt = $salt;

		} elseif ($this->salt === null) {
			$this->salt = $this->createSalt();
		}

		$this->value = $this->hashPassword($password, $this->salt);
		return $this;
	}


	/**
	 * @param $password
	 * @param null $salt
	 * @return bool
	 */
	public function isEqual($password, $salt = null)
	{
		if ($salt !== null) {
			$this->salt = $salt;
		}

		return $this->value === $this->hashPassword($password, $this->salt);
	}

	/**
	 * @param string $password
	 * @param string $salt
	 * @return string
	 */
	protected function hashPassword($password, $salt = null)
	{
		return hash('sha512', $salt . self::SEPARATOR . (string)$password);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string)$this->value;
	}

}
