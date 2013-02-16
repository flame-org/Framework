<?php
/**
 * Control
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Application\UI;

abstract class Control extends \Nette\Application\UI\Control
{
	
	public function render()
	{
		$this->beforeRender();
		$this->template->render();
	}

	protected function beforeRender()
	{

	}

	/**
	 * @param null $class
	 * @return \Nette\Templating\FileTemplate|\Nette\Templating\ITemplate
	 */
	protected function createTemplate($class = null)
	{
		$presenter = $this->getPresenter(false);
		$context = $presenter->getContext();
		$template = $context->getService('nette.template')->create($class);

		if (file_exists($file = $this->getTemplateFile()))
			$template->setFile($file);

		// default parameters
		$template->currentUrl = $context->getByType('\Nette\Http\IRequest')->getUrl();
		$template->control = $template->_control = $this;
		$template->flashes = array();
		if ($presenter instanceof Presenter && $presenter->hasFlashSession()) {
			$id = $this->getParameterId('flash');
			$template->flashes = (array) $presenter->getFlashSession()->$id;
		}

		return $template;
	}

	/**
	 * @return string
	 */
	protected function getTemplateFile()
	{
		$reflection = $this->getReflection();
		return dirname($reflection->getFileName()) . DIRECTORY_SEPARATOR . $reflection->getShortName() . '.latte';
	}
}
