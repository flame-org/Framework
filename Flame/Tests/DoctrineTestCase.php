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
	 * @param \Mockista\MockInterface $fakeRepository
	 * @return \Mockista\MockInterface
	 */
	protected function getEmMock($fakeRepository = null)
	{
		if($fakeRepository === null)
			$fakeRepository = $this->getRepositoryMock();

		$emMock = $this->mockista->create(
			'\Doctrine\ORM\EntityManager', array('getRepository', 'persist', 'flush'));
		$emMock->expects('getRepository')
			->andReturn($fakeRepository)
			->once();
		$emMock->expects('persist')
			->andReturn(null);
		$emMock->expects('flush')
			->andReturn(null);
		return $emMock;
	}

	/**
	 * @return \Mockista\MockInterface
	 */
	protected function getRepositoryMock()
	{
		return $this->mockista->create('\Doctrine\ORM\EntityRepository');
	}
}
