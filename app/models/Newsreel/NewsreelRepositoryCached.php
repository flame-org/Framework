<?php

namespace Model\Newsreel;

use \Nette\Caching\Cache;

class NewsreelRepositoryCached implements NewsreelRepository
{
	private $repository;

	private $cache;

	public function __construct(NewsreelRepository $repository, Cache $cache)
	{
		$this->repository = $repository;
		$this->cache = $cache;
	}

	public function findAll($limit = null)
	{
		$key = 'newsreels-' . $limit;

		if(isset($this->cache[$key])){
			return $this->cache[$key];
		}

		$newsreels = $this->repository->findAll($limit);
		$this->cache->save($key, $newsreels);
		return $newsreels;
	}

	public function persist(Newsreel $newsreel)
	{
		$key = 'newsreel-' . $newsreel->getId();
		$this->repository->persist($newsreel);
		$this->cache->save($key, $newsreel);
		return $this;
	}

	public function findOne($id)
	{
		$key = 'newsreel-' . $id;

		if(isset($this->cache[$key])){
			return $this->cache[$key];
		}

		$newsreel = $this->repository->findOne($id);
		$this->cache->save($key, $newsreel);
		return $newsreel;
	}
}