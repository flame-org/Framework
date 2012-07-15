<?php
/**
 * Category.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Models\Categories;

/**
 * @Entity(repositoryClass="CategoryRepository")
 * @Table(name="categories")
 */
class Category extends \Flame\Doctrine\Entity
{

	/**
	 * @Column(type="string", length=100, unique=true)
	 */
	private $name;

	/**
	 * @Column(type="string", length=250)
	 */
	private $description;

	/**
	 * @Column(type="string", length=100)
	 */
	private $slug;

	/**
	 * @OneToMany(targetEntity="\Flame\Models\Posts\Post", mappedBy="category")
	 */
	private $posts;

	public function __construct($name, $description, $slug)
	{
		$this->name = $name;
		$this->description = $description;
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

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = (string) $description;
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

	public function toArray()
	{
		return get_object_vars($this);
	}
}
