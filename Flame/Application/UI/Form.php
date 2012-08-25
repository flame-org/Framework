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

class Form extends \Nette\Application\UI\Form
{

	/**
	 * @param \Nette\ComponentModel\IContainer|null $parent
	 * @param null $name
	 */
	public function __construct(\Nette\ComponentModel\IContainer $parent = null,  $name = null)
	{
		parent::__construct($parent, $name);

		$this->addExtensionDatePicker();

		$renderer = $this->getRenderer();
		$renderer->wrappers['control']['.submit'] = 'btn btn-primary';
		$renderer->wrappers['control']['.button'] = 'btn btn-primary';
		$renderer->wrappers['error'] = array('container' => 'div class="alert alert-error"', 'item' => 'h4 class="alert-heading"');

		$this->getElementPrototype()->class[] = 'well';
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

	private function addExtensionDatePicker()
	{
		\Nette\Forms\Container::extensionMethod('addDatePicker', function (\Nette\Forms\Container $container, $name, $label = NULL) {
			return $container[$name] = new \Flame\Utils\DatePicker($label);
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
				$valid = TRUE;

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
	protected function dispatchEvent($listeners, $arg = NULL)
	{
		$args = func_get_args();
		$listeners = array_shift($args);

		foreach ((array)$listeners as $handler) {
			if ($handler instanceof \Nette\Application\UI\Link) {
				/** @var \Nette\Application\UI\Link $handler */
				$refl = $handler->getReflection();
				/** @var \Nette\Reflection\ClassType $refl */
				$compRefl = $refl->getProperty('component');
				$compRefl->accessible = TRUE;
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
}
