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
	 * @return \Nette\ComponentModel\IComponent
	 * @throws \Nette\UnexpectedValueException
	 */
	protected function createComponent($name)
	{
		$ucname = ucfirst($name);
		$method = 'createComponent' . $ucname;
		if ($ucname !== $name && method_exists($this, $method)) {
			$reflection = $this->getReflection()->getMethod($method);
			if($reflection->getName() !== $method) {
				return;
			}
			$class = get_class($this);
			$parameters = $reflection->parameters;

			$args = array();
			if (isset($parameters[0]) and !$parameters[0]->className) {
				$args[] = $name;
			}

			$args = \Nette\DI\Helpers::autowireArguments($reflection, $args, $this->context);
			$component = call_user_func_array(array($this, $method), $args);
			if (!$component instanceof \Nette\ComponentModel\IComponent && !isset($this->components[$name])) {
				throw new \Nette\UnexpectedValueException("Method $class::$method() did not return or create the desired component.");
			}

			return $component;
		}
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
		$template->control = $template->_control = $this;
		$template->flashes = array();
		if ($presenter instanceof Presenter && $presenter->hasFlashSession()) {
			$id = $this->getParameterId('flash');
			$template->flashes = (array) $presenter->getFlashSession()->$id;
		}

		return $template;
	}

}
