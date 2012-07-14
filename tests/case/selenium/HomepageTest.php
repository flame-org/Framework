<?php

class HomepageTest extends SeleniumTestCase
{

	public function testFirstArticlePresent()
	{
		$this->url('/');

		$element = $this->byCssSelector('h2');
		$this->assertEquals('Clean code', $element->text());
	}

	public function testClickToDetail()
	{
		$this->url('/');

		$element = $this->byCssSelector('h2 a');
		$element->click();

		$element = $this->byCssSelector('h1');
		$this->assertEquals('Clean code', $element->text());
	}

}
