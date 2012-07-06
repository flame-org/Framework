<?php

namespace AdminModule;

use \Nette\Application\UI\Form;

class NewsreelPresenter extends AdminPresenter
{
    private $newsreelFacade;

	public function __construct(\Model\Newsreel\NewsreelFacade $newsreelFacade )
	{
	    $this->newsreelFacade = $newsreelFacade;

        \Nette\Forms\Container::extensionMethod('addDatePicker', function (\Nette\Forms\Container $container, $name, $label = NULL) {
            return $container[$name] = new \Utils\DatePicker($label);
        });
	}

    public function actionDefault()
    {
        $this->template->newsreels = $this->newsreelFacade->getLastNewsreel();
    }

    public function actionAdd()
    {

    }

    protected function createComponentAddNewsreelForm($name)
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
            ->addRule(Form::FILLED, 'Date is required item of form')
            ->addRule(Form::VALID, 'Entered date is not valid');
        $f->addSubmit('Create', 'Create newsreel');
        $f->onSuccess[] = callback($this, 'addNewsreelFormSubmited');
    }

    public function addNewsreelFormSubmited(Form $f)
    {
        $values = $f->getValues();

        $this->newsreelFacade->addOrUpdate(
            new \Model\Newsreel\Newsreel(null, $values['title'], $values['content'], $values['date'], 0));

        $this->flashMessage('Newsreel was successfully added');
        $this->redirect('this');
    }
}