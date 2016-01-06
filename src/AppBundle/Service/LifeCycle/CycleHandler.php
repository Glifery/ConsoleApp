<?php

namespace AppBundle\Service\LifeCycle;

use AppBundle\Model\LifeCycle\CycleEvent;
use AppBundle\Tool\Char;

class CycleHandler
{
    public function handle(CycleEvent $cycleEvent, $output)
    {
        $str = $cycleEvent->getRawInput();
//        if (strpos($str, Char::ARROW_UP) !== false) {
        if ($str === Char::ARROW_UP) {
            $output->writeln('UP!!');
        } elseif (strpos($str, "\e[B") !== false) {
            $output->writeln('DOWN');
        } elseif (strpos($str, "\e[C") !== false) {
            $output->writeln('RIGHT');
        } elseif (strpos($str, "\e[D") !== false) {
            $output->writeln('LEFT');
        } elseif ($str === Char::ENTER) {
            $output->writeln('ENTER');
        } elseif ($str === Char::ESCAPE) {
            $output->writeln('ESCZPE');
        } elseif ($str === Char::SPACE) {
            $output->writeln('SPACE');
        } else {
            $output->writeln('->'.$str);
            $cycleEvent->getCycleLoop()->stopRunning();
        }
        return;
    }
}