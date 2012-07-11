<?php

namespace AdminModule;

/**
* Comments management
*/
class CommentPresenter extends AdminPresenter
{
	private $commentFacade;

    public function __construct(\Flame\Models\Comments\CommentFacade $commentFacade)
    {
        $this->commentFacade = $commentFacade;
    }

	public function renderDefault()
	{
        $this->template->comments = $this->commentFacade->getLastComments();
	}

    public function handleDelete($id)
    {
        if(!$this->getUser()->isAllowed('Admin:Comment', 'delete')){
            $this->flashMessage('Access denied');
        }else{

            $comment = $this->commentFacade->getOne($id);

            if($comment){
                $this->commentFacade->delete($comment);
            }
        }

        if(!$this->isAjax()){
            $this->redirect('this');
        }else{
            $this->invalidateControl('comments');
        }
    }

    public function handleMarkPublish($id)
    {
        if(!$this->getUser()->isAllowed('Admin:Comment', 'publish')){
            $this->flashMessage('Access denied');
        }else{

            $comment = $this->commentFacade->getOne($id);

            if($comment){
                if($comment->getPublish() == 1){
                    $comment->setPublish(0);
                }else{
                    $comment->setPublish(1);
                }
                $this->commentFacade->persist($comment);
            }
        }

        if(!$this->isAjax()){
            $this->redirect('this');
        }else{
            $this->invalidateControl('comments');
        }
    }
}
?>