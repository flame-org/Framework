<?php
/**
 * Class TemplateFormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Application;

use Flame\Application\UI\TemplateForm;
use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;
use Nette\Object;

class TemplateFormFactory extends Object implements ITemplateFormFactory
{

	/** @var  string */
	private $templateFile;

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
		$form = new TemplateForm;
		$form->setTranslator($this->translator);
		$form->setRenderer($this->renderer);
		$form->setTemplateFile($this->templateFile);
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
	 * Set file template for Form
	 *
	 * @param string $path
	 * @return $this
	 */
	public function setTemplateFile($path)
	{
		$this->templateFile = (string) $path;
		return $this;
	}
}