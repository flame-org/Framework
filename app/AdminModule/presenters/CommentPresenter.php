<?php

namespace AdminModule;

/**
* Comments managment
*/
class CommentPresenter extends AdminPresenter
{
	public function renderDefault()
	{
		$comments = $this->context->createComments()->getAll();

		if(!count($comments)){
			$this->flashMessage('Your visitors have not added any comment yet');
		}else{

			if(count($comments)){
				$posts = $this->context->createPosts();

				foreach ($comments as $key => $value) {
					$temp = $posts->getNameByID($value['id_post']);
					$comments[$key]['name'] = $temp[$value['id_post']];
				}
			}

			$this->template->comments = $comments;

		}
	}

	public function handleDelete($id)
	{
		if(!$this->getUser()->isAllowed('Admin:Comment', 'delete')){
			$this->flashMessage('Access denided');
			$this->redirect('Dashboard:');
		}else{
			$row = $this->context->createComments()->where(array('id' => $id))->fetch();
			if($row !== false)
				$row->delete();

			$this->redirect('this');
		}
	}

	public function handlePublish($id)
	{
		if(!$this->getUser()->isAllowed('Admin:Comment', 'publish')){
			$this->flashMessage('Access denided');
			$this->redirect('Dashboard:');
		}else{
			$row = $this->context->createComments()->where(array('id' => $id))->update(array('publish' => '1'));

			$this->redirect('this');
		}
	}

	public function handleUnPublish($id)
	{
		if(!$this->getUser()->isAllowed('Admin:Comment', 'publish')){
			$this->flashMessage('Access denided');
			$this->redirect('Dashboard:');
		}else{
			$row = $this->context->createComments()->where(array('id' => $id))->update(array('publish' => '0'));

			$this->redirect('this');
		}
	}
}
?>