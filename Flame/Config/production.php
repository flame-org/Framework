<?php
/**
 * production.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    28.07.12
 */

if(isset($_SERVER['DB1_HOST'], $_SERVER['DB1_NAME'], $_SERVER['DB1_USER'], $_SERVER['DB1_PASS'])){
	return array(
		'parameters' => array(
			'database' => array(
				'host' => $_SERVER['DB1_HOST'],
				'dbname' => $_SERVER['DB1_NAME'],
				'user' => $_SERVER['DB1_USER'],
				'password' => $_SERVER['DB1_PASS'],
			),
		),
	);
}else{
	return array();
}