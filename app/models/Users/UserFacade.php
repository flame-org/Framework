<?php
/**
 * UserFacade
 *
 * @author  Jiří Šifalda
 * @package
 *
 * @date    09.07.12
 */

namespace Flame\Models\Users;

class UserFacade
{
    private $repository;

    private $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('\Flame\Models\Users\User');
    }

    public function getOne($id)
    {
        return $this->repository->findOne($id);
    }

    public function getLastUsers()
    {
        return $this->repository->findAll();
    }

    public function getByUsername($username)
    {
        return $this->repository->findOneBy(array('username' => $username));
    }

    public function getByEmail($email)
    {
        return $this->repository->findOneBy(array('email' => $email));
    }

    public function persist(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $this;
    }

    public function delete(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $this;
    }
}
