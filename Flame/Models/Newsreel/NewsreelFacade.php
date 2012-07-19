<?php

namespace Flame\Models\Newsreel;

class NewsreelFacade extends \Nette\Object
{
	private $repository;

	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->repository = $entityManager->getRepository('\Flame\Models\Newsreel\Newsreel');
	}

	public function getOne($id)
	{
		return $this->repository->findOneById($id);
	}

	public function getLastNewsreel()
	{
		return $this->repository->findBy(array(), array('id' => 'DESC'));
	}

    public function getLastPassedNewsreel($limit = null)
    {
        return $this->repository->findAllPassed($limit);
    }

    public function persist(Newsreel $newsreel)
    {
        return $this->repository->save($newsreel);
    }

    public function delete(Newsreel $newsreel)
    {
        return $this->repository->delete($newsreel);
    }

	public function increaseHit(Newsreel $newsreel)
	{
		$newsreel->setHit($newsreel->getHit() + 1);
		return $this->persist($newsreel);
	}
}
