<?php
/**
 * Presenter
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Application\UI;

abstract class Presenter extends \Nette\Application\UI\Presenter
{

	public function beforeRender()
	{
		parent::beforeRender();

		if($this->isAjax()){
			$this->invalidateControl('flashMessages');
		}
	}

	/**
	 * @param null $class
	 * @return \Nette\Templating\ITemplate
	 */
	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(\Nette\Callback::create(new \Flame\Templating\Helpers, 'loader'));
		return $template;
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return null
	 */
	protected function getContextParameter($name, $default = null)
	{
		$params = $this->context->getParameters();
		return (isset($params[$name])) ? $params[$name] : $default;
	}

	/**
	 * @return mixed
	 */
	protected function getBaseUrl()
	{
		return $this->getHttpRequest()->url->baseUrl;
	}

	/**
	 * @param $name
	 * @return \Nette\Application\UI\Multiplier|\Nette\ComponentModel\IComponent
	 */
	protected function createComponent($name)
	{
		$method = 'createComponent' . ucfirst($name);
		if (method_exists($this, $method) && \Nette\Reflection\Method::from($this, $method)->hasAnnotation('multiple')) {
			$presenter = $this;
			return new \Nette\Application\UI\Multiplier(function ($id) use ($presenter, $method) {
				$defaultArgs = array($presenter, $id);
				return call_user_func_array(array($presenter, $method), $defaultArgs);
			});
			# in PHP 5.4 factory for multiplied component can be protected
			# return new UI\Multiplier(function ($id) use ($name) {
			#	return $this->$method($this, $id, $this->getDataset($name));
			# });
		}
		return parent::createComponent($name);
	}

}
