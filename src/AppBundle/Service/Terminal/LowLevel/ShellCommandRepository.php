<?php

namespace AppBundle\Service\Terminal\LowLevel;

/**
 * Class ShellCommandRepository
 * @package AppBundle\Service\Terminal\LowLewel
 */
class ShellCommandRepository
{
    /**
     * @return int
     */
    public function getTerminalWidth()
    {
        $width = shell_exec('tput cols');

        return (int)$width;
    }

    /**
     * @return int
     */
    public function getTerminalHeight()
    {
        $height = shell_exec('tput lines');

        return (int)$height;
    }

    public function resetTerminal()
    {
        shell_exec('reset');
    }

    public function switchInputToTextMode()
    {
        shell_exec('stty echo icanon');
    }

    public function switchInputToCatchMode()
    {
        shell_exec('stty -echo -icanon');
    }
} 