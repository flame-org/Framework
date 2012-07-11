<?php
/**
 * NewsreelRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Newsreel;

class NewsreelRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOne($id)
    {
        return $this->_em->find('\Flame\Models\Newsreel\Newsreel', $id);
    }
}
