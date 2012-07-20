<?php
/**
 * production.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    19.07.12
 */

return array(
	'parameters' => array(
		'database' => array(
			'driver' => 'mysql',
			'host' => $_SERVER['DB1_HOST'],
			'dbname' => $_SERVER['DB1_NAME'],
			'user' => $_SERVER['DB1_USER'],
			'password' => $_SERVER['DB1_PASS'],
		),
	),
);