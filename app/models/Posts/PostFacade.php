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

    private $postRepository;

    private $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $entityManager->getRepository('\Flame\Models\Posts\Post');
    }

    public function getLastPosts()
    {
        return $this->postRepository->findAll();
    }

    public function getLastPublishPosts()
    {
        return $this->postRepository->findBy(array('publish' => '1'));
    }

    public function getOne($id){
        return $this->postRepository->getOne($id);
    }

    public function delete(Post $post)
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
        return $this;
    }

    public function persist(Post $post)
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $this;
    }
}
