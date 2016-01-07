<?php

namespace AppBundle\Model\Terminal;

/**
 * Class DepthRegister
 * @package AppBundle\Model\Terminal
 */
class DepthRegister
{
    const DEPTH_DEFAULT = null;

    /**
     * @var integer[]
     */
    private $register;

    public function __construct()
    {
        $this->register = [];
    }

    /**
     * @param int $x
     * @param int $y
     * @return int|null
     */
    public function getDepthFor($x = 0, $y = 0)
    {
        $code = $this->convertCoordinatesToCode($x, $y);
        if (isset($this->register[$code])) {
            return $this->register[$code];
        }

        return self::DEPTH_DEFAULT;
    }

    /**
     * @param int $x
     * @param int $y
     * @param int $depth
     * @return $this
     */
    public function registerDepth($x = 0, $y = 0, $depth = 0)
    {
        $code = $this->convertCoordinatesToCode($x, $y);
        $this->register[$code] = $depth;

        return $this;
    }

    /**
     * @param integer $x
     * @param integer $y
     * @return string
     */
    private function convertCoordinatesToCode($x, $y)
    {
        $code = $x . 'x' . $y;

        return $code;
    }
}