<?php
/**
 * TestCase.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    19.10.12
 */

namespace Flame\Tests;

use Nette\Application\UI\Form;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

	/**
	 * @return \Nette\DI\Container|\SystemContainer
	 */
	public function getContext()
	{
		return \Nette\Environment::getContext();
	}

	/**
	 * @param \Nette\Application\UI\Form $form
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

}
