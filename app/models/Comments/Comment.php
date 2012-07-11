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

use Flame\Models,
    DateTime;

/**
 * @Entity(repositoryClass="CommentRepository")
 * @Table(name="comments")
 */
class Comment extends Models\Doctrine\Entity
{
    /**
     * @ManyToOne(targetEntity="\Flame\Models\Posts\Post")
     */
    private $post;

    /**
     * @Column(type="string", length=75)
     */
    private $name;

    /**
     * @Column(type="string", length=100)
     */
    private $email;

    /**
     * @Column(type="string", length=100)
     */
    private $web;

    /**
     * @Column(type="text")
     */
    private $content;

    /**
     * @Column(type="datetime")
     */
    private $created;

    /**
     * @Column(type="boolean")
     */
    private $publish;

    public function __construct(Models\Posts\Post $post, $name, $email, $web, $content, DateTime $created, $publish)
    {
        $this->post = $post;
        $this->name = $name;
        $this->email = $email;
        $this->web = $web;
        $this->content = $content;
        $this->created = $created;
        $this->publish = $publish;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(Models\Posts\Post $post)
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
