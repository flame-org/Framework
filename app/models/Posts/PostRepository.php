<?php
/**
 * PostRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Posts;

class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOne($id)
    {
        return $this->_em->find('\Flame\Models\Posts\Post', $id);
    }
}
