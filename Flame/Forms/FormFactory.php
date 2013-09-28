<?php
/**
 * Class FormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Forms;

use Flame\Application\UI\Form;
use Flame\Application\UI\TemplateForm;
use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;
use Nette\Object;

class FormFactory extends Object implements IFormFactory
{

	/** @var \Nette\Localization\ITranslator */
	private $translator;

	/** @var \Nette\Forms\IFormRenderer */
	private $renderer;

	/** @var  array|IFormProcessor[] */
	private $processors = array();

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

	/**
	 * Set form processor
	 *
	 * @param IFormProcessor $processor
	 * @return $this
	 */
	public function addProcessor(IFormProcessor $processor = null)
	{
		if($processor !== null) {
			$this->processors[] = $processor;
		}

		return $this;
	}

	/**
	 * Create base Form
	 *
	 * @return \Flame\Application\UI\Form
	 */
	public function createForm()
	{
		return $this->initForm(new Form);
	}

	/**
	 * Create base Form with template
	 *
	 * @return \Flame\Application\UI\TemplateForm
	 */
	public function createTemplateForm()
	{
		return $this->initForm(new TemplateForm);
	}

	/**
	 * @param Form $form
	 * @return Form
	 */
	private function initForm(Form &$form)
	{
		$form->setTranslator($this->translator);

		if($this->renderer !== null) {
			$form->setRenderer($this->renderer);
		}

		foreach ($this->processors as $processor) {
			$processor->attach($form);
		}

		return $form;
	}
}