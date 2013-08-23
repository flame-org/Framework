<?php
/**
 * Class FormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Application;

use Flame\Application\UI\Form;
use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;
use Nette\Object;

class FormFactory extends Object implements IFormFactory
{

	/** @var \Nette\Localization\ITranslator */
	private $translator;

	/** @var \Nette\Forms\IFormRenderer */
	private $renderer;

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
		return $form;
	}

	/**
	 * Set translate adapter
	 *
	 * @param ITranslator $translator
	 * @return $this
	 */
	public function setTranslator(ITranslator $translator = null)
	{
		$this->translator = $translator;
		return $this;
	}

	/**
	 * Sets form renderer
	 *
	 * @param IFormRenderer $renderer
	 * @return $this
	 */
	public function setRenderer(IFormRenderer $renderer = null)
	{
		$this->renderer = $renderer;
		return $this;
	}
}