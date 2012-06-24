<?php
/**
 * NetteTestCase
 *
 * @Date: 09-02-2012
 * @Package: NetteTestCase
 * @author RDPanek <rdpanek@gmail.com> { DeveloperHub
 */

namespace NetteTestCase;

use Nette\Application\Routers\Route;

class NetteTestCase
{

	public function getContext()
	{
		\Nette\Diagnostics\Debugger::enable(false);

		// Configure application
		$configurator = new \Nette\Config\Configurator;

		// Enable RobotLoader - this will load all classes automatically
		$configurator->setTempDirectory( TMP_DIR );
		$configurator->createRobotLoader()
			->addDirectory( APP_DIR )
			->addDirectory( LIBS_DIR )
			->addDirectory( TESTS_DIR )
			->register();

		// Vlastni konfiguracni soubor
		$configurator->addConfig( APP_DIR . 'config/config.neon', 'console')

		// Konfiguracni soubor NetteTestCase
		->addConfig( LIBS_DIR . 'NetteTestCase/tests.config.neon', 'console')

		// Konfiguracni soubor testovane aplikace
		->addConfig( TESTS_DIR . 'tests.config.local.neon', 'console');

		$container = $configurator->createContainer();

		// Setup router
		$container->router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
		$container->router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

		return $container;

	}

}
