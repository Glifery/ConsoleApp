<?php

namespace AppBundle\Model\Space;

trait PositionableTrait
{
    /** @var integer */
    private $x;

    /** @var integer */
    private $y;

    /**
     * @param int $x
     * @param int $y
     * @return int
     */
    public function setPosition($x = 0, $y = 0)
    {
        $this->setX($x);
        $this->setY($x);

        return $this->x;
    }

    /**
     * @param int $x
     * @param int $y
     * @return int
     */
    public function addPosition($x = 0, $y = 0)
    {
        $this->addX($x);
        $this->addY($x);

        return $this->x;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param int $x
     * @return $this
     */
    public function setX($x = 0)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * @param int $x
     * @return $this
     */
    public function addX($x = 0)
    {
        $this->x += $x;

        return $this;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param int $y
     * @return $this
     */
    public function setY($y = 0)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * @param int $y
     * @return $this
     */
    public function addY($y = 0)
    {
        $this->y += $y;

        return $this;
    }
}