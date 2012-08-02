<?php
/**
 * UsersInfoFacade.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    23.07.12
 */

namespace Flame\Models\UsersInfo;

class UserInfoFacade extends \Nette\Object
{

	private $repository;

	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->repository = $entityManager->getRepository('\Flame\Models\UsersInfo\UserInfo');
	}

	public function persist(UserInfo $user)
	{
		return $this->repository->save($user);
	}

	public function delete(UserInfo $user)
	{
		return $this->repository->delete($user);
	}

}
