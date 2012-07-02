<?php

define('WWW_DIR', __DIR__);
define('APP_DIR', WWW_DIR . '/../app');
define('LIBS_DIR', WWW_DIR . '/../libs');
define('DATA_DIR', WWW_DIR . '/../data');

require APP_DIR . '/bootstrap.php';

require WWW_DIR . '/UnitTestCase.php';
#require WWW_DIR . '/IntegrationTestCase.php';
require WWW_DIR . '/SeleniumTestCase.php';