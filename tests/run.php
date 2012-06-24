<?php

/*
 * Spoustec NetteTestCase
 *
 * php tests/run.php
 * @author RDPanek <rdpanek@gmail.com>
 */

// cesta k PHPUnit Frameworku
$dir = "./libs/NetteTestCase/framework/PhpUnit/";

// pridani trid PHPUnit do include path
$paths = scandir( $dir );
$includes = array();
foreach($paths as $path)
{
    if ( !preg_match('/^\./', $path) )
		{
        $includes[] = $dir . $path . '/';
    }
}
set_include_path(implode(PATH_SEPARATOR,$includes).PATH_SEPARATOR.get_include_path());

// zavolani autoloader
require $dir . 'phpunit/PHPUnit/Autoload.php';

// spusteni
PHPUnit_TextUI_Command::main();
