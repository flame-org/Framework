<?php

namespace FrontModule;

/**
* Post presenter
*/
class PostPresenter extends FrontPresenter
{
    private $commentFacade;
	private $postFacade;
    private $post;

    public function __construct(\Flame\Models\Posts\PostFacade $postFacade, \Flame\Models\Comments\CommentFacade $commentFacade)
    {
        $this->postFacade = $postFacade;
        $this->commentFacade = $commentFacade;
    }

	public function actionDefault($id)
	{

		$this->post = $this->postFacade->getOne($id);

		if(!$this->post){
			$this->setView('notFound');
		}else{

            $this->post->setHit($this->post->getHit() + 1);
            $this->postFacade->persist($this->post);
		}

		$this->template->post = $this->post;
	}

	protected function createComponentComments()
	{
		if(!$this->post) return null;
		return new \Flame\Components\CommentsControl($this->post, $this->commentFacade);
	}
}
?>