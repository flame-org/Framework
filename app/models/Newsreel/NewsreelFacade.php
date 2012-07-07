<?php

namespace Model\Newsreel;

class NewsreelFacade
{
	private $repository;

	public function __construct(NewsreelRepository $repository)
	{
		$this->repository = $repository;
	}

	public function getOne($id)
	{
		return $this->repository->getOne($id);
	}

	public function getLastNewsreel($limit = null)
	{
		return $this->repository->getAll($limit);
	}

    public function getLastPassedNewsreel($limit = null)
    {
        return $this->repository->getBy('date <= NOW()', $limit);
    }

	public function increaseHit(Newsreel $new)
	{
		$new->setHit($new->getHit() + 1);
		$this->repository->addOrUpdate($new);
		return $this;
	}

    public function addOrUpdate(Newsreel $newsreel)
    {
        $this->repository->addOrUpdate($newsreel);
        return $this;
    }

    public function deleteNewsreel(Newsreel $newsreel)
    {
        $this->repository->delete($newsreel);
        return $this;
    }
}