<?php
/**
 * FormWithTemplate.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    17.07.12
 */

namespace Flame\Application\UI;

class TemplateForm extends Form
{

	/** @var  string */
	private $templatePath;

	/** @var  string */
	protected $template;

	/**
	 * @param string $path
	 * @return $this
	 */
	public function setTemplateFile($path)
	{
		$this->templatePath = (string) $path;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTemplate()
	{
		if (empty($this->template)) {
			$this->template = $this->createTemplate();
		}

		return $this->template;
	}

	public function render()
	{
		// render("begin") or render("end")
		$args = func_get_args();
		if ($args) {
			parent::render($args[0]);
			return;
		}

		$this->getTemplate()->form = $this;
		$this->getTemplate()->render();
	}

	/**
	 * @return string
	 */
	protected function getTemplateFile()
	{
		if($this->templatePath === null) {
			$reflection = $this->getReflection();
			return dirname($reflection->getFileName()) . DIRECTORY_SEPARATOR . $reflection->getShortName() . ".latte";
		}

		return $this->templatePath;
	}

	/**
	 * @return \Nette\Templating\ITemplate
	 */
	protected function createTemplate()
	{
		/** @var \Nette\Templating\ITemplate $template */
		$template = clone $this->getParent()->getTemplate();
		$template->setFile($this->getTemplateFile());
		return $template;
	}
}
