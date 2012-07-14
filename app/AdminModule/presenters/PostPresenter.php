<?php

namespace AdminModule;

use Nette\Application\UI\Form;

/**
* PostPresenter
*/
class PostPresenter extends AdminPresenter
{
	private $id;
    private $post;

    private $postFacade;
    private $userFacade;

    public function __construct(\Flame\Models\Posts\PostFacade $postFacade, \Flame\Models\Users\UserFacade $userFacade)
    {
        $this->postFacade = $postFacade;
        $this->userFacade = $userFacade;
    }
	
	public function renderDefault()
	{
		$this->template->posts = $this->postFacade->getLastPosts();
	}

	public function handleDelete($id)
	{
		if(!$this->getUser()->isAllowed('Admin:Post', 'delete')){
			$this->flashMessage('Access denied');
		}else{
			
			$post = $this->postFacade->getOne($id);

			if($post){
				$this->postFacade->delete($post);
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
		if(!$this->getUser()->isAllowed('Admin:Post', 'publish')){
			$this->flashMessage('Access denied');
		}else{

			$post = $this->postFacade->getOne($id);

			if($post and (int)$post->getPublish() == 1){
				$post->setPublish(false);
                $this->postFacade->persist($post);
			}else{
                $post->setPublish(true);
                $this->postFacade->persist($post);
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
		$this->id = $id;

        if($this->post = $this->postFacade->getOne($id)){
            $this['postForm']->setDefaults($this->post->toArray());
        }else{
            $this->flashMessage('Post does not exist.');
            $this->redirect('Post:');
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

	protected function createComponentPostForm()
	{
		$f = new Form;
		$f->addText('name', 'Name:', 80)
			->addRule(FORM::FILLED, 'Name is required.')
			->addRule(FORM::MAX_LENGTH, 'Name of post must be shorter than %d chars', 100);

		$f->addText('slug', 'Name in URL', 80)
			->addRule(FORM::MAX_LENGTH, 'Name in URL must be shorter than %d chars', 100);

		$f->addText('keywords', 'META Keywords', 80)
			->addRule(FORM::MAX_LENGTH, 'Meta keywords must be shorter than %d chars', 500);

		$f->addTextArea('description', 'Descriptions', 90, 5)
			->addRule(FORM::MAX_LENGTH, 'Descriptions must be shorter than %d chars', 250);

		$f->addTextArea('content', 'Content:', 115, 35)
			->addRule(FORM::FILLED, 'Content is required.')
			->getControlPrototype()->class('mceEditor');

		$f->addCheckbox('publish', 'Make this post published?');

        if($this->id){
            $f->addCheckbox('comment', 'Allow comments?');
            $f->addSubmit('create', 'Edit post');
        }else{
            $f->addCheckbox('comment', 'Allow comments?')
                ->setDefaultValue('1');
            $f->addSubmit('create', 'Create post');
        }

		$f->onSuccess[] = callback($this, 'postFormSubmitted');

        return $f;
	}

	public function postFormSubmitted(Form $f)
	{
        if($this->id and !$this->post){
            throw new \Nette\Application\BadRequestException;
        }

        $values = $f->getValues();

        if(empty($values['slug'])){
            $slug = $this->createPostsSlug($values['name']);
        }else{
            $slug = $this->createPostsSlug($values['slug']);
        }

        if($this->id){
            $this->post
                ->setName($values['name'])
                ->setSlug($values['slug'])
                ->setDescription($values['description'])
                ->setKeywords($values['keywords'])
                ->setContent($values['content'])
                ->setPublish($values['publish'])
                ->setComment($values['comment']);

            $this->postFacade->persist($this->post);
            $this->flashMessage('Post was edited');
            $this->redirect('this');

        }else{
            $post = new \Flame\Models\Posts\Post(
                $this->userFacade->getOne($this->getUser()->getId()),
                $values['name'],
                $slug,
                $values['description'],
                $values['keywords'],
                $values['content'],
                $values['publish'],
                $values['comment']
            );
            $this->postFacade->persist($post);
            $this->flashMessage('Post was successfully added.', 'success');
            $this->redirect('Post:');
        }

	}

}
?>