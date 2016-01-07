<?php

namespace AppBundle\Model\LifeCycle;

use AppBundle\Service\LifeCycle\CycleLoop;

class CycleEvent
{
    /** @var string */
    private $inputSymbol;

    /** @var CycleLoop */
    private $cycleLoop;

    /**
     * @return string
     */
    public function getInputSymbol()
    {
        return $this->inputSymbol;
    }

    /**
     * @param string $inputSymbol
     * @return $this
     */
    public function setInputSymbol($inputSymbol)
    {
        $this->inputSymbol = $inputSymbol;

        return $this;
    }

    /**
     * @return CycleLoop
     */
    public function getCycleLoop()
    {
        return $this->cycleLoop;
    }

    /**
     * @param CycleLoop $cycleLoop
     * @return $this
     */
    public function setCycleLoop($cycleLoop)
    {
        $this->cycleLoop = $cycleLoop;

        return $this;
    }
}