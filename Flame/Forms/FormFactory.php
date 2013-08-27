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

class FormFactory extends Object implements IFormFactory
{

	/** @var \Nette\Localization\ITranslator */
	protected $translator;

	/** @var \Nette\Forms\IFormRenderer */
	protected $renderer;

	/** @var  array */
	protected $processors = array();

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
	public function setProcessor(IFormProcessor $processor = null)
	{
		if($processor !== null) {
			$this->processors[] = $processor;
		}

		return $this;
	}

	/**
	 * @param Form $form
	 */
	protected function attachProcessors(Form &$form)
	{
		if(count($this->processors)) {
			foreach ($this->processors as $processor) {
				/** @var IFormProcessor $processor */
				$processor->attach($form);
			}
		}
	}
}