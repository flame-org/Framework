<?php
/**
 * Tag.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Models\Tags;

/**
 * @Entity(repositoryClass="TagRepository")
 * @Table(name="tags")
 */
class Tag extends \Flame\Doctrine\Entity
{
	/**
	 * @Column(type="string", length=100, unique=true)
	 */
	protected $name;

	/**
	 * @Column(type="string", length=100)
	 */
	protected $slug;

	/**
	 * @ManyToMany(targetEntity="\Flame\Models\Posts\Post", mappedBy="tags")
	 */
	protected $posts;

	public function __construct($name, $slug)
	{
		$this->name = $name;
		$this->slug = $slug;
		$this->posts = new \Doctrine\Common\Collections\ArrayCollection;
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

	public function getPosts()
	{
		return $this->posts;
	}

	public function __toString()
	{
		return $this->name;
	}
}
