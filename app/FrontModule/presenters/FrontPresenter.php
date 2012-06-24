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
	}

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->menus = $this->context->createPosts()->getPages();
	}
}
