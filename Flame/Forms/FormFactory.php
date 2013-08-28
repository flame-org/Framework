<?php
/**
 * Class FormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Forms;

use Flame\Application\UI\Form;
use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;
use Nette\Object;

class FormFactory extends Factory implements IFormFactory
{

	/**
	 * Create base Form
	 *
	 * @return \Flame\Application\UI\Form
	 */
	public function createForm()
	{
		$form = new Form;
		$form->setTranslator($this->translator);
		$form->setRenderer($this->renderer);
		$this->attachProcessors($form);
		return $form;
	}
}