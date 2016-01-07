<?php

namespace AppBundle\Service;

use AppBundle\Model\Screen\WindowBounds;
use AppBundle\Model\Space\Object;
use AppBundle\Model\Space\Point;
use AppBundle\Model\Space\Window;
use AppBundle\Model\Terminal\DepthRegister;
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

    /** @var DrawTable */
    private $drawTable;

    /** @var DepthRegister */
    private $depthRegister;

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

        $this->drawTable = new DrawTable($window->getWidth(), $window->getHeight());
        $this->depthRegister = new DepthRegister();

        $this->recursiveDrawWindow($window, $window->getStyle(), $window->getX(), $window->getY());

        $this->terminalDrawer->goToScreenStart();
        $this->terminalDrawer->drawTable($this->drawTable);

        $this->drawTable = null;
        $this->depthRegister = null;
    }

    /**
     * @param Window $window
     * @param OutputFormatterStyleInterface $style
     * @param int $depth
     * @param int $offsetX
     * @param int $offsetY
     */
    private function recursiveDrawWindow(Window $window, OutputFormatterStyleInterface $style = null, $depth = 0, $offsetX = 0, $offsetY = 0)
    {
        foreach ($window->getChildren() as $child) {
            $newStyle = $child->getStyleOrParent($style);
            $newDepth = $child->getDepthWithParent($depth);
            $newOffsetX = $offsetX + $child->getX();
            $newOffsetY = $offsetY + $child->getY();

            $this->recursiveDrawWindow($child, $newStyle, $newDepth, $newOffsetX, $newOffsetY);
        }

        $windowBounds = $this->createBoundsForWindow($window, $offsetX, $offsetY);
        foreach ($window->getObjects() as $object) {
            $newStyle = $object->getStyleOrParent($style);
            $newDepth = $object->getDepthWithParent($depth);
            $newOffsetX = $offsetX + $object->getX();
            $newOffsetY = $offsetY + $object->getY();

            $this->deeperToDrawObject($object, $newStyle, $newDepth, $newOffsetX, $newOffsetY, $windowBounds);
        }
    }

    /**
     * @param Object $object
     * @param OutputFormatterStyleInterface $style
     * @param int $depth
     * @param int $offsetX
     * @param int $offsetY
     * @param WindowBounds $windowBounds
     */
    private function deeperToDrawObject(Object $object, OutputFormatterStyleInterface $style = null, $depth = 0, $offsetX = 0, $offsetY = 0, WindowBounds $windowBounds)
    {
        foreach ($object->getPoints() as $point) {
            $newOffsetX = $offsetX + $point->getX();
            $newOffsetY = $offsetY + $point->getY();

            $this->deeperToDrawPoint($point, $style, $depth, $newOffsetX, $newOffsetY, $windowBounds);
        }
    }

    /**
     * @param Point $point
     * @param OutputFormatterStyleInterface $style
     * @param int $depth
     * @param int $x
     * @param int $y
     * @param WindowBounds $windowBounds
     */
    private function deeperToDrawPoint(Point $point, OutputFormatterStyleInterface $style = null, $depth = 0, $x = 0, $y = 0, WindowBounds $windowBounds)
    {
        if ($this->outOfBoundsCheck($x, $y, $this->drawTable, $windowBounds)) {
            return;
        }

        $registeredDepth = $this->depthRegister->getDepthFor($x, $y);
        if (($registeredDepth !== null) && ($depth < $registeredDepth)) {
            return;
        }

        if ($style = $newStyle = $point->getStyleOrParent($style)) {
            $symbol = $style->apply($point->getStyledSymbol());
        } else {
            $symbol = $point->getStyledSymbol();
        }

        $this->drawTable->setSymbol($symbol, $x, $y);
        $this->depthRegister->registerDepth($x, $y, $depth);
    }

    /**
     * @param Window $window
     * @param integer $offsetX
     * @param integer $offsetY
     * @return WindowBounds
     */
    private function createBoundsForWindow(Window $window, $offsetX, $offsetY)
    {
        $windowBounds = new WindowBounds();
        $windowBounds->setMinX($offsetX);
        $windowBounds->setMinY($offsetY);
        $windowBounds->setMaxX($offsetX + $window->getWidth());
        $windowBounds->setMaxY($offsetY + $window->getHeight());

        return $windowBounds;
    }

    /**
     * @param integer $x
     * @param integer $y
     * @param DrawTable $drawTable
     * @param WindowBounds $windowBounds
     * @return bool
     */
    private function outOfBoundsCheck($x, $y, DrawTable $drawTable, WindowBounds $windowBounds)
    {
        if (
            ($x < $windowBounds->getMinX()) ||
            ($x >= $windowBounds->getMaxX()) ||
            ($x >= $drawTable->getWidth()) ||
            ($y < $windowBounds->getMinY()) ||
            ($y >= $windowBounds->getMaxY()) ||
            ($y >= $drawTable->getHeight())
        ) {
            return true;
        }

        return false;
    }
}