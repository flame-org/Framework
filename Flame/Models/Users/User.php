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
     * @Column(type="string", length=128)
     */
    private $password;

    /**
     * @Column(type="string", length=25)
     */
    private $role;

    /**
     * @Column(type="string", length=100, unique=true)
     */
    private $email;

	/**
	 * @Column(type="string", length=50)
	 */
	private $facebook;

    public function __construct($email, $password, $role)
    {
        $this->password = $password;
        $this->role = $role;
        $this->email = $email;
	    $this->facebook = null;
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

    public function getEmail()
    {
        return $this->email;
    }

	public function getFacebook()
	{
		return $this->facebook;
	}

	public function setFacebook($facebook_id)
	{
		$this->facebook = (string) $facebook_id;
		return $this;
	}

    public function toArray()
    {
        return get_object_vars($this);
    }
}
