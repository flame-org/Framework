<?php

namespace Model\Newsreel;

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

}