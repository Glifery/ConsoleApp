<?php

namespace AppBundle\Service;

use AppBundle\Model\Space\Object;
use AppBundle\Model\Space\Point;
use AppBundle\Model\Space\Window;
use AppBundle\Model\Terminal\DrawTable;
use AppBundle\Service\Terminal\LowLevel\TerminalDrawer;
use AppBundle\Service\Terminal\LowLevel\ShellCommandRepository;
use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;
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
        $this->recursiveDrawWindow($drawTable, $window, $window->getStyle(), $window->getX(), $window->getY());

        $this->terminalDrawer->goToScreenStart();
        $this->terminalDrawer->drawTable($drawTable);
    }

    /**
     * @param DrawTable $drawTable
     * @param Window $window
     * @param OutputFormatterStyleInterface $style
     * @param int $offsetX
     * @param int $offsetY
     */
    private function recursiveDrawWindow(DrawTable $drawTable, Window $window, OutputFormatterStyleInterface $style = null, $offsetX = 0, $offsetY = 0)
    {
        foreach ($window->getChildren() as $child) {
            $newStyle = $child->getStyleOrParent($style);
            $newOffsetX = $offsetX + $child->getX();
            $newOffsetY = $offsetY + $child->getY();

            $this->recursiveDrawWindow($drawTable, $child, $newStyle, $newOffsetX, $newOffsetY);
        }

        foreach ($window->getObjects() as $object) {
            $newStyle = $object->getStyleOrParent($style);
            $newOffsetX = $offsetX + $object->getX();
            $newOffsetY = $offsetY + $object->getY();
            $newWindowMaxX = $offsetX + $window->getWidth();
            $newWindowMaxY = $offsetY + $window->getHeight();

            $this->recursiveDrawObject($drawTable, $object, $newStyle, $newOffsetX, $newOffsetY, $newWindowMaxX, $newWindowMaxY);
        }
    }

    /**
     * @param DrawTable $drawTable
     * @param Object $object
     * @param OutputFormatterStyleInterface $style
     * @param int $offsetX
     * @param int $offsetY
     * @param int $windowMaxX
     * @param int $windowMaxY
     */
    private function recursiveDrawObject(DrawTable $drawTable, Object $object, OutputFormatterStyleInterface $style = null, $offsetX = 0, $offsetY = 0, $windowMaxX = 0, $windowMaxY = 0)
    {
        foreach ($object->getPoints() as $point) {
            $newOffsetX = $offsetX + $point->getX();
            $newOffsetY = $offsetY + $point->getY();

            $this->recursiveDrawPoint($drawTable, $point, $style, $newOffsetX, $newOffsetY, $windowMaxX, $windowMaxY);
        }
    }

    /**
     * @param DrawTable $drawTable
     * @param Point $point
     * @param OutputFormatterStyleInterface $style
     * @param int $x
     * @param int $y
     * @param int $windowMaxX
     * @param int $windowMaxY
     */
    private function recursiveDrawPoint(DrawTable $drawTable, Point $point, OutputFormatterStyleInterface $style = null, $x = 0, $y = 0, $windowMaxX = 0, $windowMaxY = 0)
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

        if ($style = $newStyle = $point->getStyleOrParent($style)) {
            $symbol = $style->apply($point->getStyledSymbol());
        } else {
            $symbol = $point->getStyledSymbol();
        }
        $drawTable->setSymbol($symbol, $x, $y);
    }
}