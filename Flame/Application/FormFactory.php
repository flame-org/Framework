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

abstract class FormFactory extends \Nette\Object implements IFormFactory
{
	/**
	 * @var \Nette\Application\UI\Form
	 */
	protected $form;

	/**
	 * @return \Nette\Application\UI\Form
	 * @throws \Nette\InvalidStateException
	 */
	public function createForm()
	{

		if(!$this->form instanceof \Nette\Application\UI\Form){
			throw new \Nette\InvalidStateException(__CLASS__ . '::$form must be instance of \Nette\Application\UI\Form. ' . gettype($this->form) . ' given.');
		}

		return $this->form;
	}
}
