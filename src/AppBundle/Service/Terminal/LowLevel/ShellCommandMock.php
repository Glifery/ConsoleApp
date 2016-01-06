<?php

namespace AppBundle\Service\Terminal\LowLevel;

/**
 * Class ShellCommandRepository
 * @package AppBundle\Service\Terminal\LowLewel
 */
class ShellCommandMock extends ShellCommandRepository
{
    /**
     * @return int
     */
    public function getTerminalWidth()
    {
        return 200;
    }

    /**
     * @return int
     */
    public function getTerminalHeight()
    {
        return 50;
    }

    public function resetTerminal()
    {

    }

    public function switchInputToTextMode()
    {
        shell_exec('stty +echo +icanon');
    }

    public function switchInputToCatchMode()
    {

    }
} 