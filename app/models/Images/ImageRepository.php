<?php
/**
 * ImageRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    11.07.12
 */

namespace Flame\Models\Images;

class ImageRepository extends \Doctrine\ORM\EntityRepository
{
	public function getOne($id)
	{
		return $this->_em->find('\Flame\Models\Images\Image', (int) $id);
	}
}
