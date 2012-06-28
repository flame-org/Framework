<?php

namespace AdminModule;

use Nette\Application\UI\Form,
	Nette\Image;

/**
* Images presenter
*/
class ImagePresenter extends AdminPresenter
{
	private $thumbnailW = 230;
	private $thumbnailH = 230;

	public function renderDefault()
	{
		$images = $this->context->createImages()->getAll();

		if(count($images)){
			foreach ($images as $key => $value) {
				$images[$key]['size'] = getimagesize(WWW_DIR . '/media/images/' . $value['file']);
				$images[$key]['size_thumbnail'] = getimagesize(WWW_DIR . '/media/images_thumbnails/' . $value['thumbnail']);
			}

			$this->template->images = $images;
		}
	}
	
	public function createComponentUploadImageForm($name)
	{
		$f = new Form($this, $name);
		$f->addUpload('image', 'Image')
			->addRule(FORM::IMAGE, 'Image must be JPEG, PNG or GIF')
			->addRule(FORM::MAX_FILE_SIZE, 'MAX file size is 5MB', 1024 * 5000/* 5MB in bytes */);
		$f->addText('name', 'Name:')
			->addRule(FORM::MAX_LENGTH, 'Name of the image must be shorter than 100 chars', 100);
		$f->addTextArea('desc', 'Description')
			->addRule(FORM::MAX_LENGTH, 'Description of the image must be shorter than 250 chars', 250);
		$f->addSubmit('upload', 'Upload');
		$f->onSuccess[] = callback($this, 'uploadImageSubmited');
	}

	public function uploadImageSubmited(Form $f)
	{
		$this->initDefinedSize();

		$values = $f->getValues();
		$user = $this->getUser();

		$image_name = $this->saveImage($values['image']);
		$thumbnail_name = $this->createThumbnail($image_name);
		
		$s = $this->context->createImages()->insert(
			array(
				'user' => $user->getIdentity()->username,
				'file' => $image_name,
				'name' => $values['name'],
				'desc' => $values['desc'],
				'thumbnail' => $thumbnail_name,
				)
		);

		if($s){
			$this->flashMessage('Image was uploaded.');
		}else{
			$this->flashMessage('Image cannot be added to the database.');
		}

		$this->redirect('this');
	}

	private function createThumbnail($image_name)
	{
		$image = IMAGE::fromFile(WWW_DIR . '/media/images/' . $image_name);
		$image->resize($this->thumbnailW, $this->thumbnailH, Image::SHRINK_ONLY);
		$image->sharpen();

		$image_name = 'min_' . $image_name;

		$saved = $image->save(WWW_DIR . '/media/images_thumbnails/' . $image_name);

		if ($saved) {
			return $image_name;
		} else {
			return '';
		}
	}

	private function saveImage($file)
	{
		$name = $file->name;
		$path = WWW_DIR . '/media/images/' . $name;
		
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

	private function initDefinedSize()
	{
		$factory = $this->context->createOptions();

		$width = $factory->getByName('thumbnail_width');
		$height = $factory->getByName('thumbnail_height');


		if(!is_null($width))
			$this->thumbnailW = $width;
		if(!is_null($height))
			$this->thumbnailH = $height;
	}

	public function handleDelete($id)
	{

		if(!$this->getUser()->isAllowed('Admin:Image', 'delete')){
			$this->flashMessage('Access denided');
			$this->redirect('Dashboard:');
		}else{
			$row = $this->context->createImages()->where(array('id' => $id))->fetch();	

			if($row !== false){
				$file = WWW_DIR . '/media/images/' . $row->file;
				if(file_exists($file)){
					unlink($file);
				}

				$thumbnail = WWW_DIR . '/media/images_thumbnails/' . $row['thumbnail'];
				if(file_exists($thumbnail)){
					unlink($thumbnail);
				}	

				if($row->delete()){
					$this->flashMessage('Image was deleted.', 'success');
				}
			}

			$this->redirect('this');
		}
	}
}
?>