<?php
/**
 * User
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    09.07.12
 */

namespace Flame\Models\Users;

/**
 * @Entity(repositoryClass="UserRepository")
 * @Table(name="users")
 */
class User extends \Flame\Doctrine\Entity
{
    /**
     * @Column(type="string", length=35, unique=true)
     */
    private $username;

    /**
     * @Column(type="string", length=128)
     */
    private $password;

    /**
     * @Column(type="string", length=25)
     */
    private $role;

    /**
     * @Column(type="string", length=150)
     */
    private $name;

    /**
     * @Column(type="string", length=100, unique=true)
     */
    private $email;

    public function __construct($username, $password, $role, $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->name = '';
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($pass)
    {
        $this->password = (string) $pass;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = (string) $role;
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

    public function getEmail()
    {
        return $this->email;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
