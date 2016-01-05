<?php

namespace AppBundle\Model\Space;

use Doctrine\Common\Collections\ArrayCollection;

class Object
{
    use PositionableTrait;

    /** @var ArrayCollection|Point[] */
    private $points;

    public function __construct()
    {
        $this->points = new ArrayCollection();
    }

    /**
     * @return Point[]|ArrayCollection
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param Point[]|ArrayCollection $points
     * @return $this
     */
    public function setPoints($points)
    {
        foreach ($points as $point) {
            $this->addPoint($point);
        }

        return $this;
    }

    /**
     * @param Point
     * @return $this
     */
    public function addPoint(Point $point)
    {
        $this->points->add($point);

        return $this;
    }

    /**
     * @return $this
     */
    public function clearPoints()
    {
        $this->points->clear();

        return $this;
    }
}