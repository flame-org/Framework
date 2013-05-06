<?php
/**
 * ApplicationTestCase.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    24.12.12
 */

namespace Flame\Tests;

use Nette\Application\UI\Form;

abstract class ApplicationTestCase extends MockTestCase
{

	/**
	 * @param Form  $form
	 * @param array $values
	 * @return \Nette\Application\IResponse
	 */
	public function submitForm(Form $form, array $values = array())
	{
		$get = $form->getMethod() !== Form::POST ? $values : array();
		$post = $form->getMethod() === Form::POST ? $values : array();
		list($post, $files) = $this->separateFilesFromPost($post);

		$presenter = new Tools\UIFormTestingPresenter($form);
		$this->getContext()->callMethod(array($presenter, 'injectPrimary'));

		return $presenter->run(new \Nette\Application\Request(
			'presenter',
			strtoupper($form->getMethod()),
			array('do' => 'form-submit', 'action' => 'default') + $get,
			$post,
			$files
		));
	}


	/**
	 * @param array $post
	 * @param array $files
	 *
	 * @return array
	 */
	private function separateFilesFromPost(array $post, array $files = array())
	{
		foreach ($post as $key => $value) {
			if (is_array($value)) {
				list($pPost, $pFiles) = $this->separateFilesFromPost($value);
				unset($post[$key]);

				if ($pPost) {
					$post[$key] = $pPost;
				}
				if ($pFiles) {
					$files[$key] = $pFiles;
				}
			}

			if ($value instanceof \Nette\Http\FileUpload) {
				$files[$key] = $value;
				unset($post[$key]);
			}
		}

		return array($post, $files);
	}

	/**
	 * @param \Nette\ComponentModel\IComponent $component
	 * @param array                            $methods
	 * @param string                           $name
	 * @return \Flame\Application\UI\Presenter|\PHPUnit_Framework_MockObject_MockObject
	 */
	public function attachToPresenter(\Nette\ComponentModel\IComponent $component, $methods = array(), $name = 'component')
	{
		/** @var \PHPUnit_Framework_MockObject_MockObject|\Flame\Application\UI\Presenter $presenter */
		$presenter = $this->getMock('Flame\Application\UI\Presenter', (array)$methods, array());
		$this->getContext()->callMethod(array($presenter, 'injectPrimary'));
		$component->setParent($presenter, $name);

		return $presenter;
	}

	/**
	 * @param \Nette\Application\UI\Form $form
	 * @return string
	 * @throws \Exception
	 */
	public function renderFormTemplate(Form $form)
	{
		ob_start();
		try {
			$form->render();
		} catch (\Exception $e) {
			ob_end_clean();
			throw $e;
		}

		return \Nette\Utils\Strings::normalize(ob_get_clean());
	}

}
