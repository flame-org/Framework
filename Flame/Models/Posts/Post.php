<?php
/**
 * Post
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Posts;

use DateTime,
    Flame\Models\Users\User,
	Flame\Models\Categories\Category,
	Flame\Models\Tags\Tag;

/**
 * @Entity(repositoryClass="PostRepository")
 * @Table(name="posts")
 * @orderBy({"id" = "DESC"})
 */
class Post extends \Flame\Doctrine\Entity
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
     * @Column(type="string", length=500)
     */
    protected $keywords;

    /**
     * @Column(type="text")
     */
    protected $content;

	/**
	 * @ManyToOne(targetEntity="\Flame\Models\Categories\Category", inversedBy="posts")
	 */
	protected $category;

	/**
	 * @ManyToMany(targetEntity="\Flame\Models\Tags\Tag", inversedBy="posts")
	 */
	protected $tags;

    /**
     * @Column(type="datetime")
     */
    protected $created;

    /**
     * @Column(type="boolean")
     */
    protected $publish;

    /**
     * @Column(type="boolean")
     */
    protected $comment;

    /**
     * @Column(type="integer", length=11)
     */
    protected $hit;

    /**
     * @Column(type="boolean")
     */
    protected $markdown;

    public function __construct(User $user, $name, $slug, $content, Category $category)
    {
        $this->user = $user;
        $this->name = $name;
	    $this->slug = $slug;
        $this->content = $content;
	    $this->category = $category;

	    $this->markdown = false;
	    $this->hit = 0;
	    $this->comment = true;
	    $this->publish = true;
	    $this->created = new DateTime;
	    $this->tags = new \Doctrine\Common\Collections\ArrayCollection;
	    $this->keywords = "";
	    $this->description = "";
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

    public function getName()
    {
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

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = (string) $keywords;
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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = (string) $content;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags(Tag $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated(DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    public function getPublish()
    {
        return $this->publish;
    }

    public function setPublish($publish)
    {
        $this->publish = (bool) $publish;
        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = (bool) $comment;
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

    public function getMarkdown()
    {
        return $this->markdown;
    }

    public function setMarkdown($markdown)
    {
        $this->markdown = (bool) $markdown;
        return $this;
    }
}
