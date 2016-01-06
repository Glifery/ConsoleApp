<?php

namespace AppBundle\Service\Terminal\LowLevel;

use AppBundle\Model\Terminal\DrawTable;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TerminalDrawer
 * @package AppBundle\Service\Terminal\LowLevel
 */
class TerminalDrawer
{
    /** @var OutputInterface */
    private $output;

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function goToScreenStart()
    {
        $this->output->write("\033[0;0H");
    }

    public function clearRestOfLine()
    {
        $this->output->writeln("\033[K");
    }

    public function drawTable(DrawTable $drawTable)
    {
        $this->output->write($drawTable->getAll());
    }
}