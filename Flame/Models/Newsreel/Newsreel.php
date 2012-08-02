<?php

namespace Flame\Models\Newsreel;

use DateTime;

/**
 * @Entity(repositoryClass="NewsreelRepository")
 * @Table(name="newsreel")
 * @orderBy({"id" = "DESC"})
 */
class Newsreel extends \Flame\Doctrine\Entity
{
    /**
     * @Column(type="string", length=100)
     */
	protected $title;

    /**
     * @Column(type="text")
     */
	protected $content;

    /**
     * @Column(type="datetime")
     */
	protected $date;

    /**
     * @Column(type="integer", length=11)
     */
	protected $hit;


	public function __construct($title, $content, DateTime $date)
	{
		$this->title = $title;
		$this->content = $content;
		$this->date = $date;
		$this->hit = 0;
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

}
