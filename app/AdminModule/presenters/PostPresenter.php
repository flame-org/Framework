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
		$this->template->posts = $this->context->createPosts()->getAll();
	}

	public function handleDelete($id)
	{
		if(!$this->getUser()->isAllowed('Admin:Post', 'delete')){
			$this->flashMessage('Access denided');
		}else{
			$row = $this->context->createPosts()->where(array('id' => $id))->fetch();
			if($row !== false){
				$row->delete();
			}else{
				$this->flashMessage('Required post to delete does not exist!');
			}
		}

		if(!$this->isAjax()){
			$this->redirect('this');
		}else{
			$this->invalidateControl('posts');
		}
	}

	public function handleMarkPublish($id)
	{
		$factory =  $this->context->createPosts();

		if(!$this->presenter->getUser()->isAllowed('Admin:Post', 'publish')){
			$this->flashMessage('Access denided');
		}else{

			$row = $factory->where(array('id' => $id))->fetch();

			if((int)$row['publish'] == 1){
				$row = $factory->where(array('id' => $id))->update(array('publish' => '0'));
			}else{
				$row = $factory->where(array('id' => $id))->update(array('publish' => '1'));
			}
		}

		if(!$this->isAjax()){
			$this->redirect('this');
		}else{
			$this->invalidateControl('posts');
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

		$f->addText('slug', 'Name in URL', 80)
			->setDefaultValue($values['slug'])
			->addRule(FORM::MAX_LENGTH, 'Adresa nemůže být delší jak 100 znaků', 100);

		$f->addText('keywords', 'META Keywords', 80)
			->setDefaultValue($values['keywords'])
			->addRule(FORM::MAX_LENGTH, 'Klíčová slova nemůžou mít více jak 500 znaků', 500);

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
				'keywords' => $values['keywords'],
			)
		);
		$this->flashMessage('Příspěvek byl úspěšně upraven', 'success');
		$this->redirect('this');
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

		$f->addText('slug', 'Name in URL', 80)
			->addRule(FORM::MAX_LENGTH, 'Adresa nemůže být delší jak 100 znaků', 100);

		$f->addText('keywords', 'META Keywords', 80)
			->addRule(FORM::MAX_LENGTH, 'Klíčová slova nemůžou mít více jak 500 znaků', 500);

		$f->addTextArea('description', 'Popis', 90, 5)
			->addRule(FORM::MAX_LENGTH, 'Popis příspěvku nemůže být delší jak 250 znaků', 250);

		$f->addTextArea('content', 'Obsah', 115, 35)
			->addRule(FORM::FILLED, 'Obsah příspěvku je vyžadován.')
			->getControlPrototype()->class('mceEditor');

		$f->addCheckbox('publish', 'Publikovat?');
		$f->addCheckbox('page', 'Použít jako stránku?');
		$f->addCheckbox('comment', 'Povolit komentáře?')
			->setDefaultValue('1');
		$f->addSubmit('create', 'Vytvořit příspěvek');
		$f->getElementPrototype()->onsubmit('tinyMCE.triggerSave()');
		$f->onSuccess[] = callback($this, 'addFormSubmited');
	}

	public function addFormSubmited(Form $f)
	{
		$values = $f->getValues();
		$user = $this->getUser();

		if(empty($values['slug'])){
			$slug = $this->createPostsSlug($values['name']);
		}else{
			$slug = $this->createPostsSlug($values['slug']);
		}

		$this->context->createPosts()->insert(
			array(
				'user' => $user->getIdentity()->username,
				'name' => $values['name'], 
				'description' => $values['description'], 
				'keywords' => $values['keywords'], 
				'slug' => $slug,
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
?>