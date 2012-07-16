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
	public function __construct()
	{
		parent::__construct();
	}

	protected function prepareForFormItem(array &$items)
	{
		if(count($items)){
			$prepared = array();
			foreach($items as $item){
				$prepared[$item->id] = $item->name;
			}
			return $prepared;
		}
	}
}
