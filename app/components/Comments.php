<?php

	use Nette\Application\UI, Nette\Database\Table\Selection, Nette\Application\UI\Form;

	/**
	* Comments component
	*/
	class Comments extends UI\Control
	{
		private $comments;

		public function __construct(Selection $comments)
		{
			$this->comments = $comments;
			parent::__construct();
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
			$f->addTextArea('content', 'Komentář:', 65, 5)
				->addRule(FORM::FILLED, 'Je nutné vyplnit obsah komentáře.')
				->addRule(FORM::MAX_LENGTH, 'Komentář nemůže být delší jak 1000 znaků.', 1000);
			$f->addSubmit('send', 'Odeslat');
			$f->onSuccess[] = callback($this, 'commentFormSubmited');
			return $f;
		}

		public function commentFormSubmited(Form $f)
		{
			$values = $f->getValues();
			$user = $this->presenter->getUser();
			$post_id = $this->presenter->post_id;

			if(!$user->isLoggedIn()){
				$f->addError('Aby jsi mohl přidat komentář, musíš být přihlášený');
			}else{
				$this->comments->insert(
					array(
						'id_post' => $post_id, 
						'user' => $user->getIdentity()->username, 
						'content' => $values['content'], 
						'created' => new DateTime
					)
				);
				$this->flashMessage('Komentář byl přidán. Děkujeme.');

				$this->redirect('this');
			}
		}
	}
?>