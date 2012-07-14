<?php

use Nette\Application\Routers\Route,
	Nette\Application\Routers\RouteList,
    Nette\Config\Configurator;

require_once LIBS_DIR . '/autoload.php';
require_once LIBS_DIR . '/nette/nette/Nette/loader.php';

$configurator = new Configurator();
$configurator->enableDebugger(WWW_DIR . '/../log');
$configurator->setTempDirectory(WWW_DIR . '/../temp');
$configurator->createRobotLoader()->addDirectory(APP_DIR)->register();

if (PHP_SAPI == 'cli') {
    $configurator->setDebugMode(TRUE);
    $configurator->addConfig(__DIR__ . '/Config/config.neon', $configurator::DEVELOPMENT);
}else{
    $configurator->setDebugMode($configurator::AUTO);
    $configurator->addConfig(__DIR__ . '/Config/config.neon');
}
$container = $configurator->createContainer();

$container->router[] = new Route('index.php', 'Front:Homepage:default', Route::ONE_WAY);

$container->router[] = $adminRouter = new RouteList('Admin');
	$adminRouter[] = new Route('admin/<presenter>/<action>[/<id>]', 'Dashboard:default');

$container->router[] = $frontRouter = new RouteList('Front');
	$frontRouter[] = new Route('<presenter>/<action>[/<id>][/<slug>]', 'Homepage:default');
