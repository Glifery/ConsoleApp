<?php

namespace AppBundle\Model\Space\Object;

use AppBundle\Model\Space\Object;
use AppBundle\Model\Space\Point;

class Border extends Object
{
    public function __construct($width = 0, $height = 0, $symbol = '#')
    {
        parent::__construct();

        for ($i = 0; $i < $width; $i++) {
            $point = new Point($symbol);
            $point->setX($i);
            $point->setY(0);
            $this->addPoint($point);

            $point = new Point($symbol);
            $point->setX($i);
            $point->setY($height - 1);
            $this->addPoint($point);
        }

        for ($i = 0; $i < $height; $i++) {
            $point = new Point($symbol);
            $point->setX(0);
            $point->setY($i);
            $this->addPoint($point);

            $point = new Point($symbol);
            $point->setX($width - 1);
            $point->setY($i);
            $this->addPoint($point);
        }
    }
}