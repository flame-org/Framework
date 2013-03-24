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

use Nette\Callback;

/**
 * @property \Nette\Templating\FileTemplate template
 */
abstract class Control extends \Nette\Application\UI\Control
{

	/** @var array */
	public $onBeforeRender = array();

	/**
	 * @return mixed
	 * @throws \Nette\InvalidStateException
	 */
	public function render()
	{
		$params = func_get_args();
		$type = array_shift($params);
		$method = ($type !== null) ? 'render' . ucfirst($type) : 'renderDefault';

		if(count($this->onBeforeRender)){
			foreach($this->onBeforeRender as $callback){
				if($callback instanceof Callback){
					$callback->invokeArgs($params);
				}elseif(is_array($callback) && count($callback)){
					Callback::create($callback)->invokeArgs($params);
				}else{
					throw new \Nette\InvalidStateException('Invalid before render hook callback');
				}
			}
		}

		return Callback::create($this, $method)->invokeArgs($params);
	}

	public function renderDefault()
	{
		$this->template->render();
	}

	/**
	 * @param null $class
	 * @return \Nette\Templating\FileTemplate|\Nette\Templating\ITemplate
	 */
	protected function createTemplate($class = null)
	{
		$presenter = $this->getPresenter(false);
		$context = $presenter->getContext();
		$template = clone $context->getService('nette.template')->create($class);

		if (file_exists($file = $this->getTemplateFile()))
			$template->setFile($file);

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
	 * @return string
	 */
	protected function getTemplateFile()
	{
		$reflection = $this->getReflection();
		return dirname($reflection->getFileName()) . DIRECTORY_SEPARATOR . $reflection->getShortName() . '.latte';
	}
}
