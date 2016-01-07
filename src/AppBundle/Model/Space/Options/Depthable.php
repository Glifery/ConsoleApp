<?php

namespace AppBundle\Model\Space\Options;

/**
 * Class Depthable
 * @package AppBundle\Model\Space\Options
 */
trait Depthable
{
    private $depth = 0;

    /**
     * @param int $parentDepth
     * @return int
     */
    public function getDepthWithParent($parentDepth = 0)
    {
        return $parentDepth + $this->getDepth();
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     * @return $this
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @param $depth
     * @return $this
     */
    public function addDepth($depth)
    {
        $this->depth += $depth;

        return $this;
    }
}