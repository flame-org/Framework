<?php
/**
 * Class AutowireComponentPresenter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 26.04.13
 */
namespace Flame\Application\UI;

use Nette;

/**
 * @author matej21
 */
class AutowireComponentPresenter extends Presenter
{

	/** @var Nette\DI\Container */
	private $serviceLocatorForFactories;

	/**
	 * @return Nette\DI\Container
	 */
	protected function getServiceLocatorForFactories()
	{
		if ($this->serviceLocatorForFactories === NULL) {
			return $this->getPresenter()->getContext(); // fallback
		}

		return $this->serviceLocatorForFactories;
	}

	/**
	 * @param \Nette\DI\Container $sl
	 * @internal
	 */
	public function injectServiceLocatorForFactories(Nette\DI\Container $sl)
	{
		$this->serviceLocatorForFactories = $sl;
	}

	/**
	 * @param $name
	 * @return Nette\ComponentModel\IComponent
	 * @throws Nette\UnexpectedValueException
	 */
	public function createComponent($name)
	{
		$sl = $this->getServiceLocatorForFactories();
		$ucname = ucfirst($name);
		$method = 'createComponent' . $ucname;
		if ($ucname !== $name && method_exists($this, $method)) {
			$reflection = $this->getReflection()->getMethod($method);
			if($reflection->getName() !== $method) {
				return;
			}
			$parameters = $reflection->parameters;

			$args = array();
			if (($first = reset($parameters)) && !$first->className) {
				$args[] = $name;
			}

			$args = Nette\DI\Helpers::autowireArguments($reflection, $args, $sl);
			$component = call_user_func_array(array($this, $method), $args);
			if (!$component instanceof Nette\ComponentModel\IComponent && !isset($this->components[$name])) {
				throw new Nette\UnexpectedValueException("Method $reflection did not return or create the desired component.");
			}

			return $component;
		}

	}

}