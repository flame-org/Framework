<?php
/**
 * UserInfo.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    23.07.12
 */

namespace Flame\Models\UsersInfo;

use Flame\Models\Users\User,
	DateTime;

/**
 * @Entity(repositoryClass="UserInfoRepository")
 * @Table(name="users_info")
 */
class UserInfo extends \Flame\Doctrine\Entity
{
	/**
	 * @Column(type="string", length=250)
	 */
	protected $name;

	/**
	 * @Column(type="string", length=500)
	 */
	protected $about;

	/**
	 * @Column(type="date")
	 */
	protected $birthday;

	/**
	 * @Column(type="string", length=150)
	 */
	protected $web;

	/**
	 * @Column(type="string", length=100)
	 */
	protected $facebook;

	/**
	 * @Column(type="string", length=100)
	 */
	protected $twitter;

	public function __construct($name)
	{
		$this->name = $name;
		$this->about = '';
		$this->birthday = '';
		$this->web = '';
		$this->facebook = '';
		$this->twitter = '';
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

	public function getAbout()
	{
		return $this->about;
	}

	public function setAbout($about)
	{
		$this->about = (string) $about;
		return $this;
	}

	public function getBirthday()
	{
		return $this->birthday;
	}

	public function setBirthday(DateTime $birthday)
	{
		$this->birthday = $birthday;
		return $this;
	}
	public function getWeb()
	{
		return $this->web;
	}

	public function setWeb($web)
	{
		$this->web = (string) $web;
		return $this;
	}

	public function getFacebook()
	{
		return $this->facebook;
	}

	public function setFacebook($facebook)
	{
		$this->facebook = (string) $facebook;
		return $this;
	}

	public function getTwitter()
	{
		return $this->twitter;
	}

	public function setTwitter($twitter)
	{
		$this->twitter = (string) $twitter;
		return $this;
	}
}
