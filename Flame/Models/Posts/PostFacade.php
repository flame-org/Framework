<?php
/**
 * PostFacade
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Posts;

class PostFacade
{

    private $repository;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository('\Flame\Models\Posts\Post');
    }

    public function getLastPosts()
    {
        return $this->repository->findBy(array(), array('id'=> 'DESC'));
    }

    public function getLastPublishPosts()
    {
        return $this->repository->findBy(array('publish' => '1'), array('id'=> 'DESC'));
    }

    public function getOne($id){
        return $this->repository->findOneBy(array('id' => $id));
    }

    public function delete(Post $post)
    {
        return $this->repository->delete($post);
    }

    public function persist(Post $post)
    {
        return $this->repository->save($post);
    }
}
