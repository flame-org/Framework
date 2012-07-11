<?php

namespace Flame\Models\Newsreel;

class NewsreelFacade
{
	private $repository;

    private $entityManager;

	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
        $this->entityManager = $entityManager;
		$this->repository = $entityManager->getRepository('\Flame\Models\Newsreel\Newsreel');
	}

	public function getOne($id)
	{
		return $this->repository->getOne($id);
	}

	public function getLastNewsreel()
	{
        $qb = $this->entityManager->createQueryBuilder();
        $q = $qb->select('n')
            ->from('\Flame\Models\Newsreel\Newsreel', 'n')
            ->orderBy('n.id', 'DESC');

        return $q->getQuery()->getResult();

	}

    public function getLastPassedNewsreel($limit = null)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $q = $qb->select('n')
            ->from('\Flame\Models\Newsreel\Newsreel', 'n')
            ->where($qb->expr()->lte('n.date', ':date_from'))
            ->orderBy('n.date', 'DESC');

        if($limit){
            $q->setMaxResults((int) $limit);
        }

        return $q->getQuery()
            ->setParameters(array('date_from' => new \DateTime()))
            ->getResult();
    }

    public function persist(Newsreel $newsreel)
    {
        $this->entityManager->persist($newsreel);
        $this->entityManager->flush();
        return $this;
    }

    public function delete(Newsreel $newsreel)
    {
        $this->entityManager->remove($newsreel);
        $this->entityManager->flush();
        return $this;
    }
}