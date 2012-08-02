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
	protected $name;

	/**
	 * @Column(type="string", length=250)
	 */
	protected $description;

	/**
	 * @Column(type="string", length=100)
	 */
	protected $slug;

	/**
	 * @OneToMany(targetEntity="Category", mappedBy="parent")
	 **/
	protected $children;

	/**
	 * @ManyToOne(targetEntity="Category", inversedBy="children")
	 * @JoinColumn(name="parent_id", referencedColumnName="id")
	 **/
	protected $parent;

	/**
	 * @OneToMany(targetEntity="\Flame\Models\Posts\Post", mappedBy="category")
	 */
	protected $posts;

	public function __construct($name, $slug)
	{
		$this->name = $name;
		$this->description = "";
		$this->slug = $slug;
		$this->children = new \Doctrine\Common\Collections\ArrayCollection;
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

	public function getChildren()
	{
		return $this->children;
	}

	public function setChildren($categories)
	{
		$this->children[] = $categories;
		return $this;
	}

	public function getParent()
	{
		return $this->parent;
	}

	public function setParent(Category $parent)
	{
		$this->parent = $parent;
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
