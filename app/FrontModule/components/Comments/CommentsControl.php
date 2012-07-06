<?php

namespace FrontModule\Componnets;

use Nette\Application\UI,
	Nette\Application\UI\Form;

/**
* Comments component
*/
class CommentsControl extends UI\Control
{
	private $service;

	private $postId;

	public function __construct(\CommentsService $commentsService)
	{
		parent::__construct();
		$this->service = $commentsService;
	}

	public function setPostId($id)
	{
		$this->postId = $id;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/CommentsControl.latte');
		$this->template->comments = $this->service->findBy(array('id_post' => $this->postId, 'publish' => '1'));
		$this->template->render();
	}

	protected function createComponentAddCommentForm($name)
	{
		$f = new Form($this, $name);
		$f->addText('name', 'Your name', 55)
			->addRule(FORM::FILLED, 'Your name is required!')
			//->setRequired('Your name is required!')
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than 75 chars', 75);

		$f->addText('email', 'Email adress', 55)
			->addRule(FORM::FILLED, 'Email adress is required!')
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than 100 chars', 100);

		$f->addText('web', 'Website', 55)
			->addRule(FORM::MAX_LENGTH, 'Your name cannot be longer than 100 chars', 100);

		$f->addTextArea('content', 'Comment:', 65, 7)
			->addRule(FORM::FILLED, 'Content of comment is required.')
			->addRule(FORM::MAX_LENGTH, 'Comment must be shorter than 1000 chars.', 1000);

		$f->addSubmit('send', 'Send');
		$f->onSuccess[] = callback($this, 'commentFormSubmited');
	}

	public function commentFormSubmited(Form $f)
	{
		$values = $f->getValues();

		$this->service->createOrUpdate(
			array(
				'id_post' => $this->postId, 
				'content' => $values['content'], 
				'created' => new \DateTime,
				'name' => $values['name'], 
				'email' => $values['email'],
				'web' => $this->treatUrl($values['web']),
				'publish' => '0'
			)
		);
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
?>