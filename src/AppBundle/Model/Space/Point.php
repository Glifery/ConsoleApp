<?php

namespace AppBundle\Model\Space;

class Point
{
    use PositionableTrait;

    /** @var string */
    private $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     * @return $this
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }
}