<?php
/**
 * PageRepository
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    11.07.12
 */

namespace Flame\Models\Pages;

class PageRepository extends \Flame\Doctrine\BaseRepository
{
	public function findLast($limit)
	{
		$qb = $this->entityManager->createQueryBuilder();
		$q = $qb->select('p')
			->from('\Flame\Models\Pages\Page', 'p')
			->orderBy('p.id', 'DESC');

		if($limit){
			$q->setMaxResults((int)$limit);
		}

		return $q->getQuery()->getResult();
	}
}
