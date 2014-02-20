<?php
/**
 * Class FormProcessor
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Forms;

use Flame\Forms\IFormProcessor;
use Nette\Application\UI\Form;
use Nette\Object;

abstract class FormProcessor extends Object implements IFormProcessor
{

	/**
	 * Attach processor to form
	 *
	 * @param Form $form
	 * @return $this
	 */
	public function attach(Form $form)
	{
		$form->onSubmit[] = $this->submit;
		$form->onSuccess[] = $this->success;
		$form->onError[] = $this->error;
		$form->onValidate[] = $this->validate;
		return $this;
	}

	/**
	 * @param Form $form
	 */
	public function success(Form $form) {}

	/**
	 * @param Form $form
	 */
	public function validate(Form $form) {}

	/**
	 * @param Form $form
	 */
	public function error(Form $form) {}

	/**
	 * @param Form $form
	 */
	public function submit(Form $form) {}

}