<?php

use Flame\Config\Configurator;

define('FLAME_DIR', __DIR__ );

if(!defined('NETTE')) die ('You must load Nette loader first');

$configurator = new Configurator();
$configurator->setOptionalParameters();
$configurator->enableDebugger(WWW_DIR . '/log');
$configurator->setTempDirectory(WWW_DIR . '/temp');
$configurator->createRobotLoader()->addDirectory(APP_DIR)->register();
$configurator->addConfig(FLAME_DIR . '/Config/config.neon');
$configurator->setDatabaseParametersFromEnv();
$container = $configurator->createContainer();

$doctrineConfig = $container->getService('EntityManagerConfig');
$doctrineConfig->setSQLLogger(\Flame\Utils\ConnectionPanel::register());

