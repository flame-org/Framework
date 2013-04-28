<?php

require __DIR__ . '/../../libs/autoload.php';

if (!class_exists('Tester\Assert')) {
	echo "Install Nette Tester using `composer update --dev`\n";
	exit(1);
}

Tester\Helpers::setup();
date_default_timezone_set('Europe/Prague');

function id($val) {
	return $val;
}

$configurator = new \Flame\Config\Configurator;
$configurator->setDebugMode(FALSE);
$configurator->setTempDirectory(__DIR__ . '/../temp');

return $configurator->createContainer();