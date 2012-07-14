<?php

require APP_DIR . '/models/Newsreel/Newsreel.php';

use Flame\Models\Newsreel;

class NewsreelTest extends UnitTestCase
{
    public function testConstruction()
    {
        $newsreel = new Newsreel(1, 'title', 'content', new \Datetime(), 0);

        $this->assertInstanceOf('Newsreel', $newsreel);
    }

    public function testGetters()
    {
        $date = new \Datetime();
        $newsreel = new Newsreel(1, 'title', 'content', $date, 0);

        $this->assertEquals(1, $newsreel->getId());
        $this->assertEquals('title', $newsreel->getTitle());
        $this->assertEquals('content', $newsreel->getContent());
        $this->assertEquals($date, $newsreel->getDate());
        $this->assertEquals(0, $newsreel->getHit());
    }

    public function testSetterTitle()
    {
        $newsreel = new Newsreel(1, 'title', 'content', new \Datetime(), 0);
        $newsreel->setTitle('new title');

        $this->assertEquals('new title', $newsreel->getTitle());
    }

    public function testSetterContent()
    {
        $newsreel = new Newsreel(1, 'title', 'content', new \Datetime(), 0);
        $newsreel->setContent('new content');

        $this->assertEquals('new content', $newsreel->getContent());
    }

    public function testSetterDate()
    {
        $date = new \Datetime();

        $newsreel = new Newsreel(1, 'title', 'content', new \Datetime(), 0);
        $newsreel->setDate($date);

        $this->assertEquals($date, $newsreel->getDate());
    }

    public function testSetterHit()
    {
        $newsreel = new Newsreel(1, 'title', 'content', new \Datetime(), 0);
        $newsreel->setHit(6);

        $this->assertEquals(6, $newsreel->getHit());
    }

    public function testToArray()
    {
        $date = new \Datetime();

        $newsreel = new Newsreel(1, 'title', 'content', $date, 0);
        $array = $newsreel->toArray();

        $this->assertCount(5, $array);
        $this->assertEquals(1, $array['id']);
        $this->assertEquals('title', $array['title']);
        $this->assertEquals('content', $array['content']);
        $this->assertEquals($date, $array['date']);
        $this->assertEquals(0, $array['hit']);
    }
}