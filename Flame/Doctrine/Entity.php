<?php
/**
 * Entity
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    09.07.12
 */

namespace Flame\Doctrine;

/**
 * @MappedSuperClass
 */
abstract class Entity extends \Nette\Object implements \Flame\Model\IEntity
{

    /**
     * @var int
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
	 * @return int
	 */
	public function getId()
    {
        return $this->id;
    }

	/**
	 * @param $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return array
	 */
	public function toArray()
    {
        return get_object_vars($this);
    }

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->id;
	}

}
