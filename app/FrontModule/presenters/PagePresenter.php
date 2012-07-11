<?php
/**
 * PagePresenter
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    11.07.12
 */

namespace FrontModule;

class PagePresenter extends FrontPresenter
{
    private $pageFacade;

    public function __construct(\Flame\Models\Pages\PageFacade $pageFacade)
    {
        $this->pageFacade = $pageFacade;
    }

    public function actionDetail($id)
    {
        if($page = $this->pageFacade->getOne($id)){
            $page->setHit($page->getHit() + 1);
            $this->pageFacade->persist($page);
            $this->template->page = $page;
        }else{
            $this->setView('notFound');
        }
    }
}
