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

	protected function getEmMock()
	{
		$emMock  = $this->getMock('\Doctrine\ORM\EntityManager',
			array('getRepository', 'getClassMetadata', 'persist', 'flush'), array(), '', false);
		$emMock->expects($this->any())
			->method('getRepository');
			//->will($this->returnValue(new FakeRepository()));
		$emMock->expects($this->any())
			->method('getClassMetadata')
			->will($this->returnValue((object)array('name' => 'aClass')));
		$emMock->expects($this->any())
			->method('persist')
			->will($this->returnValue(null));
		$emMock->expects($this->any())
			->method('flush')
			->will($this->returnValue(null));
		return $emMock;  // it tooks 13 lines to achieve mock!
	}

}
