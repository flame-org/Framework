<?php

// absolute filesystem path to this web root
define('WWW_DIR', __DIR__);
define('APP_DIR', WWW_DIR . '/../app');
define('LIBS_DIR', WWW_DIR . '/../vendor');

// uncomment this line if you must temporarily take down your site for maintenance
// require APP_DIR . '/templates/maintenance.phtml';

require APP_DIR . '/bootstrap.php';

// Configure and run the application!
$container->application->run();
