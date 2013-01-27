<?php
/**
 * Compiler.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    27.01.13
 */

namespace Flame\Config;

use Nette;

class Compiler extends \Nette\Config\Compiler
{

	/**
	 * @throws \Nette\InvalidStateException
	 */
	public function processServices()
	{
		$this->parseServices($this->container, $this->config);

		foreach ($this->extensions as $name => $extension) {
			if (isset($this->config[$name])) {
				$this->parseServices($this->container, $this->config[$name], $name);
			}
		}

		foreach ($this->container->getDefinitions() as $name => $def) {
			if ($def->shared || !$def->factory || !is_string($def->factory->entity) || !interface_exists($def->factory->entity)) {
				continue;
			}

			$factoryType = Nette\Reflection\ClassType::from($def->factory->entity);
			if (!$factoryType->hasMethod('create')) {
				throw new Nette\InvalidStateException("Method $factoryType::create() in factory of '$name' must be defined.");
			}

			$factoryMethod = $factoryType->getMethod('create');
			if ($factoryMethod->isStatic()) {
				throw new Nette\InvalidStateException("Method $factoryMethod in factory of '$name' must not be static.");
			}

			$returnType = $factoryMethod->getAnnotation('return');
			if ($returnType && !class_exists($returnType)) {
				if ($returnType[0] !== '\\') {
					$returnType = $factoryType->getNamespaceName() . '\\' . $returnType;
				}
				if (!class_exists($returnType)) {
					throw new Nette\InvalidStateException("Please use a fully qualified name of class in @return annotation at $factoryMethod method. Class '$returnType' cannot be found.");
				}
			}

			if ($def->class === $def->factory->entity) {
				$def->class = null;
			}

			if (!$def->class) {
				if (!$returnType) {
					throw new Nette\InvalidStateException("Method $factoryMethod has no @return annotation.");

				} else {
					$def->class = $returnType;
				}

			} elseif ($returnType !== $def->class) {
				throw new Nette\InvalidStateException("Method $factoryMethod claims in @return annotation, that it returns instance of '$returnType', but factory definition demands '$def->class'.");
			}

			if (!$def->parameters && !$def->factory->arguments) {
				$createdClassConstructor = Nette\Reflection\ClassType::from($def->class)->getConstructor();
				foreach ($factoryMethod->getParameters() as $parameter) {
					$paramDef = ($parameter->getClassName() ? $parameter->getClassName() . ' ' : '') . $parameter->getName();
					foreach ($createdClassConstructor->getParameters() as $argument) {
						if ($parameter->getName() !== $argument->getName()) {
							continue;
						} elseif (($parameter->getClassName() || $argument->getClassName()) && $parameter->getClassName() !== $argument->getClassName()) {
							throw new \Nette\InvalidStateException("Argument $argument type hint doesn't match $parameter type hint.");
						} else {
							$def->parameters[] = $paramDef;
							$def->factory->arguments[$argument->position] = '%' . $argument->getName() . '%';
						}
					}
				}
			}

			$def->setCreates($def->class, $def->factory->arguments);
			$def->class = $def->factory->entity;
			$def->factory = null;
			$def->setShared(true);
		}
	}


}
