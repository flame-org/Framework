<?php

if (@!include __DIR__ . '/../../libs/autoload.php') {
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}

// configure environment
Tester\Helpers::setup();
date_default_timezone_set('Europe/Prague');

// create temporary directory
define('TEMP_DIR', __DIR__ . '/../temp');
Tester\Helpers::purge(TEMP_DIR);

$logDir = __DIR__ . '/../log';
Flame\Tools\Files\FileSystem::mkDir($logDir);
\Nette\Diagnostics\Debugger::$logDirectory = $logDir;
\Nette\Diagnostics\Debugger::$productionMode = false;

if (extension_loaded('xdebug')) {
	xdebug_disable();
	Tester\CodeCoverage\Collector::start(__DIR__ . '/coverage.dat');
}