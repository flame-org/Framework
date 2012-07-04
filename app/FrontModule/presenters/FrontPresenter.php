<?php

namespace FrontModule;

/**
 * Base class for all applications presenters.
 */
abstract class FrontPresenter extends \BasePresenter
{

	public function startup()
	{
		parent::startup();

		if(!$this->getUser()->isAllowed($this->name, $this->view)){
			$this->flashMessage('Access denied');
			$this->redirect('Homepage:');
		}
	}

	public function beforeRender()
	{
		parent::beforeRender();
		//$this->template->menus = $this->context->createPosts()->getPages();
		//TODO: layout
		// <li n:foreach="$menus as $menu">
		// 			<a n:href="Post:, 'id' => $menu['id'],'slug' => $menu['slug']">{$menu['name']}</a>
		// 		</li>

	}
}
