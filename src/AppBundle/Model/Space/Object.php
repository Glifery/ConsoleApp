<?php

namespace AppBundle\Model\Space;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Model\Space\Options\Positionable;
use AppBundle\Model\Space\Options\Stylable;

/**
 * Class Object
 * @package AppBundle\Model\Space
 */
class Object
{
    use Positionable;
    use Stylable;

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