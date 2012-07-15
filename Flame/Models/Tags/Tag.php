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
	private $name;

	/**
	 * @Column(type="string", length=100)
	 */
	private $slug;

	/**
	 * @ManyToMany(targetEntity="\Flame\Models\Posts\Post", mappedBy="tags")
	 */
	private $post;

	public function __construct($name, $slug)
	{
		$this->name = $name;
		$this->slug = $slug;
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
		return $this->post;
	}

	public function toArray()
	{
		return get_object_vars($this);
	}
}
