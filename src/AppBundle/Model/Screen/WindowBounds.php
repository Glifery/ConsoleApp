<?php

namespace AppBundle\Model\Screen;

/**
 * Class WindowBounds
 * @package AppBundle\Model\Screen
 */
class WindowBounds
{
    private $minX;

    private $minY;

    private $maxX;

    private $maxY;

    /**
     * @return mixed
     */
    public function getMaxX()
    {
        return $this->maxX;
    }

    /**
     * @param mixed $maxX
     * @return $this
     */
    public function setMaxX($maxX)
    {
        $this->maxX = $maxX;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxY()
    {
        return $this->maxY;
    }

    /**
     * @param mixed $maxY
     * @return $this
     */
    public function setMaxY($maxY)
    {
        $this->maxY = $maxY;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinX()
    {
        return $this->minX;
    }

    /**
     * @param mixed $minX
     * @return $this
     */
    public function setMinX($minX)
    {
        $this->minX = $minX;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinY()
    {
        return $this->minY;
    }

    /**
     * @param mixed $minY
     * @return $this
     */
    public function setMinY($minY)
    {
        $this->minY = $minY;

        return $this;
    }
}