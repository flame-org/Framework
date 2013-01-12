<?php
/**
 * Configurator.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    21.07.12
 */

namespace Flame\Config;

use Nette;
use Nette\Config\Extensions;
use Nette\Config\Helpers;

class Configurator extends \Nette\Config\Configurator
{

	/**
	 * @param string $containerClass
	 */
	public function __construct($containerClass = 'Flame\DI\Container')
	{
		parent::__construct();

		$this->addParameters(array(
			'container' => array(
				'class' => 'SystemContainer',
				'parent' => $containerClass
			)
		));
	}

	/**
	 * @return \Nette\Config\Compiler
	 */
	protected function createCompiler()
	{
		$compiler = new \Nette\Config\Compiler();
		$compiler->addExtension('php', new Extensions\PhpExtension)
			->addExtension('constants', new Extensions\ConstantsExtension)
			->addExtension('nette', new \Flame\Config\Extensions\NetteExtension)
			->addExtension('extensions', new Extensions\ExtensionsExtension);
		return $compiler;
	}

	protected function buildContainer(& $dependencies = NULL)
	{
		$loader = $this->createLoader();
		$config = array();
		$code = "<?php\n";
		foreach ($this->files as $tmp) {
			list($file, $section) = $tmp;
			$code .= "// source: $file $section\n";
			try {
				if ($section === NULL) { // back compatibility
					$config = Helpers::merge($loader->load($file), $config);
					continue;
				}
			} catch (Nette\Utils\AssertionException $e) {}

			$config = Helpers::merge($loader->load($file, $section), $config);
		}
		$code .= "\n";

		if (!isset($config['parameters'])) {
			$config['parameters'] = array();
		}
		$config['parameters'] = Helpers::merge($config['parameters'], $this->parameters);

		$compiler = $this->createCompiler();
		$this->onCompile($this, $compiler);

		$code .= $compiler->compile(
			$config,
			$this->parameters['container']['class'],
			$config['parameters']['container']['parent']
		);
		$dependencies = array_merge($loader->getDependencies(), $this->parameters['debugMode'] ? $compiler->getContainerBuilder()->getDependencies() : array());
		return $code;
	}
}
