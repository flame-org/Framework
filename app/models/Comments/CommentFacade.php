<?php
/**
 * CommentFacade
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    10.07.12
 */

namespace Flame\Models\Comments;

use \Flame\Models\Comments\Comment;

class CommentFacade
{

    private $entityManager;
    private $repository;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('\Flame\Models\Comments\Comment');
    }

    public function getOne($id)
    {
        return $this->repository->getOne($id);
    }

    public function getLastComments()
    {
        return $this->repository->findAll();
    }

    public function getPublishCommentsInPost($id)
    {
        return $this->repository->findBy(array('post' => $id, 'publish' => '1' ));
    }

    public function persist(Comment $comment)
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
        return $this;
    }

    public function delete(Comment $comment)
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        return $this;
    }
}
