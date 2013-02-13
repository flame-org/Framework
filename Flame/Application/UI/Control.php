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

	protected function createTemplate($class = null)
	{
		$presenter = $this->getPresenter(FALSE);
		$template = $presenter->getContext()->getService('nette.template')->create($class);

		if ($template instanceof \Nette\Templating\FileTemplate)
			$template->setFile($this->getTemplateFile());

		$template->onPrepareFilters[] = $this->templatePrepareFilters;

		// default parameters
		$template->control = $template->_control = $this;
		$template->flashes = array();
		if ($presenter instanceof Presenter && $presenter->hasFlashSession()) {
			$id = $this->getParameterId('flash');
			$template->flashes = (array) $presenter->getFlashSession()->$id;
		}

		return $template;
	}

	/**
	 * Descendant can override this method to customize template compile-time filters.
	 * @param  Nette\Templating\Template
	 * @return void
	 */
	public function templatePrepareFilters($template)
	{

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
