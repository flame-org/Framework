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
		$newsreel = $this->repository->findOne($id);

		return $newsreel;
	}

	public function getLastNewsreel()
	{
		return $this->repository->findAll();
	}

	public function increaseHit(Newsreel $new)
	{
		$new->setHit($new->getHit() + 1);
		$this->repository->persist($new);
		return $this;
	}

    public function addOrUpdate(Newsreel $newsreel)
    {
        $this->repository->addOrUpdate($newsreel);
        return $this;
    }
}