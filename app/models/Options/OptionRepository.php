<?php
/**
 * OptionRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Options;

class OptionRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOne($id)
    {
        return $this->_em->find('\Flame\Models\Options\Option', $id);
    }
}
