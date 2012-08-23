<?php
/**
 * IModule.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    23.08.12
 */

namespace Flame\Module;

interface IModule
{

	public function getName();

	public function getVersion();

	public function getDescription();

}
