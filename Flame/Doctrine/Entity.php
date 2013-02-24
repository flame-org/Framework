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
abstract class Entity extends \Nette\Object
{

    /**
     * @var int
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

	public function __construct()
	{

	}

	/**
	 * @return int
	 */
	public function getId()
    {
        return $this->id;
    }

	/**
	 * @param $id
	 * @return Entity
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
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
		if(isset($this->name) and $this->name !== null){
			return $this->name;
		}else{
			return (string) $this->id;
		}
	}

	/**
	 * @param string
	 * @return string
	 */
	protected static function normalizeString($input)
	{
		$input = trim($input);
		return $input === '' ? NULL : $input;
	}

}
