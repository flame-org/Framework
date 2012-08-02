<?php
/**
 * Image
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    11.07.12
 */

namespace Flame\Models\Images;

/**
 * @Entity(repositoryClass="ImageRepository")
 * @Table(name="images")
 */
class Image extends \Flame\Doctrine\Entity
{

    /**
     * @Column(type="string", length=150)
     */
    protected $file;

    /**
     * @Column(type="string", length=100)
     */
    protected $name;

    /**
     * @Column(type="string", length=250)
     */
    protected $description;

    public function __construct($file)
    {
        $this->file = $file;
        $this->name = '';
        $this->description = '';
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = (string) $file;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = (string) $description;
        return $this;
    }
}
