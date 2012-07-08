<?php

use Nette\Application\Routers\Route,
	Nette\Application\Routers\RouteList,
    Nette\Config\Configurator;

require_once LIBS_DIR . '/autoload.php';
require_once LIBS_DIR . '/nette/nette/Nette/loader.php';

$configurator = new Configurator();
//$configurator->setDebugMode($configurator::AUTO);
//$configurator->setDebugMode(TRUE);
//$configurator->setProductionMode(FALSE);
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()->addDirectory(APP_DIR)->register();
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();

$container->router[] = new Route('index.php', 'Front:Homepage:default', Route::ONE_WAY);

$container->router[] = $adminRouter = new RouteList('Admin');
	$adminRouter[] = new Route('admin/<presenter>/<action>[/<id>]', 'Dashboard:default');

$container->router[] = $frontRouter = new RouteList('Front');
	$frontRouter[] = new Route('<presenter>/<action>[/<id>][/<slug>]', 'Homepage:default');
