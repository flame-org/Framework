<?php

namespace FrontModule;

/**
 * Base class for all applications presenters.
 */
abstract class FrontPresenter extends \Flame\Presenters\BasePresenter
{

    private $itemsInMenu = 5;

	public function startup()
	{
		parent::startup();

		if(!$this->getUser()->isAllowed($this->name, $this->view)){
			$this->flashMessage('Access denied');
			$this->redirect('Homepage:');
		}

        $this->initGlobalParameters();
	}

    private function initGlobalParameters()
    {
        $option = $this->context->OptionFacade->getOptionValue('items_in_menu');
        if(!is_null($option)) $this->itemsInMenu = $option;
    }

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->menus = $this->context->PageFacade->getLastPages($this->itemsInMenu);

	}

	protected function createComponentNewsreelControl()
	{
        $itemsInNewsreelMenuList = $this->context->OptionFacade->getOptionValue('items_in_newsreel_menu_list');

		$newsreel = new \Flame\Components\NewsreelControl($this->context->NewsreelFacade);
        if(!is_null($itemsInNewsreelMenuList)) $newsreel->setCountOfItemsInNewsreel($itemsInNewsreelMenuList);

		return $newsreel;
	}
}
