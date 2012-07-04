<?php

class PostsTest extends IntegrationTestCase
{	
	private $service;

	public function setUp()
	{
		$this->service = $this->getContainer()->posts;
	}

	public function testFindAllPosts()
	{
		$findAll = $this->service->findAll();

		$this->assertNotNull($findAll);
		$this->assertEquals(1, count($findAll));
	}

	public function testAddNewPost()
	{
		$newPost =  $this->service->createOrUpdate(array('name' => 'new post', 'user' => 'test_user'));

		$searchedNewPost = $this->service->findOneBy(array('name' => 'new post'));

		$this->assertEquals($newPost, $searchedNewPost);

		$findAll = $this->service->findAll();
		$this->assertEquals(2, count($findAll));
	}
}