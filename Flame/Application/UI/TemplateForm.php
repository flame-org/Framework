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

	/**
	 * @var string
	 */
	protected $template;

	/**
	 * @return string
	 */
	protected function getTemplateFile()
	{
		$reflection = $this->getReflection();
		return dirname($reflection->getFileName()) . DIRECTORY_SEPARATOR . $reflection->getShortName() . ".latte";
	}

	/**
	 * @return mixed
	 */
	protected function createTemplate()
	{
		return $this->getPresenter()->getTemplate()->setFile($this->getTemplateFile());
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
}
