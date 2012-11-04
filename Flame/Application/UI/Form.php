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

use Nette\Forms\Rules;

class Form extends \Nette\Application\UI\Form
{

	/**
	 * @param \Nette\ComponentModel\IContainer|null $parent
	 * @param null $name
	 */
	public function __construct(\Nette\ComponentModel\IContainer $parent = null,  $name = null)
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
			$this::IMAGE => 'You can upload only JPEG, GIF or PNG files.'
		);

		$this->addExtension('addDatePicker', '\Flame\Forms\Controls\DatePicker');
	}

	/**
	 * @param array $items
	 * @param string $filter
	 * @return array
	 */
	protected function prepareForFormItem(array &$items, $filter = 'name')
	{
		if(count($items)){
			$prepared = array();
			foreach($items as $item){
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
		\Nette\Forms\Container::extensionMethod($name, function (\Nette\Forms\Container $container, $name, $label = null) use ($class){
			return $container[$name] = new $class($label);
		});
	}

	/**
	 * Fires send/click events.
	 * @author Filip Procházka (filip.prochazka@kdyby.org)
	 * @return void
	 */
	public function fireEvents()
	{
		if (!$this->isSubmitted()) {
			return;

		} elseif ($this->isSubmitted() instanceof ISubmitterControl) {
			if (!$this->isSubmitted()->getValidationScope() || $this->isValid()) {
				$this->dispatchEvent($this->isSubmitted()->onClick, $this->isSubmitted());
				$valid = true;

			} else {
				$this->dispatchEvent($this->isSubmitted()->onInvalidClick, $this->isSubmitted());
			}
		}

		if (isset($valid) || $this->isValid()) {
			$this->dispatchEvent($this->onSuccess, $this);

		} else {
			$this->dispatchEvent($this->onError, $this);
		}
	}

	/**
	 * @author Filip Procházka (filip.prochazka@kdyby.org)
	 * @param array|\Traversable $listeners
	 * @param mixed $arg
	 */
	protected function dispatchEvent($listeners, $arg = null)
	{
		$args = func_get_args();
		$listeners = array_shift($args);

		foreach ((array)$listeners as $handler) {
			if ($handler instanceof \Nette\Application\UI\Link) {
				if (!$this->isValid()) continue;
				/** @var \Nette\Application\UI\Link $handler */
				$refl = $handler->getReflection();
				/** @var \Nette\Reflection\ClassType $refl */
				$compRefl = $refl->getProperty('component');
				$compRefl->accessible = true;
				/** @var \Nette\Application\UI\PresenterComponent $component */
				$component = $compRefl->getValue($handler);
				$component->redirect($handler->getDestination(), $handler->getParameters());

			} else {
				callback($handler)->invokeArgs($args);
			}
		}
	}

	/**
	 * @param array $defaults
	 */
	public function restore(array $defaults = array())
	{
		$this->setDefaults($defaults, true);
		$this->setValues($defaults, true);
	}

	/**
	 * @param array|\Nette\Forms\Traversable $values
	 * @param bool $erase
	 * @return \Nette\Forms\Container
	 */
	public function setDefaults($values, $erase = false)
	{
		$values = array_map(function ($value){
			if(is_object($value) and (method_exists($value, '__toString'))){
				if(isset($value->id)){
					return (string) $value->id;
				}else{
					return (string) $value;
				}

			}
			return $value;
		}, $values);

		return parent::setDefaults($values, $erase);
	}

}
