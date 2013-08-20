<?php

if (!class_exists('Nette\Config\CompilerExtension')) {
	class_alias('Nette\DI\CompilerExtension', 'Nette\Config\CompilerExtension');
	class_alias('Nette\DI\Compiler', 'Nette\Config\Compiler');
	class_alias('Nette\DI\Helpers', 'Nette\Config\Config\Helpers');
}