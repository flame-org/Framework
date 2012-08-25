<?php
/**
 * FormFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    24.08.12
 */

namespace Flame\Application;

class FormFactory extends \Nette\Object
{

	/**
	 * @var \Nette\Application\UI\Form
	 */
	protected $form;

	/**
	 * @param array $defautls
	 * @return \Nette\Application\UI\Form
	 * @throws \Nette\InvalidStateException
	 */
	public function createForm(array $defautls = array())
	{

		if(!$this->form instanceof \Nette\Application\UI\Form){
			throw new \Nette\InvalidStateException;
		}

		if(count($defautls)){
			$this->form->configureEdit($defautls);
		}else{
			$this->form->configureAdd();
		}

		return $this->form;
	}
}
