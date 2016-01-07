<?php

namespace AppBundle\Demo;

use AppBundle\Model\Space\Object;
use AppBundle\Tool\KeyControllInterface;

class DemoMovingHandler implements KeyControllInterface
{
    /** @var Object */
    private $object;

    /**
     * @param Object $object
     */
    public function __construct(Object $object)
    {
        $this->object = $object;
    }

    public function moveRight()
    {
        $this->object->addX(1);
    }

    public function moveLeft()
    {
        $this->object->addX(-1);
    }

    public function moveUp()
    {
        $this->object->addY(-1);
    }

    public function moveDown()
    {
        $this->object->addY(1);
    }
}