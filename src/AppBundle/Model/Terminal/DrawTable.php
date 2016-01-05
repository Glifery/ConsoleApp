<?php

namespace AppBundle\Model\Terminal;

class DrawTable
{
    /** @var integer */
    private $width;

    /** @var integer */
    private $height;

    /** @var array[] */
    private $table;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;

        $this->clear();
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param string $symbol
     * @param int $x
     * @param int $y
     * @return $this
     */
    public function setSymbol($symbol, $x = 0, $y = 0)
    {
        $this->table[$y][$x] = $symbol;

        return $this;
    }

    /**
     * @return string
     */
    public function getAll()
    {
        $rows = array_map(function(array $rowSymbols) {
                $row = implode('', $rowSymbols);

                return $row;
            },
            $this->table
        );

        $all = implode('', $rows);

        return $all;
    }

    private function clear()
    {
        $this->table = array_fill(0, $this->height - 1, array_fill(0, $this->width, ' '));
    }
}