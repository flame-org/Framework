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
		$options = $this->context->createOptions()->getAll();

		if(!count($options)){
			$this->flashMessage('You have not added any variable yet.');
		}else{
			$this->template->options = $options;
		}
		
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

		$this->context->createOptions()->insert(
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
		$row = $this->context->createOptions()->where(array('id' => $id))->fetch();
		if($row !== false)
			$row->delete();

		$this->redirect('this');
	}
}
?>