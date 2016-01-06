<?php

namespace AppBundle\Model\Space;

use AppBundle\Model\Space\Options\Positionable;
use AppBundle\Model\Space\Options\Stylable;

/**
 * Class Point
 * @package AppBundle\Model\Space
 */
class Point
{
    use Positionable;
    use Stylable;

    /** @var string */
    private $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getStyledSymbol()
    {
        if (!$this->style) {
            return $this->symbol;
        }

        $styledSymbol = $this->style->apply($this->symbol);

        return $styledSymbol;
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