<?php

namespace AppBundle\Model\LifeCycle;

use AppBundle\Service\LifeCycle\CycleLoop;

class CycleEvent
{
    /** @var string */
    private $rawInput;

    /** @var string */
    private $command;

    /** @var CycleLoop */
    private $cycleLoop;

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $command
     * @return $this
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return string
     */
    public function getRawInput()
    {
        return $this->rawInput;
    }

    /**
     * @param string $rawInput
     * @return $this
     */
    public function setRawInput($rawInput)
    {
        $this->rawInput = $rawInput;

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