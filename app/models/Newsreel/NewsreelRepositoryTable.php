<?php

namespace Model\Newsreel;

class NewsreelRepositoryTable extends \Table implements NewsreelRepository
{
	protected $tableName = 'newsreel';

	public function findAll($limit = null)
	{
		
		$rows = $this->findBy(array())->order('date DESC')->limit($limit);
		
		if(!$rows) return null;

		$newsreels = array();

		foreach ($rows as $row) {
			$newsreel = new Newsreel(
				$row->id, 
				$row->title, 
				$row->content, 
				$row->date, 
				$row->hit);

			$newsreels[] = $newsreel;
		}

		return $newsreels;
	}

	public function persist(Newsreel $newsreel)
	{
		$this->createOrUpdate(array(
			'id' => $newsreel->getId(),
			'hit' => $newsreel->getHit(),
		));

		return $this;
	}

	public function findOne($id)
	{
		$row = $this->find($id);

		if(!$row) return null;

		return new Newsreel(
			$row->id, 
			$row->title, 
			$row->content, 
			$row->date, 
			$row->hit
		);
	}

    public function addOrUpdate(Newsreel $newsreel)
    {
        $result = $this->createOrUpdate(array(
            'id' => $newsreel->getId(),
            'title' => $newsreel->getTitle(),
            'content' => $newsreel->getContent(),
            'date' => $newsreel->getDate()
        ));

        if($result){
            return new Newsreel($result->id, $result->title, $result->content, $result->date, $result->hit);
        }
    }
}