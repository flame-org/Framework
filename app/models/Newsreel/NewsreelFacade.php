<?php

namespace Flame\Models\Newsreel;

class NewsreelFacade
{
	private $repository;

	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->repository = $entityManager->getRepository('\Flame\Models\Newsreel\Newsreel');
	}

	public function getOne($id)
	{
		return $this->repository->findOneBy(array('id' => (int) $id));
	}

	public function getLastNewsreel()
	{
		return $this->repository->findAll();
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
}