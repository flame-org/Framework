<?php
/**
 * Configurator.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.11.12
 */

namespace Flame\Tests;

class Configurator extends \Flame\Config\Configurator
{

	/** @var Configurator */
	private static $configurator;

	public function __construct()
	{
		parent::__construct();

		$this->setDebugMode(true);
		$this->setEnvironment('test');

		static::$configurator = $this;
	}

	/**
	 * @return Configurator
	 */
	public static function getTestsContainer()
	{
		return static::$configurator;
	}

	/**
	 * @param $testsDir
	 * @return Configurator
	 * @throws \Flame\IOException
	 */
	public static function testsInit($testsDir)
	{
		if (!is_dir($testsDir)) {
			throw new \Flame\IOException("Given path is not a directory.");
		}

		// arguments
		$params = array(
			'wwwDir' => $testsDir,
			'appDir' => $testsDir,
			'logDir' => $testsDir . '/log',
			'tempDir' => $testsDir . '/temp',
		);

		// cleanup directories
		if (!Tools\Process::isChild()) {
			Filesystem::cleanDir($params['tempDir'] . '/cache');
			Filesystem::cleanDir($params['tempDir'] . '/classes');
			Filesystem::cleanDir($params['tempDir'] . '/entities');
			Filesystem::cleanDir($params['tempDir'] . '/proxies');
			Filesystem::cleanDir($params['tempDir'] . '/scripts');
			Filesystem::cleanDir($params['tempDir'] . '/dyn');
			Filesystem::rm($params['tempDir'] . '/btfj.dat', false);
		}

		// create container
		return new static($params);
	}

}
