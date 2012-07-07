<?php

namespace AdminModule;

use \Nette\Application\UI\Form;

class NewsreelPresenter extends AdminPresenter
{
    private $newsreelFacade;

    private $newsreel;
    private $id;

	public function __construct(\Model\Newsreel\NewsreelFacade $newsreelFacade )
	{
	    $this->newsreelFacade = $newsreelFacade;

        \Nette\Forms\Container::extensionMethod('addDatePicker', function (\Nette\Forms\Container $container, $name, $label = NULL) {
            return $container[$name] = new \Utils\DatePicker($label);
        });
	}

    public function renderDefault()
    {
        $newsreels = $this->newsreelFacade->getLastNewsreel();
        $this->template->newsreels = $newsreels;
    }

    public function actionEdit($id)
    {
        $this->id = $id;

        if($this->newsreel = $this->newsreelFacade->getOne($id)){
            $this['newsreelForm']->setDefaults($this->newsreel->toArray());
        }else{
            $this->flashMessage('Newsreel dose not exist.');
            $this->redirect('Newsreel:');
        }
    }

    protected function createComponentNewsreelForm($name)
    {
        $f = new Form($this, $name);
        $f->addText('title', 'Title:', 100)
            ->addRule(Form::FILLED, 'Title is required item.')
            ->addRule(Form::MAX_LENGTH, 'Title muse be shorten than 100 chars', 100);
        $f->addTextArea('content', 'Content:', 99, 20)
            ->addRule(Form::FILLED, 'Content is required item of form')
            ->getControlPrototype()->class('mceEditor');
        $f->addDatePicker('date', 'Date:')
            ->setDefaultValue(new \DateTime())
            //->addRule(Form::VALID, 'Entered date is not valid')
            ->addRule(Form::FILLED, 'Date is required item of form');
        $f->addSubmit('Create', 'Create newsreel');
        $f->onSuccess[] = callback($this, 'newsreelFormSubmitted');
    }

    public function newsreelFormSubmitted(Form $f)
    {
        if($this->id and !$this->newsreel){
            throw new \Nette\Application\BadRequestException;
        }

        $values = $f->getValues();

        if($this->id){ //edit
            $this->newsreel
                ->setTitle($values['title'])
                ->setDate($values['date'])
                ->setContent($values['content']);

            $this->newsreelFacade->addOrUpdate($this->newsreel);

            $this->flashMessage('Newsreel was successfully edited');
            $this->redirect('this');
        }else{ //add

            $this->newsreelFacade->addOrUpdate(
                new \Model\Newsreel\Newsreel(null, $values['title'], $values['content'], $values['date'], 0));

            $this->flashMessage('Newsreel was successfully added');
            $this->redirect('Newsreel:');
        }
    }

    public function handleDelete($id)
    {
        if(!$this->getUser()->isAllowed('Admin:Newsreel', 'delete')){
            $this->flashMessage('Access denied.');
        }else{
            if($newsreel = $this->newsreelFacade->getOne($id)){
                $this->newsreelFacade->delete($newsreel);
                $this->flashMessage('Newsreel was deleted');
            }else{
                $this->flashMessage('Newsreel does not exist!');
            }
        }

        if($this->isAjax()){
            $this->invalidateControl('newsreel');
        }else{
            $this->redirect('Newsreel:');
        }
    }
}