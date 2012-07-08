<?php

define('WWW_DIR', __DIR__);
define('APP_DIR', WWW_DIR . '/../app');
define('LIBS_DIR', WWW_DIR . '/../libs');

//require APP_DIR . '/bootstrap.php';

require WWW_DIR . '/UnitTestCase.php';
require WWW_DIR . '/IntegrationTestCase.php';
require WWW_DIR . '/SeleniumTestCase.php';