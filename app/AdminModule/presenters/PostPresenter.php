<?php

namespace AdminModule;

use Nette\Application\UI\Form;

/**
* PostPresenter
*/
class PostPresenter extends AdminPresenter
{
	private $postID;
	
	public function renderDefault()
	{
		$posts = $this->context->createPosts()->get();

		if(!count($posts)){
			$this->flashMessage('You have not added any post yet');
		}else{
			$this->template->posts = $posts;
		}
	}

	public function handleDelete($id)
	{
		if(!$this->getUser()->isAllowed('Admin:Post', 'delete')){
			$this->flashMessage('Access denided');
			$this->redirect('Dashboard:');
		}else{
			$row = $this->context->createPosts()->where(array('id' => $id))->fetch();
			if($row !== false)
				$row->delete();

			$this->redirect('this');
		}
	}

	public function actionEdit($id)
	{

		$this->postID = $id;

		$post = $this->context->createPosts()->getToEdit($this->postID);

		if($post === false){
			$this->flashMessage('Post does not exist.');
			$this->redirect('Post:');
		}else{
			$this->template->post = $post;
		}

	}

	protected function createComponentEditPostForm($name)
	{
		$values = $this->context->createPosts()->getToEdit($this->postID);

		$f = new Form($this, $name);

		$f->addText('name', 'Název', 80)
			->setDefaultValue($values['name'])
			->addRule(FORM::FILLED, 'Musíš vyplnit název příspěvku')
			->addRule(FORM::MAX_LENGTH, 'Název příspěvku nemůže být delší jak 50 znaků.', 50);

		$f->addTextArea('description', 'Popis', 90, 5)
			->setDefaultValue($values['description'])
			->addRule(FORM::MAX_LENGTH, 'Popis příspěvku nemůže být delší jak 250 znalů', 250);

		$f->addTextArea('content', 'Obsah', 115, 35)
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
	}

	public function editFormSubmited(Form $f)
	{
		$values = $f->getValues();
		$user = $this->getUser();

		if(!$user->isLoggedIn()){
			$this->redirect('Sign:in');
		}else{
			$this->context->createPosts()->where(array('id' => $this->postID))->update(
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

	protected function createComponentAddPostForm($name)
	{
		$f = new Form($this, $name);
		$f->addText('name', 'Název', 80)
			->addRule(FORM::FILLED, 'Musíš vyplnit název příspěvku')
			->addRule(FORM::MAX_LENGTH, 'Název příspěvku nemůže být delší jak 100 znaků.', 100);

		$f->addTextArea('description', 'Popis', 90, 5)
			->addRule(FORM::MAX_LENGTH, 'Popis příspěvku nemůže být delší jak 250 znalů', 250);

		$f->addTextArea('content', 'Obsah', 115, 35)
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
					'created' => new \DateTime, 
					'publish' => $values['publish'],
					'page' => $values['page'],
					'comment' => $values['comment'],
				)
			);
			$this->flashMessage('Příspěvek byl úspěšně vytvořen', 'success');
			$this->redirect('this');
		}
	}

}
?>