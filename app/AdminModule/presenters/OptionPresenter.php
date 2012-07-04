<?php

namespace AdminModule;

use Nette\Application\UI\Form;

/**
* Represent class for global settings and variables
*/
class OptionPresenter extends AdminPresenter
{
	
	public function renderDefault()
	{
		$this->template->options = $this->context->options->findAll();	
	}

	public function createComponentAddOptionForm($name)
	{
		$f = new Form($this, $name);
		$f->addText('name', 'Name:')
			->addRule(FORM::FILLED, 'Name of variable is required')
			->addRule(FORM::MAX_LENGTH, 'Name must be shorter than 50 chars', 50);
		$f->addTextArea('value', 'Value:')
			->addRule(FORM::FILLED, 'Value of variable is required')
			->addRule(FORM::MAX_LENGTH, 'Value must be shorter than 250 chars', 250);
		$f->addSubmit('Submit', 'Add');
		$f->onSuccess[] = callback($this, 'addOptionSubmited');
	}

	public function addOptionSubmited(Form $f)
	{
		$values = $f->getValues();

		$this->context->options->createOrUpdate(
			array(
				'name' => $values['name'],
				'value' => $values['value']
			)
		);

		$this->flashMessage('Global variable was added', 'success');
		$this->redirect('Option:');
	}

	public function handleDelete($id)
	{
		if(!$this->getUser()->isAllowed('Admin:Option', 'delete')){
			$this->flashMessage('Access denited');
		}else{
			$row = $this->context->options->find($id);
			if($row){
				$row->delete();
			}else{
				$this->flashMessage('Required variable does not exist');
			}
		}

		if(!$this->presenter->isAjax()){
			$this->redirect('this');
		}else{
			$this->invalidateControl('options');
		}
	}
}
?>