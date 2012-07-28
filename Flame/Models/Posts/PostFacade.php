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

class PostFacade extends \Nette\Object
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
	    return $this->repository->findOneById($id);
    }

	public function increaseHit(Post $post)
	{
		$post->setHit($post->getHit() + 1);
		return $this->persist($post);
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
