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

abstract class Presenter extends AutowirePresenter
{

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

	/**
	 * @param null $class
	 * @return \Nette\Templating\ITemplate
	 */
	protected function createTemplate($class = null)
	{
		$presenter = $this->getPresenter(false);
		$context = $presenter->getContext();
		$template = $context->getService('nette.template')->create($class);

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

}
