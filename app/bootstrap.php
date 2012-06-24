<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route,
	Nette\Application\Routers\RouteList;;


// Load Nette Framework
require LIBS_DIR . '/nette/Nette/loader.php';

// Configure application
$configurator = new Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
//$configurator->setDebugMode($configurator::AUTO);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();

// Setup router
$container->router[] = new Route('index.php', 'Front:Homepage:default', Route::ONE_WAY);

$container->router[] = $adminRouter = new RouteList('Admin');
	$adminRouter[] = new Route('admin/<presenter>/<action>[/<id>]', 'Dashboard:default');


$container->router[] = $frontRouter = new RouteList('Front');
	$frontRouter[] = new Route('<presenter>/<action>[/<id>][/<slug>]', 'Homepage:default');

// Configure and run the application!
$container->application->run();
