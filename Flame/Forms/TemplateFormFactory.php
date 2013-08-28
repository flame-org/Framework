<?php
/**
 * Class TemplateFormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Forms;

use Flame\Application\UI\TemplateForm;

class TemplateFormFactory extends Factory implements ITemplateFormFactory
{

	/** @var  string */
	protected $templateFile;

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
		$this->attachProcessors($form);
		return $form;
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