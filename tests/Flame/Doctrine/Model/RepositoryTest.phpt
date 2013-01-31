<?php
/**
 * RepositoryTest.php
 *
 * @testCase
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package
 *
 * @date    24.12.12
 */

namespace Flame\Tests\Doctrine\Model;

require_once __DIR__ . '/../../bootstrap.php';

use Tester\Assert;

class RepositoryTest extends \Flame\Tests\DoctrineTestCase
{

	public function testProperties()
	{
		$emMock = $this->getEmMock();
		$classMetadataMock = $this->mockista->create('\Doctrine\ORM\Mapping\ClassMetadata');
		$repository = new \Flame\Doctrine\Model\Repository($emMock, $classMetadataMock);

		Assert::same($emMock, $this->getAttributeValue($repository, '_em'));
		Assert::same($classMetadataMock, $this->getAttributeValue($repository, '_class'));
	}

	public function testDeleteWithoutFlush()
	{
		$entityMock = $this->mockista->create('Flame\Doctrine\Entity', array('remove'));
		$emMock = $this->getEmMock();
		$emMock->expects('remove')
			->once()
			->with($entityMock)
			->andReturn(null);
		$classMetadataMock = $this->mockista->create('\Doctrine\ORM\Mapping\ClassMetadata');

		$repository = new \Flame\Doctrine\Model\Repository($emMock, $classMetadataMock);
		Assert::same($repository, $repository->delete($entityMock, true));
	}

	public function testSetIdGenerator()
	{
		//TODO
		//$entityMock = $this->mockista->create('Flame\Doctrine\Entity');
	}

}

run(new RepositoryTest());