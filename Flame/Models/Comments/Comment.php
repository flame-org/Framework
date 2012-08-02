<?php
/**
 * Comment
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Comments;

use DateTime,
	Flame\Models\Posts\Post;

/**
 * @Entity(repositoryClass="CommentRepository")
 * @Table(name="comments")
 */
class Comment extends \Flame\Doctrine\Entity
{
    /**
     * @ManyToOne(targetEntity="\Flame\Models\Posts\Post")
     */
    protected $post;

    /**
     * @Column(type="string", length=75)
     */
    protected $name;

    /**
     * @Column(type="string", length=100)
     */
    protected $email;

    /**
     * @Column(type="string", length=100)
     */
    protected $web;

    /**
     * @Column(type="text")
     */
    protected $content;

    /**
     * @Column(type="datetime")
     */
    protected $created;

    /**
     * @Column(type="boolean")
     */
    protected $publish;

    public function __construct(Post $post, $name, $email, $content)
    {
        $this->post = $post;
        $this->name = $name;
        $this->email = $email;
        $this->web = "";
        $this->content = $content;
        $this->created = new DateTime;
        $this->publish = false;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = (string) $email;
        return $this;
    }

    public function getWeb()
    {
        return $this->web;
    }

    public function setWeb($web)
    {
        $this->web = (string) $web;
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
}
