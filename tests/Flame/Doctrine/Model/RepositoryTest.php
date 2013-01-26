<?php
/**
 * RepositoryTest.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package
 *
 * @date    24.12.12
 */

namespace Flame\Tests\Doctrine\Model;

class RepositoryTest extends \Flame\Tests\DoctrineTestCase
{

	public function testProperties()
	{
		$emMock = $this->getEmMock();
		$classMetadataMock = $this->getMockBuilder('\Doctrine\ORM\Mapping\ClassMetadata')
			->disableOriginalConstructor()
			->getMock();
		$repository = new \Flame\Doctrine\Model\Repository($emMock, $classMetadataMock);

		$this->assertAttributeEquals($emMock, '_em', $repository);
		$this->assertAttributeEquals($classMetadataMock, '_class', $repository);
	}

	public function testDeleteWithoutFlush()
	{
		//TODO: Fix: Call to a member function remove() on a non-object
//		$entityMock = $this->getMock('Flame\Doctrine\Entity');
//		$emMock = $this->getEmMock();
//		$emMock->expects($this->once())
//			->method('remove')
//			->with($entityMock)
//			->will($this->returnValue(null));
//		$classMetadataMock = $this->getMockBuilder('\Doctrine\ORM\Mapping\ClassMetadata')
//			->disableOriginalConstructor()
//			->getMock();
//		$repository = new \Flame\Doctrine\Model\Repository($emMock, $classMetadataMock);
//		$repository->delete($entityMock, true);
	}

}
