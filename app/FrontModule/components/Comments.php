<?php

namespace FrontModule;

use Nette\Application\UI, 
	Nette\Database\Table\Selection, 
	Nette\Application\UI\Form;

/**
* Comments component
*/
class Comments extends UI\Control
{
	private $comments;

	public function __construct(Selection $comments)
	{
		parent::__construct();
		$this->comments = $comments;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/Comments.latte');
		$this->template->comments = $this->comments;
		$this->template->render();
	}

	public function createComponentAddCommentForm($name)
	{
		$f = new Form($this, $name);
		$f->addText('name', 'Your name', 55)
			->addRule(FORM::FILLED, 'Your name is required!')
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

		$this->comments->insert(
			array(
				'id_post' => $this->presenter->postID, 
				'content' => $values['content'], 
				'created' => new \DateTime,
				'name' => $values['name'], 
				'email' => $values['email'],
				'web' => $this->treatUrl($values['web']),
				'publish' => '0'
			)
		);
		$f->addError('Your comment is waiting for moderation');
		//$this->flashMessage('Your comment is waiting for moderation');
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