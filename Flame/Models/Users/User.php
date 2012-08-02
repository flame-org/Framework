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
    protected $password;

    /**
     * @Column(type="string", length=25)
     */
    protected $role;

    /**
     * @Column(type="string", length=100, unique=true)
     */
    protected $email;

	/**
	 * @Column(type="string", length=50, nullable=true)
	 */
	protected $facebook;

	/**
	 * @OneToOne(targetEntity="\Flame\Models\UsersInfo\UserInfo")
	 */
	protected $info;

    public function __construct($email, $password, $role)
    {
        $this->password = $password;
        $this->role = $role;
        $this->email = $email;
	    $this->facebook = null;
	    $this->info = null;
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

	public function getInfo()
	{
		return $this->info;
	}

	public function setInfo(\Flame\Models\UsersInfo\UserInfo $info)
	{
		$this->info = $info;
		return $this;
	}

	public function setInfoNull()
	{
		$this->info = null;
		return $this;
	}
}
