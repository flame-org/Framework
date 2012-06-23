<?php

use Nette\Application\UI\Form;

/**
* Post presenter
*/
class PostPresenter extends BasePresenter
{

	public $post_id;
	
	public function renderDefault()
	{
		
	}

	public function createComponentPostList()
	{
		return new PostList($this->context->createPosts()->get());
	}

	public function actionDetail($id)
	{
		$this->post_id = $id;
		$post = $this->context->createPosts()->getDetail($id);

		if($post === false){
			$this->setView('notFound');
		}else{
			$this->template->post = $post;
		}
	}

	public function actionEdit($id)
	{
		$this->post_id = $id;
		$user = $this->getUser();

		if(!$user->isLoggedIn()){
			$this->redirect('Sign:in');
		}else{
			$post = $this->context->createPosts()->getByUser($user->getIdentity()->username, $id);

			if($post === false){
				$this->setView('notFound');
			}else{
				$this->template->post = $post;
			}
		}
	}

	public function actionAdd()
	{
		if(!$this->getUser()->isLoggedIn()){
			$this->redirect('Sign:in');
		}
	}

	protected function createComponentComments()
	{
		$comments = $this->context->createComments()->get($this->post_id);
		return new Comments($comments);
	}

	protected function createComponentAddPostForm($name)
	{
		$f = new Form($this, $name);
		$f->addText('name', 'Název', 80)
			->addRule(FORM::FILLED, 'Musíš vyplnit název příspěvku')
			->addRule(FORM::MAX_LENGTH, 'Název příspěvku nemůže být delší jak 50 znaků.', 50);
		$f->addTextArea('slug', 'Popis', 80, 6)
			->addRule(FORM::MAX_LENGTH, 'Popis příspěvku nemůže být delší jak 250 znalů', 250);
		$f->addTextArea('content', 'Obsah', 80, 40);
		$f->addCheckbox('publish', 'Publikovat?');
		$f->addSubmit('create', 'Vytvořit příspěvek');
		$f->onSuccess[] = callback($this, 'addFormSubmited');
		return $f;
	}

	public function addFormSubmited(Form $f)
	{
		$values = $f->getValues();
		$user = $this->getUser();

		if(!$user->isLoggedIn()){
			$this->redirect('Sign:in');
		}else{
			$this->context->createPosts()->insert(
				array(
					'user' => $user->getIdentity()->username,
					'name' => $values['name'], 
					'slug' => $values['slug'], 
					'content' => $values['content'], 
					'created' => new DateTime, 
					'publish' => $values['publish']
				)
			);
			$this->flashMessage('Příspěvek byl úspěšně vytvořen', 'success');
			$this->redirect('this');
		}
	}

	protected function createComponentEditPostForm($name)
	{
		$values = $this->context->createPosts()->getToEdit($this->post_id);

		$f = new Form($this, $name);

		$f->addText('name', 'Název', 80)
			->setDefaultValue($values['name'])
			->addRule(FORM::FILLED, 'Musíš vyplnit název příspěvku')
			->addRule(FORM::MAX_LENGTH, 'Název příspěvku nemůže být delší jak 50 znaků.', 50);

		$f->addTextArea('slug', 'Popis', 80, 6)
			->setDefaultValue($values['slug'])
			->addRule(FORM::MAX_LENGTH, 'Popis příspěvku nemůže být delší jak 250 znalů', 250);

		$f->addTextArea('content', 'Obsah', 80, 40)
			->setDefaultValue($values['content']);

		$f->addCheckbox('publish', 'Publikovat?')
			->setDefaultValue($values['publish']);

		$f->addSubmit('edit', 'Editovat příspěvek');
		$f->onSuccess[] = callback($this, 'editFormSubmited');

		return $f;
	}

	public function editFormSubmited(Form $f)
	{
		$values = $f->getValues();
		$user = $this->getUser();

		if(!$user->isLoggedIn()){
			$this->redirect('Sign:in');
		}else{
			$this->context->createPosts()->where(array('id' => $this->post_id))->update(
				array(
					'user' => $user->getIdentity()->username,
					'name' => $values['name'], 
					'slug' => $values['slug'], 
					'content' => $values['content'], 
					'created' => new DateTime, 
					'publish' => $values['publish']
				)
			);
			$this->flashMessage('Příspěvek byl úspěšně upraven', 'success');
			$this->redirect('this');
		}
	}
}
?>