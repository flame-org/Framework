<?php


namespace Tests;

class HomepagePresenterTest extends \NetteTestCase\TestCase
{
	private $object;

	public function setUp()
	{
		parent::setUp();
		//exit(print_r(get_declared_classes()));
		$this->object = new \FrontModule\HomepagePresenter(\Nette\Environment::getContext());


	}

	public function testRenderDefault()
	{
		$req = new \Nette\Application\Request('Homepage', 'POST', array());
		$res = $this->object->run($req);
		$this->assertInstanceOf('Nette\Application\Responses\TextResponse', $res);
	}
}