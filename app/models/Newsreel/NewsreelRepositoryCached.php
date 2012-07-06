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

        if(count($newsreels))
		    $this->cache->save($key, $newsreels, array(Cache::EXPIRE => '+ 5 hours'));

		return $newsreels;
	}

	public function persist(Newsreel $newsreel)
	{
		$key = 'newsreel-' . $newsreel->getId();
		$this->repository->persist($newsreel);
		$this->cache->save($key, $newsreel, array(Cache::EXPIRE => '+ 5 hours'));
		return $this;
	}

	public function findOne($id)
	{
		$key = 'newsreel-' . $id;

		if(isset($this->cache[$key])){
			return $this->cache[$key];
		}

		$newsreel = $this->repository->findOne($id);
		$this->cache->save($key, $newsreel, array(Cache::EXPIRE => '+ 5 hours'));
		return $newsreel;
	}

    public function addOrUpdate(Newsreel $newsreel)
    {
        $resutl = $this->repository->addOrUpdate($newsreel);

        if($resutl instanceof Newsreel){
            $key = 'newsree-' . $resutl->getId();
            $this->cache->save($key, $resutl);
        }

        return $resutl;

    }
}