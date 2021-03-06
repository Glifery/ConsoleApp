<?php

namespace AppBundle\Service\LifeCycle;

use AppBundle\Model\LifeCycle\CycleEvent;
use AppBundle\Service\Terminal\LowLevel\ShellCommandRepository;

class CycleLoop
{
    /** @var ShellCommandRepository */
    private $shellCommandRepository;

    /** @var CycleHandler */
    private $cycleHandler;

    /** @var bool */
    private $isRun;

    /**
     * @param CycleHandler $cycleHandler
     */
    public function __construct(ShellCommandRepository $shellCommandRepository, CycleHandler $cycleHandler)
    {
        $this->shellCommandRepository = $shellCommandRepository;
        $this->cycleHandler = $cycleHandler;
    }

    /**
     * @return $this
     */
    public function run()
    {
        $this->shellCommandRepository->switchInputToCatchMode();

        $this->cycleHandler->init();

        $this->isRun = true;
        while (($this->isRun) && ($symbol = fread(STDIN, 4096))) {
            $cycleEvent = $this->createCycleEvent($symbol);

            $this->cycleHandler->handleIteration($cycleEvent);
        }

        $this->shellCommandRepository->switchInputToTextMode();

        return $this;
    }

    /**
     * @return $this
     */
    public function stopRunning()
    {
        $this->isRun = false;

        return $this;
    }

    /**
     * @param $symbol
     * @return CycleEvent
     */
    private function createCycleEvent($symbol)
    {
        $cycleEvent = new CycleEvent();
        $cycleEvent->setCycleLoop($this);
        $cycleEvent->setInputSymbol($symbol);

        return $cycleEvent;
    }
} 