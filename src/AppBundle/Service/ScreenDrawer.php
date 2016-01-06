<?php

namespace AppBundle\Service;

use AppBundle\Model\Space\Object;
use AppBundle\Model\Space\Point;
use AppBundle\Model\Space\Window;
use AppBundle\Model\Terminal\DrawTable;
use AppBundle\Service\Terminal\LowLevel\TerminalDrawer;
use AppBundle\Service\Terminal\LowLevel\ShellCommandRepository;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ScreenDrawer
 * @package AppBundle\Service
 */
class ScreenDrawer
{
    /** @var ShellCommandRepository */
    private $shellCommandRepository;

    /** @var TerminalDrawer */
    private $terminalDrawer;

    /** @var Window */
    private $rootWIndow;

    /**
     * @param ShellCommandRepository $shellCommandRepository
     * @param TerminalDrawer $terminalDrawer
     */
    public function __construct(ShellCommandRepository $shellCommandRepository, TerminalDrawer $terminalDrawer)
    {
        $this->shellCommandRepository = $shellCommandRepository;
        $this->terminalDrawer = $terminalDrawer;
    }

    /**
     * @return Window
     */
    public function getRootWIndow()
    {
        return $this->rootWIndow;
    }

    /**
     * @param Window $rootWIndow
     * @return $this
     */
    public function setRootWindow(Window $rootWIndow)
    {
        $this->rootWIndow = $rootWIndow;

        return $this;
    }

    /**
     * @param OutputInterface $output
     */
    public function initDraw(OutputInterface $output)
    {
        $this->terminalDrawer->setOutput($output);

        $this->shellCommandRepository->resetTerminal();
    }

    public function redraw()
    {
        if (!$window = $this->getRootWIndow()) {
            throw new \TerminalDrawerException('Trying to redraw terminal without window');
        }

        $drawTable = new DrawTable($window->getWidth(), $window->getHeight());
        $this->recursiveDrawWindow($drawTable, $window, $window->getX(), $window->getY());

        $this->terminalDrawer->goToScreenStart();
        $this->terminalDrawer->drawTable($drawTable);
    }

    /**
     * @param DrawTable $drawTable
     * @param Window $window
     * @param integer $offsetX
     * @param integer $offsetY
     */
    private function recursiveDrawWindow(DrawTable $drawTable, Window $window, $offsetX = 0, $offsetY = 0)
    {
        foreach ($window->getChildren() as $child) {
            $this->recursiveDrawWindow($drawTable, $child, $offsetX + $child->getX(), $offsetY + $child->getY());
        }

        foreach ($window->getObjects() as $object) {
            $this->recursiveDrawObject($drawTable, $object, $offsetX + $object->getX(), $offsetY + $object->getY(), $offsetX + $window->getWidth(), $offsetY + $window->getHeight());
        }
    }

    /**
     * @param DrawTable $drawTable
     * @param Object $object
     * @param int $offsetX
     * @param int $offsetY
     * @param int $windowMaxX
     * @param int $windowMaxY
     */
    private function recursiveDrawObject(DrawTable $drawTable, Object $object, $offsetX = 0, $offsetY = 0, $windowMaxX = 0, $windowMaxY = 0)
    {
        foreach ($object->getPoints() as $point) {
            $this->recursiveDrawPoint($drawTable, $point, $offsetX + $point->getX(), $offsetY + $point->getY(), $windowMaxX, $windowMaxY);
        }
    }

    /**
     * @param DrawTable $drawTable
     * @param Point $point
     * @param int $x
     * @param int $y
     * @param int $windowMaxX
     * @param int $windowMaxY
     */
    private function recursiveDrawPoint(DrawTable $drawTable, Point $point, $x = 0, $y = 0, $windowMaxX = 0, $windowMaxY = 0)
    {
        if (
            ($x < 0) ||
            ($x >= $drawTable->getWidth()) ||
            ($x >= $windowMaxX) ||
            ($y < 0) ||
            ($y >= $drawTable->getHeight() ||
            ($y >= $windowMaxY))
        ) {
            return;
        }

        $symbol = $point->getStyledSymbol();
        $drawTable->setSymbol($symbol, $x, $y);
    }
}