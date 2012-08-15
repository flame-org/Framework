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
	 * @param array $defaults
	 */
	public function restore(array $defaults = array())
	{
		$this->setDefaults($defaults, true);
		$this->setValues($defaults, true);
	}
}
