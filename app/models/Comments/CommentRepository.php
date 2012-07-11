<?php
/**
 * CommentRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Comments;

class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOne($id)
    {
        return $this->_em->find('\Flame\Models\Comments\Comment', $id);
    }
}
