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

use Nette;
use Nette\Reflection\Property;

abstract class Presenter extends \Nette\Application\UI\Presenter
{

	/**
	 * @var array
	 */
	private $autowire = array();

	/**
	 * @var Nette\DI\Container
	 */
	private $serviceLocator;

	/**
	 * @param \Nette\DI\Container $dic
	 * @throws \Nette\InvalidStateException
	 * @throws \Nette\DI\MissingServiceException
	 */
	public function injectProperties(Nette\DI\Container $dic)
	{
		$this->serviceLocator = $dic;
		$cache = new Nette\Caching\Cache($this->serviceLocator->getByType('Nette\Caching\IStorage'), 'Presenter.Autowire');
		if (($this->autowire = $cache->load($presenterClass = get_class($this))) === null) {
			$this->autowire = array();

			$rc = $this->getReflection();
			$ignore = class_parents('Nette\Application\UI\Presenter') + array('ui' => 'Nette\Application\UI\Presenter');
			foreach ($rc->getProperties(Property::IS_PUBLIC | Property::IS_PROTECTED) as $prop) {
				if (in_array($prop->getDeclaringClass()->getName(), $ignore) || !$prop->hasAnnotation('autowire')) {
					continue;
				}

				if (!$type = ltrim($prop->getAnnotation('var'), '\\')) {
					throw new Nette\InvalidStateException("Missing annotation @var with typehint on $prop.");
				}

				if (!class_exists($type) && !interface_exists($type)) {
					if (substr($prop->getAnnotation('var'), 0, 1) === '\\') {
						throw new Nette\InvalidStateException("Class \"$type\" was not found, please check the typehint on $prop");
					}

					if (!class_exists($type = $prop->getDeclaringClass()->getNamespaceName() . '\\' . $type) && !interface_exists($type)) {
						throw new Nette\InvalidStateException("Neither class \"" . $prop->getAnnotation('var') . "\" or \"$type\" was found, please check the typehint on $prop");
					}
				}

				if (empty($this->serviceLocator->classes[strtolower($type)])) {
					throw new Nette\DI\MissingServiceException("Service of type \"$type\" not found for $prop.");
				}

				// unset property to pass control to __set() and __get()
				unset($this->{$prop->getName()});
				$this->autowire[$prop->getName()] = array(
					'value' => null,
					'type' => Nette\Reflection\ClassType::from($type)->getName()
				);
			}

			$files = array_map(function ($class) {
				return Nette\Reflection\ClassType::from($class)->getFileName();
			}, array_diff(array_values(class_parents($presenterClass) + array('me' => $presenterClass)), $ignore));

			$cache->save($presenterClass, $this->autowire, array(
				$cache::FILES => $files,
			));

		} else {
			foreach ($this->autowire as $propName => $tmp) {
				unset($this->{$propName});
			}
		}
	}


	/**
	 * @param $name
	 * @param $value
	 * @throws Nette\MemberAccessException
	 */
	public function __set($name, $value)
	{
		if (!isset($this->autowire[$name])) {
			return parent::__set($name, $value);

		} elseif ($this->autowire[$name]['value']) {
			throw new Nette\MemberAccessException("Property \$$name has already been set.");

		} elseif (!$value instanceof $this->autowire[$name]['type']) {
			throw new Nette\MemberAccessException("Property \$$name must be an instance of " . $this->autowire[$name]['type'] . ".");
		}

		return $this->autowire[$name]['value'] = $value;
	}



	/**
	 * @param $name
	 * @throws \Nette\MemberAccessException
	 * @return mixed
	 */
	public function &__get($name)
	{
		if (!isset($this->autowire[$name])) {
			return parent::__get($name);
		}

		if (empty($this->autowire[$name]['value'])) {
			$this->autowire[$name]['value'] = $this->serviceLocator->getByType($this->autowire[$name]['type']);
		}

		return $this->autowire[$name]['value'];
	}

	public function beforeRender()
	{
		parent::beforeRender();

		if($this->isAjax()){
			$this->invalidateControl('flashMessages');
		}
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
