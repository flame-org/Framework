<?php
/**
 * UserRepository
 *
 * @author  Jiří Šifalda
 * @package FLame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Users;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOne($id)
    {
        return $this->_em->find('\Flame\Models\Users\User', $id);
    }
}
