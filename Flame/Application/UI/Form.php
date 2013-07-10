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
use Nette\ComponentModel\IContainer;
use Nette\Forms\Rules;
use Nette\Forms\Container;

class Form extends \Nette\Application\UI\Form
{

	/** @var int */
	private $id;

	/**
	 * @param IContainer $parent
	 * @param null $name
	 */
	public function __construct(IContainer $parent = null, $name = null)
	{
		parent::__construct($parent, $name);

		Rules::$defaultMessages = array(
			$this::EQUAL => 'Please enter %s.',
			$this::FILLED => 'Field "%label" is required.',
			$this::MIN_LENGTH => 'Field "%label" must be longer than %d chars.',
			$this::MAX_LENGTH => 'Field "%label" must be shorter than %d chars.',
			$this::LENGTH => 'Value of field "%label" must be longer than %d and shorter than %d chars.',
			$this::EMAIL => 'Field "%label" must be valid email address.',
			$this::URL => 'Field "%label" must be valid URL address.',
			$this::IMAGE => 'You can upload only JPEG, GIF or PNG files.',
			$this::MAX_FILE_SIZE => 'File size must be less than %d KB'
		);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
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
	 * @param array  $items
	 * @param string $filter
	 * @return array
	 */
	protected function prepareForFormItem(array &$items, $filter = 'name')
	{
		if (count($items)) {
			$prepared = array();
			foreach ($items as $item) {
				$prepared[$item->id] = $item->$filter;
			}

			return $prepared;
		}

		return $items;
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
