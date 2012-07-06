<?php

namespace Model\Newsreel;

class NewsreelRepositoryTable extends \Table implements NewsreelRepository
{
	protected $tableName = 'newsreel';

	public function findAll($limit = null)
	{
		
		$rows = $this->findBy(array())->order('date DESC')->limit($limit);
		
		$newsreels = array();
		foreach ($rows as $row) {
			//dump($row);exit();
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

		return new Newsreel(
			$row->id, 
			$row->title, 
			$row->content, 
			$row->date, 
			$row->hit
		);
	}
}