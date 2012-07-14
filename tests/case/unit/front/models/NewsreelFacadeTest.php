<?php

require APP_DIR . '/models/Newsreel/NewsreelRepository.php';
require APP_DIR . '/models/Newsreel/NewsreelFacade.php';

use Flame\Models\Newsreel;

class NewsreelFacadeTest extends UnitTestCase
{
    private $repository;

    private $facade;

    public function setUp()
    {

        $this->repository = $this->getMockBuilder('NewsreelRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new NewsreelFacade($this->repository);

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
        return new Newsreel(1, 'newsreel', 'the best test of newsreel', new \DateTime(), 0);
    }
}