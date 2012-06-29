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
			$this->redirect(':Front:Message:accessDenied');
		}
	}

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->menus = $this->context->createPosts()->getPages();
	}
}
