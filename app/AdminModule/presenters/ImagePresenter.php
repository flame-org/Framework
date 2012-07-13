<?php

namespace AdminModule;

use Nette\Application\UI\Form,
	Nette\Image;

/**
* Images presenter
*/
class ImagePresenter extends AdminPresenter
{
	private $imageFacade;

	private $userFacade;

	private $imageStorage;

	public function __construct(\Flame\Models\Images\ImageFacade $imageFacade, \Flame\Models\Users\UserFacade $userFacade)
	{
		$this->imageFacade = $imageFacade;
		$this->userFacade = $userFacade;
	}

	public function startup()
	{
		parent::startup();
		$params = $this->context->getParameters();
		$this->imageStorage = $params['imageStorage'];
	}

	public function renderDefault()
	{
		$this->template->images = $this->imageFacade->getLastImages();
	}
	
	public function createComponentUploadImageForm()
	{
		$f = new Form;
		$f->addUpload('image', 'Image')
			->addRule(FORM::IMAGE, 'Image must be JPEG, PNG or GIF')
			->addRule(FORM::MAX_FILE_SIZE, 'MAX file size is 5MB', 1024 * 5000/* 5MB in bytes */);
		$f->addText('name', 'Name:')
			->addRule(FORM::MAX_LENGTH, 'Name of the image must be shorter than %d chars', 100);
		$f->addTextArea('desc', 'Description')
			->addRule(FORM::MAX_LENGTH, 'Description of the image must be shorter than %d chars', 250);
		$f->addSubmit('upload', 'Upload');
		$f->onSuccess[] = callback($this, 'uploadImageSubmitted');

		return $f;
	}

	public function uploadImageSubmitted(Form $f)
	{
		$values = $f->getValues();

		$image = new \Flame\Models\Images\Image(
			$this->userFacade->getOne($this->getUser()->getId()),
			$this->saveImage($values['image']),
			$values['name'],
			$values['desc']
		);

		$this->imageFacade->persist($image);
		$this->flashMessage('Image was uploaded.');
		$this->redirect('Image:');
	}

	private function saveImage($file)
	{
		$name = $file->name;
		$path = $this->imageStorage['baseDir'] .
			DIRECTORY_SEPARATOR .
			$this->imageStorage['imageDir'] .
			DIRECTORY_SEPARATOR . $name;
		
		if(!file_exists($path)){
			$file->move($path);
		}else{
			$new_name = $this->getRandomImagePrefix() . '_' . $name;
			$file->move(str_replace($name, $new_name, $path));
			$name = $new_name;

		}
		return $name;
	}

	private function getRandomImagePrefix()
	{
		//$charset = 'abcdefghijklmnopqrstuvwxyz012345678901234567890123456789';
		$charset = uniqid('', false);
		$str = "";

		for($i=0;$i< 6;$i++) {
			$pos = mt_rand(0, strlen($charset)-1);
			$str .= $charset[$pos];
		}

		return $str;
	}

	public function handleDelete($id)
	{

		if(!$this->getUser()->isAllowed('Admin:Image', 'delete')){
			$this->flashMessage('Access denied');
		}else{
			$row = $this->imageFacade->getOne($id);

			if($row){

				$file = $this->imageStorage['baseDir'] .
					DIRECTORY_SEPARATOR .
					$this->imageStorage['imageDir'] .
					DIRECTORY_SEPARATOR . $row->file;

				if(file_exists($file)){
					unlink($file);
				}

				$this->imageFacade->delete($row);
			}else{
				$this->flashMessage('Required image to delete does not exist!');
			}
		}

		if(!$this->isAjax()){
			$this->redirect('this');
		}else{
			$this->invalidateControl('images');
		}
	}
}
?>