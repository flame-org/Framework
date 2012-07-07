<?php

namespace Model\Newsreel;

class NewsreelRepositoryTable extends \Table implements NewsreelRepository
{
	protected $tableName = 'newsreel';

	public function getAll($limit = null)
	{
		$rows = $this->findAll()->order('date DESC')->limit($limit);
        return $this->createNewsreelArray($rows);
	}

    public function getBy($conditions, $limit = null)
    {
        $rows = $this->findBy($conditions)->order('date DESC')->limit($limit);
        return $this->createNewsreelArray($rows);
    }

	public function getOne($id)
	{
		$row = $this->find($id);

		if(!$row){
            return null;
        }else{
            return new Newsreel(
                $row->id,
                $row->title,
                $row->content,
                $row->date,
                $row->hit
            );
        }
	}

    public function addOrUpdate(Newsreel $newsreel)
    {
        $this->createOrUpdate(array(
            'id' => $newsreel->getId(),
            'title' => $newsreel->getTitle(),
            'content' => $newsreel->getContent(),
            'date' => $newsreel->getDate(),
            'hit' => $newsreel->getHit()
        ));

        return $this;
    }

    public function delete(Newsreel $newsreel)
    {
        $row = $this->findBy($newsreel->toArray())->limit(1);

        if($row) $row->delete();
        return $this;
    }

    private function createNewsreelArray($newsreelRows)
    {
        if(!count($newsreelRows)){
            return null;
        }else{
            $newsreels = array();

            foreach ($newsreelRows as $row) {
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
    }
}