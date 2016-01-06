<?php

namespace AppBundle\Model\Space;

use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;

class Point
{
    use PositionableTrait;

    /** @var string */
    private $symbol;

    /** @var OutputFormatterStyleInterface */
    private $style;

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

    /**
     * @return OutputFormatterStyleInterface
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param OutputFormatterStyleInterface $style
     * @return $this
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }
}