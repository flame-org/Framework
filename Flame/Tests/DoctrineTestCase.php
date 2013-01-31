<?php
/**
 * DoctrineTestCase.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    24.12.12
 */

namespace Flame\Tests;

class DoctrineTestCase extends MockTestCase
{

	/**
	 * @param null $fakeRepository
	 * @return \Mockista\MockInterface
	 */
	protected function getEmMock($fakeRepository = null)
	{
		if($fakeRepository === null)
			$fakeRepository = $this->getRepositoryMock();

		$emMock = $this->mockista->create(
			'\Doctrine\ORM\EntityManager', array('getRepository', 'getClassMetadata', 'persist', 'flush'));
		$emMock->expects('getRepository')
			->andReturn($fakeRepository);
		$emMock->expects('getClassMetadata')
			->andReturn((object) array('name' => 'aClass'));
		$emMock->expects('persist')
			->andReturn(null);
		$emMock->expects('flush')
			->andReturn(null);
		return $emMock;
	}

	/**
	 * @param string $method
	 * @param null $returnVal
	 * @return \Mockista\MockInterface
	 */
	protected function getRepositoryMock($method = '', $returnVal = null)
	{
		$mock = $this->mockista->create('\Doctrine\ORM\EntityRepository');
		$mock->expects($method)
			->andReturn($returnVal);
		return $mock;
	}
}
