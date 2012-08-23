<?php
/**
 * Module.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package
 *
 * @date    23.08.12
 */

namespace Flame\Module;

abstract class BaseModule extends \Nette\Object implements IModule
{

	/**
	 * @var string
	 */
	protected $name = '';

	/**
	 * @var string
	 */
	protected $versinon = '1';

	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return $this->versinon;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

}
