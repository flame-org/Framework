<?php
/**
 * Form
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Application\UI;

use Nette\ArrayHash;
use Nette\Forms\Container;

class Form extends \Nette\Application\UI\Form
{

	/** @var int */
	private $id;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return $this
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
		return $this;
	}

	/**
	 * @param bool $asArray
	 * @return array|\Nette\ArrayHash
	 */
	public function getValues($asArray = false)
	{
		$values = (array)parent::getValues($asArray);
		if (!isset($values['id']))
			$values['id'] = $this->getId();

		return ArrayHash::from($values);
	}

	/**
	 * @param array|\Nette\Forms\Traversable $values
	 * @param bool                           $erase
	 * @return \Nette\Forms\Container
	 */
	public function setDefaults($values, $erase = false)
	{

		// Set form ID
		if (isset($values['id'])) {
			$this->setId($values['id']);
		} elseif (isset($values->id)) {
			$this->setId($values->id);
		}

		// Get object to string for values compatibility
		if (is_array($values) and count($values)) {
			$values = array_map(function ($value) {
				if (is_object($value) and (method_exists($value, '__toString'))) {
					if (isset($value->id)) {
						return (string)$value->id;
					} else {
						return (string)$value;
					}

				}

				return $value;
			}, $values);
		}

		return parent::setDefaults($values, $erase);
	}

	/**
	 * @param $name
	 * @param $class
	 */
	protected function addExtension($name, $class)
	{
		Container::extensionMethod($name, function (Container $container, $name, $label = null) use ($class) {
			return $container[$name] = new $class($label);
		});
	}

}
