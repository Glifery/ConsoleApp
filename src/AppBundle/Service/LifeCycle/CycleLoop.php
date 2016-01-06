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
    public function run($output)
    {
        $this->shellCommandRepository->switchInputToCatchMode();

        $this->isRun = true;
        while (($this->isRun) && ($symbol = fread(STDIN, 4096))) {
            $cycleEvent = $this->createCycleEvent($symbol);

            $this->cycleHandler->handle($cycleEvent, $output);
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
        $cycleEvent->setRawInput($symbol);
        $cycleEvent->setCommand($symbol);

        return $cycleEvent;
    }
} 