<?php
/**
 * OptionFacade
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    09.07.12
 */

namespace Flame\Models\Options;

use \Flame\Models\Options\Option;

class OptionFacade
{
    private $repository;

    private $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('\Flame\Models\Options\Option');
    }

    public function getOne($id)
    {
        return $this->repository->findOne($id);
    }

    public function getByName($name)
    {
        return $this->repository->findOneBy(array('name' => $name));
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

    public function persist(Option $option)
    {
        $this->entityManager->persist($option);
        $this->entityManager->flush();
        return $this;
    }

    public function delete(Option $option)
    {
        $this->entityManager->remove($option);
        $this->entityManager->flush();
        return $this;
    }

    public function getOptionValue($name)
    {
        $option = $this->repository->findOneBy(array('name' => $name));

        if($option){
            return $option->value;
        }else{
            return null;
        }
    }

}
