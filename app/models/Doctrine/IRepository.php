<?php
/**
 * IRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    12.07.12
 */

namespace Flame\Models\Doctrine;

interface IRepository
{
	const NO_FLUSH = true;

	const FLUSH = false;
}
