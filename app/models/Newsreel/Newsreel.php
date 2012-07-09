<?php

namespace Flame\Models\Newsreel;

class Newsreel extends \Nette\Object
{
	private $id;

	private $title;

	private $content;

	private $date;

	private $hit;


	public function __construct($id, $title, $content, $date, $hit)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->date = $date;
		$this->hit = $hit;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getHit()
	{
		return $this->hit;
	}

	public function setHit($hit)
	{
		$this->hit = (int) $hit;
		return $this;
	}

    public function setTitle($title)
    {
        $this->title = (string) $title;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = (string) $content;
        return $this;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'content' => $this->content,
            'title' => $this->title,
            'date' => $this->date,
            'hit' => $this->hit
        );
    }

}