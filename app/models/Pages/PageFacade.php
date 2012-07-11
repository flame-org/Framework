<?php
/**
 * PageFacade
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    09.07.12
 */

namespace Flame\Models\Pages;

use Flame\Models\Pages;

class PageFacade
{
    private $repository;

    private $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('\Flame\Models\Pages\Page');
    }

    public function getOne($id)
    {
        return $this->repository->getOne($id);
    }

    public function getLastPages($limit = null)
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

    public function persist(Page $page)
    {
        $this->entityManager->persist($page);
        $this->entityManager->flush();
        return $this;
    }

    public function delete(Page $page)
    {
        $this->entityManager->remove($page);
        $this->entityManager->flush();
        return $this;
    }
}
