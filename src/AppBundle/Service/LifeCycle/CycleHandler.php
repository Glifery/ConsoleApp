<?php

namespace AppBundle\Service\LifeCycle;

use AppBundle\Model\LifeCycle\CycleEvent;
use AppBundle\Service\ScreenDrawer;
use AppBundle\Tool\Char;

class CycleHandler
{
    /** @var CycleInputManager */
    private $cycleInputNamager;

    /** @var ScreenDrawer */
    private $screenDrawer;

    /**
     * @param CycleInputManager $cycleInputManager
     * @param ScreenDrawer $screenDrawer
     */
    public function __construct(CycleInputManager $cycleInputManager, ScreenDrawer $screenDrawer)
    {
        $this->cycleInputNamager = $cycleInputManager;
        $this->screenDrawer = $screenDrawer;
    }

    /**
     * @return $this
     * @throws \TerminalDrawerException
     */
    public function init()
    {
        $this->screenDrawer->redraw();

        return $this;
    }

    /**
     * @param CycleEvent $cycleEvent
     * @return $this
     * @throws \AppBundle\Exception\LifeCycle\CycleInputException
     * @throws \TerminalDrawerException
     */
    public function handleIteration(CycleEvent $cycleEvent)
    {
        $this->cycleInputNamager->handleEventInput($cycleEvent);
        $this->screenDrawer->redraw();

        return $this;
    }
}