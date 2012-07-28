<?php

namespace Flame\Components\Comments;

use	Nette\Application\UI\Form;

/**
* Comments component
*/
class Comment extends \Flame\Application\UI\Control
{
	private $commentFacade;

	private $post;

	public function __construct(\Flame\Models\Posts\Post $post, \Flame\Models\Comments\CommentFacade $commentFacade)
	{
		parent::__construct();
		$this->commentFacade = $commentFacade;
        $this->post = $post;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/Comment.latte');
		$this->template->comments = $this->commentFacade->getPublishCommentsInPost($this->post);
		$this->template->render();
	}

	protected function createComponentAddCommentForm()
	{
		$f = new Form;
		$f->addText('name', 'Your name', 55)
			->addRule(FORM::FILLED, 'Your name is required!')
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than %d chars', 75);

		$f->addText('email', 'Email adress', 55)
			->addRule(FORM::FILLED, 'Email adress is required!')
			->addRule(FORM::EMAIL)
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than %d chars', 100);

		$f->addText('web', 'Website', 55)
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than %d chars', 100);

		$f->addTextArea('content', 'Comment:', 65, 7)
			->addRule(FORM::FILLED, 'Content of comment is required.')
			->addRule(FORM::MAX_LENGTH, 'Comment must be shorter than %d chars.', 1000);

		$f->addSubmit('send', 'Send');
		$f->onSuccess[] = callback($this, 'commentFormSubmitted');

        return $f;
	}

	public function commentFormSubmitted(Form $f)
	{
		$values = $f->getValues();

		$comment = new \Flame\Models\Comments\Comment($this->post, $values['name'], $values['email'], $values['content']);
		$comment->setWeb($values['web']);
        $this->commentFacade->persist($comment);
		$this->flashMessage('Your comment is waiting for moderation');
		$this->redirect('this');
	}

	private function treatUrl($url)
	{
		if(strpos($url, 'http') !== true){
			$url = 'http://' . $url;
		}

		return $url;
	}
}
