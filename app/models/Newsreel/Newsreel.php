<?php

namespace Flame\Models\Newsreel;

use DateTime;

/**
 * @Entity(repositoryClass="NewsreelRepository")
 * @Table(name="newsreel")
 */
class Newsreel extends \Flame\Models\Doctrine\Entity
{
    /**
     * @Column(type="string", length=100)
     */
	private $title;

    /**
     * @Column(type="text")
     */
	private $content;

    /**
     * @Column(type="datetime")
     */
	private $date;

    /**
     * @Column(type="integer", length=11)
     */
	private $hit;


	public function __construct($title, $content, DateTime $date, $hit)
	{
		$this->title = $title;
		$this->content = $content;
		$this->date = $date;
		$this->hit = $hit;
	}

	public function getTitle()
	{
		return $this->title;
	}

    public function setTitle($title)
    {
        $this->title = (string) $title;
        return $this;
    }

	public function getContent()
	{
		return $this->content;
	}

    public function setContent($content)
    {
        $this->content = (string) $content;
        return $this;
    }
	public function getDate()
	{
		return $this->date;
	}

    public function setDate(DateTime $date)
    {
        $this->date = $date;
        return $this;
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

    public function toArray()
    {
        return get_object_vars($this);
    }

}