<?php

use Nette\Application\UI\Form;

/**
* Represent class for global settings and variables
*/
class OptionPresenter extends BasePresenter
{
	
	public function renderDefault()
	{
		$options = $this->context->createOptions()->getAll();

		if(!count($options)){
			$this->flashMessage('Doposud nepřidáno žádné globální nastavení');
		}else{
			$this->template->options = $options;
		}
		
	}

	public function createComponentAddOptionForm($name)
	{
		$f = new Form($this, $name);
		$f->addText('name', 'Název:')
			->addRule(FORM::FILLED, 'Musíš zadat název proměné')
			->addRule(FORM::MAX_LENGTH, 'Název nesmí překročit 50 znaků', 50);
		$f->addTextArea('value', 'Hodnota:')
			->addRule(FORM::FILLED, 'Musíš zadat název proměné')
			->addRule(FORM::MAX_LENGTH, 'Název nesmí překročit 50 znaků', 250);
		$f->addSubmit('Submit', 'Přidat');
		$f->onSuccess[] = callback($this, 'addOptionSubmited');
	}

	public function addOptionSubmited(Form $f)
	{
		$values = $f->getValues();
		$user = $this->getUser();

		if(!$user->isLoggedIn()){
			$this->redirect('Sign:in');
			$this->flashMessage('Musíš být přihlášen');
		}else{
			$this->context->createOptions()->insert(
				array(
					'name' => $values['name'],
					'value' => $values['value']
				)
			);

			$this->flashMessage('Nastavení (proměná) bylo přidáno.', 'success');
			$this->redirect('Option:');
		}
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