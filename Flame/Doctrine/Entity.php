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
abstract class Entity extends \Nette\Object implements IEntity
{

    /**
     * @var int
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

	public function __toString()
	{
		return (string) $this->id;
	}

}
