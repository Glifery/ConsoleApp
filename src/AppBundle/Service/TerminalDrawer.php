<?php

namespace AppBundle\Service;

use AppBundle\Model\Space\Object;
use AppBundle\Model\Space\Point;
use AppBundle\Model\Space\Window;
use AppBundle\Model\Terminal\DrawTable;
use AppBundle\Service\Terminal\LowLevel\ShellOutputRepository;
use AppBundle\Service\Terminal\LowLevel\ShellCommandRepository;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TerminalDrawer
 * @package AppBundle\Service
 */
class TerminalDrawer
{
    /** @var ShellCommandRepository */
    private $shellCommandRepository;

    /** @var ShellOutputRepository */
    private $shellOutputRepository;

    /** @var Window */
    private $rootWIndow;

    /**
     * @param ShellCommandRepository $shellCommandRepository
     * @param ShellOutputRepository $shellOutputRepository
     */
    public function __construct(ShellCommandRepository $shellCommandRepository, ShellOutputRepository $shellOutputRepository)
    {
        $this->shellCommandRepository = $shellCommandRepository;
        $this->shellOutputRepository = $shellOutputRepository;
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
    public function setRootWIndow(Window $rootWIndow)
    {
        $this->rootWIndow = $rootWIndow;

        return $this;
    }

    /**
     * @param OutputInterface $output
     */
    public function initDraw(OutputInterface $output)
    {
        $this->shellOutputRepository->setOutput($output);

        $this->shellCommandRepository->resetTerminal();
    }

    public function redraw()
    {
        if (!$window = $this->getRootWIndow()) {
            throw new \TerminalDrawerException('Trying to redraw terminal without window');
        }

        $drawTable = new DrawTable($window->getWidth(), $window->getHeight());
        $this->recursiveDrawWindow($drawTable, $window, $window->getX(), $window->getY());

        $this->shellOutputRepository->goToScreenStart();
        $this->shellOutputRepository->drawTable($drawTable);
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
            $this->recursiveDrawObject($drawTable, $object, $offsetX + $object->getX(), $offsetY + $object->getY(), $window->getWidth(), $window->getHeight());
        }
    }

    /**
     * @param DrawTable $drawTable
     * @param Object $object
     * @param int $offsetX
     * @param int $offsetY
     * @param int $width
     * @param int $height
     */
    private function recursiveDrawObject(DrawTable $drawTable, Object $object, $offsetX = 0, $offsetY = 0, $width = 0, $height = 0)
    {
        foreach ($object->getPoints() as $point) {
            $this->recursiveDrawPoint($drawTable, $point, $offsetX + $point->getX(), $offsetY + $point->getY(), $width, $height);
        }
    }

    /**
     * @param DrawTable $drawTable
     * @param Point $point
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     */
    private function recursiveDrawPoint(DrawTable $drawTable, Point $point, $x = 0, $y = 0, $width = 0, $height = 0)
    {
        if (
            ($x < 0) ||
            ($x > $drawTable->getWidth()) ||
            ($y < 0) ||
            ($y > $drawTable->getHeight())
        ) {
            return;
        }

        $symbol = $point->getSymbol();
        $drawTable->setSymbol($symbol, $x, $y);
    }
}