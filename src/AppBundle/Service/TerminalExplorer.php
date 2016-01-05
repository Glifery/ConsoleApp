<?php

namespace AppBundle\Service;

use AppBundle\Model\Space\Window;
use AppBundle\Service\Terminal\LowLevel\ShellCommandRepository;

/**
 * Class TerminalExplorer
 * @package AppBundle\Service
 */
class TerminalExplorer
{
    /**
     * @var ShellCommandRepository
     */
    private $shellCommandRepository;

    /**
     * @param ShellCommandRepository $shellCommandRepository
     */
    public function __construct(ShellCommandRepository $shellCommandRepository)
    {
        $this->shellCommandRepository = $shellCommandRepository;
    }

    /**
     * @return Window
     */
    public function createRootWindow()
    {
        $rootWindow = new Window();
        $rootWindow->setX(0);
        $rootWindow->setY(0);
        $rootWindow->setWidth($this->shellCommandRepository->getTerminalWidth());
        $rootWindow->setHeight($this->shellCommandRepository->getTerminalHeight());

        return $rootWindow;
    }
}