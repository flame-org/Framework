<?php
/**
 * Options
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    09.07.12
 */

namespace Flame\Models\Options;

/**
 * @Entity(repositoryClass="OptionRepository")
 * @Table(name="options")
 */
class Option extends \Flame\Doctrine\Entity
{
    /**
     * @Column(type="string", length=50, unique=true)
     */
    protected $name;

    /**
     * @Column(type="string", length=250)
     */
    protected $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
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

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = (string) $value;
        return $this;
    }

}
