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

use Flame\Models\Users\User;

/**
 * @Entity(repositoryClass="ImageRepository")
 * @Table(name="images")
 */
class Image extends \Flame\Doctrine\Entity
{

    /**
     * @ManyToOne(targetEntity="\Flame\Models\Users\User")
     */
    private $user;

    /**
     * @Column(type="string", length=150)
     */
    private $file;

    /**
     * @Column(type="string", length=100)
     */
    private $name;

    /**
     * @Column(type="string", length=250)
     */
    private $description;

    public function __construct(User $user, $file, $name, $description)
    {
        $this->user = $user;
        $this->file = $file;
        $this->name = $name;
        $this->description = $description;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
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
