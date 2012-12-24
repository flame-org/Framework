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

class DoctrineTestCase extends TestCase
{

	/**
	 * @param \PHPUnit_Framework_MockObject_MockObject $fakeRepository
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getEmMock(\PHPUnit_Framework_MockObject_MockObject $fakeRepository = null)
	{
		if($fakeRepository === null)
			$fakeRepository = $this->getRepositoryMock();

		$emMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
			->setMethods(array('getRepository', 'getClassMetadata', 'persist', 'flush'))
			->disableOriginalConstructor()
			->getMock();
		$emMock->expects($this->any())
			->method('getRepository')
			->will($this->returnValue($fakeRepository));
		$emMock->expects($this->any())
			->method('getClassMetadata')
			->will($this->returnValue((object)array('name' => 'aClass')));
		$emMock->expects($this->any())
			->method('persist')
			->will($this->returnValue(null));
		$emMock->expects($this->any())
			->method('flush')
			->will($this->returnValue(null));
		return $emMock;
	}

	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getRepositoryMock()
	{
		$repositoryMock = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
			->disableOriginalConstructor()->getMock();
		return $repositoryMock;
	}
}
