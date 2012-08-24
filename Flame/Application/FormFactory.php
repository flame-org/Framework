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
	 * @return mixed
	 */
	public function createForm()
	{
		return $this->form;
	}
}
