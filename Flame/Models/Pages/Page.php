<?php

namespace Flame\Models\Pages;

use DateTime,
    \Flame\Models\Users\User;

/**
 * @Entity(repositoryClass="PageRepository")
 * @Table(name="pages")
 */
class Page extends \Flame\Doctrine\Entity
{
    /**
     * @ManyToOne(targetEntity="\Flame\Models\Users\User")
     */
    protected $user;

    /**
     * @Column(type="string", length=100)
     */
    protected $name;

    /**
     * @Column(type="string", length=100)
     */
    protected $slug;

    /**
     * @Column(type="string", length=250)
     */
    protected $description;

    /**
     * @Column(type="string", length=250)
     */
    protected $keywords;

    /**
     * @Column(type="text")
     */
    protected $content;

    /**
     * @Column(type="datetime")
     */
    protected $created;

    /**
     * @Column(type="integer", length=11)
     */
    protected $hit;

    public function __construct(User $user, $name, $slug, $content)
    {
        $this->user = $user;
        $this->name = $name;
        $this->slug = $slug;
        $this->description = "";
        $this->keywords = "";
        $this->content = $content;
        $this->created = new DateTime;
        $this->hit = 0;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = (string) $slug;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = (string) $description;
        return $this;
    }
    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
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
    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated(DateTime $date)
    {
        $this->created = $date;
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
