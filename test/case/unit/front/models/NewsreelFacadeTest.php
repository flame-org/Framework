<?php

require APP_DIR . '/models/Newsreel/NewsreelRepository.php';
require APP_DIR . '/models/Newsreel/NewsreelFacade.php';

class NewsreelFacadeTest extends UnitTestCase
{
    private $repository;

    private $facade;

    public function setUp()
    {

        $this->repository = $this->getMockBuilder('\Model\Newsreel\NewsreelRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new Model\Newsreel\NewsreelFacade($this->repository);

    }

    public function testGetOne()
    {
        $newsreelPattern = $this->createNewsreel();
        $this->repository->expects($this->once())
            ->method('getOne')
            ->with(1)
            ->will($this->returnValue($newsreelPattern));

        $this->assertEquals($newsreelPattern, $this->facade->getOne(1));
    }

    public function testLastnewsreel()
    {
        $newsreelPattern = $this->createNewsreel();

        $this->repository->expects($this->once())
            ->method('getLastNewsreel')
            ->will($this->returnValue(array($newsreelPattern)));

        $newsreel = $this->facade->getLastNewsreel();
        $this->assertEquals(1, count($newsreel));
        $this->assertEquals($newsreelPattern, $newsreel[0]);
    }

    private function createNewsreel()
    {
        return new \Model\Newsreel\Newsreel(1, 'newsreel', 'the best test of newsreel', new \DateTime(), 0);
    }
}