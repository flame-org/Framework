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
		$posts = $this->context->createPosts();

		$post = $posts->getDetail($id);

		if($post === false){
			$this->setView('notFound');
		}else{
			$posts->updateHit($id);
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
			->addRule(FORM::MAX_LENGTH, 'Název příspěvku nemůže být delší jak 100 znaků.', 100);

		$f->addTextArea('description', 'Popis', 80, 6)
			->addRule(FORM::MAX_LENGTH, 'Popis příspěvku nemůže být delší jak 250 znalů', 250);

		$f->addTextArea('content', 'Obsah', 80, 25)
			->getControlPrototype()->class('mceEditor');

		$f->addCheckbox('publish', 'Publikovat?');
		$f->addCheckbox('page', 'Použít jako stránku?');
		$f->addCheckbox('comment', 'Povolit komentáře?')
			->setDefaultValue('1');
		$f->addSubmit('create', 'Vytvořit příspěvek');
		$f->onSuccess[] = callback($this, 'addFormSubmited');
		$f->getElementPrototype()->onsubmit('tinyMCE.triggerSave()');
	}

	public function addFormSubmited(Form $f)
	{
		$values = $f->getValues();
		$user = $this->getUser();

		if(!$user->isLoggedIn()){
			$this->redirect('Sign:in');
			$this->flashMessage('Musíš být přihlášen');
		}else{
			$this->context->createPosts()->insert(
				array(
					'user' => $user->getIdentity()->username,
					'name' => $values['name'], 
					'description' => $values['description'], 
					'slug' => $this->createPostsSlug($values['name']),
					'content' => $values['content'], 
					'created' => new DateTime, 
					'publish' => $values['publish'],
					'page' => $values['page'],
					'comment' => $values['comment'],
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

		$f->addTextArea('description', 'Popis', 80, 6)
			->setDefaultValue($values['description'])
			->addRule(FORM::MAX_LENGTH, 'Popis příspěvku nemůže být delší jak 250 znalů', 250);

		$f->addTextArea('content', 'Obsah', 80, 40)
			->setDefaultValue($values['content'])
			->getControlPrototype()->class('mceEditor');

		$f->addCheckbox('publish', 'Publikovat?')
			->setDefaultValue($values['publish']);

		$f->addCheckbox('page', 'Použít jako stránku?')
			->setDefaultValue($values['page']);

		$f->addCheckbox('comment', 'Povolit komentáře?')
			->setDefaultValue($values['comment']);

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
					'description' => $values['description'], 
					'slug' => $this->createPostsSlug($values['name']),
					'content' => $values['content'], 
					'publish' => $values['publish'],
					'page' => $values['page'],
					'comment' => $values['comment'],
				)
			);
			$this->flashMessage('Příspěvek byl úspěšně upraven', 'success');
			$this->redirect('this');
		}
	}

	private function createPostsSlug($name)
	{
		$url = preg_replace('~[^\\pL0-9_]+~u', '-', $name);
		$url = trim($url, "-");
		$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
		$url = strToLower($url);
		$url = preg_replace('~[^-a-z0-9_]+~', '', $url);

		return $url;
	}
}
?>