<?php

namespace AdminModule;

use Nette\Application\UI\Form,
    \Flame\Models\Options;

/**
* Represent class for global settings and variables
*/
class OptionPresenter extends AdminPresenter
{

    private $optionFacade;

    private $id;
    private $option;

    public function __construct(Options\OptionFacade $optionFacade)
    {
        $this->optionFacade = $optionFacade;
    }
	
	public function renderDefault()
	{
		$this->template->options = $this->optionFacade->getAll();
	}

    public function actionEdit($id)
    {
        $this->id = $id;

        if($this->option = $this->optionFacade->getOne((int) $id)){
            $this['optionForm']->setDefaults($this->option->toArray());
        }else{
            $this->flashMessage('Option does not exist');
            $this->redirect('Option:');
        }
    }

	public function createComponentOptionForm()
	{
		$f = new Form;

        if($this->id){
            $f->addText('name', 'Name:', 54)
                ->addRule(FORM::FILLED, 'Name of variable is required')
                ->addRule(FORM::MAX_LENGTH, 'Name must be shorter than %d chars', 50)
                ->setDisabled();
        }else{
            $f->addText('name', 'Name:', 54)
                ->addRule(FORM::FILLED, 'Name of variable is required')
                ->addRule(FORM::MAX_LENGTH, 'Name must be shorter than %d chars', 50);
        }

		$f->addTextArea('value', 'Value:')
			->addRule(FORM::FILLED, 'Value of variable is required')
			->addRule(FORM::MAX_LENGTH, 'Value must be shorter than %d chars', 250);

        if($this->id){
            $f->addSubmit('Submit', 'Edit');
        }else{
            $f->addSubmit('Submit', 'Add');
        }
		$f->onSuccess[] = callback($this, 'optionFormSubmitted');

        return $f;
	}

	public function optionFormSubmitted(Form $f)
	{

        if($this->id and !$this->option){
            throw new \Nette\Application\BadRequestException;
        }

        $values = $f->getValues();

        if($this->id){

            $this->option->setValue($values['value']);
            $this->optionFacade->persist($this->option);
            $this->flashMessage('Option was edited.');
            $this->redirect('this');

        }else{
            if($this->optionFacade->getByName($values['name'])){
                $f->addError('Option name ' . $values['name'] . ' exist, but name of option must be unique.');
            }else{
                $option = new Options\Option($values['name'], $values['value']);
                $this->optionFacade->persist($option);

                $this->flashMessage('Global variable was added', 'success');
                $this->redirect('Option:');
            }
        }
	}

	public function handleDelete($id)
	{
		if(!$this->getUser()->isAllowed('Admin:Option', 'delete')){
			$this->flashMessage('Access denied');
		}else{
			$option = $this->optionFacade->getOne($id);
			if($option){
				$this->optionFacade->delete($option);
			}else{
				$this->flashMessage('Required variable does not exist');
			}
		}

		if(!$this->isAjax()){
			$this->redirect('this');
		}else{
			$this->invalidateControl('options');
		}
	}
}
?>