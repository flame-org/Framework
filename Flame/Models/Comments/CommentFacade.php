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

class CommentFacade extends \Nette\Object
{

    private $repository;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository('\Flame\Models\Comments\Comment');
    }

    public function getOne($id)
    {
	    return $this->repository->findOneById($id);
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
        return $this->repository->save($comment);
    }

    public function delete(Comment $comment)
    {
        return $this->repository->delete($comment);
    }
}
