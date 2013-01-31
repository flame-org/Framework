<?php
/**
 * FacadeTest.php
 *
 * @testCase \Flame\Tests\Doctrine\Model\FacadeTest
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    24.12.12
 */

namespace Flame\Tests\Doctrine\Model;

require_once __DIR__ . '/../../bootstrap.php';

use Nette;
use Tester\Assert;

class FakeFacade extends \Flame\Doctrine\Model\Facade
{
	public $repositoryName = 'test';
}

class FailFacade extends \Flame\Doctrine\Model\Facade
{

}

class FacadeTest extends \Flame\Tests\DoctrineTestCase
{

	public function testAbstractConstructor()
	{
		Assert::throws(function (){
			new FailFacade($this->mockista->create('\Doctrine\ORM\EntityManager'));
		}, '\Nette\InvalidStateException');
	}

	public function testProperties()
	{
		$repositoryMock = $this->getRepositoryMock();
		$emMock = $this->getEmMock($repositoryMock);
		$facade = new FakeFacade($emMock);
		Assert::same($facade->repositoryName, $this->getAttributeValue($facade, 'repositoryName'));
		Assert::same($repositoryMock, $this->getAttributeValue($facade, 'repository'));
	}

	public function testGetOne()
	{
		$id = 23;
		$repositoryMock = $this->mockista->create('\Flame\Doctrine\Model\Repository');
		$repositoryMock->expects('findOneById')
			->once()
			->with($id)
			->andReturn(null);

		$emMock = $this->getEmMock($repositoryMock);
		$facade = new FakeFacade($emMock);
		Assert::null($facade->getOne($id));
	}

	public function testSave()
	{
		$entityMock = $this->mockista->create('Flame\Doctrine\Entity');
		$repositoryMock = $this->mockista->create('\Flame\Doctrine\Model\Repository');
		$repositoryMock->expects('save')
			->once()
			->with($entityMock, true)
			->andReturn(null);
		$emMock = $this->getEmMock($repositoryMock);
		$facade = new FakeFacade($emMock);

		Assert::null($facade->save($entityMock, false));
	}

	public function testDelete()
	{
		$entityMock = $this->mockista->create('Flame\Doctrine\Entity');
		$repositoryMock = $this->mockista->create('\Flame\Doctrine\Model\Repository');
		$repositoryMock->expects('delete')
			->once()
			->with($entityMock, false)
			->andReturn(null);
		$emMock = $this->getEmMock($repositoryMock);
		$facade = new FakeFacade($emMock);

		Assert::null($facade->delete($entityMock, true));
	}

}

run(new FacadeTest());

