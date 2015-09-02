<?php

namespace GintonicCMS\Model\Entity;

use Cake\TestSuite\TestCase;
use GintonicCMS\ORM\Entity;

class EntityTest extends TestCase 
{
    /**
     * MyModelTest::testEnum()
     *
     * @return void
     */
    public function testEnum() 
    {
        $array = [
            1 => 'foo',
            2 => 'bar',
        ];

        $res = Entity::enum(null, $array, false);
        $this->assertEquals($array, $res);

        $res = Entity::enum(2, $array, false);
        $this->assertEquals('bar', $res);

        $res = Entity::enum('2', $array, false);
        $this->assertEquals('bar', $res);

        $res = Entity::enum(3, $array, false);
        $this->assertFalse($res);
    }

}
