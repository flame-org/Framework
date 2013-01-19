<?php
/**
 * bootstrap.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 *
 * @date    24.12.12
 */

// Load Nette Framework
require __DIR__ . '/../libs/autoload.php';

$configurator = new Flame\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(__DIR__ . '/log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->addParameters(
	array(
		'appDir' => __DIR__,
		'wwwDir' => realpath(__DIR__ . '/../www'),
		'rootDir' => realpath(__DIR__ . '/..')
	)
);
$configurator->createRobotLoader()
	//->addDirectory(__DIR__)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();

return $container;
